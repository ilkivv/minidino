<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use \Bitrix\Main\Localization\Loc;
$this->setFrameMode(true);?>
<?
$INPUT_ID = trim($arParams["~INPUT_ID"]);
if(strlen($INPUT_ID) <= 0)
	$INPUT_ID = "title-search-input";
$INPUT_ID = CUtil::JSEscape($INPUT_ID);

$CONTAINER_ID = trim($arParams["~CONTAINER_ID"]);
if(strlen($CONTAINER_ID) <= 0)
	$CONTAINER_ID = "search-form";
$CONTAINER_ID = CUtil::JSEscape($CONTAINER_ID);

if($arParams["SHOW_INPUT"] !== "N"):?>
	<!-- Top Search
	============================================= -->
    <form action="<?echo $arResult["FORM_ACTION"]?>" method="get" id="<?echo $CONTAINER_ID?>">
        <input id="<?echo $INPUT_ID?>"  type="text" name="q" class="sm-form-control" value=""
               placeholder="<?= Loc::getMessage("CT_BST_SEARCH_BUTTON") ?>">
    </form>
<?endif?>
<script>
	BX.ready(function(){
		new JCTitleSearch({
			'AJAX_PAGE' : '<?echo CUtil::JSEscape(POST_FORM_ACTION_URI)?>',
			'CONTAINER_ID': '<?echo $INPUT_ID?>',
			'INPUT_ID': '<?echo $INPUT_ID?>',
			'MIN_QUERY_LEN': 2
		});
	});
</script>
