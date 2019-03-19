<?php

/**
 * @file plugins/generic/dates/DatesPlugin.inc.php
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @class dates
 * @ingroup plugins_generic_dates
 *
 * @brief dates plugin class
 */

import('lib.pkp.classes.plugins.GenericPlugin');

class DatesPlugin extends GenericPlugin {
	/**
	 * Called as a plugin is registered to the registry
	 * @param $category String Name of category plugin was registered to
	 * @return boolean True iff plugin initialized successfully; if false,
	 * 	the plugin will not be registered.
	 */
	function register($category, $path) {
		$success = parent::register($category, $path);
		if (!Config::getVar('general', 'installed') || defined('RUNNING_UPGRADE')) return true;
		if ($success && $this->getEnabled()) {
			// Insert Dates div
			HookRegistry::register('Templates::Article::Details', array($this, 'addDates'));
		}
		return $success;
	}

	/**
	 * Get the plugin display name.
	 * @return string
	 */
	function getDisplayName() {
		return __('plugins.generic.dates.displayName');
	}

	/**
	 * Get the plugin description.
	 * @return string
	 */
	function getDescription() {
		return __('plugins.generic.dates.description');
	}

	/**
	 * Add dates to article landing page
	 * @param $hookName string
	 * @param $params array
	 */
	function addDates($hookName, $params) {
		$request = $this->getRequest();
		$context = $request->getContext();

		$smarty =& $params[1];
		$output =& $params[2];

		$article = $smarty->get_template_vars('article');

		$dates = "";
		$submitdate = $article->getDateSubmitted();
		$publishdate = $article->getDatePublished();
		$reviewdate = "";

		$editDecisionDao = DAORegistry::getDAO('EditDecisionDAO');
		$decisions = $editDecisionDao->getEditorDecisions($article->getId());

		foreach ($decisions as $decision) {
			if ($decision['stageId'] == '3' && $decision['decision'] == '1')
				$reviewdate = $decision[dateDecided];			
		}

		if ($submitdate)
			$dates .= "Received " . date('Y-m-d',strtotime($submitdate)) . "<br />";
		if ($reviewdate)
			$dates .= "Accepted " . date('Y-m-d',strtotime($reviewdate)) . "<br />";
		if ($publishdate)
			$dates .= "Published " . date('Y-m-d',strtotime($publishdate));

		$smarty->assign('dates', $dates);

		$output .= $smarty->fetch($this->getTemplateResource('dates.tpl'));
		return false;		

	}
}

?>
