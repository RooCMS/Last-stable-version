{* Основной шаблон управления лентами *}

<div class="col-md-2">
	<ul class="nav nav-pills nav-stacked">
	{*<ul class="nav nav-list">*}
		<li class="nav-header">Управление лентами</li>
		{if isset($smarty.get.part) && ($smarty.get.part == 'control' || $smarty.get.part == 'edit_item' || $smarty.get.part == 'settings' || $smarty.get.part == 'create_item')}
			<li{if isset($smarty.get.part) && $smarty.get.part == "create_item"} class="active"{/if}><a href="{$SCRIPT_NAME}?act=feeds&part=create_item&page={$smarty.get.page}"><span class="icon-fixed-width icon-volume-up"></span> Создать новый элемент ленты</a></li>
			<li{if isset($smarty.get.part) && $smarty.get.part == "settings"} class="active"{/if}> <a href="{$SCRIPT_NAME}?act=feeds&part=settings&page={$smarty.get.page}"><span class="icon-fixed-width icon-cog"></span> Настройки ленты</a></li>
            {if isset($smarty.get.part) && ($smarty.get.part != 'edit_item' && $smarty.get.part != 'settings' && $smarty.get.part != 'create_item')}
				<li class="nav-header">Опции</li>
				<li><a href="{$SCRIPT_NAME}?act=feeds"><span class="icon-fixed-width icon-arrow-left"></span>  Вернуться ко всем лентам</a></li>
			{/if}
		{else}
			<li><a href="{$SCRIPT_NAME}?act=structure&part=create&type=feed"><span class="icon-fixed-width icon-plus-sign"></span> Создать новую ленту</a></li>
		{/if}
		{if isset($smarty.get.part) && ($smarty.get.part == 'edit_item' || $smarty.get.part == 'settings' || $smarty.get.part == 'create_item')}
			<li class="nav-header">Опции</li>
			<li><a href="{$SCRIPT_NAME}?act=feeds&part=control&page={$smarty.get.page}"><span class="icon-fixed-width icon-arrow-left"></span>  Вернуться в ленту</a></li>
		{/if}
	</ul>
</div>
<div class="col-md-10 thumbnail">
	<div class="caption">
    	{$content}
	</div>
</div>