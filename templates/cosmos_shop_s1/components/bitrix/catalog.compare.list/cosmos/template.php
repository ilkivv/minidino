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
use \Bitrix\Main\Localization\Loc;

$itemCount = count($arResult);
$isAjax = (isset($_REQUEST["ajax_action"]) && $_REQUEST["ajax_action"] == "Y");
$idCompareCount = 'compareList'.$this->randString();
$obCompare = 'ob'.$idCompareCount;
$idCompareTable = $idCompareCount.'_tbl';
$idCompareRow = $idCompareCount.'_row_';
$idCompareAll = $idCompareCount.'_count';
$mainClass = 'compare-switcher';

$style = ($itemCount == 0 ? ' style="display: none;"' : '');
?><div class="<? echo $mainClass; ?> hidden-sm hidden-xs">
    <div class="compare-switcher-head">
        <span>
            <?=Loc::getMessage("CATALOG_COMPARE_ELEMENTS")?>
        </span>
        <div class="compare-switcher-trigger icon-line-bar-graph-2"><span id="<? echo $idCompareAll; ?>" <? echo $style; ?>><? echo $itemCount; ?></span></div>
    </div>
    <div id="<? echo $idCompareCount; ?>" class="compare-switcher-body">
<?
unset($style, $mainClass);
if ($isAjax)
{
	$APPLICATION->RestartBuffer();
}
$frame = $this->createFrame($idCompareCount)->begin('');
?>
<?
if (!empty($arResult))
{
?>

<div class="col_full bottommargin-sm compare-table-container">
	<table id="<? echo $idCompareTable; ?>" class="compare-items table">
	<tbody><?
		foreach($arResult as $arElement)
		{
			?><tr id="<? echo $idCompareRow.$arElement['PARENT_ID']; ?>">
				<td class="center"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=$arElement["SRC"]?>"></a></td>
				<td><a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="compare-item"><?=$arElement["NAME"]?></a></td>
				<td><noindex><a href="javascript:void(0);"  data-id="<? echo $arElement['PARENT_ID']; ?>" rel="nofollow" title="<?=Loc::getMessage("CATALOG_COMPARE_REMOVE");?>"><i class="icon-remove"></i></a></noindex></td>
			</tr><?
		}
	?>
	</tbody>
	</table>
</div>

<div class="col_full nobottommargin">
	<a href="<? echo $arParams["COMPARE_URL"]; ?>" class="button button-mini noleftmargin"><?=Loc::getMessage('CP_BCCL_TPL_MESS_COMPARE_PAGE'); ?></a>
</div>
<?
} else { ?>
	<div class="alert alert-info">
		<?=Loc::getMessage("CATALOG_COMPARE_NO_ELEMENTS");?>
	</div>
<?}
$frame->end();
if ($isAjax)
{
	die();
}
$currentPath = CHTTP::urlDeleteParams(
	$APPLICATION->GetCurPageParam(),
	array(
		$arParams['PRODUCT_ID_VARIABLE'],
		$arParams['ACTION_VARIABLE'],
		'ajax_action'
	),
	array("delete_system_params" => true)
);

$jsParams = array(
	'VISUAL' => array(
		'ID' => $idCompareCount,
	),
	'AJAX' => array(
		'url' => $currentPath,
		'params' => array(
			'ajax_action' => 'Y'
		),
		'templates' => array(
			'delete' => (strpos($currentPath, '?') === false ? '?' : '&').$arParams['ACTION_VARIABLE'].'=DELETE_FROM_COMPARE_LIST&'.$arParams['PRODUCT_ID_VARIABLE'].'='
		)
	),
);
?>
</div>
</div>
<script type="text/javascript">
var <? echo $obCompare; ?> = new JCCatalogCompareList(<? echo CUtil::PhpToJSObject($jsParams, false, true); ?>)
</script>