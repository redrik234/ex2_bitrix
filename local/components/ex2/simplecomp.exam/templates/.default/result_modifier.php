<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$products = [];
foreach($arResult['DATA'] as $news) {
    $products = array_merge($products, array_map(fn($product) => (int)$product['PROPERTY_PRICE_VALUE'], $news['PRODUCTS']));
}

$arResult['MAX_PRICE'] = max($products);
$arResult['MIN_PRICE'] = min($products);
$this->__component->SetResultCacheKeys(['MAX_PRICE', 'MIN_PRICE']);

?>
