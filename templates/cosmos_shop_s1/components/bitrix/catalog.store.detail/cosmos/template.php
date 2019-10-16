<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="map" class="col_full">
	<?
	if(($arResult["GPS_N"]) != 0 && ($arResult["GPS_S"]) != 0)
	{
		$gpsN = substr($arResult["GPS_N"],0,15);
		$gpsS = substr($arResult["GPS_S"],0,15);
		$gpsText = $arResult["ADDRESS"];
		$gpsTextLen = strlen($arResult["ADDRESS"]);
		if($arResult["MAP"] == 0)
		{
			$APPLICATION->IncludeComponent("bitrix:map.yandex.view", ".default", array(
					"INIT_MAP_TYPE" => "MAP",
					"MAP_DATA" => serialize(array("yandex_lat"=>$gpsN,"yandex_lon"=>$gpsS,"yandex_scale"=>11,"PLACEMARKS" => array( 0=>array("LON"=>$gpsS,"LAT"=>$gpsN,"TEXT"=>$arResult["ADDRESS"])))),
					"MAP_WIDTH" => "100%",
					"MAP_HEIGHT" => "350",
					"CONTROLS" => array(
						0 => "ZOOM",
					),
					"OPTIONS" => array(
						0 => "ENABLE_SCROLL_ZOOM",
						1 => "ENABLE_DBLCLICK_ZOOM",
						2 => "ENABLE_DRAGGING",
					),
					"MAP_ID" => ""
				),
				false
			);
		}
		else
		{
			$APPLICATION->IncludeComponent("bitrix:map.google.view", ".default", array(
					"INIT_MAP_TYPE" => "MAP",
					"MAP_DATA" => serialize(array("google_lat"=>$gpsN,"google_lon"=>$gpsS,"google_scale"=>11,"PLACEMARKS" => array( 0=>array("LON"=>$gpsS,"LAT"=>$gpsN,"TEXT"=>$arResult["ADDRESS"])))),
					"MAP_WIDTH" => "100%",
					"MAP_HEIGHT" => "350",
					"CONTROLS" => array(
						0 => "ZOOM",
					),
					"OPTIONS" => array(
						0 => "ENABLE_SCROLL_ZOOM",
						1 => "ENABLE_DBLCLICK_ZOOM",
						2 => "ENABLE_DRAGGING",
					),
					"MAP_ID" => ""
				),
				false
			);
		}
	}
	?>
</div>

<div class="col_one_third">
	<?
	if(intval($arResult["IMAGE_ID"]) > 0)
	{
		?>
		<div class="catalog-detail-image" id="catalog-detail-main-image">
			<a href="<?=CFile::GetPath($arResult["IMAGE_ID"]);?>" data-lightbox="image" target="_blank">
				<img src="<?=CFile::GetPath($arResult["IMAGE_ID"]);?>" class="thumbnail">
			</a>
		</div>
		<?
	}
	?>
</div>
<div class="col_one_third">
	<address>
		<abbr title="<?=GetMessage("S_ADDRESS");?>"><strong><?=GetMessage("S_ADDRESS");?></strong></abbr><br>
		<?=$arResult["ADDRESS"];?>
	</address>
	<?if (strlen($arResult["PHONE"]) > 0) : ?>
		<abbr title="<?=GetMessage("S_PHONE");?>"><strong><?=GetMessage("S_PHONE");?></strong></abbr><br><?=$arResult["PHONE"];?><br><br>
	<?endif;?>
	<?if (strlen($arResult["SCHEDULE"]) > 0) : ?>
		<abbr title="<?=GetMessage("S_SCHEDULE");?>"><strong><?=GetMessage("S_SCHEDULE");?></strong></abbr><br><?=$arResult["SCHEDULE"];?><br><br>
	<?endif;?>
	<?if (strlen($arResult["EMAIL"]) > 0) : ?>
		<abbr title="<?=GetMessage("S_EMAIL");?>"><strong><?=GetMessage("S_EMAIL");?></strong></abbr><br><?=$arResult["EMAIL"];?>
	<?endif;?>
</div>
<?if($arResult["DESCRIPTION"]):?>
	<div class="col_one_third col_last">
		<?=$arResult["DESCRIPTION"];?>
	</div>
<?endif;?>
<div class="clearfix"></div>
<?
if(isset($arResult["LIST_URL"]))
{
	?>
	<a href="<?=$arResult["LIST_URL"]?>" class="button button-mini button-border"><?=GetMessage("BACK_STORE_LIST")?>  </a>
	<?
}
?>