<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>

<h4 class="widget__title"><?=GetMessage("VIEW_HEADER");?></h4>
<div class="widget-last-view">
	<?foreach($arResult as $arItem):?>
		<div class="spost clearfix">

			<?if($arParams["VIEWED_IMAGE"]=="Y" && is_array($arItem["PICTURE"])):?>
				<div class="entry-image">
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><img src="<?=$arItem["PICTURE"]["src"]?>" alt="<?=$arItem["NAME"]?>"></a>
				</div>
			<?endif?>
			<div class="entry-c">

				<?if($arParams["VIEWED_NAME"]=="Y"):?>
					<div class="entry-title">
						<a class="title-href" href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a>
					</div>
				<?endif?>
				<ul class="entry-meta">
					<?if($arParams["VIEWED_PRICE"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
						<li class="color"><?=$arItem["PRICE_FORMATED"]?></li>
					<?endif?>
				</ul>

				<?if($arParams["VIEWED_CANBUY"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
					<noindex>
						<a href="<?=$arItem["BUY_URL"]?>" rel="nofollow"><?=GetMessage("PRODUCT_BUY")?></a>
					</noindex>
				<?endif?>
				<?if($arParams["VIEWED_CANBASKET"]=="Y" && $arItem["CAN_BUY"]=="Y"):?>
					<noindex>
						<a href="<?=$arItem["ADD_URL"]?>" rel="nofollow"><?=GetMessage("PRODUCT_BASKET")?></a>
					</noindex>
				<?endif?>
			</div>
		</div>
	<?endforeach;?>
</div>
<?endif;?>