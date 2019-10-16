<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

$arDefaultParams = array(
    'NL_USE_IMAGE_RESIZE' => 'N',
    'NL_IMAGE_RESIZE_WIDTH' => 430,
    'NL_IMAGE_RESIZE_HEIGHT' => 430,
    'NL_IMAGE_RESIZE_TYPE' => BX_RESIZE_IMAGE_EXACT,
    'LINK_TO_AJAX' => SITE_DIR . "ajax/formserv.php",
);

$arParams = array_merge($arDefaultParams, $arParams);

$resPhotos = CIBlockElement::GetProperty(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    array("sort" => "asc"),
    array("CODE" => "MORE_PHOTO")
);
$pictureSizesThumb= array("width" => $arParams["NL_IMAGE_RESIZE_WIDTH"], "height" =>  $arParams["NL_IMAGE_RESIZE_HEIGHT"]);
$pictureSizesBig= array("width" => 1200, "height" => 1200);
$filesCounter = 0;

while ($arPhoto = $resPhotos->Fetch()) {
    $pictureId = intval($arPhoto["VALUE"]);
    if ($pictureId == 0) continue;
    $arFileTmp = CFile::ResizeImageGet(
        $pictureId,
        $pictureSizesThumb,
        (int)$arParams["NL_IMAGE_RESIZE_TYPE"],
        true, flase, false, 100
    );
    $arResult["MORE_PHOTO"][$filesCounter]["SRC_THUMB"] = $arFileTmp["src"];

    $arFileTmp = CFile::ResizeImageGet(
        $pictureId,
        $pictureSizesBig,
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true, flase, false, 100
    );
    $arResult["MORE_PHOTO"][$filesCounter]["SRC"] = $arFileTmp["src"];

    $arResult["MORE_PHOTO"][$filesCounter]["ALT"] = $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_ALT"];
    if ($arResult["MORE_PHOTO"][$filesCounter]["ALT"] == "")
        $arResult["MORE_PHOTO"][$filesCounter]["ALT"] = $arResult["NAME"];

    $arResult["MORE_PHOTO"][$filesCounter]["TITLE"] = $arResult["IPROPERTY_VALUES"]["ELEMENT_DETAIL_PICTURE_FILE_TITLE"];
    if ($arResult["MORE_PHOTO"][$filesCounter]["TITLE"] == "")
        $arResult["MORE_PHOTO"][$filesCounter]["TITLE"] = $arResult["NAME"];


    $filesCounter++;
}

$resFiles = CIBlockElement::GetProperty(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    array("sort" => "asc"),
    array("CODE" => "ADDITIONAL_FILES")
);

$filesCounter = 0;

while ($arFile = $resFiles->Fetch()) {
    $fileId = intval($arFile["VALUE"]);

    if ($fileId < 1) {
        continue;
    }
    $fileData = CFile::GetFileArray($fileId);

    $fileType = explode('.', $fileData['FILE_NAME']);
    $fileData["FILE_EXTENSION"] = $fileType[1];

    $fileData["FILE_SIZE_FORMATED"] = CFile::FormatSize($fileData["FILE_SIZE"]);
    $imgFileExtension = $_SERVER["DOCUMENT_ROOT"] . SITE_TEMPLATE_PATH . "/images/fileicons/" . $fileData["FILE_EXTENSION"] . "-128.png";
    if (file_exists($imgFileExtension)) {
        $fileData["FILE_EXTENSION_SRC"] = SITE_TEMPLATE_PATH . "/images/fileicons/" . $fileData["FILE_EXTENSION"] . "-128.png";
    } else {
        $fileData["FILE_EXTENSION_SRC"] = SITE_TEMPLATE_PATH . "/images/fileicons/file-128.png";
    }
    $arResult["ADDITIONAL_FILES"][$filesCounter] = $fileData;

    $filesCounter++;
}


$resShowButtons = CIBlockElement::GetProperty(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    array("sort" => "asc"),
    array("CODE" => "SHOW_ASK_QUESTION")
);

if ($arBtn = $resShowButtons->Fetch()) {
    $arResult["SHOW_ASK_QUESTION"] = $arBtn["VALUE_XML_ID"];
}

$resShowButtons = CIBlockElement::GetProperty(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    array("sort" => "asc"),
    array("CODE" => "SHOW_ZAKAZ")
);

if ($arBtn = $resShowButtons->Fetch()) {
    $arResult["SHOW_ZAKAZ"] = $arBtn["VALUE_XML_ID"];
}

$resImgPosition = CIBlockElement::GetProperty(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    array("sort" => "asc"),
    array("CODE" => "DETAIL_PICTURE_POSITION")
);

if ($arPosition = $resImgPosition->Fetch()) {
    switch ($arPosition["VALUE_XML_ID"]) {
        case 'C':
            $arResult["DETAIL_PICTURE_POSITION"] = "aligncenter";
            break;
        case 'R':
            $arResult["DETAIL_PICTURE_POSITION"] = "alignright";
            break;
        
        default:
            $arResult["DETAIL_PICTURE_POSITION"] = "alignleft";
            break;
    }
} else {
    $arResult["DETAIL_PICTURE_POSITION"] = "alignleft";
}


switch (count($arResult["MORE_PHOTO"])) {
    case 2:
        $arResult["COL_DATA"]["CLASS"] = "col-2";
        $arResult["COL_DATA"]["DATA_BIG"] = '';
        break;
    case 3:
        $arResult["COL_DATA"]["CLASS"] = "col-3";
        $arResult["COL_DATA"]["DATA_BIG"] = '';
        break;
    case 4:
        $arResult["COL_DATA"]["CLASS"] = "col-4";
        $arResult["COL_DATA"]["DATA_BIG"] = '';
        break;
    
    default:
        $arResult["COL_DATA"]["CLASS"] = "col-4";
        $arResult["COL_DATA"]["DATA_BIG"] = 'data-big="1"';
        break;
}

$resIncludeFiles = CIBlockElement::GetProperty(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    array("sort" => "asc"),
    array("CODE" => "INCLUDE_FILES")
);

$arResult["INCLUDE_FILES"] = array(
    'products.php',
    'projects.php',
    'cert.php',
    'reviews.php',
    'staff.php',

);

while ($arIncludeFiles = $resIncludeFiles->Fetch()) {
    if ($arIncludeFiles["VALUE"] == null) { continue; }
    $arResult["INCLUDE_FILES"][] = $arIncludeFiles["VALUE"];
}

$resRelatedElements = CIBlockElement::GetProperty(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    array("sort" => "asc"),
    array("CODE" => "RELATED_ELEMENTS")
);
while ($arRelatedElement = $resRelatedElements->Fetch()) {
    if ($arRelatedElement["VALUE"] == null) { continue; }
    $arResult["RELATED_ELEMENTS"][] = $arRelatedElement["VALUE"];
}

global $APPLICATION;

$cp = $this->__component;

if (is_object($cp))
{
    //$cp->arResult['DE'] = 'Мое название';
    //$cp->arResult['IS_OBJECT'] = 'Y';
    $cp->SetResultCacheKeys(array('DETAIL_PICTURE'));
}