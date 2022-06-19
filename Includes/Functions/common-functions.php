<?php
/*--------------------------------------------------
/* 関数
/*------------------------------------------------*/

// /**
//  * 配列のエスケープ
//  *
//  * @param $array 配列
//  */
// function mywpdb_escape_array($array)
// {
//   $rtn_array = [];
//   if (!empty($array)) {
//     foreach ($array as $key => $value) {
//       $rtn_array[$key] = esc_attr($value);
//     }
//   }
//   return $rtn_array;
// }

/**
 * 配列のサニタイズ
 *
 * @param $array 配列
 */
function mywpdb_sanitize_array($array) {
	$rtn_array = [];
	if (!empty($array)) {
		foreach ($array as $key => $value) {
			if (!is_array($value)) {
				$value = trim($value);
				$value = stripslashes($value);
				$value = htmlspecialchars($value, ENT_QUOTES);
				$value = htmlentities($value);
				$value = sanitize_text_field($value);
				$rtn_array[$key] = $value;
			}
		}
	}
	return $rtn_array;
}

/**
 * ＄＿POSTの中身をサニタイズ
 *
 * @param $
 */
function mywpdb_s_POST($key) {
	$s_POST = mywpdb_sanitize_array($_POST);
	if (isset($s_POST[$key]) || array_key_exists($key, $s_POST)) {
		return $s_POST[$key];
	} else {
		return false;
	}
}

/**
 * ＄＿GETの中身をサニタイズ
 *
 * @param $
 */
function mywpdb_s_GET($key) {
	$s_GET = mywpdb_sanitize_array($_GET);
	if (isset($_GET[$key])) {
		if (is_array($_GET[$key])) {
			return mywpdb_sanitize_array($_GET[$key]);
		} else {
			return $s_GET[$key];
		}
	} else {
		return false;
	}
}

/**
 * 現在のページのリンクをパラメータ付きで取得
 */
function mywpdb_url() {
	return admin_url() . 'admin.php?page=mywpdb_page';
}

/**
 * 現在のページのリンクをパラメータ付きで取得
 */
function mywpdb_get_current_link() {
	// $link = is_ssl() ? 'https' . '://' . esc_url_raw($_SERVER['HTTP_HOST']) .esc_url_raw($_SERVER['REQUEST_URI']) : 'http' . '://' . esc_url_raw($_SERVER['HTTP_HOST']) . esc_url_raw($_SERVER['REQUEST_URI']);
	$ssl = is_ssl() ? 'https' . '://' :  'http' . '://';
	$http_host = sanitize_text_field($_SERVER['HTTP_HOST']);
	$request_uri = sanitize_url($_SERVER['REQUEST_URI']);
	$link = $ssl . $http_host . $request_uri;

	return $link;
}


/**
 * 現在の$sanitized_GETを全て取得しinput[type="hidden"]に変換
 *
 * @param $exclude 除外するアイテムのキー
 */
function mywpdb_GETS($exclude = null) {
	$sanitized_GET = mywpdb_sanitize_array($_GET);
	foreach ($sanitized_GET as $key => $value) {
		if ($key == $exclude) {
			continue;
		}
?>
<input type="hidden"
			 name="<?php echo esc_attr($key) ?>"
			 value="<?php echo esc_attr($value) ?>">
<?php  }
}


/**
 * パンクズりすと
 *
 * @param $
 */
function mywpdb_breadcrumb() {
	$sanitized_GET = mywpdb_sanitize_array($_GET);
	$sanitized_where_GET = (isset($_GET['where'])) ? mywpdb_sanitize_array($_GET['where']) : '';
	?>
<div class="mywpdb_breadcrumb">
	<a href="<?php echo esc_url(admin_url() . "?page=mywpdb_page") ?>">テーブル一覧</a>

	<?php if (mywpdb_s_GET('table_name')) { ?>
	>
	<a href="<?php echo esc_url(admin_url() . "?page=mywpdb_page&view=table&offset=0&table_name=" . mywpdb_s_GET('table_name')) ?>">
		<?php echo esc_html(mywpdb_s_GET('table_name')) ?>
	</a>
	<?php } ?>

	<?php if (!empty($sanitized_where_GET)) {
			$first_key = array_key_first($sanitized_where_GET);
			$first_value = $sanitized_where_GET[$first_key];
		?>
	>
	<a href="<?php echo esc_url(admin_url() . "?page=mywpdb_page&table_name=" . mywpdb_s_GET('table_name')) ?>">
		<?php
				$output = "where '";
				$output .= esc_html($first_key);
				$output .= "' = '";
				$output .= esc_html($first_value);
				$output .= "'";
				echo esc_html($output);
				?>
	</a>

	<?php } ?>
</div>

<?php
}




// function mywpdb_validation($data)
// {
//   $data = trim($data);
//   $data = stripslashes($data);
//   $data = htmlspecialchars($data);
//   return $data;
// }


/**
 * ページネーション
 *
 * @param $page_count ページの数
 */
function mywpdb_pagination($max) {
	$paged = ceil($max / 25);
	$offset = (int) mywpdb_s_GET('offset');
	$offset_prev = ($offset === 0) ? 0 : $offset - 1;
	$offset_next = ($offset === $paged) ? $offset + 1 : $paged;

	if ($paged == 0) {
		return false;
	}

?>
<form class="mywpdbPagination"
			mehtod="GET"
			action="<?php echo esc_url(mywpdb_get_current_link()) ?>">
	<?php mywpdb_GETS() ?>

	<button class="mywpdbPagination__firstButton"
					name="offset"
					value="0">
		<?php echo esc_html('<<') ?>
	</button>

	<button class="mywpdbPagination__prevButton"
					name="offset"
					value="<?php echo esc_attr($offset_prev) ?>">
		<?php echo esc_html('<') ?>
	</button>

	<ul class="mywpdbPagination__list">

		<?php
			$b = 0;
			for ($i = 1; $i <= $paged; $i++) {
				$current = ($offset == $i) ? '-current' : '';
			?>
		<li class="mywpdbPagination__item <?php echo esc_attr($current) ?>">
			<button class="mywpdbPagination__itemButton"
							name="offset"
							value="<?php echo esc_attr($i) ?>">
				<?php echo esc_html($i) ?>
			</button>
		</li>
		<?php } ?>

	</ul>

	<button class="mywpdbPagination__nextButton"
					name="offset"
					value="<?php echo esc_attr($offset_next) ?>">
		<?php echo esc_html('>') ?>
	</button>

	<button class="mywpdbPagination__lastButton"
					name="offset"
					value="<?php echo esc_attr($paged) ?>">
		<?php echo esc_html('>>') ?>
	</button>
</form>



<script>
(function($) {

	let $offset = <?php echo esc_html($offset) ?>

	let target = $('.mywpdbPagination__itemButton[value="' + $offset + '"]')
	let targetWidth = target.width()
	let targetPosition = target.position()
	let targetParent = target.parents('.mywpdbPagination__list')
	let targetParentWidth = targetParent.width()
	let targetParentScrolleLeft = targetPosition.left - (targetParentWidth / 2 + targetWidth)

	targetParent.scrollLeft(targetParentScrolleLeft)


})(jQuery);
</script>
<?php

}

/**
 * 固定のhidden input
 */
function mywpdb_const_input() {
?>
<input type="hidden"
			 name="page"
			 value="mywpdb_page">
<?php
}
