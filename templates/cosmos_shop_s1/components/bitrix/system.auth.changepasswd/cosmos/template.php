<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
ShowMessage($arParams["~AUTH_RESULT"]);
?>
<div class="divcenter" style="max-width: 500px;">
	<div class="panel panel-default nobottommargin">
		<div class="panel-body" style="padding: 40px;">
			<form class="nobottommargin" method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
				<?if (strlen($arResult["BACKURL"]) > 0): ?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<? endif ?>
				<input type="hidden" name="AUTH_FORM" value="Y">
				<input type="hidden" name="TYPE" value="CHANGE_PWD">
				<h4><?=GetMessage("AUTH_CHANGE_PASSWORD")?></h4>

				<div class="col_full">
					<label for="login-form-username"><?=GetMessage("AUTH_LOGIN")?> *</label>
					<input type="text" id="login-form-username" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" class="form-control" />
				</div>

				<div class="col_full">
					<label for="login-form-checkword"><?=GetMessage("AUTH_CHECKWORD")?> *</label>
					<input type="text" id="login-form-checkword" name="USER_CHECKWORD" maxlength="50" value="<?=$arResult["USER_CHECKWORD"]?>" class="form-control" />
				</div>

				<div class="col_full">
					<label for="login-form-password"><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?> *</label>
					<input type="password" id="login-form-password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="form-control" autocomplete="off" />
					<?if($arResult["SECURE_AUTH"]):?>
						<span class="bx-auth-secure" id="bx_auth_secure" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
						</span>
						<noscript>
							<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
								<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
							</span>
						</noscript>
						<script type="text/javascript">
							document.getElementById('bx_auth_secure').style.display = 'block';
						</script>
					<?endif?>
				</div>

				<div class="col_full">
					<label for="login-form-password-confirm"><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?> *</label>
					<input id="login-form-password-confirm" type="password" name="USER_CONFIRM_PASSWORD" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="form-control" />
				</div>

				<div class="col_full">
					<input class="button button-3d nomargin" type="submit" name="change_pwd" value="<?=GetMessage("AUTH_CHANGE")?>" />
					<a href="<?=$arResult["AUTH_AUTH_URL"]?>" class="fright"><?=GetMessage("AUTH_AUTH")?></a>
				</div>
			</form>

			<div class="col_full nobottommargin">
				<p class="nobottommargin"><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></p>
				<p class="nobottommargin"><?=GetMessage("AUTH_REQ")?> *</p>
			</div>
			<script type="text/javascript">
				document.bform.USER_LOGIN.focus();
			</script>
		</div>
	</div>
</div>


