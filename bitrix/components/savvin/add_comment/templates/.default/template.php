<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<style>
	.add-comment,
	.add-comment label,
	.add-comment input,
	.add-comment textarea{
		width: 100%;
	}
	.add-comment{
		border: 1px solid;
		padding: 15px;
	}
</style>

<p>Комментарии к записи с ID - <b><?=$arResult['ELEMENT_ID']?></b></p>

<?foreach ($arResult['COMMENTS'] as $num => $comment) { //вывод уже созданных комментариев?>
	<div>
		<p><b>#<?=$num+1?></b> <?=$comment['NAME']?></p>
		<i><?=$comment['DETAIL_TEXT']?></i>
		<hr>
	</div>
<?}?>

<?//вывод формы для добавления комментария?>
<div>
	<form class="add-comment" action="<?=POST_FORM_ACTION_URI?>" method="post">
		<h3>Добавление комментария</h3>
		<p><label for="fio-<?=$arResult['ELEMENT_ID']?>">ФИО: <input type="text" name="fio" id="fio-<?=$arResult['ELEMENT_ID']?>" placeholder="Иванов Иван Иванович"></label></p>
		<p><label for="email-<?=$arResult['ELEMENT_ID']?>">Е-маил: <input type="text" name="email" id="email-<?=$arResult['ELEMENT_ID']?>" placeholder="mail@mail.ru"></label></p>
		<p><label for="comment-<?=$arResult['ELEMENT_ID']?>">Комментарий: <textarea name="comment" id="comment-<?=$arResult['ELEMENT_ID']?>" rows="5"></textarea></label></p>
		<p><input type="submit"></p>
	</form>
</div>