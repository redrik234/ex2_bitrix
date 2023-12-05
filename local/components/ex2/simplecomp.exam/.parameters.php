<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
	die();
}

use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

$arComponentParameters = array(
	"PARAMETERS" => array(
		"PRODUCTS_IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_PRODUCTS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"NEWS_IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_NEWS_IBLOCK_ID"),
			"TYPE" => "STRING",
		),
		"PRODUCTS_IBLOCK_PROPERTY" => array(
			"PARENT" => "BASE",
			"NAME" => GetMessage("SIMPLECOMP_PRODUCTS_IBLOCK_PROPERTY"),
			"TYPE" => "STRING",
		),
		"CACHE_TIME"  => array(
			"DEFAULT"=>36000000
		),
	)		
);
