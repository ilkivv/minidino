<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if (count($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["VALUE"]) == 1) {
    $tmnMorePhoto = $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"];
    unset($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"]);
    $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][] = $tmnMorePhoto;
    unset($tmnMorePhoto);
}

$arDefaultParams = array(
    'NL_USE_IMAGE_THUMB_RESIZE' => 'Y',
    'NL_IMAGE_THUMB_RESIZE_WIDTH' => 100,
    'NL_IMAGE_THUMB_RESIZE_HEIGHT' => 100,
    'NL_IMAGE_THUMB_RESIZE_TYPE' => BX_RESIZE_IMAGE_EXACT,
    'DETAIL_PAGE_TABS_SORT' => "INFO_DESC",
    'DETAIL_USE_TABS' => "Y",
);

$arParams = array_merge($arDefaultParams, $arParams);
$arParams['NL_IMAGE_RESIZE_WIDTH'] = (int) $arParams['NL_IMAGE_RESIZE_WIDTH'];
$arParams['NL_IMAGE_RESIZE_HEIGHT'] = (int) $arParams['NL_IMAGE_RESIZE_HEIGHT'];
$arParams['NL_IMAGE_RESIZE_TYPE'] = (int) $arParams['NL_IMAGE_RESIZE_TYPE'];
if ($arParams["DETAIL_USE_TABS"] == ""){
    $arParams["DETAIL_USE_TABS"] = $arDefaultParams["DETAIL_USE_TABS"];
}

if ($arParams["NL_USE_IMAGE_THUMB_RESIZE"] == "Y") {
    $objCFile = new CFile();
        $pictureId = $arResult["DETAIL_PICTURE"]["ID"];
        if (isset($pictureId) && $pictureId > 0) {
            $arFileTmp = $objCFile->ResizeImageGet(
                $pictureId,
                array("width" => $arParams["NL_IMAGE_THUMB_RESIZE_WIDTH"], "height" => $arParams["NL_IMAGE_THUMB_RESIZE_HEIGHT"]),
                $arParams["NL_IMAGE_THUMB_RESIZE_TYPE"],
                true
            );
            $arResult["DETAIL_PICTURE"]["THUMB"] = array(
                'SRC' => $arFileTmp["src"],
                'WIDTH' => $arFileTmp["width"],
                'HEIGHT' => $arFileTmp["height"],
            );
        }

    foreach ($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"] as $keyFile => $arPhoto){
        $pictureId = $arPhoto["ID"];
        if (isset($pictureId) && $pictureId > 0) {
            $arFileTmp = $objCFile->ResizeImageGet(
                $pictureId,
                array("width" => $arParams["NL_IMAGE_THUMB_RESIZE_WIDTH"], "height" => $arParams["NL_IMAGE_THUMB_RESIZE_HEIGHT"]),
                $arParams["NL_IMAGE_THUMB_RESIZE_TYPE"],
                true
            );
            $arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]["FILE_VALUE"][$keyFile]["THUMB"] = array(
                'SRC' => $arFileTmp["src"],
                'WIDTH' => $arFileTmp["width"],
                'HEIGHT' => $arFileTmp["height"],
            );
        }
    }
}


$resFiles = CIBlockElement::GetProperty(
    $arResult["IBLOCK_ID"],
    $arResult["ID"],
    array("sort" => "asc"),
    array("CODE" => "FILES")
);

$filesCounter = 0;

while ($arFile = $resFiles->Fetch()) {
    $fileId = intval($arFile["VALUE"]);
    $arResult["ADDITIONAL_FILES_TITLE"] = $arFile["NAME"];

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



$arResult["AR_TABS"] = array(
    "INFO" => array(
            "HREF" => "#tabs-2",
            "NAME" => Loc::getMessage("FULL_PROPERTIES"),
            "ICON" => "icon-info-sign",
            "SORT" => 100
            ),
    "DESC" => array(
            "HREF" => "#tabs-1",
            "NAME" => Loc::getMessage("FULL_DESCRIPTION"),
            "ICON" => "icon-align-justify2",
            "SORT" => 200
            ),
    );


switch ($arParams["DETAIL_PAGE_TABS_SORT"]) {
    case 'DESC_INFO':
        $arResult["AR_TABS"]["DESC"]["SORT"] = 50;
        break;
    
    default:

        break;
}

foreach ($arResult["AR_TABS"] as $key => $row) {
    $sort[$key]  = $row['SORT'];
}

array_multisort($sort, SORT_ASC, $arResult["AR_TABS"]);
?>