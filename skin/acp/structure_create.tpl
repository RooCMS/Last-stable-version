{* Шаблон создания новой страницы в структуре сайта *}
<div class="panel-heading">
	Новая страница сайта
</div>
<div class="panel-body">
	<form method="post" action="{$SCRIPT_NAME}?act=structure&part=create" role="form" class="form-horizontal">

		<div class="form-group">
			<label for="inputTitle" class="col-lg-3 control-label">
				Название страницы: <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Будет использовано в мета теге title." data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="title" id="inputTitle" class="form-control" required>
			</div>
		</div>

		<div class="form-group">
			<label for="inputAlias" class="col-lg-3 control-label">
				Alias страницы:  <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Значение должно быть уникальным" data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="alias" id="inputAlias" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label for="inputMetaDesc" class="col-lg-3 control-label">
				Мета описание страницы:
			</label>
			<div class="col-lg-9">
				<input type="text" name="meta_description" id="inputMetaDesc" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label for="inputMetaKeys" class="col-lg-3 control-label">
				Ключевые слова страницы:
			</label>
			<div class="col-lg-9">
				<input type="text" name="meta_keywords" id="inputMetaKeys" class="form-control">
			</div>
		</div>

		<div class="form-group">
			<label for="inputNoindex" class="col-lg-3 control-label">
				SEO NOINDEX: <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Запрещает индексировать страницу поисковыми роботами." data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default active">
						<input type="radio" name="noindex" value="0" id="flag_noindex_false" checked><i class="fa fa-fw fa-eye"></i>Разрешить индексацию
					</label>
					<label class="btn btn-default">
						<input type="radio" name="noindex" value="1" id="flag_noindex_true"><i class="fa fa-fw fa-eye-slash"></i>Запретить индексацию
					</label>
				</div>
			</div>
		</div>

		{* Миниаютры *}
		<div class="form-group">
			<label for="inputThumbWidth" class="col-lg-3 control-label">
				Ширина миниатюр картинок у этой страницы:
				<small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Значение в пикселях. Оставьте поле пустым или укажите 0 что бы применить глобальные настройки." data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="thumb_img_width" id="inputThumbWidth" class="form-control" pattern="^[ 0-9]+$">
				<small>По умолчанию: {$default_thumb_size['width']}px</small>
			</div>
		</div>
		<div class="form-group">
			<label for="inputThumbHeight" class="col-lg-3 control-label">
				Высота миниатюр картинок у этой страницы:
				<small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Значение в пикселях. Оставьте поле пустым или укажите 0 что бы применить глобальные настройки." data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<input type="text" name="thumb_img_height" id="inputThumbHeight" class="form-control" pattern="^[ 0-9]+$">
				<small>По умолчанию: {$default_thumb_size['height']}px</small>
			</div>
		</div>

		<div class="form-group">
			<label for="inputSort" class="col-lg-3 control-label">
				Порядок расположения страницы в структуре:
			</label>
			<div class="col-lg-9">
				<input type="text" name="sort" id="inputSort" class="form-control" pattern="^[ 0-9]+$">
			</div>
		</div>

		<div class="form-group">
			<label for="inputType" class="col-lg-3 control-label">
				Тип страницы: <small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Вы не сможете в последствии изменить тип страницы." data-placement="left"></span></small>
			</label>
			<div class="col-lg-9">
				<select name="page_type" id="inputType" class="selectpicker show-tick" required>
					{foreach from=$page_types key=ptype item=ptitle}
						<option value="{$ptype}"{if isset($smarty.get.type) && $smarty.get.type == $ptype} selected{/if}>{$ptitle}</option>
					{/foreach}
				</select>
			</div>
		</div>

		<div class="form-group">
			<label for="inputStructure" class="col-lg-3 control-label">
				Расположение страницы в структуре:
			</label>
			<div class="col-lg-9">
				<select name="parent_id" id="inputStructure" class="selectpicker show-tick" required data-header="Структура сайта" data-size="auto" data-live-search="true" data-width="50%">
					{foreach from=$tree item=p}
						<option value="{$p['id']}" data-subtext="{$p['alias']}">{section name=level loop=$p['level']}&middot; {/section} {$p['title']}</option>
					{/foreach}
				</select>
			</div>
		</div>

		{if !empty($groups)}
			<div class="form-group">
				<label for="inputGroupAccess" class="col-lg-3 control-label">
					Доступ для групп:
					<small><span class="fa fa-question-circle fa-fw" rel="tooltip" title="Укажите какие группы пользователей смогут просматривать эту страницу" data-placement="left"></span></small>
				</label>
				<div class="col-lg-9">
					<div class="btn-group" data-toggle="buttons" id="inputGroupAccess">
						{*<label class="btn btn-default active">
							<input type="checkbox" name="gids[]" value="0" autocomplete="off" checked><i class="fa fa-fw fa-users"></i> Все группы
						</label>*}
						{foreach from=$groups item=group}
							<label class="btn btn-default">
								<input type="checkbox" name="gids[]" value="{$group['gid']}" autocomplete="off"><i class="fa fa-fw fa-user"></i> {$group['title']}
							</label>
						{/foreach}
					</div>
				</div>
			</div>
		{/if}

		<div class="row">
			<div class="col-lg-9 col-md-offset-3">
				<input type="hidden" name="empty" value="1">
				<input type="submit" name="create_unit" class="btn btn-success" value="Создать">
				<input type="submit" name="create_unit_ae" class="btn btn-default" value="Создать и выйти">
			</div>
		</div>

	</form>
</div>