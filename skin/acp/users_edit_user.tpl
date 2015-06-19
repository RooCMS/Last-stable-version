{* Шаблон редактирования пользователя *}
<div class="panel-heading">
	Редактируем пользователя #{$user['uid']} {$user['nickname']}
</div>
<div class="panel-body">
	<form method="post" action="{$SCRIPT_NAME}?act=users&part=update&uid={$user['uid']}" role="form" class="form-horizontal">

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

		<div class="form-group">
			<label for="inputLogin" class="col-lg-3 control-label">
				Логин пользователя: <small><span class="fa fa-info fa-fw" rel="tooltip" title="Должен быть уникальным" data-placement="right"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="login" id="inputLogin" class="form-control" value="{$user['login']}" required>
			</div>
		</div>

		<div class="form-group">
			<label for="inputNickname" class="col-lg-3 control-label">
				Имя пользователя:  <small><span class="fa fa-info fa-fw" rel="tooltip" title="Должно быть уникальным" data-placement="right"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="nickname" id="inputNickname" class="form-control" value="{$user['nickname']}">
			</div>
		</div>

		<div class="form-group">
			<label for="inputEmail" class="col-lg-3 control-label">
				Электронная почта:  <small><span class="fa fa-info fa-fw" rel="tooltip" title="Должна быть уникальной. Нельзя заводить несколько аккаунтов на один почтовый ящик" data-placement="right"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="email" id="inputEmail" class="form-control"  value="{$user['email']}" pattern="^\s*\w+\-*\.*\w*@\w+\.[\w+\s*]{literal}{2,}{/literal}" required>
			</div>
		</div>

		<div class="form-group">
			<label for="inputPassword" class="col-lg-3 control-label">
				Пароль:  <small><span class="fa fa-info fa-fw" rel="tooltip" title="Оставьте поле пустым, что бы не менять пароль." data-placement="right"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="password" id="inputPassword" class="form-control"  pattern="^[\d\D]{literal}{5,}{/literal}">
			</div>
		</div>


		<div class="row">
			<div class="col-lg-9 col-md-offset-3">
				<input type="hidden" name="empty" value="1">
				<input type="submit" name="update_user" class="btn btn-success" value="Обновить">
				<input type="submit" name="update_user_ae" class="btn btn-default" value="Обновить и выйти">
			</div>
		</div>

	</form>
</div>