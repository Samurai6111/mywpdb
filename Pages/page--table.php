<?php
$mywpdb_delete = new Mywpdb_Delete();
$mywpdb_get_able = new Mywpdb_Get_Table();
$table_column_names = $mywpdb_get_able->table_column_names(mywpdb_s_GET('table_name'));
$table_column_values = $mywpdb_get_able->table_column_values();
$max = $mywpdb_get_able->table_column_values_max();

?>

<h1><?php mywpdb_breadcrumb() ?></h1>
<table class="mywpdbTable">
	<tr class="mywpdbTable__tr">
		<th class="mywpdbTable__head">action</th>

		<?php foreach ($table_column_names as $table_column_name) { ?>
			<th class="mywpdbTable__head">
				<?php echo esc_html($table_column_name) ?>
			</th>
		<?php } ?>
	</tr>

	<?php
	foreach ($table_column_values as $table_column_value) {
		$first_key = array_key_first($table_column_value);
		$first_value = $table_column_value[$first_key];
	?>
		<tr class="mywpdbTable__tr">
			<td class="mywpdbTable__desc">
				<div class="mywpdbTable__flex">

					<form action="<?php echo esc_attr(mywpdb_get_current_link()) ?>" method="POST" id="tableRowDelete">
						<?php wp_nonce_field('mywpdb_delete_row', 'mywpdb_nonce_field'); ?>
						<input type="hidden" name="table_key" value="<?php echo esc_attr($first_key) ?>">
						<input type="hidden" name="table_name" value="<?php echo esc_attr(mywpdb_s_GET('table_name')) ?>">
						<input type="hidden" name="table_value" value="<?php echo esc_attr($first_value) ?>">

						<button type="button" class="-error" form="tableRowDelete" onclick="mywpdb_confirm_to_submit(event)">削除</button>
					</form>

					<form action="<?php echo esc_url(get_admin_url()) ?>" method="GET">
						<?php mywpdb_const_input() ?>

						<input type="hidden" name="table_name" value="<?php echo esc_attr(mywpdb_s_GET('table_name')) ?>">
						<input type="hidden" name="view" value="table_row">

						<button type="submit" name="where[<?php echo esc_attr($first_key) ?>]" value="<?php echo esc_attr($first_value) ?>">編集</button>
					</form>
				</div>
			</td>

			<?php foreach ($table_column_value as $table_value) {
				$table_value = strip_tags($table_value);
				$table_value = mb_substr($table_value, 0, 100);
			?>
				<td class="mywpdbTable__desc"><?php echo esc_html($table_value) ?></td>
			<?php } ?>
		</tr>
	<?php } ?>
</table>

<?php mywpdb_pagination($max) ?>


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
</script>
