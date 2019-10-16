<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$buttonId = $this->randString();
?>
<div class="bx-subscribe"  id="sender-subscribe">
<?
$frame = $this->createFrame("sender-subscribe", false)->begin("");
?>
	<?if(isset($arResult['MESSAGE'])) :?>
	<div class="style-msg successmsg">
		<div class="sb-msg">
			<strong><?=GetMessage('subscr_form_response_'.$arResult['MESSAGE']['TYPE'])?></strong>
			<?=htmlspecialcharsbx($arResult['MESSAGE']['TEXT'])?>
		</div>
	</div>
	<?endif?>

	<div class="widget-subscribe-form-result"></div>
	<form id="widget-subscribe-form3" action="<?=$arResult["FORM_ACTION"]?>" role="form" method="post" class="nobottommargin">
		<div class="input-group" style="max-width:400px;">
			<?=bitrix_sessid_post()?>
			<input type="hidden" name="sender_subscription" value="add">
			<input type="hidden" name="cosmos_ajax" value="Y">
			<?if(count($arResult["RUBRICS"])>0):?>
				<div class="bx-subscribe-desc"><?=GetMessage("subscr_form_title_desc")?></div>
			<?endif;?>
			<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
			<div class="bx_subscribe_checkbox_container">
				<input type="checkbox" name="SENDER_SUBSCRIBE_RUB_ID[]" id="SENDER_SUBSCRIBE_RUB_ID_<?=$itemValue["ID"]?>" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?>>
				<label for="SENDER_SUBSCRIBE_RUB_ID_<?=$itemValue["ID"]?>"><?=htmlspecialcharsbx($itemValue["NAME"])?></label>
			</div>
			<?endforeach;?>

			<span class="input-group-addon"><i class="icon-email2"></i></span>
			<input type="email" name="SENDER_SUBSCRIBE_EMAIL" value="<?=$arResult["EMAIL"]?>" title="<?=GetMessage("subscr_form_email_title")?>" placeholder="<?=htmlspecialcharsbx(GetMessage('subscr_form_email_title'))?>" class="form-control required email">
			<span class="input-group-btn">
				<button class="btn btn-danger" type="submit"><?=GetMessage("subscr_form_button")?></button>
			</span>
		</div>
	</form>
<?
$frame->end();
?>
</div>