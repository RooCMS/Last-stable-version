{* Шаблон переноса элемента из ленты в ленту *}

<div class="panel-heading">
	Переносим "{$item['title']}"
</div>

<form method="post" action="{$SCRIPT_NAME}?act=feeds&part=migrate_item&item={$item['id']}&page={$item['sid']}" role="form" class="form-horizontal">
	<div class="panel-body">
		<div class="row">
			<div class="col-xs-12 lead">
					Переносим публикацию: <span class="mark">"{$item['title']}"</span>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-5 text-right">
				из ленты
				<br /><span class="btn btn-default btn-block">{$feeds[$item['sid']]['title']}</span>
			</div>
			<div class="col-sm-2 text-center">
				<i class="fa fa-fw fa-angle-double-right fa-4x"></i>
			</div>
			<div class="col-sm-5">
				в ленту
				<br />
				<select name="to" id="inputFeeds" class="selectpicker show-tick" required data-header="Ленты" data-size="auto" data-live-search="true" data-width="100%">
					{foreach from=$feeds item=f}
						<option value="{$f['id']}" data-subtext="{$f['alias']}" {if $f['id'] == $item['sid']}selected disabled="disabled" {/if}>{$f['title']}</option>
					{/foreach}
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 text-right">
				<input type="hidden" name="from" value="{$item['sid']}">
				<input type="hidden" name="item" value="{$item['id']}">
				<input type="submit" name="migrate_item" class="btn btn-success" value="Сохранить">
			</div>
		</div>
	</div>
</form>

