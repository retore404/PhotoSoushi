<?php
/**
 * PhotoSoushi WordPress Theme
 *
 * @package WordPress
 * @subpackage PhotoSoushi
 * @author retore
 * @link https://github.com/retore404/PhotoSoushi
 * @license http://www.gnu.org/licenses/gpl-2.0.html GPL v2 or later
 */

/**
 * 記事中1枚目の画像をアイキャッチ化する.
 */
function catch_first_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();
	$output    = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
	$first_img = $matches [1] [0];
	if ( empty( $first_img ) ) { // Defines a default image.
		$dir       = get_template_directory_uri();
		$first_img = "$dir/images/thumbnail.svg";
	}
	return $first_img;
}

/**
 * リサイズ画像の自動生成を停止する.
 *
 * @param array $new_sizes 生成される画像サイズを定義する配列.
 * @return array $new_sizes 生成される画像サイズを定義する配列.
 */
function disable_image_sizes( $new_sizes ) {
	unset( $new_sizes['thumbnail'] );
	unset( $new_sizes['medium'] );
	unset( $new_sizes['large'] );
	unset( $new_sizes['medium_large'] );
	unset( $new_sizes['1536x1536'] );
	unset( $new_sizes['2048x2048'] );
	return $new_sizes;
}
add_filter( 'intermediate_image_sizes_advanced', 'disable_image_sizes' );
add_filter( 'big_image_size_threshold', '__return_false' );


/**
 * タイトルタグを自動生成(All in One SEO Pack無効時).
 *
 * @param array $title タイトルタグの内容配列.
 * @return array $title タイトルタグの内容配列（カスタマイズ）.
 */
function custom_title_text( $title ) {
	// ページネーションまたはアーカイブページのとき，タイトルにページ番号と全ページ数を含める.
	if ( is_paged() || is_archive() ) {
		global $wp_query;
		$current_page = get_query_var( 'paged' );
		if ( 0 === $current_page ) {
			$current_page = ++$current_page;
		}
		$max_pages      = $wp_query->max_num_pages;
		$title['title'] = $title['title'] . '(' . $current_page . '/' . $max_pages . ')';
	}
	// タグラインとページ番号は表示しない（ページ番号はタイトル文字列に挿入し，個別の表記は停止）.
	$title['tagline'] = '';
	$title['page']    = '';
	return $title;
}
add_theme_support( 'title-tag' );
add_filter( 'document_title_parts', 'custom_title_text', 11 );

/**
 * タイトルタグを自動生成(All in One SEO Pack有効時).
 *
 * @param array $title タイトルタグの内容文字列（デフォルト）.
 * @return array $title タイトルタグの内容文字列（カスタマイズ）.
 */
function custom_title_text_for_aioseo( $title ) {
	// ページネーションまたはアーカイブページのとき，タイトルにページ番号と全ページ数を含める.
	if ( is_paged() || is_archive() ) {
		global $wp_query;
		$current_page = get_query_var( 'paged' );
		if ( 0 === $current_page ) {
			$current_page = ++$current_page;
		}
		$max_pages = $wp_query->max_num_pages;
		$title     = $title . '(' . $current_page . '/' . $max_pages . ')';
	}
	return $title;
}
add_filter( 'aioseo_title', 'custom_title_text_for_aioseo' );

// ウィジェット.
register_sidebar(
	array(
		'name'          => __( 'MainWidget1' ),
		'id'            => 'main_widget1',
		'before_widget' => '<div class="widget-wrapper">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	)
);

register_sidebar(
	array(
		'name'          => __( 'Footer Widget1' ),
		'id'            => 'footer_widget1',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	)
);

register_sidebar(
	array(
		'name'          => __( 'Footer Widget2' ),
		'id'            => 'footer_widget2',
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	)
);

/** ページネーション. */
function the_pagination() {
	global $wp_query;
	$bignum = 999999999;
	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}
	echo '<nav class="pagination">';
	echo wp_kses_post(
		paginate_links(
			array(
				'base'      => str_replace( $bignum, '%#%', esc_url( get_pagenum_link( $bignum ) ) ),
				'format'    => '',
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $wp_query->max_num_pages,
				'prev_text' => '«',
				'next_text' => '»',
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			)
		)
	);
	echo '</nav>';
}

/** コメントフォームの順序変更.
 *
 * @param array $fields コメントフィールド.
 * @return array $fields コメントフィールド（コメント部の順序逆転）.
 */
function move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'move_comment_field_to_bottom' );

// pタグの自動挿入を停止.
add_action(
	'init',
	function() {
		remove_filter( 'the_excerpt', 'wpautop' );
		remove_filter( 'the_content', 'wpautop' );
	}
);

add_filter(
	'tiny_mce_before_init',
	function( $init ) {
		$init['wpautop']                 = false;
		$init['apply_source_formatting'] = true;
		return $init;
	}
);


/** タグ名の置き換え（アイコン化）.
 *
 * @param string $tag_name タグ名（アイコン置き換え前）.
 * @return string $tag_name タグ名（アイコン置き換え後）.
 */
function replace_tag_name( $tag_name ) {
	// 設定値の読み込み（タグ置き換え設定）.
	$options = get_option( 'photo_soushi_theme_options' );

	// テーマ設定において，タグ置き換え（カメラ）が"ON"である場合，タグの置換を実施する.
	// 設定値は"ON"/"OFF"/undefined(初回設定前)が存在する. undefinedの場合，"ON"とみなす.
	$option_camera_icon_replace = isset( $options['setting_tag_replace_camera'] ) ? $options['setting_tag_replace_camera'] : 'ON';
	if ( 'ON' === $option_camera_icon_replace ) {
		// タグ名の"Camera:"をアイコンに置き換える.
		$tag_name = str_replace( 'Camera:', '<span class="ps-icon ps-icon-camera"></span> ', $tag_name );
	}

	// テーマ設定において，タグ置き換え（レンズ）が"ON"である場合，タグの置換を実施する.
	// 設定値は"ON"/"OFF"/undefined(初回設定前)が存在する. undefinedの場合，"ON"とみなす.
	$option_lens_icon_replace = isset( $options['setting_tag_replace_lens'] ) ? $options['setting_tag_replace_lens'] : 'ON';
	if ( 'ON' === $option_lens_icon_replace ) {
		// タグ名の"Lens:"をアイコンに置き換える.
		$tag_name = str_replace( 'Lens:', '<span class="ps-icon ps-icon-lens"></span> ', $tag_name );
	}

	// テーマ設定において，タグ置き換え（T*）が"ON"である場合，タグの置換を実施する.
	// 設定値は"ON"/"OFF"/undefined(初回設定前)が存在する. undefinedの場合，"ON"とみなす.
	$option_tstar_replace = isset( $options['setting_tag_replace_tstar'] ) ? $options['setting_tag_replace_tstar'] : 'ON';
	if ( 'ON' === $option_tstar_replace ) {
		// タグ名の"T*"を赤字にする.
		$tag_name = str_replace( 'T*', '<span class="t-star">T*</span>', $tag_name );
	}

	// テーマ設定において，タグ置き換え（Location）が"ON"である場合，タグの置換を実施する.
	// 設定値は"ON"/"OFF"/undefined(初回設定前)が存在する. undefinedの場合，"ON"とみなす.
	$option_location_icon_replace = isset( $options['setting_tag_replace_location'] ) ? $options['setting_tag_replace_location'] : 'ON';
	if ( 'ON' === $option_location_icon_replace ) {
		// タグ名の"Location:"をアイコンに置き換える.
		$tag_name = str_replace( 'Location:', '<span class="ps-icon ps-icon-pin"></span> ', $tag_name );
	}

	return $tag_name;
}



/**
 * 月別アーカイブページヘッダ部の年・月表示フォーマットオプションの取得関数.
 *
 * @return string $ym_format 年・月表示フォーマット
 */
function get_photo_soushi_ym_format() {
	// テーマ設定の読み込み.
	$options = get_option( 'photo_soushi_theme_options' );

	// テーマ設定における年・月表示フォーマットを取得.
	// 設定値がundefined(初回設定前)の場合，"M. Y"とみなす.
	$ym_format = isset( $options['setting_ym_format'] ) ? $options['setting_ym_format'] : 'M. Y';

	return $ym_format;
}

/**
 * CSSの読み込み.
 */
function photo_soushi_enque_styles() {
	// PhotoSoushi style.cssの読み込み.
	wp_enqueue_style(
		'photo-soushi-css',
		get_stylesheet_uri(),
		array(),
		'1.0.0',
		'all'
	);

	// アイコン(ps-icons)の読み込み.
	wp_enqueue_style(
		'photo-soushi-icons',
		get_stylesheet_directory_uri() . '/webfont/ps-icons/style.css',
		array(),
		'1.0.0',
		'all'
	);

	// アイコン(ps-sns-icons)の読み込み.
	wp_enqueue_style(
		'photo-soushi-sns-icons',
		get_stylesheet_directory_uri() . '/webfont/ps-sns-icons/style.css',
		array(),
		'1.0.0',
		'all'
	);

	// 設定画面におけるダークモード設定の読み込み.
	// テーマ設定の読み込み.
	$options = get_option( 'photo_soushi_theme_options' );
	// 初回設定前は'Light'（デフォルト）とみなす.
	$theme_color_option = isset( $options['setting_dark_theme'] ) ? $options['setting_dark_theme'] : 'Light';

	// テーマ設定においてダークモードを指定しているとき，PhotoSoushi style-dark-theme.cssを読み込む.
	if ( 'Dark' === $theme_color_option ) {
		wp_enqueue_style(
			'photo-soushi-dark-theme-css',
			get_stylesheet_directory_uri() . '/style-dark-theme.css',
			array(),
			'1.0.0',
			'all'
		);
	}

	// テーマ設定においてクライアント設定依存を指定しているとき，PhotoSoushi style-dark-theme-prefers.cssを読み込む.
	if ( 'Prefers' === $theme_color_option ) {
		wp_enqueue_style(
			'photo-soushi-dark-theme-css',
			get_stylesheet_directory_uri() . '/style-dark-theme-prefers.css',
			array(),
			'1.0.0',
			'all'
		);
	}
}
add_action( 'wp_enqueue_scripts', 'photo_soushi_enque_styles' );

/**
 * WebPファイルの許可
 *
 * @param array $mimes 許可するmimesの配列.
 * @return array $mimes 許可するmimesの配列(カスタムで許可するmimes追加済).
 */
function permit_mime_types( $mimes ) {
	$mimes['webp'] = 'image/webp';
	return $mimes;
}
add_filter( 'upload_mimes', 'permit_mime_types' );

// テーマオプションを読み込み.
require_once get_stylesheet_directory() . '/theme-options.php';
