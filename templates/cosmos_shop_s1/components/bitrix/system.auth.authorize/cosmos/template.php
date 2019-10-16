<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?
ShowMessage($arParams["~AUTH_RESULT"]);
ShowMessage($arResult['ERROR_MESSAGE']);
?>
<div class="divcenter" style="max-width: 500px;">
	<div class="panel panel-default nobottommargin">
		<div class="panel-body" style="padding: 40px;">

			<form name="form_auth" method="post" class="nobottommargin" target="_top" action="<?=$arResult["AUTH_URL"]?>">

				<?if($arResult["AUTH_SERVICES"]):?>
					<h4><?=GetMessage("AUTH_TITLE")?></h4>
				<?endif?>

				<input type="hidden" name="AUTH_FORM" value="Y" />
				<input type="hidden" name="TYPE" value="AUTH" />
				<?if (strlen($arResult["BACKURL"]) > 0):?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
				<?endif?>
				<?foreach ($arResult["POST"] as $key => $value):?>
					<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
				<?endforeach?>

				<div class="col_full">
					<label for="login-form-username"><?=GetMessage("AUTH_LOGIN")?></label>
					<input id="login-form-username" class="form-control" type="text" name="USER_LOGIN" value="<?=$arResult["LAST_LOGIN"]?>" />
				</div>

				<div class="col_full">
					<label for="login-form-password"><?=GetMessage("AUTH_PASSWORD")?></label>
					<input id="login-form-password" class="form-control" type="password" name="USER_PASSWORD" autocomplete="off" />
					<?if($arResult["SECURE_AUTH"]):?>
						<span class="bx-auth-secure" id="bx_auth_secure" title="<?=GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
						</span>
						<noscript>
							<span class="bx-auth-secure" title="<?=GetMessage("AUTH_NONSECURE_NOTE")?>">
								<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
							</span>
						</noscript>
						<script type="text/javascript">
							document.getElementById('bx_auth_secure').style.display = 'block';
						</script>
					<?endif?>
				</div>

				<?if($arResult["CAPTCHA_CODE"]):?>
					<div class="col_full">
						<div class="col_full nobottommargin">
							<label for="form-captcha-password"><?echo GetMessage("AUTH_OTP_CAPTCHA_PROMT")?></label>
						</div>
						<div class="col_half">
							<input id="form-captcha-password" class="form-control" type="text" name="captcha_word" value="" size="15" />
						</div>
						<div class="col_half col_last">
							<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
							<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" height="34" alt="CAPTCHA" />
						</div>
					</div>
				<?endif;?>

				<div class="col_full">
					<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
						<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" />
						<label for="USER_REMEMBER">&nbsp;<?=GetMessage("AUTH_REMEMBER_ME")?></label>
					<?endif?>
				</div>


				<div class="col_full">
					<div class="col_half">
						<input class="button button-3d nomargin" type="submit" name="Login" value="<?=GetMessage("AUTH_AUTHORIZE")?>" />
					</div>
					<div class="col_half col_last">
						<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
							<noindex>
								<a class="fright" href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a><br>
								<a class="fright" href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a>
							</noindex>
						<?endif?>
					</div>
				</div>
			</form>
			<?if($arResult["AUTH_SERVICES"]):?>
				<div class="divider divider-border divider-center"><i class="icon-cloud3"></i></div>
				<div class="col_full nobottommargin">
						<?
						$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
							array(
								"AUTH_SERVICES" => $arResult["AUTH_SERVICES"],
								"CURRENT_SERVICE" => $arResult["CURRENT_SERVICE"],
								"AUTH_URL" => $arResult["AUTH_URL"],
								"POST" => $arResult["POST"],
								"SHOW_TITLES" => $arResult["FOR_INTRANET"]?'N':'Y',
								"FOR_SPLIT" => $arResult["FOR_INTRANET"]?'Y':'N',
								"AUTH_LINE" => $arResult["FOR_INTRANET"]?'N':'Y',
							),
							$component,
							array("HIDE_ICONS"=>"Y")
						);
						?>
				</div>
			<?endif?>
			<script type="text/javascript">
				<?if (strlen($arResult["LAST_LOGIN"])>0):?>
				try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
				<?else:?>
				try{document.form_auth.USER_LOGIN.focus();}catch(e){}
				<?endif?>
			</script>
		</div>
	</div>
</div>
