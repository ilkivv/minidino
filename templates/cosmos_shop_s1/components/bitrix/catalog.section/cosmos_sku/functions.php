<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

if (!function_exists('getDoublePicturesForItem'))
{
    function getDoublePicturesForItem(&$item, $propertyCode, $pictureSizes = false)
	{
		$result = array(
			'PICT' => false,
			'SECOND_PICT' => false
		);

		if (!empty($item) && is_array($item))
		{
			if (!empty($item['PREVIEW_PICTURE']))
			{
				if (!is_array($item['PREVIEW_PICTURE']))
					$item['PREVIEW_PICTURE'] = CFile::GetFileArray($item['PREVIEW_PICTURE']);
				if (isset($item['PREVIEW_PICTURE']['ID']))
				{
					$result['PICT'] = array(
						'ID' => (int)$item['PREVIEW_PICTURE']['ID'],
						'SRC' => $item['PREVIEW_PICTURE']['SRC'],
						'WIDTH' => (int)$item['PREVIEW_PICTURE']['WIDTH'],
						'HEIGHT' => (int)$item['PREVIEW_PICTURE']['HEIGHT']
					);
				}
			}
			if (!empty($item['DETAIL_PICTURE']))
			{
				$keyPict = (empty($result['PICT']) ? 'PICT' : 'SECOND_PICT');
				if (!is_array($item['DETAIL_PICTURE']))
					$item['DETAIL_PICTURE'] = CFile::GetFileArray($item['DETAIL_PICTURE']);
				if (isset($item['DETAIL_PICTURE']['ID']))
				{
					$result[$keyPict] = array(
						'ID' => (int)$item['DETAIL_PICTURE']['ID'],
						'SRC' => $item['DETAIL_PICTURE']['SRC'],
						'WIDTH' => (int)$item['DETAIL_PICTURE']['WIDTH'],
						'HEIGHT' => (int)$item['DETAIL_PICTURE']['HEIGHT']
					);
				}
			}
			if (empty($result['SECOND_PICT']))
			{
				if (
					'' != $propertyCode &&
					isset($item['PROPERTIES'][$propertyCode]) &&
					'F' == $item['PROPERTIES'][$propertyCode]['PROPERTY_TYPE']
				)
				{
					if (
						isset($item['DISPLAY_PROPERTIES'][$propertyCode]['FILE_VALUE']) &&
						!empty($item['DISPLAY_PROPERTIES'][$propertyCode]['FILE_VALUE'])
					)
					{
						$fileValues = (
						isset($item['DISPLAY_PROPERTIES'][$propertyCode]['FILE_VALUE']['ID']) ?
							array(0 => $item['DISPLAY_PROPERTIES'][$propertyCode]['FILE_VALUE']) :
							$item['DISPLAY_PROPERTIES'][$propertyCode]['FILE_VALUE']
						);
						foreach ($fileValues as &$oneFileValue)
						{
							$keyPict = (empty($result['PICT']) ? 'PICT' : 'SECOND_PICT');
							$result[$keyPict] = array(
								'ID' => (int)$oneFileValue['ID'],
								'SRC' => $oneFileValue['SRC'],
								'WIDTH' => (int)$oneFileValue['WIDTH'],
								'HEIGHT' => (int)$oneFileValue['HEIGHT']
							);
							if ('SECOND_PICT' == $keyPict)
								break;
						}
						if (isset($oneFileValue))
							unset($oneFileValue);
					}
					else
					{
						$propValues = $item['PROPERTIES'][$propertyCode]['VALUE'];
						if (!is_array($propValues))
							$propValues = array($propValues);
						foreach ($propValues as &$oneValue)
						{
							$oneFileValue = CFile::GetFileArray($oneValue);
							if (isset($oneFileValue['ID']))
							{
								$keyPict = (empty($result['PICT']) ? 'PICT' : 'SECOND_PICT');
								$result[$keyPict] = array(
									'ID' => (int)$oneFileValue['ID'],
									'SRC' => $oneFileValue['SRC'],
									'WIDTH' => (int)$oneFileValue['WIDTH'],
									'HEIGHT' => (int)$oneFileValue['HEIGHT']
								);
								if ('SECOND_PICT' == $keyPict)
									break;
							}
						}
						if (isset($oneValue))
							unset($oneValue);
					}
				}
			}
		}


        if (is_array($pictureSizes)) {
            foreach ($result as $keyPicture => $picture) {
                $pictureId = intval($picture['ID']);
                if ($pictureId == 0) return;
                $arFileTmp = CFile::ResizeImageGet(
                    $pictureId,
                    $pictureSizes,
                    $pictureSizes["resize_type"],
                    true, flase, false, 100
                );
                $result[$keyPicture]["SRC"] = $arFileTmp["src"];
                $result[$keyPicture]["WIDTH"] = $arFileTmp["width"];
                $result[$keyPicture]["HEIGHT"] = $arFileTmp["height"];
            }
        }
		return $result;
	}
}
?>