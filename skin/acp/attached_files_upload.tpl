{* Форма загрузки изображений *}
<p>
	Загрузить файлы: <small><i class="fa fa-question-circle fa-fw" rel="tooltip" title="Можно загружать файлы форматов: {foreach from=$allow_files_type item=type name=itype}{$type['ext']}{if !$smarty.foreach.itype.last}, {/if}{/foreach}" data-placement="right"></i></small>
	<span class="btn btn-info btn-xs" id="addfiles"><i class="fa fa-fw fa-upload"></i> добавить поле для загрузки файлов</span>
	<div id="morefiles">
		<input type="file" name="files[]" class="btn btn-default" multiple size="50" accept="{foreach from=$allow_files_type item=type name=itype}{$type['mime_type']}{if !$smarty.foreach.itype.last},{/if}{/foreach}">
	</div>
</p>
{literal}
<script>
	$(document).ready(function() {
		$('#addfiles').click(function() {
			$('<input type="file" name="files[]" multiple size="50" class="btn btn-default" accept="{/literal}{foreach from=$allow_images_type item=type name=itype}{$type['mime_type']}{if !$smarty.foreach.itype.last},{/if}{/foreach}{literal}">').appendTo('#morefiles');
		});
	});
</script>
{/literal}


