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
	$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
	if ( empty( $matches [1] [0] ) ) { // 記事中のimgタグの正規表現合致がない場合.
		$dir       = get_template_directory_uri();
		$first_img = "$dir/images/thumbnail.svg";
	} else { // 記事中のimgタグの正規表現合致がある場合.
		$first_img = $matches [1] [0];
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
 * @param string $title タイトルタグの内容文字列（デフォルト）.
 * @return string $title タイトルタグの内容文字列（カスタマイズ）.
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

/************** メタデータ定義 **************/
/**
 * Descriptionの指定.
 */
function add_description_metadata() {
	// description格納用変数を定義.
	$description = null;
	if ( is_page() || is_single() ) { // ページもしくは個別記事の場合，そのページの投稿概要を設定.
		$description = get_the_excerpt();
	} else { // 上記のどれにも該当しないとき，サイトのキャッチフレーズを設定.
		$description = get_bloginfo( 'description' );
	}
	echo '<meta name="description" content="' . esc_html( $description ) . '">' . "\n";
}
add_action( 'wp_head', 'add_description_metadata' );

/**
 * Canonicalの指定.
 */
function add_canonical_metadata() {
	// canonical格納用変数を定義.
	$canonical = null;
	if ( is_home() || is_front_page() ) { // HomeページもしくはFrontページの場合は，home_urlを設定.
		$canonical = home_url();
	} elseif ( is_category() ) { // カテゴリーアーカイブの場合は，カテゴリーアーカイブ1ページ目を設定.
		$canonical = get_category_link( get_query_var( 'cat' ) );
	} elseif ( is_tag() ) { // タグアーカイブの場合は，タグアーカイブ1ページ目を設定.
		$canonical = get_tag_link( get_queried_object()->term_id );
	} elseif ( is_search() ) {  // 検索結果一覧の場合，検索結果1ページ目を設定.
		$canonical = get_search_link();
	} elseif ( is_page() || is_single() ) { // ページもしくは個別記事の場合，そのページのパーマリンクを設定.
		$canonical = get_permalink();
	} else { // 上記のどれにも該当しないとき，home_urlを設定.
		$canonical = home_url();
	}
	echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";
}
remove_action( 'wp_head', 'rel_canonical' ); // 既存のcanonical定義を削除.
add_action( 'wp_head', 'add_canonical_metadata' );

/**
 * OGPの設定(og:site_name)
 */
function add_ogp_site_name() {
	// site_name格納用変数を定義.
	$site_name = get_bloginfo( 'name' );
	echo '<meta property="og:site_name" content="' . esc_html( $site_name ) . '">' . "\n";
}
add_action( 'wp_head', 'add_ogp_site_name' );

/**
 * OGPの設定(og:title)
 */
function add_ogp_title() {
	// title格納用変数を定義.
	$title = null;
	if ( is_home() || is_front_page() ) { // HomeページもしくはFrontページの場合は，サイトタイトルを設定.
		$title = get_bloginfo( 'name' );
	} else { // それ以外のときページタイトル.
		$title = wp_get_document_title();
	}
	echo '<meta property="og:title" content="' . esc_html( $title ) . '">' . "\n";
}
add_action( 'wp_head', 'add_ogp_title' );

/******** ウィジェット関連カスタマイズ ********/
/**
 * タグクラウドリンクからaria-labelを除去し，特定文字列をアイコンに置き換える.
 *
 * @param string $return タグクラウド文字列.
 * @return string $return タグクラウド文字列(aria-label除去・特定文字列のアイコン置き換え).
 */
function wp_tag_cloud_customize( $return ) {
	$return = preg_replace( '/aria-label=".*"/', '', $return ); // 置き換えの邪魔になるaria-labelを削除.
	$return = replace_tag_str( $return ); // タグ名の一部をアイコン置き換え.
	$return = str_replace( '<a', '<span class="tag-cloud-link-wrapper"><span class="ps-icon ps-icon-tag"></span><a', $return );
	$return = str_replace( '</a>', '</a></span>', $return );
	return $return;
}
add_filter( 'wp_tag_cloud', 'wp_tag_cloud_customize' );

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


/** タグ名を含む文字列の置き換え.
 *
 * @param string $tag_str タグ名置き換え前文字列.
 * @return string $tag_str タグ名置き換え後文字列.
 */
function replace_tag_str( $tag_str ) {
	// "Camera:"のアイコン置き換え.
	$tag_str = str_replace( 'Camera:', '<span class="ps-icon ps-icon-camera"></span> ', $tag_str );
	// "Lens:"のアイコン置き換え.
	$tag_str = str_replace( 'Lens:', '<span class="ps-icon ps-icon-lens"></span> ', $tag_str );
	// "T*"の赤字化.
	$tag_str = str_replace( 'T*', '<span class="t-star">T*</span>', $tag_str );
	// "Location:"のアイコン置き換え.
	$tag_str = str_replace( 'Location:', '<span class="ps-icon ps-icon-pin"></span> ', $tag_str );
	return $tag_str;
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
