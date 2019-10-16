<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);
if (count($arResult["ITEMS"])  < 1) return;
?>
        
        <ul id="portfolio-filter" class="portfolio-filter clearfix">
            <li class="activeFilter"><a href="#" data-filter="all"><?=GetMessage('NL_FAQ_ALL')?></a></li>
            <?foreach($arResult["SECTIONS"] as $arSect):?>
                <li><a href="#" data-filter=".faq-<?=$arSect["ID"]?>"><?=$arSect["NAME"]?></a></li>
            <?endforeach;?>
        </ul>

        <div class="clear"></div>

        <div id="faqs" class="faqs">

            <?foreach($arResult["ITEMS"] as $arItem):?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="toggle faq<?=$arItem["SECTION_CLASS"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="togglet"><i class="toggle-closed <?=$arItem["SECTION_ICON"]?>"></i><i class="toggle-open icon-question-sign"></i><?=$arItem["NAME"]?></div>
                    <div class="togglec"><?=$arItem["PREVIEW_TEXT"]?></div>
                </div>
            <?endforeach;?>

        </div>
