<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
use \Bitrix\Main\Localization\Loc;
if(!empty($arResult["CATEGORIES"])):?>
	<div class="top-cart-content"  style="background-color: #fff; max-width: 500px;">
		<div class="top-cart-title">
			<h4><?=Loc::getMessage("ST_H4_TITLE");?></h4>
		</div>
		<div class="top-cart-items">
		<?foreach($arResult["CATEGORIES"] as $category_id => $arCategory):?>
			<?foreach($arCategory["ITEMS"] as $i => $arItem):?>
				<?if($category_id === "all"):?>
					<td class="title-search-all"><a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></td>
				<?elseif(isset($arResult["ELEMENTS"][$arItem["ITEM_ID"]])):
					$arElement = $arResult["ELEMENTS"][$arItem["ITEM_ID"]];
				?>
					<div class="top-cart-item clearfix">
						<div class="top-cart-item-image">
							<a href="<?echo $arItem["URL"]?>"><img src="<?echo $arElement["PICTURE"]["src"]?>" alt=""></a>
						</div>
						<div class="top-cart-item-desc">
							<a href="<?echo $arItem["URL"]?>"><?echo $arItem["NAME"]?></a>
							<?foreach($arElement["PRICES"] as $code=>$arPrice):?>
								<?if($arPrice["CAN_ACCESS"]):?>
									<span class="top-cart-item-price">
										<?if($arPrice["DISCOUNT_VALUE"] < $arPrice["VALUE"]):?>
											<s><?=$arPrice["PRINT_VALUE"]?></s> <?=$arPrice["PRINT_DISCOUNT_VALUE"]?>
										<?else:?><?=$arPrice["PRINT_VALUE"]?><?endif;?>
									</span>
								<?endif;?>
							<?endforeach;?>
						</div>
					</div>
				<?elseif(isset($arItem["ICON"])):?>
				<?endif;?>
			</tr>
			<?endforeach;?>
		<?endforeach;?>

		</div>

	</div>
<?endif;
?>