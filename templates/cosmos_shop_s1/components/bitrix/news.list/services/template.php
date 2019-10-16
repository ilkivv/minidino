<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
$this->setFrameMode(true);
if (count($arResult["ITEMS"]) < 1) return;

if ($arParams["FEATURE_BOX_ICONS"] == "Y") {
    $elementClass = $arParams["FEATURE_BOX_CLASS"] . ' ' . $arParams["FEATURE_BOX_COLOR"] . ' ' . $arParams["FEATURE_BOX_BORDER"];
    if ($arParams["FEATURE_BOX_EFFECT"] == "Y" && !stripos($elementClass, "fbox-plain") > 0) {
        $elementClass .= " " . "fbox-effect";
    }
} else {
    $elementClass = 'fbox-plain' . ' ' . $arParams["FEATURE_BOX_CLASS"];
}
?>
<? foreach ($arResult["ITEMS"] as $key => $arItem): ?>
    <?
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));

    ?>
    <div class="col_one_third <?= (($key + 1) % 3 == 0) ? 'col_last' : '' ?>">
        <div class="feature-box <?=$elementClass?>" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
            <? if ($arParams["FEATURE_BOX_ICONS"] == "Y" &&
                isset($arItem["DISPLAY_PROPERTIES"]["ICON"]["DISPLAY_VALUE"])
                && strlen($arItem["DISPLAY_PROPERTIES"]["ICON"]["DISPLAY_VALUE"]) > 0
            ):
                ?>
                <div class="fbox-icon bounceIn animated" data-animate="bounceIn" data-delay="800">
                    <a href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>">
                        <i class="<?= $arItem["DISPLAY_PROPERTIES"]["ICON"]["DISPLAY_VALUE"] ?> i-alt"></i>
                    </a>
                </div>
            <? else: ?>
                <div class="fbox-icon bounceIn animated">
                    <a href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>">
                        <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="<?= $arItem["NAME"] ?>">
                    </a>
                </div>
            <? endif; ?>
            <h3>
                <a class="nott" href="<?= $arItem["DISPLAY_PROPERTIES"]["LINK"]["DISPLAY_VALUE"] ?>">
                    <?= $arItem["NAME"] ?>
                </a>
            </h3>

            <p><?= $arItem["PREVIEW_TEXT"] ?></p>
        </div>
    </div>
    <?= (($key + 1) % 3 == 0) ? '<div class="clear"></div>' : '' ?>
<? endforeach; ?>
