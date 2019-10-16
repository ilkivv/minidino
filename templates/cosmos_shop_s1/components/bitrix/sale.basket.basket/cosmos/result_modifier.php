<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


use Bitrix\Main\Application; 
$request = Application::getInstance()->getContext()->getRequest(); 
$clearBasket = htmlspecialchars($request->getQuery("CLEAR_BASKET"));
if ($clearBasket == "Y") {
	CSaleBasket::DeleteAll(CSaleBasket::GetBasketUserID());
	LocalRedirect($APPLICATION->GetCurPage());
}