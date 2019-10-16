<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

CJSCore::Init(array('currency')); 
$allCurrency = CSaleLang::GetLangCurrency(SITE_ID);
$currencyFormat = CCurrencyLang::GetFormatDescription($allCurrency); 
?> 
<script type="text/javascript"> 
	BX.Currency.setCurrencyFormat('<?=$allCurrency?>', <? echo CUtil::PhpToJSObject($currencyFormat, false, true); ?>);  
</script>