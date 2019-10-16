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
if (count($arResult["ITEMS"])  < 1) return;
?>

<div class="nobottommargin">
<?foreach($arResult["ITEMS"] as $arItem):?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div class="fancy-title title-bottom-border">
        <h3><?=$arItem['NAME']?></h3>
    </div>
    <div class="accordion accordion-bg clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <?foreach ($arItem["DISPLAY_PROPERTIES"] as $propKey => $arPropValue) :?>
            <div class="acctitle"><i class="acc-closed icon-ok-circle"></i><i class="acc-open icon-remove-circle"></i><?=$arPropValue["NAME"]?></div>
            <div class="acc_content clearfix">
                <?=$arPropValue["DISPLAY_VALUE"]?>
            </div>
        <?endforeach;?>
    </div>
    <?if (CModule::IncludeModule("form") && $arParams["SHOW_FORM"] == "Y"):?>
        <a href="<?=$arParams["FORM_URL"]?>" data-lightbox="ajax" class="button button-3d button-black nomargin"><?=GetMessage('NL_VACANCIE_APPLY')?></a>
    <?endif;?>
    <div class="divider divider-short"><i class="icon-crop"></i></div>
<?endforeach;?>
</div>