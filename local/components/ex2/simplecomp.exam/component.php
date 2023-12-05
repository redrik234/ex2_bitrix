<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if(!Loader::includeModule("iblock"))
{
	ShowError(GetMessage("SIMPLECOMP_EXAM2_IBLOCK_MODULE_NONE"));
	return;
}

function getData(int $newsIblockId, int $productsIblockId, string $property)  {
	$data = [];

	$newsORM = CIBlockElement::GetList(
		[],
		[
			'IBLOCK_ID' => $newsIblockId,
			'ACTIVE' 	=> "Y"
		],
		false,
		false,
		[
			'ID', 'NAME', 'ACTIVE_FROM'
		]
	);

	while($arNews = $newsORM->Fetch()) {
		$data[$arNews['ID']] = array_merge($arNews, getSectionAndProducts((int)$arNews['ID'], $productsIblockId, $property));
	}

	return $data;
}

function getSectionAndProducts(int $newsId, int $productsIblockId, string $property) {
	$sections = [];
	$products = [];

	$sectionsORM = CIBlockSection::GetList(
		[],
		[
			'IBLOCK_ID' => $productsIblockId,
			'ACTIVE' 	=> "Y",
			$property	=> $newsId
		],
		false,
		[
			'ID', 'NAME', $property
		]
	);

	while($arSection = $sectionsORM->Fetch()) {
		$sections[$arSection['ID']] = $arSection;
		$products = array_merge($products, getProducts((int)$arSection['ID'], $productsIblockId));
	}

	return [
		'SECTIONS'  => $sections,
		'PRODUCTS' => $products
	];
}

function getProducts(int $sectionId, int $productsIblockId)  {
	$products = [];

	$productsORM = CIBlockElement::GetList(
		[],
		[
			'IBLOCK_ID'  => $productsIblockId,
			'ACTIVE' 	 => "Y",
			'SECTION_ID' => $sectionId
		],
		false,
		false,
		[
			'ID', 'NAME', 'PROPERTY_ARTNUMBER', 'PROPERTY_MATERIAL', 'PROPERTY_PRICE'
		]
	);

	while($arProduct = $productsORM->Fetch()) {
		$products[$arProduct['ID']] = $arProduct;
	}

	return $products;
}

function getUniqCountProducts(array $data) {
	$products = [];
	foreach($data as $news) {
		foreach($news['PRODUCTS'] as $product) {
			$products[$product['ID']] = null;
		}
	}

	return count($products);
}

if (!isset($arParams['CACHE_TIME'])) {
	$arParams['CACHE_TIME'] = 360000000;
}

if (!isset($arParams['NEWS_IBLOCK_ID'])) {
	$arParams['NEWS_IBLOCK_ID'] = 0;
}

if (!isset($arParams['PRODUCTS_IBLOCK_ID'])) {
	$arParams['PRODUCTS_IBLOCK_ID'] = 0;
}

if ($this->startResultCache()) {
	$data = getData((int)$arParams['NEWS_IBLOCK_ID'], (int)$arParams['PRODUCTS_IBLOCK_ID'], $arParams['PRODUCTS_IBLOCK_PROPERTY']);
	$arResult['PRODUCT_COUNT'] = getUniqCountProducts($data);
	$arResult['DATA'] = $data;

	$this->SetResultCacheKeys(['PRODUCT_COUNT']);
	$this->includeComponentTemplate();	
}
else {
	$this->abortResultCache();
}

$APPLICATION->setTitle(Loc::GetMessage('TITLE_PRODUCTS_COUNT') . $arResult['PRODUCT_COUNT']);
?>