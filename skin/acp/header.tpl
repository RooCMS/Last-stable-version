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
<meta http-equiv="Content-Type" 	content="{$charset}" />
<meta http-equiv="Content-language"	content="ru" />
<meta http-equiv="Pragma" 		content="no-cache" />
<meta http-equiv="Expires" 		content="-1" />
<meta http-equiv="Cache-Control" 	content="no-cache" />

<link href="favicon.ico" 	rel="icon" 		type="image/x-icon" />
<link href="favicon.ico" 	rel="shortcut icon" 	type="image/x-icon" />

<base href="{if trim($site['domain']) != ""}{$site['domain']}{else}http://{$smarty.server.SERVER_NAME}{/if}" /><!--[if IE]></base><![endif]-->

<!-- Style -->
<link rel="stylesheet" type="text/css" href="{$SKIN}/style.min.css{$build}" media="screen" />

<!-- JS -->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<script type="text/javascript" src="plugin/iepngfix_tilebg.min.js{$build}"></script>
<script type="text/javascript" src="plugin/jquery-core.min.js{$build}"></script>
<script type="text/javascript" src="plugin/jquery-migrate.min.js{$build}"></script>
<script type="text/javascript" src="plugin/colorbox.js.php{$build}"></script>
<script type="text/javascript" src="plugin/jquery.zoom.min.js{$build}"></script>
<script type="text/javascript" src="plugin/bootstrap.php{$build}"></script>
<script type="text/javascript" src="{$SKIN}/roocms.min.js{$build}"></script>

{$jscript}

</head>
<body>

{if isset($cpmenu)}{$cpmenu}{/if}

{if trim($error) != ""}
	<div class="alert alert-danger t12 text-left in fade notice" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		{$error}
	</div>
{/if}
{if trim($info) != ""}
	<div class="alert alert-info t12 text-left in fade notice" role="alert">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		{$info}
	</div>
{/if}

<div class="container-fluid">
	<div class="row">