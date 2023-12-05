<?
if ($arParams['SPECIALDATE'] === "Y" && $arResult['ITEMS']) {
    $arResult['DATE_FIRST_NEWS'] = $arResult['ITEMS'][0]['ACTIVE_FROM'];
    $this->__component->setResultCacheKeys(['DATE_FIRST_NEWS']);
}

?>