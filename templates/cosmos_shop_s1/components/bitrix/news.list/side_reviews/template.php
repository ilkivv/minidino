<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? $this->setFrameMode(true);
if (count($arResult["ITEMS"]) < 1) return;
?>
<div class="widget clearfix">
	<h4><?= $arResult["NAME"] ?></h4>

	<div class="fslider testimonial noborder nopadding noshadow" data-animation="slide" data-arrows="false">
		<div class="flexslider">
			<div class="slider-wrap">
				<? foreach ($arResult["ITEMS"] as $arItem): ?>
					<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
					<div class="slide" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
						<? if (isset($arItem["PREVIEW_PICTURE"]["SRC"])): ?>
							<div class="testi-image">
								<img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
										 title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>">
							</div>
						<? endif; ?>
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

</div>
