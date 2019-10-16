<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arDefaultParams = array(
    'ELEMENT_LINE_COUNT' => 3,
    'SHOW_DOCS' => "N"
);

$arParams = array_merge($arDefaultParams, $arParams);

foreach ($arResult["ITEMS"] as $key => $arItem)
{
	if (isset($arItem["PREVIEW_PICTURE"]["ID"]))
	{
		$arFileTmp = CFile::ResizeImageGet(
				$arItem["PREVIEW_PICTURE"]["ID"],
				array("width" => 64, "height" => 64),
				BX_RESIZE_IMAGE_EXACT,
				true
		);
		$arResult["ITEMS"][$key]["PREVIEW_PICTURE_RESIZED"] = array(
				'SRC'    => $arFileTmp["src"],
				'WIDTH'  => $arFileTmp["width"],
				'HEIGHT' => $arFileTmp["height"],
		);
	}

	if ($arParams["SHOW_DOCS"] == "Y") {

		$resFiles = CIBlockElement::GetProperty(
		    $arItem["IBLOCK_ID"],
		    $arItem["ID"],
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
		    $arResult["ITEMS"][$key]["ADDITIONAL_FILES"][$filesCounter] = $fileData;

		    $filesCounter++;
		}
	}

}

?>