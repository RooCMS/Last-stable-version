{* Шаблон создания новой страницы в структуре сайта *}
<div class="card-header">
	Новая страница
</div>
<form method="post" action="{$SCRIPT_NAME}?act=structure&part=create" role="form" class="form-horizontal">
<div class="card-body">
	<div class="form-group row">
		<label for="inputTitle" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Название страницы: <small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Будет использовано в меню и хлебных крошках." data-placement="left"></span></small>
		</label>
		<div class="col-md-8">
			<input type="text" name="title" id="inputTitle" class="form-control" spellcheck required>
		</div>
	</div>

	<div class="form-group row">
		<label for="inputAlias" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Alias страницы:  <small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Значение должно быть уникальным" data-placement="left"></span></small>
		</label>
		<div class="col-md-8">
			<input type="text" name="alias" id="inputAlias" class="form-control">
		</div>
	</div>

	{* SEO *}
	<div class="form-group row">
		<label for="inputMetaTitle" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Мета заголовок: <small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Meta Title" data-placement="left"></span></small>
		</label>
		<div class="col-lg-8">
			<input type="text" name="meta_title" id="inputMetaTitle" class="form-control" spellcheck>
		</div>
	</div>

	<div class="form-group row">
		<label for="inputMetaDesc" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Мета описание: <small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Meta Description" data-placement="left"></span></small>
		</label>
		<div class="col-lg-8">
			<input type="text" name="meta_description" id="inputMetaDesc" class="form-control" spellcheck>
		</div>
	</div>

	<div class="form-group row">
		<label for="inputMetaKeys" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Ключевые слова: <small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Meta Keywords" data-placement="left"></span></small>
		</label>
		<div class="col-lg-8">
			<input type="text" name="meta_keywords" id="inputMetaKeys" class="form-control" spellcheck>
		</div>
	</div>

	<div class="form-group row">
		<label for="inputNoindex" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			SEO индексация: <small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Запрещает индексировать страницу поисковыми роботами." data-placement="left"></span></small>
		</label>
		<div class="col-lg-8">
			<div class="btn-group btn-group-toggle roocms-boolui" data-toggle="buttons">
				<label class="btn btn-light active">
					<input type="radio" name="noindex" value="0" id="flag_noindex_false" checked><i class="fas fa-fw fa-check-square text-success"></i> Разрешить индексацию
				</label>
				<label class="btn btn-light">
					<input type="radio" name="noindex" value="1" id="flag_noindex_true"><i class="fas fa-fw fa-square text-danger"></i> Запретить индексацию
				</label>
			</div>
		</div>
	</div>

	{* Миниаютры *}
	<div class="form-group row">
		<label for="inputThumbWidth" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Ширина миниатюр картинок у этой страницы:
			<small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Значение в пикселях. Оставьте поле пустым или укажите 0 что бы применить глобальные настройки." data-placement="left"></span></small>
		</label>
		<div class="col-lg-8">
			<input type="number" name="thumb_img_width" id="inputThumbWidth" class="form-control" pattern="^[ 0-9]+$">
			<small>По умолчанию: {$default_thumb_size['width']}px</small>
		</div>
	</div>
	<div class="form-group row">
		<label for="inputThumbHeight" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Высота миниатюр картинок у этой страницы:
			<small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Значение в пикселях. Оставьте поле пустым или укажите 0 что бы применить глобальные настройки." data-placement="left"></span></small>
		</label>
		<div class="col-lg-8">
			<input type="number" name="thumb_img_height" id="inputThumbHeight" class="form-control" pattern="^[ 0-9]+$">
			<small>По умолчанию: {$default_thumb_size['height']}px</small>
		</div>
	</div>

	<div class="form-group row">
		<label for="inputSort" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Порядок расположения страницы в структуре:
		</label>
		<div class="col-lg-8">
			<input type="number" name="sort" id="inputSort" class="form-control" pattern="^[ 0-9]+$">
		</div>
	</div>

	<div class="form-group row">
		<label for="inputType" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Тип страницы: <small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Вы не сможете в последствии изменить тип страницы." data-placement="left"></span></small>
		</label>
		<div class="col-lg-8">
			<select name="page_type" id="inputType" class="selectpicker show-tick" required>
				{foreach from=$content_types key=type item=title}
					<option value="{$type}"{if isset($smarty.get.type) && $smarty.get.type == $type} selected{/if}>{$title}</option>
				{/foreach}
			</select>
		</div>
	</div>

	<div class="form-group row">
		<label for="inputStructure" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Расположение страницы в структуре:
		</label>
		<div class="col-lg-8">
			<select name="parent_id" id="inputStructure" class="selectpicker show-tick" required data-header="Структура сайта" data-size="auto" data-live-search="true" data-width="50%">
				{foreach from=$tree item=p}
					<option value="{$p['id']}" data-subtext="{$p['alias']}">{section name=level loop=$p['level']}&middot; {/section} {$p['title']}</option>
				{/foreach}
			</select>
		</div>
	</div>

	{if !empty($groups)}
		<div class="form-group row">
			<label for="inputGroupAccess" class="col-md-4 col-form-label mb-0 mt-2 text-right">
				Доступ для групп:
				<small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Укажите какие группы пользователей смогут просматривать эту страницу" data-placement="left"></span></small>
			</label>
			<div class="col-lg-8">
				<div class="btn-group btn-group-toggle roocms-boolui" data-toggle="buttons" id="inputGroupAccess">
					{*<label class="btn btn-default active">
						<input type="checkbox" name="gids[]" value="0" autocomplete="off" checked><i class="fa fa-fw fa-users"></i> Все группы
					</label>*}
					{foreach from=$groups item=group}
						<label class="btn btn-light">
							<input type="checkbox" name="gids[]" value="{$group['gid']}" autocomplete="off"><i class="far fa-fw fa-square"></i> {*<i class="fas fa-fw fa-users"></i>*} {$group['title']}
						</label>
					{/foreach}
				</div>
			</div>
		</div>
	{/if}

	<div class="form-group row">
		<label for="inputNoNav" class="col-md-4 col-form-label mb-0 mt-2 text-right">
			Навигация: <small><span class="fas fa-question-circle fa-fw" rel="tooltip" title="Данный раздел можно обозначить как часть общей навигации" data-placement="left"></span></small>
		</label>
		<div class="col-lg-8">
			<div class="btn-group btn-group-toggle roocms-boolui" data-toggle="buttons">
				<label class="btn btn-light active">
					<input type="radio" name="nav" value="1" id="flag_nav_false" checked><i class="fas fa-fw fa-check-square text-success"></i> Отображать
				</label>
				<label class="btn btn-light">
					<input type="radio" name="nav" value="0" id="flag_nav_true"><i class="fas fa-fw fa-square text-danger"></i> Скрыть
				</label>
			</div>
		</div>
	</div>
</div>
<div class="card-footer">
	<div class="row">
		<div class="col-lg-8 offset-md-4">
			<input type="submit" name="create_unit" class="btn btn-success" value="Создать">
			<input type="submit" name="create_unit['ae']" class="btn btn-outline-success" value="Создать и выйти">
		</div>
	</div>
</div>
</form>