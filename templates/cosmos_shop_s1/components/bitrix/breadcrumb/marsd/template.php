<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//delayed function must return a string
if(empty($arResult))
	return "";


$strReturn = '<ol class="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">';

$num_items = count($arResult);
for($index = 0, $itemSize = $num_items; $index < $itemSize; $index++) {
    $title = htmlspecialcharsex($arResult[$index]["TITLE"]);

    if ($index == $itemSize - 1) $strNoFollow = ' rel="nofollow"';
    else $strNoFollow = "";

    //if ($arResult[$index]["LINK"] <> "" && $index != $itemSize - 1)
        $strReturn .= '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
                            <a itemprop="item" href="' . $arResult[$index]["LINK"] . '" title="' . $title . '"' . $strNoFollow .'>'
                                . $title
                            . ' <meta itemprop="name" content="' . $title . '" />
                                <meta itemprop="position" content="' . ($index+1) . '" />
                            </a>
                        </li>';
	/*else
		$strReturn .= '<li class="active" itemprop="itemListElement" itemscope
                            itemtype="http://schema.org/ListItem">' . $title
                        . ' <meta itemprop="name" content="' . $title . '" />
                            <meta itemprop="position" content="' . ($index+1) . '" />
                        </li>';

    */
}


$strReturn .= '</ol>';


return $strReturn;
?>