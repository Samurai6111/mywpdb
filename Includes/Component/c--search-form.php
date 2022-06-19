<?php


//--------------------------------------------------
// search
//--------------------------------------------------
$search_tables = $Mywpdb_Get_Table->search_tables();
$Mywpdb_Search = new Mywpdb_Search();
$s = $Mywpdb_Search->s;
?>
<h1>検索フォーム</h1>
<form class="mywpdbSearch__form" method="GET">
	<?php mywpdb_const_input() ?>

	<div class="mywpdbSearch__selectWrap">
		<button class="mywpdbSearch__selectButton -btn" id="js__mywpdbSearch__selectButton" onclick="onclickSelectAll(event)" type="button">
			全て選択
		</button>

		<select name="search_tables[]" id="js__mywpdbSearch__select" class="mywpdbSearch__select" multiple>
			<?php
			$index = -1;
			foreach ($Mywpdb_Get_Table->tables() as $table_name) {
				$index++;
				$selected = (in_array($table_name, $search_tables)) ? 'selected' : '';
			?>
				<option value="<?php echo esc_attr($table_name)  ?>" <?php echo esc_attr($selected) ?>>
					<?php echo esc_html($table_name) ?>
				</option>
			<?php } ?>
		</select>
	</div>

	<input type="hidden" name="search_result">
	<input type="text" class="mywpdbSearch__keyword" value="<?php echo esc_attr($s) ?>" name="s">

	<button class="mywpdbSearch__submit -btn" type="submit">送信</button>
</form>
