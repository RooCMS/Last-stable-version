{* Шаблон "ног" *}


<div class="container mb-3">
	<div class="row">
		<div class="col-md-6">
			<div class="text-uppercase border-bottom pb-1 mb-2">Навигация</div>
			{if !empty($navtree)}
				<div class="d-flex flex-row flex-wrap">
					{foreach from=$navtree item=navitem key=k name=navigate}
						{if $smarty.foreach.navigate.first}
							<div class="d-flex flex-column col-sm-6 my-1 px-0">
						{/if}

						{if $navitem['level'] == 0 && !$smarty.foreach.navigate.first}
							</div>
							<div class="d-flex flex-column col-sm-6 my-1 px-0 mx-0">
						{/if}

						<a href="/index.php?page={$navitem['alias']}" class="text-secondary py-1 roocms-topnav-sublink{if $navitem['level'] == 0}-first{/if}">{$navitem['title']}</a>

						{if $smarty.foreach.navigate.last}
							</div>
						{/if}
					{/foreach}
				</div>
			{/if}
		</div>
		<div class="col-md-2 text-gray ptsans">
			<div class="text-uppercase border-bottom pb-1 mb-2">Информация</div>
		</div>
		<div class="col-md-4">
			<div class="text-uppercase border-bottom pb-1 mb-2">{if $userdata['uid'] != 0}Личный кабинет{else}Прочее{/if}</div>
		</div>
	</div>
</div>


{*
<div class="container">
	<div class="row">
		<div class="col-sm-8">
			<div class="row">
				{assign var=rows value=0}
				{foreach from=$navtree item=nitem key=k name=navigate}
					{if $nitem['level'] == 0}
						{if !$smarty.foreach.navigate.first}</div>{/if}
						{assign var=rows value=$rows+1}
						{if $rows == 5}
							{assign var=rows value=1}
							</div><div class="row">
						{/if}
						<div class="col-md-3 col-xs-12 text-overflow">
						<a href="/index.php?page={$nitem['alias']}" class="btn btn-sm btn-link ptsans">{$nitem['title']}</a>
					{else}
						<br /><a href="/index.php?page={$nitem['alias']}" class="btn btn-sm btn-link ptsans">{$nitem['title']}</a>
					{/if}
					{if $smarty.foreach.navigate.last}
						</div>
					{/if}
				{/foreach}
			</div>



			{if $nitem['rss'] == 1 && $config->rss_power}
				<a href="/index.php?page={$nitem['alias']}&export=RSS" class="btn btn-sm btn-link ptsans" target="_blank" title="{$nitem['title']} RSS"><i class="fa fa-fw fa-rss"></i></a>
			{/if}


		</div>
		<div class="col-sm-4">
			{if !isset($smarty.get.part)}
				{$module->load("express_reg")}
			{/if}
		</div>
	</div>
	<div class="row">
		<div class="col-sm-8">
			{include file='counters.tpl'}
		</div>
		<div class="col-sm-4">
			<div class="pull-right"><small>{$copyright}</small></div>
			<a id="move_top" href="{$smarty.server.REQUEST_URI}#" class="btn btn-info"><i class="fa fa-fw fa-chevron-circle-up"></i> Наверх</a>
		</div>
	</div>
</div>
*}

</body>
</html>