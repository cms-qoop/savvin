<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

use Bitrix\Main\Loader,
	Bitrix\Iblock;

class SavvinComments extends CBitrixComponent
{

	public function getComments(){ //получение уже созданных комментариев

		Loader::includeModule('iblock');
		$elements = \Bitrix\Iblock\ElementTable::getList(array(
			'order'	=> array('TIMESTAMP_X'=>'asc'),
			'select' => array('NAME','CODE','DETAIL_TEXT'),
			'filter' => array(
					'IBLOCK_ID'=>$this->arResult['IBLOCK_ID_COMMENTS'],
					'CODE'=>$this->arResult['ELEMENT_ID'],
					'=ACTIVE' => 'Y'
				)
		))->fetchAll();

		return $elements;

	}

	public function addComment(){ //добавляем комментарий
		$properties = CIBlockProperty::GetList(Array(), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$this->arResult['IBLOCK_ID_COMMENTS'], "CODE"=>"EMAIL")); //проверяем свойство на наличии
		if(!$prop_fields = $properties->GetNext()){ //если свойства в инфоблоке нет, то создаем
			$arFields = Array(
				"NAME" => "Е-маил",
				"ACTIVE" => "Y",
				"SORT" => "500",
				"CODE" => "EMAIL",
				"PROPERTY_TYPE" => "S",
				"IBLOCK_ID" => $this->arResult['IBLOCK_ID_COMMENTS']
			);
			$iblockproperty = new CIBlockProperty;
			$PropertyID = $iblockproperty->Add($arFields); //создаем свойство
		}
		$el = new CIBlockElement;
		$arLoadProductArray = Array(
			"IBLOCK_SECTION_ID" => false,
			"IBLOCK_ID"      => $this->arResult['IBLOCK_ID_COMMENTS'],
			"CODE"           => $this->arResult['ELEMENT_ID'],
			"NAME"           => (strlen($_REQUEST['fio'])>0?$_REQUEST['fio']:'No name'),
			"ACTIVE"         => "Y",
			"DETAIL_TEXT"    => $_REQUEST['comment'],
			"PROPERTY_VALUES"=> array('EMAIL'=>(strlen($_REQUEST['email'])>0?$_REQUEST['email']:''))
		);
		if($PRODUCT_ID = $el->Add($arLoadProductArray)){
			return $PRODUCT_ID;
		}else{
			return $el->LAST_ERROR;
		}

	}

	public function executeComponent()
	{
		$this->arResult = array();
		$this->arResult['IBLOCK_TYPE'] = $this->arParams['IBLOCK_TYPE'];
		$this->arResult['IBLOCK_ID'] = $this->arParams['IBLOCK_ID'];
		$this->arResult['ELEMENT_ID'] = $this->arParams['ELEMENT_ID'];
		$this->arResult['IBLOCK_ID_COMMENTS'] = $this->arParams['IBLOCK_ID_COMMENTS'];
		$this->arResult['COMMENTS'] = $this->getComments();

		if(strlen($_REQUEST['comment'])>0){
			$this->addComment();
			LocalRedirect(POST_FORM_ACTION_URI);
		}

		$this->IncludeComponentTemplate();

    }
}
