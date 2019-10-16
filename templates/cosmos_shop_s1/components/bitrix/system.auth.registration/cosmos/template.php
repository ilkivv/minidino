<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div class="divcenter" style="max-width: 500px;">
	<?
	ShowMessage($arParams["~AUTH_RESULT"]);

	if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK"):?>
		<div class="style-msg successmsg">
			<div class="sb-msg"><i class="icon-thumbs-up"></i><?=GetMessage("AUTH_EMAIL_SENT")?></div>
		</div>
	<?else:?>
		<div class="panel panel-default nobottommargin">
			<div class="panel-body" style="padding: 40px;">
				<noindex>
				<form class="nobottommargin" method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
					<?if (strlen($arResult["BACKURL"]) > 0) : ?>
						<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
					<?endif;?>
					<input type="hidden" name="AUTH_FORM" value="Y" />
					<input type="hidden" name="TYPE" value="REGISTRATION" />

					<h4><?=GetMessage("AUTH_REGISTER")?></h4>
					<?if($arResult["USE_EMAIL_CONFIRMATION"] === "Y"):?>
						<p><?=GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></p>
					<?endif?>

					<div class="col_full">
						<label for="login-form-authname"><?=GetMessage("AUTH_NAME")?></label>
						<input id="login-form-authname" type="text" name="USER_NAME" value="<?=$arResult["USER_NAME"]?>" class="form-control" />
					</div>

					<div class="col_full">
						<label for="login-form-lastname"><?=GetMessage("AUTH_LAST_NAME")?></label>
						<input type="text" id="login-form-lastname" name="USER_LAST_NAME" value="<?=$arResult["USER_LAST_NAME"]?>" class="form-control" />
					</div>

					<div class="col_full">
						<label for="login-form-authlogin"><?=GetMessage("AUTH_LOGIN_MIN")?> *</label>
						<input type="text" id="login-form-authlogin" name="USER_LOGIN" value="<?=$arResult["USER_LOGIN"]?>" class="form-control" />
					</div>

					<div class="col_full">
						<label for="login-form-passwordreq"><?=GetMessage("AUTH_PASSWORD_REQ")?> *</label>
						<input id="login-form-passwordreq" type="password" name="USER_PASSWORD" value="<?=$arResult["USER_PASSWORD"]?>" class="form-control" />

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

					<div class="col_full">
						<label for="login-form-authcofm"><?=GetMessage("AUTH_CONFIRM")?> *</label>
						<input id="login-form-authcofm" type="password" name="USER_CONFIRM_PASSWORD" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="form-control" />
					</div>
					<div class="col_full">
						<label for="login-form-authemail"><?=GetMessage("AUTH_EMAIL")?><?if($arResult["EMAIL_REQUIRED"]):?> *<?endif?></label>
						<input id="login-form-authemail" type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" class="form-control" />
					</div>


					<?// ********************* User properties ***************************************************?>
					<?if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):?>
							<h4><?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></h4>
							<?foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):?>
								<div class="col_full">
									<label for="login-form-authemail">
										<?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?> *<?endif;?>
									</label>
									<?$APPLICATION->IncludeComponent(
										"bitrix:system.field.edit",
										$arUserField["USER_TYPE"]["USER_TYPE_ID"],
										array(
											"bVarsFromForm" => $arResult["bVarsFromForm"],
											"arUserField" => $arUserField,
											"form_name" => "bform"),
										null,
										array("HIDE_ICONS"=>"Y")
									);?>
								</div>
							<?endforeach;?>
					<?endif;?>
					<?// ******************** /User properties ***************************************************?>

					<?if ($arResult["USE_CAPTCHA"] == "Y"):?>
						<div class="col_full">
								<div class="col_full nobottommargin">
									<label for="form-captcha-password"><?=GetMessage("CAPTCHA_REGF_PROMT")?> *</label>
								</div>
								<div class="col_half">
									<input id="form-captcha-password" class="form-control" type="text" name="captcha_word" value="" size="15" />
								</div>
								<div class="col_half col_last">
									<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" height="34" alt="CAPTCHA" />
								</div>
						</div>
					<?endif;?>

					<div class="col_full">
						<input class="button button-3d nomargin" type="submit" name="Register" value="<?=GetMessage("AUTH_REGISTER")?>" />
						<a class="fright" href="<?=$arResult["AUTH_AUTH_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_AUTH")?></a>
					</div>
				</form>
				<p class="nobottommargin">
					<?=$arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?><br>
					<span class="starrequired">*</span><?=GetMessage("AUTH_REQ")?>
				</p>
				</noindex>
				<script type="text/javascript">
					document.bform.USER_NAME.focus();
				</script>
			</div>
		</div>
	<?endif?>
</div>