<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
	global $USER;
	if($USER->IsAdmin()){
		$iblockNewsType = 'catalog'; //тип ИБ
		$iblockNews = 3; //блок от куда подтягивать элементы (новости например)
		$iblockComment = 54; //блок куда сохранять комментарии (сортируются по дате CODE комментария = id новости)
		$arNewsId = array( //ид новостей
			295,
			293,
			294
		);?>
		<h1>Компонент по выводу комментариев</h1>

		<?foreach ($arNewsId as $key => $idNew) { //переборка всех новостей?>
			<div style="border:2px solid;padding:15px;margin-bottom: 15px;">
			<?$elements = \Bitrix\Iblock\ElementTable::getList(array(
				'select' => array('NAME','PREVIEW_TEXT'), //запрашиваем данные новости
				'filter' => array(
					'IBLOCK_ID'=>$iblockNews,
					'ID'=>$idNew
				)
			))->fetch();?>

			<p><b>Текст новости</b>: <i><?=$elements['PREVIEW_TEXT']?></i></p>
			<p><b>ИД новости</b>: <i><?=$idNew?></i></p>
			<?$APPLICATION->IncludeComponent(
				"savvin:add_comment","",
				Array(
					'IBLOCK_TYPE'=>$iblockNewsType, //тип ИБ
					'IBLOCK_ID'=>$iblockNews, //ид ИБ
					'ELEMENT_ID'=>$idNew, //ид элемента к которому относится комментарий
					'IBLOCK_ID_COMMENTS'=>$iblockComment //ид ИБ, где хранятся комментарии
				),
				false
			);?>
			</div>
		<?}

	}else{
		LocalRedirect('/404.php');
	}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>