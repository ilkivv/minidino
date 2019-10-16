<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Config\Option;

Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . "/css/swiper.css"); 