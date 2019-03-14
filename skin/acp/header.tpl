<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" id="RooCMS">
<head>
<title>{$site['title']}</title>
<meta name="robots"			content="no-index,no-follow,all" />
<meta name="revisit-after"		content="365 days" />
<meta name="Document-state" 		content="dynamic" />
<meta name="Resource-type" 		content="document" />
<meta name="Author" 			content="alex Roosso @ {$site['domain']}" lang="ru" />
<meta name="Copyright" 			content="RooCMS @ {$site['domain']}" lang="ru" />
<meta name="viewport" 			content="width=device-width, initial-scale=1.0">
<meta name="theme-color"		content="#3D4F61">
<meta http-equiv="Content-Type" 	content="{$charset}" />
<meta http-equiv="Content-language"	content="ru" />
<meta http-equiv="Pragma" 		content="no-cache" />
<meta http-equiv="Expires" 		content="-1" />
<meta http-equiv="Cache-Control" 	content="no-cache" />

<link href="favicon.ico" 	rel="icon" 		type="image/x-icon" />
<link href="favicon.ico" 	rel="shortcut icon" 	type="image/x-icon" />

<base href="{if trim($site['domain']) != ""}http{if isset($smarty.server.HTTPS)}s{/if}://{$site['domain']}{else}http{if isset($smarty.server.HTTPS)}s{/if}://{$smarty.server.SERVER_NAME}{/if}" /><!--[if IE]></base><![endif]-->

<!-- Style -->
<link rel="stylesheet" type="text/css" href="plugin/fancybox/jquery.fancybox.min.css{$build}" media="screen" />
<link rel="stylesheet" type="text/css" href="/plugin/font-awesome/css/font-awesome.min.css{$build}" media="screen" />
<link rel="stylesheet" type="text/css" href="/plugin/bootstrap/css/bootstrap.min.css{$build}" media="screen" />
<link rel="stylesheet" type="text/css" href="/plugin/bootstrap-select/css/bootstrap-select.min.css{$build}" media="screen" />
<link rel="stylesheet" type="text/css" href="/plugin/bootstrap-datepicker/css/bootstrap-datepicker.min.css{$build}" media="screen" />
<link rel="stylesheet" type="text/css" href="/plugin/bootstrap-tagsinput/css/bootstrap-tagsinput.min.css{$build}" media="screen" />
<link rel="stylesheet" type="text/css" href="{$SKIN}/css/style.min.css{$build}" media="screen" />

<!-- JS -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<script type="text/javascript" src="plugin/iepngfix_tilebg.min.js{$build}"></script>
<script type="text/javascript" src="plugin/jquery-core.min.js{$build}"></script>
<script type="text/javascript" src="plugin/jquery-migrate.min.js{$build}"></script>
<script type="text/javascript" src="plugin/fancybox/jquery.fancybox.min.js{$build}"></script>
{*<script type="text/javascript" src="plugin/jquery.touchswipe.min.js{$build}"></script>*}
<script type="text/javascript" src="/plugin/bootstrap/js/bootstrap.bundle.min.js{$build}"></script>
<script type="text/javascript" src="/plugin/bootstrap-select/js/bootstrap-select.min.js{$build}"></script>
<script type="text/javascript" src="/plugin/bootstrap-select/js/i18n/defaults-ru_RU.min.js{$build}"></script>
<script type="text/javascript" src="/plugin/bootstrap-datepicker/js/bootstrap-datepicker.min.js{$build}"></script>
<script type="text/javascript" src="/plugin/bootstrap-datepicker/js/locales/bootstrap-datepicker.ru.min.js{$build}"></script>
<script type="text/javascript" src="/plugin/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js{$build}"></script>
<script type="text/javascript" src="{$SKIN}/js/roocms.min.js{$build}"></script>
<script type="text/javascript" src="{$SKIN}/js/jquery.roocms.boolui.min.js{$build}"></script>

{$jscript}

</head>
<body>

{if isset($cpmenu)}{$cpmenu}{/if}

{if trim($error) != ""}
	<div class="toast fade notice" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-header">
			{*<img src="..." class="rounded mr-2" alt="...">*}
			<strong class="mr-auto">Error</strong>
			<small>11 mins ago</small>
			<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="toast-body">
			{$error}
		</div>
	</div>
{/if}
{if trim($info) != ""}
	<div class="toast fade notice" role="status" aria-live="polite" aria-atomic="true">
		<div class="toast-header">
			{*<img src="..." class="rounded mr-2" alt="...">*}
			<strong class="mr-auto">Info</strong>
			<small>11 mins ago</small>
			<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="toast-body">
			{$info}
		</div>
	</div>
{/if}

<div class="container-fluid">
	<div class="row">