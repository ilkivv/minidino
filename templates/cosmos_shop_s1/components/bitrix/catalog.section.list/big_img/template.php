<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$this->setFrameMode(true);
if(count($arResult["SECTIONS"]) < 1) return;

$colInfo = CMarsShopHelper::getColInfo($arParams["LINE_ELEMENT_COUNT"]);

foreach($arResult["SECTIONS"] as $keySection => $arSection):
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));?>
        <div class="<?=$colInfo["CLASS"]?> <?=(($keySection+1)%$arParams["LINE_ELEMENT_COUNT"] == 0)? ' col_last': ''?>">
            <div class="feature-box media-box" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                <div class="fbox-media">
                    <a href="<?=$arSection["SECTION_PAGE_URL"]?>" title="<?=$arSection["NAME"]?>">
                        <img src="<?=$arSection["PICTURE_RESIZED"]["SRC"]?>" alt="<?=$arSection["PICTURE"]["ALT"]?>" title="<?=$arSection["PICTURE"]["TITLE"]?>">
                    </a>
                </div>
                <div class="fbox-desc">
                    <h3><a href="<?=$arSection["SECTION_PAGE_URL"]?>" title="<?=$arSection["NAME"]?>"><?=$arSection["NAME"]?></a></h3>
                    <p class="notopmargin"><?=TruncateText($arSection["DESCRIPTION"], 200)?></p>
                </div>
            </div>
        </div><?=(($keySection+1)%$arParams["LINE_ELEMENT_COUNT"] == 0)? '<div class="clear"></div>': ''?>
<?endforeach;?>


