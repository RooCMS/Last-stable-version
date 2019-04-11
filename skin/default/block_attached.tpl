{* Шаблон дизайна отображения картинок и файлов в блоках *}

{if !empty($images)}
	<div class="d-flex flex-row align-content-stretch justify-content-center flex-wrap">
		{assign var=UGID value= 1|rand:399}
		{foreach from=$images item=img name=bimgs}
			<a href="/upload/images/{$img['resize']}" data-fancybox="gallery{$UGID}" data-animation-duration="300" data-caption="{$img['alt']}" title="{$img['alt']}" class="px-1 mb-1 {if $smarty.foreach.bimgs.total <= 6}flex-fill{/if} block-images"><img src="/upload/images/{$img['thumb']}" class="w-100 img-fluid border my-1" alt="{$img['alt']}"></a>
		{/foreach}
	</div>
{/if}


{if !empty($attachfile)}
	<strong class="small">Файлы:</strong>
	<div class="d-flex flex-column flex-sm-row align-content-stretch {*justify-content-center*} flex-wrap mb-3">
		{foreach from=$attachfile item=file}
			<br /><a href="/upload/files/{$file['file']}" class="btn btn-sm btn-outline-gray flex-fill"><i class="fas fa-fw fa-download"></i> {$file['filetitle']}</a>
		{/foreach}
	</div>
{/if}