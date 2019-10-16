<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
</div>
<div class="section parallax dark notopmargin" style="background-image: url('<?=$arParams["BG_SRC"]?>'); padding: 120px 0;" data-stellar-background-ratio="0.4">
	<div class="fslider testimonial testimonial-full" data-arrows="false" style="z-index: 2;">
		<div class="flexslider">
			<div class="slider-wrap">
				<? foreach ($arResult["ITEMS"] as $arItem): ?>
				<?
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
					<div class="testi-image">
						<img src="<?= $arItem["PREVIEW_PICTURE_RESIZED"]["SRC"] ?>" alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>">
					</div>
					<div class="testi-content">
						<p><?= $arItem["PREVIEW_TEXT"] ?></p>
						<div class="testi-meta">
							<?= $arItem["NAME"] ?>
							<span><?= $arItem["DISPLAY_PROPERTIES"]["CLIENT_COMPANY"]["DISPLAY_VALUE"] ?></span>
						</div>
					</div>
				</div>
				<? endforeach; ?>
			</div>
		</div>
	</div>
	<div class="video-wrap" style="z-index: 1;">
		<? $classBgColor = (strlen($arParams["BG_COLOR"]) < 2) ?  " bgcolor": ""?>
		<div class="video-overlay<?=$classBgColor?>" style="background: <?=$arParams["BG_COLOR"]?>;"></div>
	</div>
</div>
<div class="container clearfix">