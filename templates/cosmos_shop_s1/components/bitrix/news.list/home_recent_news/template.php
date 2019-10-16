<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<? if ($arParams["HEADER_TITLE_TYPE"] == "h4") : ?>
	    <h4><?=$arParams["PAGER_TITLE"]?></h4>
<?else : ?>
	<div class="fancy-title title-bottom-border hidden-sm">
	    <h3><?=$arParams["PAGER_TITLE"]?></h3>
	</div>
<?endif;?>
<div id="home-recent-news" class="hidden-sm">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>
	    <div class="spost clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
			<?if ($arParams["NL_USE_IMAGE_RESIZE"] == "Y") : ?>
		        <div class="entry-image">
		            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
		            	<img class="image_fade" src="<?=$arItem["PREVIEW_PICTURE_RESIZED"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
		            </a>
		        </div>
			<?else:?>
		        <div class="entry-image">
		            <a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
		            	<img class="image_fade" src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
		            </a>
		        </div>
			<?endif;?>
	        <div class="entry-c">
	            <div class="entry-title">
	                <h4><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h4>
	            </div>
	            <ul class="entry-meta">
	                <li><i class="icon-calendar3"></i> <?=$arItem["DISPLAY_ACTIVE_FROM"]?></li>
	            </ul>
	        </div>
	    </div>
	<?endforeach;?>
	<? if ($arParams["HIDE_ALL_LINK"] != "Y") : ?>
		<a href="<?=str_replace('#SITE_DIR#', SITE_DIR, $arResult["LIST_PAGE_URL"])?>" class="button button-mini button-border button-rounded fright"><?=GetMessage('MD_NL_ALL', array('#DATA#' => $arParams["PAGER_TITLE"]))?> <i class="icon-line-fast-forward norightmargin"></i></a>
	<?endif;?>
</div>