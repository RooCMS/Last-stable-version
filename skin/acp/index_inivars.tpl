{* Значение PHP переменных *}

<h3>Значение PHP переменных</h3>

<table class="table table-hover table-condensed">
	{*<caption>Общая сводка</caption>*}
	<thead>
		<tr>
			<th>Параметр</th>
			<th>Локальное значение</th>
			<th class="visible-lg">Значение на сервере</th>
			<th class="hidden-xs">Разрешения</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$inivars item=inival key=ininame}
		<tr{if $inival['local_value'] != $inival['global_value']} class="success"{/if}>
    		<td>{$ininame}</td>
    		<td{if $inival['local_value'] != $inival['global_value']} class="text-success bold"{/if}>{$inival['local_value']}{if $inival['local_value'] != $inival['global_value']}<small><br />{if trim($inival['global_value']) != ""}{$inival['global_value']}{else}пустое значение{/if}</small>{/if}</td>
    		<td class="visible-lg">{$inival['global_value']}</td>
    		<td class="hidden-xs">
				{if $inival['access'] == 1}
					Через пользовательские скрипты
				{elseif $inival['access'] == 2 || $inival['access'] == 6}
					<code>.htaccess</code>, <code>php.ini</code> или <code>httpd.conf</code>
				{elseif $inival['access'] == 4}
					<code>php.ini</code> или <code>httpd.conf</code>
				{elseif $inival['access'] == 7}
					<span class="text-primary">Полный доступ</span>
				{else}
					{$inival['access']}
				{/if}
    		</td>
		</tr>
		{/foreach}
	</tbody>
</table>