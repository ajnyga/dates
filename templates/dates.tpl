{**
 * plugins/generic/dates/templates/articleFooter.tpl
 *
 * Copyright (c) 2014-2021 Simon Fraser University
 * Copyright (c) 2003-2021 John Willinsky
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 *
 *}
<div class="item dates">
        <section class="sub_item">
        {if array_key_exists('received', $dates)}
                <h2 class="label">{translate key="plugins.generic.dates.received"} </h2>
                <div class="value">{$dates.received} </div>
        {/if}
        {if $dates.accepted}
                 <h2 class="label">
                {translate key="plugins.generic.dates.accepted"}  </h2>
                 <div class="value">{$dates.accepted} </div>
        {/if}
        {if $dates.published}
                  <h2 class="label"> {translate key="plugins.generic.dates.published"}  </h2>
                  <div class="value">{$dates.published} </div>
        {/if}
        </section>
</div>

