<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
?>
<h4><?=$arParams["PAGER_TITLE"]?></h4>
<div id="post-list-footer">
	<?foreach($arResult["ITEMS"] as $arItem):?>
		<?
		$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		?>

	    <div class="spost clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	        <div class="entry-c">
	            <div class="entry-title">
	                <h4><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h4>
	            </div>
	            <ul class="entry-meta">
	                <li><?=$arItem["DISPLAY_ACTIVE_FROM"]?></li>
	            </ul>
	        </div>
	    </div>
	<?endforeach;?>
</div>