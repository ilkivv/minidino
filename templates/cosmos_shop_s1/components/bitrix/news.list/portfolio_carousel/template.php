<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
?>
<? if ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] != "N") :?>
	<div class="heading-block center">
		<h3><?= $arParams["TITLE_TEXT"] ?></h3>
		<span><?= $arParams["UNDER_TITLE_TEXT"] ?></span>
	</div>
<?elseif ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] == "N" && count($arResult["ITEMS"]) > 0) : ?>
	<div class="line topmargin-sm bottommargin-sm"></div>
	<h3><?= $arParams["TITLE_TEXT"] ?></h3>
<?endif;?>
<div class="owl-carousel portfolio-carousel carousel-widget portfolio-nomargin"  data-margin="1" data-nav="true" data-pagi="false" data-items-xxs="1" data-items-xs="1" data-items-sm="2" data-items-md="<?=$arParams["VISIBLE_ELEMENTS_COUNT"]?>"  data-items-lg="<?=$arParams["VISIBLE_ELEMENTS_COUNT"]?>">
	<? foreach ($arResult["ITEMS"] as $arItem): ?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
		<div class="oc-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
			<div class="iportfolio">
				<div class="portfolio-image">
					<a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
						<img src="<?= $arItem["PREVIEW_PICTURE_RESIZED"]["SRC"] ?>" alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>">
					</a>

					<div class="portfolio-overlay">
						<a href="<?= $arItem["PREVIEW_PICTURE_RESIZED_BIG"]["SRC"] ?>" class="left-icon" data-lightbox="image">
							<i class="icon-line-zoom-in"></i>
						</a>
						<a href="<?= $arItem["DETAIL_PAGE_URL"] ?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
					</div>
				</div>
				<div class="portfolio-desc">
					<h3><a href="<?= $arItem["DETAIL_PAGE_URL"] ?>"><?= $arItem["NAME"] ?></a></h3>
					<span><?= $arItem["SECTION_TAGS"] ?></span>
				</div>
			</div>
		</div>
	<? endforeach; ?>
</div>