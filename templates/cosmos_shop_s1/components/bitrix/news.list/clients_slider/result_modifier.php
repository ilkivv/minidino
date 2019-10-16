<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arDefaultParams = array(
    'NL_USE_IMAGE_RESIZE' => 'N',
    'NL_IMAGE_RESIZE_WIDTH' => 180,
    'NL_IMAGE_RESIZE_HEIGHT' => 180,
    'NL_IMAGE_RESIZE_TYPE' => BX_RESIZE_IMAGE_PROPORTIONAL,
    'ELEMENT_LINE_COUNTER' => 6,
);

$arParams = array_merge($arDefaultParams, $arParams);
if ($arParams["NL_IMAGE_RESIZE_HEIGHT"] < 60) {
    $arParams["NL_IMAGE_RESIZE_HEIGHT"] = $arDefaultParams["NL_IMAGE_RESIZE_HEIGHT"];
}
if ($arParams["NL_IMAGE_RESIZE_WIDTH"] < 60) {
    $arParams["NL_IMAGE_RESIZE_WIDTH"] = $arDefaultParams["NL_IMAGE_RESIZE_WIDTH"];
}

$arParams['NL_IMAGE_RESIZE_WIDTH'] = (int) $arParams['NL_IMAGE_RESIZE_WIDTH'];
$arParams['NL_IMAGE_RESIZE_HEIGHT'] = (int) $arParams['NL_IMAGE_RESIZE_HEIGHT'];
$arParams['NL_IMAGE_RESIZE_TYPE'] = (int) $arParams['NL_IMAGE_RESIZE_TYPE'];

if ($arParams["NL_USE_IMAGE_RESIZE"] == "Y") {
    foreach ($arResult["ITEMS"] as $keyItem => $arItem) {
        $pictureId = $arItem["PREVIEW_PICTURE"]["ID"];

        if (isset($pictureId) && $pictureId > 0) {
            $arFileTmp = CFile::ResizeImageGet(
                $pictureId,
                array("width" => $arParams["NL_IMAGE_RESIZE_WIDTH"], "height" => $arParams["NL_IMAGE_RESIZE_HEIGHT"]),
                $arParams["NL_IMAGE_RESIZE_TYPE"],
                true
            );
            $arResult["ITEMS"][$keyItem]["PREVIEW_PICTURE"] = array(
                'SRC' => $arFileTmp["src"],
                'WIDTH' => $arFileTmp["width"],
                'HEIGHT' => $arFileTmp["height"],
            );
        }

    }
}

?>