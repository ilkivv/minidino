<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Page\Asset;
Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/calendar.css");
?>