<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

if (!Loader::includeModule('iblock')){
	return;
}

$arIBlockType = CIBlockParameters::GetIBlockTypes(); //получаем типы ИБ

$arIBlocks=array(); //пустые массивы для хранения типов и ид ИБ
$arIblocksComments=array(); //пустые массивы для хранения всех ид ИБ

$db_iblock = \Bitrix\Iblock\IblockTable::getList(array(
		'order' => array('SORT' => 'asc'),
		'select' => array('ID','NAME','IBLOCK_TYPE_ID'),
	));
while($arRes = $db_iblock->Fetch()){
	//собираем данные для вывода
	$arIBlocks[$arRes['IBLOCK_TYPE_ID']][$arRes["ID"]] = "(".$arRes["ID"].") ".$arRes["NAME"];
	$arIblocksComments[$arRes["ID"]] = "(".$arRes["ID"].") ".$arRes["NAME"];
}


$arComponentParameters = array(
	"GROUPS" => array(
	),
	"PARAMETERS" => array(
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => 'Тип инфоблока',
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType, //вывод типов ИБ
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => 'ID инфоблока',
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks[$arCurrentValues['IBLOCK_TYPE']], //вывод ид ИБ исходя из типа ИБ
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		"ELEMENT_ID" => array(
			"PARENT" => "BASE",
			"NAME" => "ID элемента",
			"TYPE" => "STRING",
			"DEFAULT" => '',
		),
		"IBLOCK_ID_COMMENTS" => array(
			"PARENT" => "BASE",
			"NAME" => 'ID инфоблока в котором хранятся комментарии',
			"TYPE" => "LIST",
			"VALUES" => $arIblocksComments, //вывод всех ид ИБ
			"REFRESH" => "Y",
			"ADDITIONAL_VALUES" => "Y",
		),
		
	),
);