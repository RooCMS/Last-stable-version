{* Шаблон ленты *}
<div class="row">
	<div class="col-lg-{if !empty($rsslink)}11{else}12{/if} col-sm-{if !empty($rsslink)}10{else}12{/if}">
		<h1 class="white">{$page_title}</h1>
	</div>
	{if !empty($rsslink)}
		<div class="col-lg-1 col-sm-2 text-right">
			<a href="{$rsslink}" class="btn btn-warning btn-xs"><span class="fa fa-rss fa-fw"></span>RSS 2.0</a>
		</div>
	{/if}
</div>


{foreach from=$feeds item=item}
	<div id="item-id-{$item['id']}">
		<div class="row">
			<div class="col-sm-12">
				<h3><a href="{$SCRIPT_NAME}?page={$feed['alias']}{if isset($smarty.get.pg)}&pg={$smarty.get.pg}{/if}&id={$item['id']}">{$item['title']}</a></h3>
				{*<span>
					{$item['date']['day']}
					{$item['date']['tmonth']}
					{$item['date']['year']}
					<br /><small>{$item['date']['ftday']} {$item['date']['time']}</small>
				</span>*}
				<small>{$item['datepub']}</small>
			</div>
		</div>
		<div class="row">
			{if isset($item['image'][0])}
				{foreach from=$item['image'] item=image}
				<div class="col-lg-2 col-md-3 col-sm-4 text-left">
					<a href="{$SCRIPT_NAME}?page={$feed['alias']}{if isset($smarty.get.pg)}&pg={$smarty.get.pg}{/if}&id={$item['id']}"><img src="upload/images/{$image['thumb']}" border="0" alt="{$image['alt']}" class="img-thumbnail"></a>
				</div>
				{/foreach}
			{/if}
			<div class="col-lg-{if isset($item['image'][0])}10{else}12{/if} col-md-{if isset($item['image'][0])}9{else}12{/if} col-sm-{if isset($item['image'][0])}8{else}12{/if}">
				{$item['brief_item']}
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 text-right">
				<a href="{$SCRIPT_NAME}?page={$feed['alias']}{if isset($smarty.get.pg)}&pg={$smarty.get.pg}{/if}&id={$item['id']}" class="btn btn-xs btn-primary">Читать полностью <span class="fa fa-chevron-circle-right fa-fw"></span></a>
			</div>
		</div>
	</div>
{/foreach}


{if isset($pages) && !empty($pages)}
	<ul class="pagination">
		{foreach from=$pages item=page}
			{if isset($page['prev'])}
				<li><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['prev']}{get_params prefix='&amp;' exclude='page,pg'}">&larr;</a></li>
			{elseif isset($page['next'])}
				<li><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['next']}{get_params prefix='&amp;' exclude='page,pg'}">&rarr;</a></li>
			{else}
				{if isset($smarty.get.pg) && $smarty.get.pg == $page['n']}
					<li class="active"><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['n']}{get_params prefix='&amp;' exclude='page,pg'}">{$page['n']}</a></li>
				{else}
					{if !isset($smarty.get.pg) && $page['n'] == "1"}
						<li class="active"><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['n']}{get_params prefix='&amp;' exclude='page,pg'}">{$page['n']}</a></li>
					{else}
						<li><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['n']}{get_params prefix='&amp;' exclude='page,pg'}">{$page['n']}</a></li>
					{/if}
				{/if}
			{/if}
		{/foreach}
	</ul>
{/if}
