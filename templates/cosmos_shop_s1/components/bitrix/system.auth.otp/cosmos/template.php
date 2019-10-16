<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
?>
<div class="divcenter" style="max-width: 500px;">
	<?if ($arResult['REQUIRED_BY_MANDATORY'] === true):?>
	<?$APPLICATION->IncludeComponent(
		"bitrix:security.auth.otp.mandatory",
		"",
		array(
			"AUTH_LOGIN_URL" => $arResult["~AUTH_LOGIN_URL"],
			"NOT_SHOW_LINKS" => $arParams["NOT_SHOW_LINKS"]
		)
	);?>
	<?else:?>
	<?
	ShowMessage($arParams["~AUTH_RESULT"]);
	?>
		<div class="panel panel-default nobottommargin">
			<div class="panel-body" style="padding: 40px;">
				<form name="form_auth" method="post" target="_top" class="nobottommargin" action="<?=$arResult["AUTH_URL"]?>">
					<input type="hidden" name="AUTH_FORM" value="Y" />
					<input type="hidden" name="TYPE" value="OTP" />

					<h4><?=GetMessage("AUTH_OTP_PLEASE_AUTH")?></h4>

					<div class="col_full">
						<label for="form-otp-password"><?=GetMessage("AUTH_OTP_OTP")?></label>
						<input id="form-otp-password" class="form-control" type="text" name="USER_OTP" value="" autocomplete="off"/>
					</div>

					<div class="col_full">
						<?if($arResult["CAPTCHA_CODE"]):?>
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
						<?endif;?>
					</div>

					<?if($arResult["REMEMBER_OTP"]):?>
						<div class="col_full">
							<input type="checkbox" id="OTP_REMEMBER" name="OTP_REMEMBER" value="Y" /><label for="OTP_REMEMBER">&nbsp;<?=GetMessage("AUTH_OTP_REMEMBER_ME")?></label>
						</div>
					<?endif?>
					<div class="col_full nobottommargin">
						<input class="button button-3d nomargin" type="submit" name="Otp" value="<?=GetMessage("AUTH_OTP_AUTHORIZE")?>" />
						<?if ($arParams["NOT_SHOW_LINKS"] != "Y"):?>
							<a href="<?=$arResult["AUTH_LOGIN_URL"]?>" class="fright" rel="nofollow"><?echo GetMessage("AUTH_OTP_AUTH_BACK")?></a>
						<?endif?>
					</div>
				</form>
			</div>
		</div>
	<script type="text/javascript">
	try{document.form_auth.USER_OTP.focus();}catch(e){}
	</script>
	<?endif;?>
</div>
