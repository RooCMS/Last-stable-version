{* Шаблон отображения списка пользователей *}
<div class="panel-heading">
	Пользователи
</div>


<table class="table table-hover table-condensed hidden-xs">
	<thead>
	<tr class="active">
		<th width="2%">ID</th>
		<th width="3%">Аватар</th>
		<th width="43%">Имя пользователя <small>Логин и E-mail</small></th>
		<th width="11%">Титул</th>
		<th width="10%">Последний визит</th>
		<th width="30%">Опции</th>
	</tr>
	</thead>
	<tbody>
	{foreach from=$data item=user}
		<tr{if $user['status'] == 0 && $user['activation_code'] == ""} class="danger"{elseif $user['status'] == 0 && $user['activation_code'] != ""} class="warning"{/if} title="{$user['user_slogan']}">
			<td class="text-muted">{$user['uid']}</td>
			<td>
				{if $user['avatar'] != ""}<a href="{$SCRIPT_NAME}?act=users&part=edit_user&uid={$user['uid']}"><img src="/upload/images/{$user['avatar']}" height="40" class="img-circle"></a>{/if}
			</td>
			<td>
				<a href="{$SCRIPT_NAME}?act=users&part=edit_user&uid={$user['uid']}">{$user['nickname']}</a>
				{if $user['user_sex'] == "m"}<i class="fa fa-fw fa-mars text-info"></i>{elseif $user['user_sex'] == "f"}<i class="fa fa-fw fa-venus text-danger"></i>{/if}
				<span class="label label-info pull-right hidden-sm">{$user['gtitle']}</span>
				{if $user['status'] == 0 && $user['activation_code'] != ""}<span class="label label-warning pull-right hidden-sm">Не активирован</span>{/if}
				{if $user['status'] == 0 && $user['activation_code'] == ""}<span class="label label-danger pull-right hidden-sm">Отключен</span>{/if}
				<br /><small>{$user['login']} ({$user['email']}) <i class="fa fa-fw {if $user['mailing'] == 0}fa-envelope text-muted{else}fa-envelope-open text-success{/if}"></i></small>
			</td>
			<td class="text-left">
				{if $user['title'] == "a" && $user['uid'] == 1}
					<span class="label label-primary">Супер Администратор</span>
				{elseif $user['title'] == "a" && $user['uid'] != 1}
					<span class="label label-info">Администратор</span>
				{else}
					<span class="label label-default">Пользователь</span>
				{/if}
			</td>
			<td class="small">{$user['last_visit']}</td>
			<td>
				<div class="btn-group">
					<a href="{$SCRIPT_NAME}?act=users&part=edit_user&uid={$user['uid']}" class="btn btn-sm btn-outline-primary"><span class="fa fa-pencil-square-o fa-fw"></span><span class="hidden-sm">Редактировать</span></a>
					{if $user['uid'] != 1}<a href="{$SCRIPT_NAME}?act=users&part=delete_user&uid={$user['uid']}" class="btn btn-sm btn-danger"><span class="fa fa-user-times fa-fw"></span><span class="hidden-sm">Удалить</span></a>{/if}
				</div>
			</td>
		</tr>
	{/foreach}
	</tbody>
</table>

<ul class="list-group visible-xs">
	{foreach from=$data item=user}
		<li class="list-group-item{if $user['status'] == 0 && $user['activation_code'] == ""} list-group-item-danger{elseif $user['status'] == 0 && $user['activation_code'] != ""} list-group-item-warning{/if} no-overflow">
			{if $user['avatar'] != ""}<a href="{$SCRIPT_NAME}?act=users&part=edit_user&uid={$user['uid']}" class="pull-left avatar-xs"><img src="/upload/images/{$user['avatar']}" class="img-circle"></a>{/if}

			{if $user['status'] == 0}<span style="text-decoration: line-through;">{/if}

				<a href="{$SCRIPT_NAME}?act=users&part=edit_user&uid={$user['uid']}"><!-- #{$user['uid']} --> {$user['nickname']}</a>

				<br />
				{if $user['title'] == "a" && $user['uid'] == 1}
					<span class="label label-primary">Супер Администратор</span>
				{elseif $user['title'] == "a" && $user['uid'] != 1}
					<span class="label label-info">Администратор</span>
				{else}
					<span class="label label-default">Пользователь</span>
				{/if}

			{if $user['status'] == 0}</span>{/if}

			<div class="pull-right">
				<div class="btn-group">
					<a href="{$SCRIPT_NAME}?act=users&part=edit_user&uid={$user['uid']}" class="btn btn-sm btn-outline-primary"><span class="fa fa-pencil-square-o fa-fw"></span><span class="hidden-sm"></span></a>
					{if $user['uid'] != 1}<a href="{$SCRIPT_NAME}?act=users&part=delete_user&uid={$user['uid']}" class="btn btn-sm btn-danger"><span class="fa fa-user-times fa-fw"></span><span class="hidden-sm"></span></a>{/if}
				</div>
			</div>
		</li>
	{/foreach}
</ul>