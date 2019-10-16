<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
<div id="posts" class="small-thumbs">
	<?if ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] == "Y" && $arParams["SHOW_INFOBLOCK_DESCRIPTION_POSITION"] == "top"
		&& $arResult["NAV_RESULT"]->NavPageNomer == 1 && strlen($arResult["DESCRIPTION"]) > 0) :?>
		<div class="col_full">
			<?=$arResult["DESCRIPTION"]?>
		</div>
	<?endif;?>

	<?if ($arParams["SHOW_SECTION_DESCRIPTION"] == "Y" && $arParams["SHOW_SECTION_DESCRIPTION_POSITION"] == "top"
		&& $arResult["NAV_RESULT"]->NavPageNomer == 1 && isset($arResult["SECTION"]["PATH"][0]["DESCRIPTION"])
		&& strlen($arResult["SECTION"]["PATH"][0]["DESCRIPTION"]) > 0) :?>
		<div class="col_full">
			<?=$arResult["SECTION"]["PATH"][0]["DESCRIPTION"]?>
		</div>
	<?endif;?>

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
    <div class="entry clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>" itemscope itemtype="http://schema.org/NewsArticle">
		<?if($arParams["DISPLAY_PICTURE"]!="N" && is_array($arItem["PREVIEW_PICTURE"])):?>
			<?if ($arParams["NL_USE_IMAGE_RESIZE"] == "Y") : ?>
		        <div class="entry-image">
		            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
		            	<img itemprop="image" class="image_fade" src="<?=$arItem["PREVIEW_PICTURE_RESIZED"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
		            </a>
		        </div>
			<?else:?>
		        <div class="entry-image">
		            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
		            	<img itemprop="image" class="image_fade" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
		            </a>
		        </div>
			<?endif;?>
		<?endif?>
        <div class="entry-c">
			<?if($arParams["DISPLAY_NAME"]!="N" && $arItem["NAME"]):?>
				<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
		            <div class="entry-title">
		                <h2 itemprop="headline"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h2>
		            </div>
				<?else:?>
		            <div class="entry-title">
		                <h2 itemprop="headline"><?=$arItem["NAME"]?></h2>
		            </div>
				<?endif;?>
			<?endif;?>
            <ul class="entry-meta clearfix">
				<?if($arParams["DISPLAY_DATE"]!="N" && $arItem["DISPLAY_ACTIVE_FROM"]):?>
	                <li itemprop="datePublished"><i class="icon-calendar3"></i> <?=$arItem["DISPLAY_ACTIVE_FROM"]?></li>
				<?endif?>
            </ul>
	            <div class="entry-content" itemprop="description">
					<?if($arParams["DISPLAY_PREVIEW_TEXT"]!="N" && $arItem["PREVIEW_TEXT"]):?>
		                <p><?=$arItem["PREVIEW_TEXT"];?></p>
					<?endif;?>
					<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
	                	<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"class="button button-mini button-rounded noleftmargin"><?=GetMessage('MD_NL_READ_MORE');?></a>
					<?endif;?>
	            </div>
        </div>
    </div>
<?endforeach;?>
	<?if ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] == "Y" && $arParams["SHOW_INFOBLOCK_DESCRIPTION_POSITION"] == "bottom"
			&& $arResult["NAV_RESULT"]->NavPageNomer == 1 && strlen($arResult["DESCRIPTION"]) > 0) :?>
		<div class="col_full">
			<?=$arResult["DESCRIPTION"]?>
		</div>
	<?endif;?>
	<?if ($arParams["SHOW_SECTION_DESCRIPTION"] == "Y" && $arParams["SHOW_SECTION_DESCRIPTION_POSITION"] == "bottom"
		&& $arResult["NAV_RESULT"]->NavPageNomer == 1 && isset($arResult["SECTION"]["PATH"][0]["DESCRIPTION"])
		&& strlen($arResult["SECTION"]["PATH"][0]["DESCRIPTION"]) > 0) :?>
		<div class="col_full">
			<?=$arResult["SECTION"]["PATH"][0]["DESCRIPTION"]?>
		</div>
	<?endif;?>
</div><!-- #posts end -->
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
