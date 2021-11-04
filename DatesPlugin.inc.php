<?php

/**
 * @file plugins/generic/dates/DatesPlugin.inc.php
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
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
	function register($category, $path, $mainContextId = NULL) {
		$success = parent::register($category, $path, $mainContextId);
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

		$smarty = $params[1];
		$output =& $params[2];

		$article = $smarty->get_template_vars('article');

		$dates = "";
		$submitdate = $article->getDateSubmitted();
		$publishdate = $article->getDatePublished();
		$reviewdate = "";

		// Get all decisions for this submission
		$editDecisionDao = DAORegistry::getDAO('EditDecisionDAO');
		$decisions = $editDecisionDao->getEditorDecisions($article->getId());

		// Loop through the decisions
		foreach ($decisions as $decision) {
			// If we have a review stage decision and it was a submission accepted decision, get to date for the decision
			if ($decision['stageId'] == '3' && $decision['decision'] == '1')
				$reviewdate = $decision['dateDecided'];
		}

		$dates = array();
		if ($submitdate)
			$dates['received'] = date('Y-m-d',strtotime($submitdate));
		if ($reviewdate)
			$dates['accepted'] = date('Y-m-d',strtotime($reviewdate));
		if ($publishdate)
			$dates['published'] = date('Y-m-d',strtotime($publishdate));

		// Only show dates if there was a review
		if ($reviewdate){
			$smarty->assign('dates', $dates);
			$output .= $smarty->fetch($this->getTemplateResource('dates.tpl'));
		}
		return false;

	}
}

?>
