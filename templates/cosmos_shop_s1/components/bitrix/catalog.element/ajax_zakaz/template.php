<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(false);
$elCurrency = $arResult["DISPLAY_PROPERTIES"]["PRICECURRENCY"]["VALUE_ENUM"];
$arPropHide = array("PRICE", "NEW_PRICE", "PRICECURRENCY", "PRODUCT_STATUS", "MORE_PHOTO");
?>
<h4 class="bottommargin-sm"><?=$arResult["NAME"]?></h4>
<!-- Product Single - Gallery
============================================= -->
<div class="product-image bottommargin-sm">
	<img src="<?=$arResult["DETAIL_PICTURE_RESIZED"]["SRC"]?>" alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>">
</div>
<div class="product-price">
	<?if ($arResult["PRICES"]["PRICE"]["VALUE"] < 1):?>
		<span><?=GetMessage("CATALOG_ASK_FOR_PRICE")?></span>
	<?else:?>
		<?if(isset($arResult["PRICES"]["NEW_PRICE"]["VALUE"]) && $arResult["PRICES"]["NEW_PRICE"]["VALUE"] > 0):?>
			<del><?=$arResult["PRICES"]["PRICE"]["VALUE"]?> <?=$elCurrency?></del>
			<ins><?=$arResult["PRICES"]["NEW_PRICE"]["VALUE"]?> <?=$elCurrency?></ins>
		<?else:?>
			<ins><?=$arResult["PRICES"]["PRICE"]["VALUE"]?> <?=$elCurrency?></ins>
		<?endif;?>
	<?endif;?>
	<?if(
		isset($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"])
		&& strlen($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"]) > 0
		&& isset($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"])
	):?>
		<?
		$labelClass='';
		if ($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "EXPECTED") {
			$labelClass = "warning";
		} elseif ($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "IN_STOCK") {
			$labelClass = "success";
		} elseif ($arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE_XML_ID"] == "UNDER_THE_ORDER") {
			$labelClass = "info";
		}
		?>
		<span class="label label-<?=$labelClass?>"><?=$arResult["DISPLAY_PROPERTIES"]["PRODUCT_STATUS"]["VALUE"]?></span>
	<?endif;?>
</div>