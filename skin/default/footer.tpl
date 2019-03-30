{* Шаблон "ног" *}


<div class="container mb-3">
	<div class="row">
		<div class="col-md-6 text-gray ptsans">
			<div class="text-uppercase border-bottom pb-1 mb-2">Навигация</div>
			{if !empty($navtree)}
				<div class="d-flex flex-row flex-wrap">
					{foreach from=$navtree item=navitem key=k name=navigate}
						{if $smarty.foreach.navigate.first}
							<div class="d-flex flex-column col-sm-6 px-0">
						{/if}

						{if $navitem['level'] == 0 && !$smarty.foreach.navigate.first}
							</div>
							<div class="d-flex flex-column col-sm-6 px-0 mx-0">
						{/if}

						<a href="/index.php?page={$navitem['alias']}" class="text-gray roocms-foot-link{if $navitem['level'] == 0}-first{/if}">{$navitem['title']}</a>

						{if $smarty.foreach.navigate.last}
							</div>
						{/if}
					{/foreach}
				</div>
			{/if}
		</div>
		<div class="col-md-2 text-gray ptsans">
			<div class="text-uppercase border-bottom pb-1 mb-2">Информация</div>
			<a href="{$SCRIPT_NAME}?part=fl152&ajax=true" data-fancybox data-animation-duration="300" data-type="ajax" class="text-gray roocms-foot-link">Соглашение о передачи персональной информации</a>

			{include file='counters.tpl'}
		</div>
		<div class="col-md-4 text-gray ptsans">
			<div class="text-uppercase border-bottom pb-1 mb-2">{if $userdata['uid'] != 0}Личный кабинет{else}Рассылка{/if}</div>
			{if $userdata['uid'] != 0}
				<a class="text-gray" href="{$SCRIPT_NAME}?part=ucp&act=ucp"><i class="far fa-fw fa-user mr-1"></i>Личный кабинет</a>
				<br /><a class="text-gray" href="{$SCRIPT_NAME}?part=ucp&act=pm"><i class="far fa-fw fa-envelope mr-1"></i>Личные сообщения</a>
				<br />
				<br /><a class="text-gray" href="{$SCRIPT_NAME}?part=ucp&act=logout"><i class="fas fa-fw fa-sign-out-alt mr-1"></i>Выйти из аккаунта</a>
			{/if}
			{$module->load("express_reg")}

			<a id="move_top" href="{$smarty.server.REQUEST_URI}#" class="btn btn-info"><i class="fas fa-fw fa-chevron-circle-up"></i> Наверх</a>
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-center small">
			<hr />
			Создано на <br />{$copyright}
		</div>
	</div>
</div>


{*
{if $nitem['rss'] == 1 && $config->rss_power}
	<a href="/index.php?page={$nitem['alias']}&export=RSS" class="btn btn-sm btn-link ptsans" target="_blank" title="{$nitem['title']} RSS"><i class="fa fa-fw fa-rss"></i></a>
{/if}

<a id="move_top" href="{$smarty.server.REQUEST_URI}#" class="btn btn-info"><i class="fa fa-fw fa-chevron-circle-up"></i> Наверх</a>
*}

</body>
</html>