{**
 * plugins/generic/dates/templates/articleFooter.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 *}
<div class="item dates">
        <div class="value">
        {if array_key_exists('received', $dates)}
                        {translate key="plugins.generic.dates.received"} {$dates.received} <br/>
        {/if}
        {if $dates.accepted}
                {translate key="plugins.generic.dates.accepted"} {$dates.accepted} <br/>
        {/if}
        {if $dates.published}
                {translate key="plugins.generic.dates.published"} {$dates.published} <br/>
        {/if}
        </div>
</div>

