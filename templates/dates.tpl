{**
 * plugins/generic/dates/templates/articleFooter.tpl
 *
 * Copyright (c) 2014-2019 Simon Fraser University
 * Copyright (c) 2003-2019 John Willinsky
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 *}
<div class="item dates">
	<div class="value">
	{if isset(dates.received) }
		{translate key="plugins.generic.dates.received"} {dates[received]} <br/>
	{/if}
	{if isset(dates.accepted) }
		{translate key="plugins.generic.dates.accepted"} {dates[accepted]} <br/>
	{/if}
	{if isset(dates.published) }
		{translate key="plugins.generic.dates.published"} {dates[published]} <br/>
	{/if}
	</div>
</div>
