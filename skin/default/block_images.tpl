{* Шаблон дизайна отображения картинок в блоках *}
<div class="center">
	{foreach from=$images item=img}
		<a href="/upload/images/resize/{$img['filename']}" rel="img"><img src="/upload/images/thumb/{$img['filename']}" class="img-thumbnail" style="margin: 3px 0px;"></a>
	{/foreach}
</div>



