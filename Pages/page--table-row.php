<?php
$Mywpdb_Get_Table = new Mywpdb_Get_Table();
$table_row_values = $Mywpdb_Get_Table->table_row_values();

$Mywpdb_Update = new Mywpdb_Update();
?>

<h1><?php mywpdb_breadcrumb() ?></h1>
<br>

<form method="POST">
	<?php wp_nonce_field('mywpdb_update_row', 'mywpdb_nonce_field'); ?>

	<input type="hidden"
				 name="table_name"
				 value="<?php echo esc_attr(mywpdb_s_GET('table_name')) ?>">

	<table class="mywpdbTable -w100">
		<?php
		foreach ($table_row_values as $table_key => $table_value) {
			$letter_count = mb_strlen($table_value);
		?>
		<tr class="mywpdbTable__tr">
			<th class="mywpdbTable__head -tal">
				<?php echo esc_html($table_key) ?>
			</th>

			<td class="mywpdbTable__desc -w100">
				<?php if ($letter_count > 200) { ?>
				<textarea name="<?php echo esc_attr($table_key) ?>"
									id=""
									cols="30"
									rows="10"><?php echo esc_html($table_value) ?></textarea>
				<?php } else { ?>
				<input type="text"
							 name="<?php echo esc_attr($table_key) ?>"
							 value="<?php echo esc_attr($table_value) ?>">
				<?php } ?>
			</td>
		</tr>
		<?php } ?>
	</table>

	<br>
	<button class="-btn"
					name="mywpdbUpdateTrigger">変更する</button>
</form>
