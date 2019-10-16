<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="divcenter" style="max-width: 500px;">
	<?if ($USER->IsAuthorized()) :?>
		<div class="style-msg successmsg">
			<div class="sb-msg"><i class="icon-thumbs-up"></i><?=$arResult["MESSAGE_TEXT"]?></div>
		</div>
	<?else :?>
		<div class="style-msg alertmsg">
			<div class="sb-msg"><i class="icon-warning-sign"></i><?=$arResult["MESSAGE_TEXT"]?></div>
		</div>
	<?endif;?>
	<?//here you can place your own messages
		switch($arResult["MESSAGE_CODE"])
		{
		case "E01":
			?><? //When user not found
			break;
		case "E02":
			?><? //User was successfully authorized after confirmation
			break;
		case "E03":
			?><? //User already confirm his registration
			break;
		case "E04":
			?><? //Missed confirmation code
			break;
		case "E05":
			?><? //Confirmation code provided does not match stored one
			break;
		case "E06":
			?><? //Confirmation was successfull
			break;
		case "E07":
			?><? //Some error occured during confirmation
			break;
		}
	?>
	<?if($arResult["SHOW_FORM"]):?>
		<div class="panel panel-default nobottommargin">
			<div class="panel-body" style="padding: 40px;">
				<form method="post" action="<?=$arResult["FORM_ACTION"]?>" class="nobottommargin">

					<h3><?=GetMessage("CT_BSAC_CONFIRM_TITLE")?></h3>

					<div class="col_full">
						<label for="login-form-username"><?=GetMessage("CT_BSAC_LOGIN")?>:</label>
						<input class="form-control" type="text" id="login-form-username" name="<?=$arParams["LOGIN"]?>" value="<?=(strlen($arResult["LOGIN"]) > 0? $arResult["LOGIN"]: $arResult["USER"]["LOGIN"])?>" />
					</div>

					<div class="col_full">
						<label for="login-form-confirm-code"><?=GetMessage("CT_BSAC_CONFIRM_CODE")?>:</label>
						<input id="login-form-confirm-code" class="form-control" type="text" name="<?=$arParams["CONFIRM_CODE"]?>" value="<?=$arResult["CONFIRM_CODE"]?>"/>
					</div>

					<div class="col_full nobottommargin">
						<input class="button button-3d nomargin" type="submit" value="<?=GetMessage("CT_BSAC_CONFIRM")?>" />
					</div>
					<input type="hidden" name="<?=$arParams["USER_ID"]?>" value="<?=$arResult["USER_ID"]?>" />
				</form>
			</div>
		</div>
	<?elseif(!$USER->IsAuthorized()):?>
		<?$APPLICATION->IncludeComponent("bitrix:system.auth.authorize", "cosmos", Array(

		),
		false
	);?>
	<?endif?>
</div>
