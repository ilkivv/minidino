<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"])  < 1) return;
?>
<?foreach($arResult["SECTIONS"] as $arSection):?>
	<?
	if (strlen($arSection["NAME"]) < 1 && count($arResult["SECTIONS"]) > 1) {
		$arSection["NAME"] = GetMessage("OTHER");
	}
	?>
	<?if (strlen($arSection["NAME"]) > 0 && $arParams["SHOW_INFOBLOCK_DESCRIPTION"] != "N") :?>
		<div class="fancy-title title-bottom-border bottommargin-sm">
			<h3><?=$arSection["NAME"]?></h3>
		</div>
		<div class="col_full">
		<?
		echo $arSection["DESCRIPTION"]; 
		?>
		</div>
	<? elseif ($arParams["SHOW_INFOBLOCK_DESCRIPTION"] == "N") : ?>
		<div class="line topmargin-sm bottommargin-sm"></div>
		<h3>
			<?= $arParams["TITLE_TEXT"] ?>
		</h3>
	<?endif;?>
	<?
		$rowCounter = 0;
	?>
	<div class="col_full sectionblock-grid">
		<?foreach($arSection["ITEMS"] as $arItem):?>
		    <?
		    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
		    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
		    $rowCounter++;
		    ?>
			<div class="col_one_third<?=($rowCounter % 3 == 0) ? " col_last": ""?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<div class="thumbnail">
					<div class="divflex">
						<div>
							<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
								<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
									<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
								</a>
							<?else : ?>
								<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>">
							<?endif;?>
						</div>
					</div>
					<div class="caption">
						<?if(!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])):?>
							<h4 class="nobottommargin nott"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h4>
						<?else : ?>
							<h4 class="nobottommargin nott"><?=$arItem["NAME"]?></h4>
						<?endif;?>
						<p class="nobottommargin"><?=$arItem["PREVIEW_TEXT"]?></p>
						<? if (count($arItem["DISPLAY_PROPERTIES"]) > 0) :?>
							<div class="line"></div>
						<?endif;?>
						<?foreach($arItem["DISPLAY_PROPERTIES"] as $pid=>$arProperty):?>
							<?
							$icon = CMarsShopHelper::getIconByPropCode($arProperty["CODE"]);
							if ($icon) {
								echo $icon;
							} else {
								echo $arProperty["NAME"] . ':&nbsp;';
							}
							?>
							<?if(is_array($arProperty["DISPLAY_VALUE"])):?>
								<?=implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]);?>
							<?else:?>
								<?$arProperty["DISPLAY_VALUE"] = CMarsShopHelper::getLinkByPropCode($arProperty["DISPLAY_VALUE"], $arProperty["CODE"]);?>
								<?=$arProperty["DISPLAY_VALUE"];?>
							<?endif?>
							<br />
						<?endforeach;?>
					</div>
				</div>
			</div>
		    <?
		    if ($rowCounter == $colInfo["NUM"]) :?><div class="clear"></div><?
		    $rowCounter = 0;
		    endif;?>
		<?endforeach;?>
	</div>
	<div class="clear"></div>
<?endforeach;?>

<div class="clear"></div>