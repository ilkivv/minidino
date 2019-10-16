<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
$this->setFrameMode(true);
if (count($arResult["ITEMS"]) < 1) return;

?>
<? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div class="col_one_third <?= (($key + 1) % 3 == 0) ? 'col_last' : '' ?>">
        <div class="feature-box media-box feature-cosmos" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <div class="fbox-media fbounceIn animated">
                <a href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>">
                    <img src="<?= $arItem["PREVIEW_PICTURE_RESIZED"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
                </a>
            </div>
            <div class="fbox-desc">
                <h3>
                    <a class="nott" href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>">
                        <?= $arItem["NAME"] ?>
                    </a>
                </h3>
                <p class="hidden-sm hidden-xs"><?= $arItem["PREVIEW_TEXT"] ?>
                    <br>
                    <a class="button button-border button-rounded button-light button-mini noleftmargin button-reveal tright"
                       href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>"
                       title="<?= $arItem["NAME"] ?>"><i class="icon-line-arrow-right"></i> <span><?=Loc::getMessage("NL_SI_READ_MORE")?></span></a>
                </p>
            </div>
        </div>
    </div>
    <?= (($key + 1) % 3 == 0) ? '<div class="clear"></div>' : '' ?>
<? endforeach; ?>
