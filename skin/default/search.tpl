{* Шаблон результатов поиска *}

<h1>
	Поиск: {$searchstring}
</h1>

{foreach from=$result item=item}
	<div class="panel panel-default">
		<div class="panel-body">
			<div id="item-id-{$item['id']}">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="feed-title">
							<a href="{$SCRIPT_NAME}?page={$item['alias']}&id={$item['id']}{if isset($smarty.get.search)}&search={$smarty.get.search}{/if}">{$item['title']}</a>
						</h3>
						<div class="feed-date small">
							<a href="{$SCRIPT_NAME}?page={$item['alias']}"><i class="fa fa-folder"></i> {$item['feed_title']}</a>
							<i class="fa fa-calendar"></i> {$item['datepub']}
							{if $item['views'] != 0}<i class="fa fa-fw fa-eye" title="Просмотрено раз"></i> {$item['views']}{/if}
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12">
						{if isset($item['image'][0])}
							{foreach from=$item['image'] item=image}
								<a href="{$SCRIPT_NAME}?page={$item['alias']}&id={$item['id']}{if isset($smarty.get.search)}&search={$smarty.get.search}{/if}"><img src="upload/images/{$image['thumb']}" border="0" alt="{$image['alt']}" class="img-thumbnail feed-image-prev"></a>
							{/foreach}
						{/if}
						{$item['brief_item']}
					</div>
				</div>
				<hr />
				<div class="row">
					<div class="col-sm-6">
						{if !empty($item['tags'])}
							<span class="small">
								{foreach from=$item['tags'] item=tag}
									<a href="{$SCRIPT_NAME}?part=tags&tag={$tag['title']}" class="btn btn-default btn-xs"><i class="fa fa-fw fa-tag fa-va"></i>{$tag['title']}</a>
								{/foreach}
							</span>
						{/if}
					</div>
					<div class="col-sm-6 text-right">
						<a href="{$SCRIPT_NAME}?page={$item['alias']}&id={$item['id']}{if isset($smarty.get.search)}&search={$smarty.get.search}{/if}" class="btn btn-sm btn-primary">Читать полностью <span class="fa fa-chevron-circle-right fa-fw"></span></a>
					</div>
				</div>
			</div>
		</div>
	</div>
{/foreach}

{* Pagination *}
{if isset($pages) && !empty($pages)}
	<ul class="pagination">
		{foreach from=$pages item=page}
			{if isset($page['prev'])}
				<li><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['prev']}{get_params exclude='page,pg'}">&larr;</a></li>
			{elseif isset($page['next'])}
				<li><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['next']}{get_params exclude='page,pg'}">&rarr;</a></li>
			{else}
				{if isset($smarty.get.pg) && $smarty.get.pg == $page['n']}
					<li class="active"><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['n']}{get_params exclude='page,pg'}">{$page['n']}</a></li>
				{else}
					{if !isset($smarty.get.pg) && $page['n'] == "1"}
						<li class="active"><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['n']}{get_params exclude='page,pg'}">{$page['n']}</a></li>
					{else}
						<li><a href="{$SCRIPT_NAME}?page={$feed['alias']}&pg={$page['n']}{get_params exclude='page,pg'}">{$page['n']}</a></li>
					{/if}
				{/if}
			{/if}
		{/foreach}
	</ul>
{/if}