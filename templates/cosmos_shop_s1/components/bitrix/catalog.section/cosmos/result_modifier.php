<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require_once ("functions.php");
$arDefaultParams = array(
    'SECTION_USE_IMAGE_RESIZE' => 'N',
    'SECTION_IMAGE_RESIZE_WIDTH' => 360,
    'SECTION_IMAGE_RESIZE_HEIGHT' => 360,
    'SECTION_IMAGE_RESIZE_TYPE' => BX_RESIZE_IMAGE_PROPORTIONAL,
);

$arParams = array_merge($arDefaultParams, $arParams);
$arParams['SECTION_IMAGE_RESIZE_WIDTH'] = intval($arParams['SECTION_IMAGE_RESIZE_WIDTH']);
$arParams['SECTION_IMAGE_RESIZE_HEIGHT'] = intval($arParams['SECTION_IMAGE_RESIZE_HEIGHT']);
$arParams['SECTION_IMAGE_RESIZE_TYPE'] = intval($arParams['SECTION_IMAGE_RESIZE_TYPE']);

$arEmptyPreview = false;
$strEmptyPreview = $this->GetFolder().'/images/no_photo.png';
if (file_exists($_SERVER['DOCUMENT_ROOT'].$strEmptyPreview))
{
    $arSizes = getimagesize($_SERVER['DOCUMENT_ROOT'].$strEmptyPreview);
    if (!empty($arSizes))
    {
        $arEmptyPreview = array(
            'SRC' => $strEmptyPreview,
            'WIDTH' => intval($arSizes[0]),
            'HEIGHT' => intval($arSizes[1])
        );
    }
    unset($arSizes);
}
unset($strEmptyPreview);

$resizeData = false;
if ($arParams["SECTION_USE_IMAGE_RESIZE"] == "Y") {
    $resizeData = array(
        "width" => intval($arParams['SECTION_IMAGE_RESIZE_WIDTH']),
        "height" => intval($arParams['SECTION_IMAGE_RESIZE_HEIGHT']),
        "resize_type" => intval($arParams['SECTION_IMAGE_RESIZE_TYPE']),
    );
}
foreach ($arResult["ITEMS"] as $keyItem => $arItem) {
    $productPictures = getDoublePicturesForItem(
        $arItem,
        $arParams['ADD_PICT_PROP'],
        $resizeData
    );

    if (empty($productPictures['PICT']))
        $productPictures['PICT'] = $arEmptyPreview;
    if (empty($productPictures['SECOND_PICT']))
        $productPictures['SECOND_PICT'] = $productPictures['PICT'];

    $arResult["ITEMS"][$keyItem]['PREVIEW_PICTURE'] = $productPictures['PICT'];
    $arResult["ITEMS"][$keyItem]['PREVIEW_PICTURE_SECOND'] = $productPictures['SECOND_PICT'];
}
