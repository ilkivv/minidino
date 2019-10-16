<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?><?

ShowMessage($arParams["~AUTH_RESULT"]);

?>
<div class="divcenter" style="max-width: 500px;">
	<div class="panel panel-default nobottommargin">
		<div class="panel-body" style="padding: 40px;">
			<form name="bform" class="nobottommargin" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
				<?if (strlen($arResult["BACKURL"]) > 0) :?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?endif;?>
				<input type="hidden" name="AUTH_FORM" value="Y">
				<input type="hidden" name="TYPE" value="SEND_PWD">

				<h4><?=GetMessage("AUTH_FORGOT_TITLE")?></h4>
				<p>
					<?=GetMessage("AUTH_FORGOT_PASSWORD_1")?>
				</p>
				<div class="col_full">
					<label for="login-form-username"><?=GetMessage("AUTH_LOGIN")?></label>
					<input id="login-form-username" type="text" name="USER_LOGIN" class="form-control" value="<?=$arResult["LAST_LOGIN"]?>" />
				</div>

				<div class="col_full"><?=GetMessage("AUTH_OR")?></div>

				<div class="col_full">
					<label for="login-form-email"><?=GetMessage("AUTH_EMAIL")?></label>
					<input id="login-form-email" type="text" name="USER_EMAIL" class="form-control" />
				</div>

				<div class="col_full nobottommargin">
					<input class="button button-3d nomargin" type="submit" name="send_account_info" value="<?=GetMessage("AUTH_SEND")?>" />
					<a class="fright" href="<?=$arResult["AUTH_AUTH_URL"]?>"><?=GetMessage("AUTH_AUTH")?></a>
				</div>
			</form>
			<script type="text/javascript">
				document.bform.USER_LOGIN.focus();
			</script>
		</div>
	</div>
</div>
