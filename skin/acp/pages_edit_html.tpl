{* Шаблон редактирования HTML страницы *}
<div class="panel-heading">
	<script type="text/javascript" src="plugin/ckeditor.php"></script>

	<q>{$data['title']}</q>

	<p class="pull-right"><a href="{$SCRIPT_NAME}?act=structure&part=edit&id={$data['sid']}" class="btn btn-default btn-xs"><span class="fa fa-pencil-square-o fa-fw"></span> Редактировать теги</a></p>
</div>
<div class="panel-body">
	<form method="post" action="{$SCRIPT_NAME}?act=pages&part=update&page={$data['sid']}" enctype="multipart/form-data" role="form" class="form-horizontal cked">
		<div class="row">
			<div class="col-lg-12">
				<dl class="dl-horizontal">
					<dt>ID #:</dt>
					<dd>{$data['sid']}</dd>

					<dt>Название страницы:</dt>
					<dd><a href="index.php/page-{$data['alias']}" target="_blank">{$data['title']}</a></dd>

					<dt>Алиас страницы:</dt>
					<dd>{$data['alias']}</dd>

					{if $data['meta_description'] != ""}
						<dt>Мета описание:</dt>
						<dd>{$data['meta_description']}</dd>
					{/if}

					{if $data['meta_keywords'] != ""}
						<dt>Мета ключевые слова:</dt>
						<dd>{$data['meta_keywords']}</dd>
					{/if}

					<dt>Последнее обновление:</dt>
					<dd>{$data['lm']}</dd>
				</dl>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<textarea id="content_field" class="form-control ckeditor" name="content">{$data['content']}</textarea>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				{$attachedimages}
			</div>
			<div class="col-md-6">
				{$attachedfiles}
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				{$imagesupload}
			</div>
			<div class="col-md-6">
				{$filesupload}
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 text-right">
				<input type="submit" name="update_page" class="btn btn-success" value="Обновить страницу">
			</div>
		</div>
	</form>
</div>