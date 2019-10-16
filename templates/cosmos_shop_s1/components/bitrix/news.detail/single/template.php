<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use \Bitrix\Main\Localization\Loc;
use Boxsol\CosmoFashion\Template;
$this->setFrameMode(true);
?>
<!-- Single Post
============================================= -->

<div class="entry nobottompadding nobottommargin clearfix noborder">
	<? if ($arParams["DISPLAY_NAME"] != "N" && $arResult["NAME"]): ?>
		<div class="entry-title">
			<h2><?= $arResult["NAME"] ?></h2>
		</div>
	<? endif; ?>

	<!-- Entry Content
	============================================= -->
	<div class="entry-content notopmargin bottommargin-sm">
		<? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arResult["DETAIL_PICTURE"])): ?>
			<div class="entry-image <?=$arResult["DETAIL_PICTURE_POSITION"]?>">
				<img src="<?= $arResult["DETAIL_PICTURE"]["SRC"] ?>"
						 alt="<?= $arResult["DETAIL_PICTURE"]["ALT"] ?>" title="<?= $arResult["DETAIL_PICTURE"]["TITLE"] ?>">
			</div>
		<? endif ?>

		<?if ($arResult["SHOW_ASK_QUESTION"] == "Y") : ?>
			<div class="col-md-3 col_last fright">
				<div class="promo promo-light promo-mini promo-center">
					<a href="<?=$arParams["LINK_TO_AJAX"]?>?ELEMENT_CODE=<?=$arResult["CODE"]?>&TYPE=ASK_QUESTION" data-lightbox="ajax" class="button button-mini nomargin">
						<?=(strlen($arParams["MSG_ASK_QUESTION"]) > 0) ? $arParams["MSG_ASK_QUESTION"] : Loc::getMessage("MD_ND_MSG_ASK_QUESTION_DEF");?>
					</a>
					<p class="nomargin"><small> <?=(strlen($arParams["MSG_ASK_QUESTION_UNDER"]) > 0) ? $arParams["MSG_ASK_QUESTION_UNDER"] : Loc::getMessage("MD_ND_MSG_ASK_QUESTION_UNDER_DEF");?></small></p>
				</div>
			</div>
		<?endif;?>
		<? if ($arParams["DISPLAY_DATE"] != "N" && $arResult["DISPLAY_ACTIVE_FROM"]): ?>
			<ul class="entry-meta">
					<li><i class="icon-calendar3"></i> <?= $arResult["DISPLAY_ACTIVE_FROM"] ?></li>
			</ul>
		<? endif; ?>
		<? if ($arResult["NAV_RESULT"]): ?>
			<? if ($arParams["DISPLAY_TOP_PAGER"]): ?><?= $arResult["NAV_STRING"] ?><? endif; ?>
			<?= $arResult["NAV_TEXT"]; ?>
			<? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?><?= $arResult["NAV_STRING"] ?><? endif; ?>
		<? elseif (strlen($arResult["DETAIL_TEXT"]) > 0): ?>
			<?
				$stringToTheEnd;
			   	foreach ($arResult["INCLUDE_FILES"] as $keyFile => $valIncludeFile) {
				   	ob_start();
						$APPLICATION->IncludeFile(
				                SITE_DIR . "include/infoblock/" . $valIncludeFile,
				                Array("arResult" => $arResult),
				                Array(
				                	"MODE" => "html",
									"NAME" => $valIncludeFile,
									"SHOW_BORDER" => false
									)
				            );
			   			$includeFileString = ob_get_contents();
				   	ob_end_clean();
				   	$macrosPosition = strpos($arResult["DETAIL_TEXT"], "#" . strtoupper($valIncludeFile). "#");
				   	if ($macrosPosition !== false) {
						$arResult["DETAIL_TEXT"] = str_replace("#" . strtoupper($valIncludeFile). "#", $includeFileString, $arResult["DETAIL_TEXT"]);
				   	} else {
				   		$stringToTheEnd .= $includeFileString;
				   	}
	   			}
			?>
			<?= $arResult["DETAIL_TEXT"]; 	?>
			<?= $stringToTheEnd;			?>
		<? else: ?>
			<?= $arResult["PREVIEW_TEXT"]; ?>
		<? endif ?>
		<br/>
		<? foreach ($arResult["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
			<?
			$icon = CMarsShopHelper::getIconByPropCode($arProperty["CODE"]);
			if ($icon) {
				echo $icon;
			} else {
				echo $arProperty["NAME"] . ':&nbsp;';
			}
			?>
			<? if (is_array($arProperty["DISPLAY_VALUE"])): ?>
				<?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
			<? else: ?>
				<?$arProperty["DISPLAY_VALUE"] = CMarsShopHelper::getLinkByPropCode($arProperty["DISPLAY_VALUE"], $arProperty["CODE"]);?>
				<?= $arProperty["DISPLAY_VALUE"]; ?>
			<? endif ?>
			<br/>
		<? endforeach; ?>
		<!-- Post Single - Content End -->
		<div class="clear"></div>
	</div>
	<?if (count($arResult["MORE_PHOTO"]) > 0) :?>
		<div class="fancy-title title-bottom-border bottommargin-sm">
			<h3><?=Loc::getMessage("MD_ND_GALLERY"); ?></h3>
		</div>
		<div class="masonry-thumbs <?=$arResult["COL_DATA"]["CLASS"]?> bottommargin" <?=$arResult["COL_DATA"]["DATA_BIG"]?> data-lightbox="gallery">
			<?foreach($arResult["MORE_PHOTO"] as $keyPhoto => $arPhoto):?>
			<a href="<?=$arPhoto["SRC"]?>" data-lightbox="gallery-item" title="<?=$arPhoto["TITLE"]?>">
				<img class="image_fade" src="<?=$arPhoto["SRC_THUMB"]?>" alt="<?=$arResult["NAME"]?>" title="<?=$arPhoto["TITLE"]?>" alt="<?=$arPhoto["ALT"]?>">
			</a>
			<?endforeach;?>
		</div>
	<?endif;?>

	<?if ($arResult["SHOW_ZAKAZ"] == "Y") : ?>
		<div class="promo promo-light bottommargin">
			<h3><?=(strlen($arParams["MSG_ZAKAZ_TITLE"]) > 0) ?
			str_replace("#NAME#", $arResult["NAME"], $arParams["MSG_ZAKAZ_TITLE"])
			: Loc::getMessage("MD_ND_MSG_ZAKAZ_TITLE_DEF", array("#NAME#" => $arResult["NAME"]))?></h3>
			<span><?=(strlen($arParams["MSG_ZAKAZ_UNDER"]) > 0) ? $arParams["MSG_ZAKAZ_UNDER"] : Loc::getMessage("MD_ND_MSG_ZAKAZ_UNDER_DEF");?></span>
			<a href="<?=$arParams["LINK_TO_AJAX"]?>?ELEMENT_CODE=<?=$arResult["CODE"]?>" data-lightbox="ajax" class="button "><?=(strlen($arParams["MSG_ZAKAZ"]) > 0) ? $arParams["MSG_ZAKAZ"] : Loc::getMessage("MD_ND_MSG_ZAKAZ_DEF");?></a>
		</div>
	<?endif;?>

	<?if (count($arResult["ADDITIONAL_FILES"]) > 0) :?>
		<div class="fancy-title title-bottom-border">
			<h3><?=Loc::getMessage("MD_ND_DOCUMENTS");?></h3>
		</div>
		<?foreach($arResult["ADDITIONAL_FILES"] as $keyPhoto => $arFile):?>
			<div class="col_half col_last">
				<div class="feature-box fbox-plain">
					<div class="fbox-icon bounceIn animated" data-animate="bounceIn">
						<a href="<?=$arFile["SRC"]?>" title="<?=$arFile["ORIGINAL_NAME"]?>" target="_blank">
							<img src="<?=$arFile["FILE_EXTENSION_SRC"]?>" alt="<?=$arFile["ORIGINAL_NAME"]?>">
						</a>
					</div>
					<a href="<?=$arFile["SRC"]?>" target="_blank" title="<?=$arFile["ORIGINAL_NAME"]?>"><h5 class="nobottommargin"><?=$arFile["ORIGINAL_NAME"]?></h5></a>
					<p><?=Loc::getMessage("MD_ND_FILE_SIZE")?> <?=$arFile["FILE_SIZE_FORMATED"]?></p>
				</div>
			</div>
		<?endforeach;?>

	<?endif;?>
	<div class="col_full nobottommargin">
	<?
	if (isset($arResult["SECTION_URL"]) && strlen($arResult["SECTION_URL"]) > 0) {
		$backUrl = $arResult["SECTION_URL"];
	} else {
		$backUrl =  $arResult["IBLOCK"]["LIST_PAGE_URL"];
	}
	?>
		<div class="col_half">
			<a href="<?=$backUrl?>" class="button button-small button-border button-reveal noleftmargin">
				<i class="icon-double-angle-left"></i><span><?=Loc::getMessage("MD_ND_BACK"); ?></span>
			</a>
		</div>
		<div class="col_half col_last">
			<?
			if (array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
			{
				$APPLICATION->IncludeComponent("bitrix:main.share", "projectx", array(
					"HANDLERS"          => $arParams["SHARE_HANDLERS"],
					"PAGE_URL"          => $arResult["~DETAIL_PAGE_URL"],
					"PAGE_TITLE"        => $arResult["~NAME"],
					"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
					"SHORTEN_URL_KEY"   => $arParams["SHARE_SHORTEN_URL_KEY"],
					"HIDE"              => $arParams["SHARE_HIDE"],
				),
					$component,
					array("HIDE_ICONS" => "Y")
				);
			}
			?>
		</div>
	</div>
</div><!-- .entry end -->
<?if (Template::getInstance()->getOptionString(COSMOS_MODULE_NAME, 'use_schema', 'N') == "Y") :?>
	<script type="application/ld+json">
	{
	  "@context": "http://schema.org",
	  "@type": "NewsArticle",
	  "mainEntityOfPage":{
	    "@type":"WebPage",
	    "@id":"<?=$APPLICATION->GetCurUri();?>"
	  },
	  "headline": "<?= $arResult["NAME"] ?>",
	  "image": {
	    "@type": "ImageObject",
	    "url": "<?=$arResult["DETAIL_PICTURE"]["SRC"] ?>",
	    "height": <?=$arResult["DETAIL_PICTURE"]["HEIGHT"] ?>,
	    "width": <?=$arResult["DETAIL_PICTURE"]["WIDTH"] ?>
	  },
	  "description": "<?= $arResult["PREVIEW_TEXT"] ?>"
	}
	</script>
<?endif;?>