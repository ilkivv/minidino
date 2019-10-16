<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
if(!empty($arResult["STORES"]) && $arParams["MAIN_TITLE"] != ''):?>
	<div class="fancy-title title-bottom-border">
		<h3><?=$arParams["MAIN_TITLE"]?></h3>
	</div>
<?endif;?>
<div class="table-responsive bottommargin" id="catalog_store_amount_div">
	<?if(!empty($arResult["STORES"])):?>
	<table id="c_store_amount" class="table table-hover table-bordered">
		<?foreach($arResult["STORES"] as $pid => $arProperty):?>
			<tr style="display: <? echo ($arParams['SHOW_EMPTY_STORE'] == 'N' && isset($arProperty['REAL_AMOUNT']) && $arProperty['REAL_AMOUNT'] <= 0 ? 'none' : ''); ?>;">
				<?if (isset($arProperty["TITLE"])):?>
					<td><a href="<?=$arProperty["URL"]?>?cosmos_ajax=Y" data-lightbox="ajax"> <?=$arProperty["TITLE"]?></a></td>
				<?endif;?>
				<?if (isset($arProperty["IMAGE_ID"]) && !empty($arProperty["IMAGE_ID"])):?>
					<td><span><?=GetMessage('S_IMAGE')?> <?=CFile::ShowImage($arProperty["IMAGE_ID"], 200, 200, "border=0", "", true);?></span></td>
				<?endif;?>
				<?if (isset($arProperty["PHONE"])):?>
					<td><span><?=GetMessage('S_PHONE')?> <?=$arProperty["PHONE"]?></span></td>
				<?endif;?>
				<?if (isset($arProperty["SCHEDULE"])):?>
					<td><span><?=GetMessage('S_SCHEDULE')?> <?=$arProperty["SCHEDULE"]?></span></td>
				<?endif;?>
				<?if (isset($arProperty["EMAIL"])):?>
					<td><span><?=GetMessage('S_EMAIL')?> <?=$arProperty["EMAIL"]?></span></td>
				<?endif;?>
				<?if (isset($arProperty["DESCRIPTION"])):?>
					<td><span><?=GetMessage('S_DESCRIPTION')?> <?=$arProperty["DESCRIPTION"]?></span></td>
				<?endif;?>
				<?if (isset($arProperty["COORDINATES"])):?>
					<td><span><?=GetMessage('S_COORDINATES')?> <?=$arProperty["COORDINATES"]["GPS_N"]?>, <?=$arProperty["COORDINATES"]["GPS_S"]?></span></td>
				<?endif;?>
				<?if ($arParams['SHOW_GENERAL_STORE_INFORMATION'] == "Y") :?>
					<td><?=GetMessage('BALANCE')?>:</td>
				<?else:?>
					<td><?=GetMessage('S_AMOUNT')?></td>
				<?endif;?>
				<td><span id="<?=$arResult['JS']['ID']?>_<?=$arProperty['ID']?>"><?=$arProperty["AMOUNT"]?></span></td>
				<?
				if (!empty($arProperty['USER_FIELDS']) && is_array($arProperty['USER_FIELDS']))
				{
					foreach ($arProperty['USER_FIELDS'] as $userField)
					{
						if (isset($userField['CONTENT']))
						{
							?><td><span><?=$userField['TITLE']?>: <?=$userField['CONTENT']?></span></td><?
						}
					}
				}
				?>
			</tr>
		<?endforeach;?>
		</table>
	<?endif;?>
</div>
<?if (isset($arResult["IS_SKU"]) && $arResult["IS_SKU"] == 1):?>
	<script type="text/javascript">
		var obStoreAmount = new JCCatalogStoreSKU(<? echo CUtil::PhpToJSObject($arResult['JS'], false, true, true); ?>);
	</script>
	<?
endif;?>