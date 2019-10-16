<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
$uniqId = "portfolio-" . $this->randString(6);
?>
<?if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
	<?if (count($arResult["SECTIONS"]) > 1) : ?>
        <!-- Portfolio Filter
        ============================================= -->
        <ul class="portfolio-filter clearfix" data-container="#<?=$uniqId?>">
        
            <li class="activeFilter"><a href="#" data-filter="*"><?=GetMessage('NL_PF_SHOW_ALL');?></a></li>
            <?foreach($arResult["SECTIONS"] as $arSect):?>
                <li><a href="#" data-filter=".pf-<?=$arSect["ID"]?>"><?=$arSect["NAME"]?></a></li>
            <?endforeach;?>
        
        </ul><!-- #portfolio-filter end -->

        <div class="clear"></div>
    <?endif;?>
    <!-- Portfolio Items
    ============================================= -->
    <div id="<?=$uniqId?>" class="portfolio grid-container portfolio-3 clearfix" data-layout="fitRows">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
		    <article class="portfolio-item<?=$arItem["SECTION_CLASS"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		        <div class="portfolio-image">
		            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
		                <img src="<?=$arItem["PREVIEW_PICTURE"]["RESIZED"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
		            </a>
		            <div class="portfolio-overlay" data-lightbox="gallery">
		                <a href="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" class="left-icon" data-lightbox="gallery-item"><i class="icon-line-zoom-in"></i></a>
		                <?foreach($arItem["PROPERTIES"]["MORE_PHOTO"]["SLIDES"] as $arSlide):?>
	                        <a href="<?=$arSlide["SRC"]?>" class="hidden" data-lightbox="gallery-item"></a>
		                <?endforeach;?>
		                <a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="right-icon"><i class="icon-line-ellipsis"></i></a>
		            </div>
		        </div>
		        <div class="portfolio-desc">
		            <h3><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h3>
		            <span><?=$arItem["SECTION_TAGS"]?></span>
		        </div>
		    </article>

		<?endforeach;?>
    </div><!-- #portfolio end -->

	<?if (count($arResult["SECTIONS"]) > 1) : ?>
    <?endif;?>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>
