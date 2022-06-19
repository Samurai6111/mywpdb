<?php
$Mywpdb_Get_Table = new Mywpdb_Get_Table();
?>
<h1>テーブル一覧</h1>

<form class="mywpdb__form"
			method="GET">
			<?php mywpdb_const_input() ?>
			<input type="hidden" name="view" value="table">
			<input type="hidden" name="offset" value="0">

	<table class="mywpdbTable">
		<?php
		foreach ($Mywpdb_Get_Table->tables() as $table_name) { ?>
		<tr class="mywpdbTable__tr">
			<td class="mywpdbTable__head">
				<button class="mywpdb__formButton"
								type="submit"
								name="table_name"
								value="<?php echo esc_attr($table_name) ?>">
								<?php echo esc_html($table_name) ?>
							</button>
			</td>
		</tr>
		<?php } ?>
	</table>
</form>
