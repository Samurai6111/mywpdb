<?php
$Mywpdb_Get_Table = new Mywpdb_Get_Table();
$Mywpdb_Search = new Mywpdb_Search();
$search_results = $Mywpdb_Search->search_results();
$s = $Mywpdb_Search->s;
?>

<h1>検索結果ページ</h1>
<h2>検索キーワード : <?php echo esc_html($s) ?></h2>
<?php
if (!empty($search_results)) {
	foreach ($search_results as $search_table => $table_column_values) {
		$table_column_names = $Mywpdb_Get_Table->table_column_names($search_table);
?>
<br>
<h2>テーブル名 : <?php echo esc_html($search_table) ?></h2>
<table class="mywpdbTable">
	<tr class="mywpdbTable__tr">
		<th class="mywpdbTable__head">
			<div class="mywpdbTable__flex">修正</div>
		</th>

		<?php foreach ($table_column_names as $table_column_name) { ?>
		<th class="mywpdbTable__head">
			<?php echo esc_html($table_column_name) ?>
		</th>
		<?php } ?>
	</tr>

	<?php
			foreach ($table_column_values as $table_column_value) {
				$first_key = array_key_first($table_column_value);
				$first_value = $table_column_value[$first_key]; ?>
	<tr class="mywpdbTable__tr">

		<td class="mywpdbTable__desc">
			<div class="mywpdbTable__flex">
				<form action="<?php get_admin_url() ?>"
							method="GET">
					<?php mywpdb_GETS('s') ?>

					<input type="hidden"
								 name="view"
								 value="table_row">

					<input type="hidden"
								 name="offset"
								 value="0">

					<input type="hidden"
								 name="table_name"
								 value="<?php echo esc_attr($search_table) ?>">
					<input type="hidden"
								 name="where[<?php echo esc_attr($first_key) ?>]"
								 value="<?php echo esc_attr($first_value) ?>">
					<button type="submit">編集</button>
				</form>

				<form action="<?php echo esc_url(mywpdb_get_current_link()) ?>"
							method="POST"
							id="tableRowDelete">
					<input type="hidden"
								 name="mywpdb_delete">
					<input type="hidden"
								 name="get_current_link"
								 value="<?php echo esc_url(mywpdb_get_current_link()) ?>">
					<input type="hidden"
								 name="table_key"
								 value="<?php echo esc_attr($first_key) ?>">
					<input type="hidden"
								 name="table_name"
								 value="<?php echo esc_attr($search_table) ?>">
					<input type="hidden"
								 name="table_value"
								 value="<?php echo esc_attr($first_value) ?>">

					<button type="button"
									class="-error"
									form="tableRowDelete"
									onclick="mywpdb_confirm_to_submit(event)">削除</button>
				</form>
			</div>
		</td>

		<?php
					foreach ($table_column_value as $table_row_value) {
						$table_value_output = strip_tags($table_row_value);
						$table_value_output = mb_substr($table_row_value, 0, 100);
					?>
		<td class="mywpdbTable__desc">
			<?php echo esc_html($table_value_output) ?>
		</td>
		<?php } ?>
	</tr>
	<?php } ?>

</table>

<?php } ?>
<?php } ?>


<script>
function mywpdb_confirm_to_submit(e) {
	(function($) {
		target = e.target;
		if (window.confirm("データを削除しますか？")) {
			formID = $(target).attr("form");
			$("#" + formID).submit();
		} else {}
	})(jQuery);
}

(function($) {
	$('.mywpdbTable__desc').each(function() {
		let text = $(this).text()
		let $s = '<?php echo esc_html($s) ?>'
		if (text.match($s)) {
			let replace = text.replace($s, "<b class='-searchHighlight'>" + $s + "</b>");
			$(this).html(replace)
		}
	})
})(jQuery);
</script>