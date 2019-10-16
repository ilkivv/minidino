<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);
?>
<?if (strlen($arParams["TITLE_TEXT"]) > 0) : ?>
	<? if ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] != "N") : ?>
		<div class="heading-block center">
			<h3><?= $arParams["TITLE_TEXT"] ?></h3>
			<span><?= $arParams["UNDER_TITLE_TEXT"] ?></span>
		</div>
	<?elseif ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] == "N" && count($arResult["ITEMS"]) > 0) : ?>
		<div class="line topmargin-sm bottommargin-sm"></div>
		<h3>
			<?= $arParams["TITLE_TEXT"] ?>
		</h3>
	<?endif;?>
<?endif;?>
<ul class="testimonials-grid grid-<?=$arParams["ELEMENT_LINE_COUNT"]?> clearfix nobottommargin<?=($arParams["ELEMENT_LINE_COUNT"] > 1) ? "":" noautomaxheight"?>">
	<? foreach ($arResult["ITEMS"] as $arItem): ?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<li id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
			<div class="testimonial">
				<?if (isset($arItem["PREVIEW_PICTURE_RESIZED"]["SRC"]) && strlen($arItem["PREVIEW_PICTURE_RESIZED"]["SRC"]) > 0) :?>
					<div class="testi-image">
						<img src="<?= $arItem["PREVIEW_PICTURE_RESIZED"]["SRC"] ?>" alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>">
					</div>
				<?endif;?>
				<div class="testi-content">
					<p><?= $arItem["PREVIEW_TEXT"] ?></p>
					<?if (count($arItem["ADDITIONAL_FILES"]) > 0) :?><br>
						<?foreach($arItem["ADDITIONAL_FILES"] as $keyFile => $arFile):?>
							<div class="<?=($arParams["ELEMENT_LINE_COUNT"] > 2) ? "col_full":"col_half"?><?=(($keyFile+1) % 2 == 0) ? " col_last" : ""?> bottommargin-sm">
								<div class="feature-box fbox-plain fbox-small">
									<div class="fbox-icon bounceIn animated" data-animate="bounceIn">
										<a href="<?=$arFile["SRC"]?>" title="<?=$arFile["ORIGINAL_NAME"]?>" target="_blank">
											<img src="<?=$arFile["FILE_EXTENSION_SRC"]?>" alt="<?=$arFile["ORIGINAL_NAME"]?>">
										</a>
									</div>
									<a href="<?=$arFile["SRC"]?>" target="_blank" title="<?=$arFile["ORIGINAL_NAME"]?>"><h3 class="nobottommargin"><?=$arFile["ORIGINAL_NAME"]?> (<?=$arFile["FILE_SIZE_FORMATED"]?>)</h3></a>
								</div>
							</div>
						<?endforeach;?>
						<div class="clear"></div>
					<?endif;?>
					<div class="testi-meta">
						<?= $arItem["NAME"] ?>
						<span><?= $arItem["DISPLAY_PROPERTIES"]["CLIENT_COMPANY"]["DISPLAY_VALUE"] ?></span>
					</div>
				</div>
			</div>
		</li>
	<? endforeach; ?>
</ul>