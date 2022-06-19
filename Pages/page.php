<?php
//--------------------------------------------------
// テーブル
//--------------------------------------------------
$Mywpdb_Get_Table = new Mywpdb_Get_Table();

?>

<div class="mywpdb">
	<div class="inner">
		<?php
		require_once($mywpdb_path . '/Includes/Component/c--search-form.php');

		$Mywpdb_Page = new Mywpdb_Page();
		$Mywpdb_Page->view();
		?>
	</div>
</div>
