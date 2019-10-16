<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if (count($arResult["ITEMS"])  < 1) return;
?>
<div class="fslider" data-pagi="false" data-animation="fade">
    <div class="flexslider">
        <div class="slider-wrap">
<?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div class="slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>"><a href="#"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>" alt="<?=$arItem["PREVIEW_PICTURE"]["TITLE"]?>"></a></div>
<?endforeach;?>
        </div>
    </div>
</div>