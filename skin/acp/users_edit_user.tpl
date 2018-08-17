{* Шаблон редактирования пользователя *}
<div class="panel-heading">
	Редактируем пользователя #{$user['uid']} {$user['nickname']}
</div>
<div class="panel-body">
	<form method="post" action="{$SCRIPT_NAME}?act=users&part=update_user&uid={$user['uid']}" enctype="multipart/form-data" role="form" class="form-horizontal">

		{if $user['uid'] != 1}
		<div class="btn-group" data-toggle="buttons">
			<label class="btn btn-default{if $user['status'] == 1} active{/if} btn-sm" for="flag_status_true" rel="tooltip" title="Учетная запись активна" data-placement="auto" data-container="body">
				<input type="radio" name="status" value="1" id="flag_status_true"{if $user['status'] == 1} checked{/if}> <span class="text-success"><span class="fa fa-fw fa-eye"></span></span>
			</label>
			<label class="btn btn-default{if $user['status'] == 0} active{/if} btn-sm" for="flag_status_false" rel="tooltip" title="Учетная запись отключена" data-placement="auto" data-container="body">
				<input type="radio" name="status" value="0" id="flag_status_false"{if $user['status'] == 0} checked{/if}> <span class="text-danger"><span class="fa fa-fw fa-eye-slash"></span></span>
			</label>
		</div>
		{/if}

		{if $i_am_groot}
		{if $user['uid'] != 1}<br /><br />{/if}
		<blockquote class="quote quote-warning">
			Внимание! Вы редактируете собственные данные.
			<br />По завершению редактирования RooCMS может попросить вас заново указать ваш логин и пароль для авторизации.
			<br />В некоторых случаях, вы можете увидеть предупрждение системы безопастности RooCMS о попытке подмены данных. В этом случае вам не стоит волноваться, потому что это просто срабатывание защиты Панели Управления от несанкционированного доступа.
		</blockquote>
		{/if}

		<h5 class="text-info">Персональные данные:</h5>

		<div class="form-group">
			<label for="inputNickname" class="col-lg-3 control-label">
				Псевдоним пользователя:  <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Должен быть уникальным" data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="nickname" id="inputNickname" class="form-control" value="{$user['nickname']}" spellcheck required>
			</div>
		</div>

		<div class="form-group">
			<label for="inputLogin" class="col-lg-3 control-label">
				Логин пользователя: <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Должен быть уникальным" data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="login" id="inputLogin" class="form-control" value="{$user['login']}" required>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword" class="col-lg-3 control-label">
				Пароль:  <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Оставьте поле пустым, что бы не менять пароль." data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="password" id="inputPassword" class="form-control"  pattern="^[\d\D]{literal}{5,}{/literal}">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail" class="col-lg-3 control-label">
				Электронная почта:  <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Должна быть уникальной. Нельзя заводить несколько аккаунтов на один почтовый ящик" data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<div class="input-group">
					<input type="text" name="email" id="inputEmail" class="form-control"  value="{$user['email']}" pattern="[A-Za-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{literal}{2,6}{/literal}$" required>
					<div class="input-group-btn" data-toggle="buttons">
						<label class="btn btn-default{if $user['mailing'] == 1} active{/if}" for="flag_status_true" rel="tooltip" title="Получать рассылку" data-placement="auto" data-container="body">
							<input type="radio" name="mailing" value="1" id="flag_status_true"{if $user['mailing'] == 1} checked{/if}> <span class="text-success"><i class="fa fa-fw fa-envelope-open"></i></span>
						</label>
						<label class="btn btn-default{if $user['mailing'] == 0} active{/if}" for="flag_status_false" rel="tooltip" title="Не получать рассылку" data-placement="auto" data-container="body">
							<input type="radio" name="mailing" value="0" id="flag_status_false"{if $user['mailing'] == 0} checked{/if}> <span class="text-danger"><i class="fa fa-fw fa-envelope"></i></span>
						</label>
					</div>
				</div>
			</div>
		</div>

		<hr />
		<h5 class="text-info">Анкетные данные:</h5>

		<div class="form-group">
			<label for="inputUserName" class="col-lg-3 control-label">
				Имя:
			</label>
			<div class="col-lg-9">
				<input type="text" name="user_name" id="inputUserName" class="form-control" value="{$user['user_name']}">
			</div>
		</div>

		<div class="form-group">
			<label for="inputUserSurName" class="col-lg-3 control-label">
				Фамилия:
			</label>
			<div class="col-lg-9">
				<input type="text" name="user_surname" id="inputUserSurName" class="form-control" value="{$user['user_surname']}">
			</div>
		</div>

		<div class="form-group">
			<label for="inputUserLastName" class="col-lg-3 control-label">
				Отчество:
			</label>
			<div class="col-lg-9">
				<input type="text" name="user_last_name" id="inputUserLastName" class="form-control" value="{$user['user_last_name']}">
			</div>
		</div>

		<div class="form-group">
			<label for="inputUserBirthdate" class="col-lg-3 control-label">
				Дата рождения:
			</label>
			<div class="col-lg-9">
				<input type="text" name="user_birthdate" id="inputUserBirthdate" value="{$user['user_birthdate']}" class="form-control datepicker form-date">
			</div>
		</div>

		<div class="form-group">
			<label for="inputUserSlogan" class="col-lg-3 control-label">
				Девиз:
			</label>
			<div class="col-lg-9">
				<textarea class="form-control" id="inputUserSlogan" name="user_slogan" rows="3" spellcheck>{$user['user_slogan']}</textarea>
			</div>
		</div>

		<div class="form-group">
			<label for="inputUserSex" class="col-lg-3 control-label">
				Пол:
			</label>
			<div class="col-lg-9">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default{if $user['user_sex'] == "n"} active{/if}">
						<input type="radio" name="user_sex" id="inputUserSex" autocomplete="off" value="n"{if $user['user_sex'] == "n"} checked{/if}><i class="fa fa-fw fa-user"></i> Не указан
					</label>
					<label class="btn btn-default{if $user['user_sex'] == "m"} active{/if}">
						<input type="radio" name="user_sex" id="inputUserSexM" autocomplete="off" value="m"{if $user['user_sex'] == "m"} checked{/if}><i class="fa fa-fw fa-male"></i> Мужской
					</label>
					<label class="btn btn-default{if $user['user_sex'] == "f"} active{/if}">
						<input type="radio" name="user_sex" id="inputUserSexF" autocomplete="off" value="f"{if $user['user_sex'] == "f"} checked{/if}><i class="fa fa-fw fa-female"></i> Женский
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			<label for="inputAvatar" class="col-lg-3 control-label">
				Аватар:  <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="{$config->users_avatar_width}x{$config->users_avatar_height} пикселей" data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				{if $user['avatar'] != ""}<span id="dua-{$user['uid']}" class="hover-cursor delete_useravatar pull-right"  rel="tooltip" title="Удалить аватар пользователя" data-placement="left"><img src="/upload/images/{$user['avatar']}" height="40" class="img-circle"></span>{/if} <input type="file" name="avatar" id="inputAvatar" class="btn btn-default">
			</div>
		</div>

		<hr />
		<h5 class="text-info">Права и группа пользователя:</h5>

		{if $user['uid'] != 1}
		<div class="form-group">
			<label for="inputTitle" class="col-lg-3 control-label">
				Титул:  <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Администраторы могут получить доступ к Панели Управления" data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<select name="title"  id="inputTitle" class="selectpicker show-tick" data-size="auto" data-width="50%">
					<option value="a" {if $user['title'] == "a"}selected{/if}>Администратор</option>
					<option value="u" {if $user['title'] == "u"}selected{/if}>Пользователь</option>
				</select>
			</div>
		</div>
		{/if}

		{if !empty($groups)}
		<div class="form-group">
			<label for="inputGroups" class="col-lg-3 control-label">
				Основная группа пользователя:
			</label>
			<div class="col-lg-9">
				<select name="gid" id="inputGroups" class="selectpicker show-tick" required data-header="Группы пользователей" data-size="auto" data-live-search="true" data-width="50%">
					<option value="0" {if $user['gid'] == 0}selected{/if}>Не состоит в группе</option>
					{foreach from=$groups item=group}
						<option value="{$group['gid']}" data-subtext="В группе {$group['users']} пользователей" {if $group['gid'] == $user['gid']}selected{/if}>{$group['title']}</option>
					{/foreach}
				</select>
				<input type="hidden" name="now_gid" value="{$user['gid']}" readonly>
			</div>
		</div>
		{/if}

		<div class="row">
			<div class="col-lg-9 col-md-offset-3">
				<input type="submit" name="update_user" class="btn btn-success" value="Обновить">
				<input type="submit" name="update_user_ae" class="btn btn-default" value="Обновить и выйти">
			</div>
		</div>

	</form>
</div>

{literal}
	<script>
		$(document).ready(function(){
			$('span[id^=dua]').click(function() {
				var attrdata = $(this).attr('id');
				var arrdata = attrdata.split('-');
				var uid = arrdata[1];

				$("#dua-"+uid).load('/acp.php?act=ajax&part=delete_user_avatar&uid='+uid, function() {
					$("#dua-"+uid).animate({'opacity':'0.2'}, 750, function() {
						$("#dua-"+uid).hide(600).delay(900).remove();
					});
				});

			});
	});
	</script>
{/literal}