<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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

$templateData = array(
	'TEMPLATE_THEME' => $this->GetFolder().'/themes/'.$arParams['TEMPLATE_THEME'].'/style.css',
	'TEMPLATE_CLASS' => 'bx-'.$arParams['TEMPLATE_THEME']
);
$curJsId = $this->randString();
?>
<div id="bx-set-const-<?=$curJsId?>" class="bx-modal-container container-fluid <? echo $templateData['TEMPLATE_CLASS']; ?>">
	<div class="row">
		<div class="col-xs-12">
			<strong class="bx-modal-small-title"><?=GetMessage("CATALOG_SET_BUY_SET")?></strong>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<div class="bx-original-item-container">
				<?if ($arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]):?>
					<img src="<?=$arResult["ELEMENT"]["DETAIL_PICTURE"]["src"]?>" style="width: 70px;height: auto;" alt="">
				<?else:?>
					<img src="<?=$this->GetFolder().'/images/no_foto.png'?>" style="width: 70px;height: auto;" alt="">
				<?endif?>

				<div>
					<?=$arResult["ELEMENT"]["NAME"]?> <br>
					<span class="bx-added-item-new-price"><strong><?=$arResult["ELEMENT"]["PRICE_PRINT_DISCOUNT_VALUE"]?></strong></span>
					<?if (!($arResult["ELEMENT"]["PRICE_VALUE"] == $arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"])):?><span class="bx-catalog-set-item-price-old"><strong><?=$arResult["ELEMENT"]["PRICE_PRINT_VALUE"]?></strong></span><?endif?>

				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="bx-added-item-table-container">
				<table class="bx-added-item-table">
					<tbody data-role="set-items">
					<?foreach($arResult["SET_ITEMS"]["DEFAULT"] as $key => $arItem):?>
						<tr
							data-id="<?=$arItem["ID"]?>"
							data-img="<?=$arItem["DETAIL_PICTURE"]["src"]?>"
							data-url="<?=$arItem["DETAIL_PAGE_URL"]?>"
							data-name="<?=$arItem["NAME"]?>"
							data-price="<?=$arItem["PRICE_DISCOUNT_VALUE"]?>"
							data-print-price="<?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?>"
							data-old-price="<?=$arItem["PRICE_VALUE"]?>"
							data-print-old-price="<?=$arItem["PRICE_PRINT_VALUE"]?>"
							data-diff-price="<?=$arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>"

						>
							<td class="bx-added-item-table-cell-img">
								<?if ($arItem["DETAIL_PICTURE"]["src"]):?>
									<img src="<?=$arItem["DETAIL_PICTURE"]["src"]?>" class="img-responsive" alt="">
								<?else:?>
									<img src="<?=$this->GetFolder().'/images/no_foto.png'?>" class="img-responsive" alt="">
								<?endif?>
							</td>
							<td class="bx-added-item-table-cell-itemname">
								<a class="tdn" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
							</td>
							<td class="bx-added-item-table-cell-price">
								<span class="bx-added-item-new-price"><?= $arItem["PRICE_PRINT_DISCOUNT_VALUE"]?></span>
								<?if ($arItem["PRICE_VALUE"] != $arItem["PRICE_DISCOUNT_VALUE"]):?>
									<br><span class="bx-added-item-old-price"><?=$arItem["PRICE_PRINT_VALUE"]?></span>
								<?endif?>
							</td>
							<td class="bx-added-item-table-cell-del"><div class="bx-added-item-delete" data-role="set-delete-btn"></div></td>
						</tr>
					<?endforeach?>
					</tbody>
				</table>
			</div>
		</div>

		<div class="col-sm-3">
			<div class="bx-constructor-container-result">
				<span class="bx-item-set-current-price" data-role="set-price"><?=$arResult["SET_ITEMS"]["PRICE"]?></span>

				<span class="bx-added-item-old-price" data-role="set-old-price">
					<?if ($arResult["SET_ITEMS"]["OLD_PRICE"]):?>
						<?=$arResult["SET_ITEMS"]["OLD_PRICE"]?>
					<?endif?>
				</span>

				<span class="bx-item-set-economy-price" data-role="set-diff-price">
					<?if ($arResult["SET_ITEMS"]["PRICE_DISCOUNT_DIFFERENCE"]):?>
						<?=GetMessage("CATALOG_SET_DISCOUNT_DIFF", array("#PRICE#" => $arResult["SET_ITEMS"]["PRICE_DISCOUNT_DIFFERENCE"]))?>
					<?endif?>
				</span>

				<div>
					<a href="javascript:void(0)" data-role="set-buy-btn" class="button button-small"><?=GetMessage("CATALOG_SET_BUY")?></a>
				</div>
			</div>
		</div>
	</div>

	<div class="bx-catalog-set-topsale-slider-box">
		<div class="bx-catalog-set-topsale-slider-container">
			<div class="bx-catalog-set-topsale-slids bx-catalog-set-topsale-slids-<?=$curJsId?>" data-role="set-other-items">
				<?foreach($arResult["SET_ITEMS"]["OTHER"] as $key => $arItem):?>
				<div class="bx-catalog-set-item-container bx-catalog-set-item-container-<?=$curJsId?>"
					data-id="<?=$arItem["ID"]?>"
					data-img="<?=$arItem["DETAIL_PICTURE"]["src"]?>"
					data-url="<?=$arItem["DETAIL_PAGE_URL"]?>"
					data-name="<?=$arItem["NAME"]?>"
					data-price="<?=$arItem["PRICE_DISCOUNT_VALUE"]?>"
					data-print-price="<?=$arItem["PRICE_PRINT_DISCOUNT_VALUE"]?>"
					data-old-price="<?=$arItem["PRICE_VALUE"]?>"
					data-print-old-price="<?=$arItem["PRICE_PRINT_VALUE"]?>"
					data-diff-price="<?=$arItem["PRICE_DISCOUNT_DIFFERENCE_VALUE"]?>"
				>
					<div class="bx-catalog-set-item">
						<div class="bx-catalog-set-item-img">
							<div class="bx-catalog-set-item-img-container">
							<?if ($arItem["DETAIL_PICTURE"]["src"]):?>
								<img src="<?=$arItem["DETAIL_PICTURE"]["src"]?>" class="img-responsive" alt=""/>
							<?else:?>
								<img src="<?=$this->GetFolder().'/images/no_foto.png'?>" class="img-responsive"/>
							<?endif?>
							</div>
						</div>
						<div class="bx-catalog-set-item-title">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
						</div>
						<div class="bx-catalog-set-item-price">
							<div class="bx-catalog-set-item-price-new"><?= $arItem["PRICE_PRINT_DISCOUNT_VALUE"]?></div>
							<?if ($arItem["PRICE_VALUE"] != $arItem["PRICE_DISCOUNT_VALUE"]):?>
								<div class="bx-catalog-set-item-price-old"><?=$arItem["PRICE_PRINT_VALUE"]?></div>
							<?endif?>
						</div>
						<div class="bx-catalog-set-item-add-btn">
							<a href="javascript:void(0)" data-role="set-add-btn" class="button button-small"><?=GetMessage("CATALOG_SET_BUTTON_ADD")?></a>
						</div>
					</div>
				</div>
				<?endforeach?>
			</div>
		</div>
	</div>
</div>
<?
$arJsParams = array(
	"numSliderItems" => count($arResult["SET_ITEMS"]["OTHER"]),
	"jsId" => $curJsId,
	"parentContId" => "bx-set-const-".$curJsId,
	"ajaxPath" => $this->GetFolder().'/ajax.php',
	"currency" => $arResult["ELEMENT"]["PRICE_CURRENCY"],
	"mainElementPrice" => $arResult["ELEMENT"]["PRICE_DISCOUNT_VALUE"],
	"mainElementOldPrice" => $arResult["ELEMENT"]["PRICE_VALUE"],
	"mainElementDiffPrice" => $arResult["ELEMENT"]["PRICE_DISCOUNT_DIFFERENCE_VALUE"],
	"lid" => SITE_ID,
	"iblockId" => $arParams["IBLOCK_ID"],
	"basketUrl" => $arParams["BASKET_URL"],
	"setIds" => $arResult["DEFAULT_SET_IDS"],
	"offersCartProps" => $arParams["OFFERS_CART_PROPERTIES"],
	"itemsRatio" => $arResult["ITEMS_RATIO"],
	"noFotoSrc" => $this->GetFolder().'/images/no_foto.png'
);
?>
<script type="text/javascript">
	BX.message({
		"ADD_BUTTON" : "<?=GetMessageJs("CATALOG_SET_BUTTON_ADD")?>",
		"CATALOG_SET_DISCOUNT_DIFF" : "<?=GetMessageJs("CATALOG_SET_DISCOUNT_DIFF")?>"
	});

	BX.ready(function(){
		new BX.Catalog.SetConstructor(<?=CUtil::PhpToJSObject($arJsParams)?>);
	});
</script>