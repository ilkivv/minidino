<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);
if (count($arResult["ITEMS"])  < 1) return;

if ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] != "N") {
    echo $arResult["DESCRIPTION"];
} else {
?>
    <div class="line topmargin-sm bottommargin-sm"></div>
    <h3>
        <?= $arParams["TITLE_TEXT"] ?>
    </h3>
<?
}?>
<?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div class="panel panel-default col_last" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="panel-body">
        <a href="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" data-lightbox="image">
            <img src="<?=$arItem["PREVIEW_PICTURE_RESIZED"]["SRC"]?>" width="150px" class="alignleft" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" title="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>">
        </a>
        <h3><?=$arItem["NAME"]?></h3>
        <?=$arItem["PREVIEW_TEXT"]?>
        </div>
    </div>
<?endforeach;?>

