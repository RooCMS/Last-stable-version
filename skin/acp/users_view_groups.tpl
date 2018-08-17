{* Шаблон отображения списка пользователей *}
<div class="panel-heading">
	Группы пользователей
</div>

{if !empty($data)}
	<table class="table table-hover table-condensed hidden-xs">
		<thead>
			<tr class="active">
				<th width="3%">ID</th>
				<th width="56%">Название группы</th>
				<th width="11%">Кол-во участников</th>
				<th width="30%">Опции</th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$data item=group}
			<tr>
				<td class="text-muted">{$group['gid']}</td>
				<td>
					<a href="{$SCRIPT_NAME}?act=users&part=edit_group&gid={$group['gid']}">{$group['title']}</a>
				</td>
				<td class="text-left">
					{$group['users']}
				</td>
				<td>
					<div class="btn-group">
						<a href="{$SCRIPT_NAME}?act=users&part=edit_group&gid={$group['gid']}" class="btn btn-xs btn-default"><span class="fa fa-pencil-square-o fa-fw"></span><span class="hidden-sm">Редактировать</span></a>
						<a href="{$SCRIPT_NAME}?act=users&part=delete_group&gid={$group['gid']}" class="btn btn-xs btn-danger"><span class="fa fa-trash fa-fw"></span><span class="hidden-sm">Удалить</span></a>
					</div>
				</td>
			</tr>
		{/foreach}
		</tbody>
	</table>

	<ul class="list-group visible-xs">
		{foreach from=$data item=group}
			<li class="list-group-item">

				<a href="{$SCRIPT_NAME}?act=users&part=edit_group&gid={$group['gid']}">{$group['title']}</a>

				<div class="pull-right">
					<div class="btn-group">
						<a href="{$SCRIPT_NAME}?act=users&part=edit_group&gid={$group['gid']}" class="btn btn-xs btn-default"><span class="fa fa-pencil-square-o fa-fw"></span><span class="hidden-sm"></span></a>
						<a href="{$SCRIPT_NAME}?act=users&part=delete_group&gid={$group['gid']}" class="btn btn-xs btn-danger"><span class="fa fa-trash fa-fw"></span><span class="hidden-sm"></span></a>
					</div>
				</div>
			</li>
		{/foreach}
	</ul>

{else}
	<div class="panel-body">
		На данный момент групп не создано. Вы можете создать первую группу воспользовавшись слева пунктом меню "Создать группу".
	</div>
{/if}