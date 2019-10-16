<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true);
$uniqId = $this->randString(6);
if (count($arResult["ITEMS"]) < 1) return;
?>
<div class="owl-carousel owl-carousel-full image-carousel carousel-widget" style="padding: 20px 0;"
		data-margin="30" data-loop="true" data-nav="false" data-pagi="false" data-items-xxs="2" data-items-xs="3" data-items-sm="<?=$arParams["ELEMENT_LINE_COUNTER"]?>" data-items-md="<?=$arParams["ELEMENT_LINE_COUNTER"]?>" data-items-lg="<?=$arParams["ELEMENT_LINE_COUNTER"]?>">
	<? foreach ($arResult["ITEMS"] as $arItem): ?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="oc-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
			<?if(isset($arItem["PROPERTIES"]["LINK"]["VALUE"]) && strlen($arItem["PROPERTIES"]["LINK"]["VALUE"]) > 0):?>
				<a href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"];?>" target="_blank">
					<img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>">
				</a>
			<?else:?>
				<img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>">
			<?endif;?>
		</div>
	<? endforeach; ?>
</div>