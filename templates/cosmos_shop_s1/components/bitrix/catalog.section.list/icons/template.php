<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$this->setFrameMode(true);
if(count($arResult["SECTIONS"]) < 1) return;

foreach($arResult["SECTIONS"] as $keySection => $arSection):
        $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
        $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));?>
        <div class="col_half<?=(($keySection+1)%2 == 0)? ' col_last': ''?> big-icon-section">
            <div class="feature-box fbox-large fbox-rounded" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                <div class="fbox-icon">
                    <img src="<?=$arSection["PICTURE_RESIZED"]["SRC"]?>" alt="<?=$arSection["PICTURE"]["ALT"]?>" title="<?=$arSection["PICTURE"]["TITLE"]?>">
                </div>
                <div class="description">
                    <h3><a href="<?=$arSection["SECTION_PAGE_URL"]?>" title="<?=$arSection["NAME"]?>"><?=$arSection["NAME"]?></a></h3>
                    <p class="notopmargin"><?=TruncateText($arSection["DESCRIPTION"], 100)?></p>
                </div>
            </div>
        </div><?=(($keySection+1)%2 == 0)? '<div class="clear"></div>': ''?>
<?endforeach;?>