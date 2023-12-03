<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if (isset($arResult['MAX_PRICE']) && isset($arResult['MIN_PRICE'])) {
    $html = '<div style="color:red; margin: 34px 15px 35px 15px">' . Loc::GetMessage('SIMPLECOMP_WIDGET', ['#MIN_PRICE#' => $arResult['MIN_PRICE'], '#MAX_PRICE#' => $arResult['MAX_PRICE']]) . '</div>';
    $APPLICATION->AddViewContent('prices', $html);
}

?>