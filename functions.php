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
 * 記事中1枚目の画像URLを返す.
 *
 * @param string $type 1枚目の画像がヒットしない場合に返すデフォルトアイキャッチ画像の形式("svg"もしくは"png"を指定. 指定がない場合，svg).
 * @return string $first_img 表示中ページの1枚目画像URL(画像がない場合，デフォルトアイキャッチ画像URL).
 */
function catch_first_image( $type = 'svg' ) {
	global $post;
	$first_img = '';
	$extension = '.' . $type;
	ob_start();
	ob_end_clean();
	$output = preg_match_all( '/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches );
	if ( empty( $matches [1] [0] ) ) { // 記事中のimgタグの正規表現合致がない場合.
		$dir       = get_template_directory_uri();
		$first_img = "$dir/images/thumbnail" . $extension;
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
 * タイトルタグを自動生成.
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

/************** メタデータ定義 **************/
/**
 * メタデータ用共通関数(description)
 *
 * @return string $description 固定ページもしくは個別記事ページのとき，その抜粋/それ以外の場合，サイトのキャッチフレーズを返す変数.
 */
function get_ps_description() {
	// description格納用変数を定義.
	$description = null;
	if ( is_page() || is_single() ) { // ページもしくは個別記事の場合，そのページの投稿概要を設定.
		$description = get_the_excerpt();
		// 例外処理：投稿抜粋が空のとき，サイトのキャッチフレーズに置き換える.
		$description = '' === $description ? get_bloginfo( 'description' ) : $description;
	} else { // 上記のどれにも該当しないとき，サイトのキャッチフレーズを設定.
		$description = get_bloginfo( 'description' );
	}
	return $description;
}

/**
 * メタデータ用共通関数(title)
 *
 * @return string $title HomeページもしくはFrontページの場合は，サイトタイトル. それ以外の場合，表示中ページのtitle-tag.
 */
function get_ps_title() {
	// title格納用変数を定義.
	$title = null;
	if ( is_home() || is_front_page() ) { // HomeページもしくはFrontページの場合は，サイトタイトルを設定.
		$title = get_bloginfo( 'name' );
	} else { // それ以外のときページタイトル.
		$title = wp_get_document_title();
	}
	return $title;
}

/**
 * 不要metadataの削除
 */
remove_action( 'wp_head', 'wp_generator' ); // generatorを削除.
remove_action( 'wp_head', 'wp_shortlink_wp_head' ); // 短縮URLを削除.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); // 絵文字対応削除.
remove_action( 'wp_print_styles', 'print_emoji_styles' ); // 絵文字対応削除.
remove_action( 'wp_head', 'rsd_link' ); // 外部投稿用URL削除.
remove_action( 'wp_head', 'wlwmanifest_link' ); // 外部投稿用URL削除.

/**
 * Mediaelement系CSS/JSの削除.
 */
function custom_deregister_mediaemlements() {
	wp_deregister_style( 'wp-mediaelement' );
	wp_deregister_script( 'mediaelement' );
}
add_action( 'wp_enqueue_scripts', 'custom_deregister_mediaemlements' );

/**
 * Descriptionの指定.
 */
function add_description_metadata() {
	$description = get_ps_description(); // メタデータ用共通関数(description)を呼び出し.
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
	} elseif ( is_date() ) { // 月別アーカイブの場合は，月別アーカイブページ1ページ目を設定.
		$canonical = get_month_link( get_the_time( 'Y' ), get_the_time( 'M' ) );
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
	$title = get_ps_title();
	echo '<meta property="og:title" content="' . esc_html( $title ) . '">' . "\n";
}
add_action( 'wp_head', 'add_ogp_title' );

/**
 * OGPの設定(og:description)
 */
function add_ogp_description() {
	$description = get_ps_description(); // メタデータ用共通関数(description)を呼び出し.
	echo '<meta property="og:description" content="' . esc_html( $description ) . '">' . "\n";
}
add_action( 'wp_head', 'add_ogp_description' );

/**
 * OGPの設定(og:url)
 */
function add_ogp_url() {
	$url = null; // ページのURLを格納する変数.
	if ( is_home() || is_archive() || is_search() ) {
		$url = get_pagenum_link( get_query_var( 'paged' ) ); // 一覧系ページの場合.
	} else {
		$url = get_pagenum_link( get_query_var( 'page' ) ); // それ以外の場合.
	}
	echo '<meta property="og:url" content="' . esc_url( $url ) . '">' . "\n";
}
add_action( 'wp_head', 'add_ogp_url' );

/**
 * OGPの設定(og:image)
 */
function add_ogp_image() {
	// URLの設定.
	$url = null;
	// 表示中ページから導出できる投稿をループして，urlがnullである場合に画像URLをurlにセットする.
	// $urlには1記事目の最初の画像，1記事目で画像がヒットしない場合はデフォルトサムネイル(png)がセットされる.
	if ( have_posts() ) {
		while ( have_posts() ) :
			the_post();
			if ( is_null( $url ) ) {
				$url = catch_first_image( 'png' ); // 画像のURLを格納.
			}
		endwhile;
	}
	echo '<meta property="og:image" content="' . esc_url( $url ) . '">' . "\n";
	if ( substr( $url, 0, 5 ) === 'https' ) { // 取得した画像のURLがhttpsから始まるとき，secure_urlとしても指定.
		echo '<meta property="og:image:secure_url" content="' . esc_url( $url ) . '">' . "\n";
	}

	// width/heightの設定.
	$attachment_image_src = wp_get_attachment_image_src( attachment_url_to_postid( $url ), 'full' ); // og:imageのURLに紐づく添付画像ファイル情報を取得.
	// URLに紐づく添付画像ファイル情報がない場合は，デフォルトアイキャッチ画像を使用していると判断するため，デフォルト値としてアイキャッチ画像サイズを設定.
	$width  = 1200; // デフォルトアイキャッチpng画像の幅.
	$height = 800; // デフォルトアイキャッチpng画像の高さ.
	if ( $attachment_image_src ) { // URLに紐づく添付画像ファイル情報がない場合，falseが返ってきている．情報を取得できた場合のみ，ifブロック内の処理を実施.
		$width  = (int) $attachment_image_src[1]; // 添付画像の幅.
		$height = (int) $attachment_image_src[2]; // 添付画像の高さ.
	}
	// WebP画像が取得されているとき，width/heightが0になっている.
	// そのため，widthまたはheightが0のとき，og:image:width/og:image:heightは出力しない.
	if ( $width > 0 && $height > 0 ) {
		echo '<meta property="og:image:width" content="' . esc_html( $width ) . '">' . "\n";
		echo '<meta property="og:image:height" content="' . esc_html( $height ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'add_ogp_image' );

/**
 * メタデータの設定(article)
 */
function add_article_metadata() {
	if ( is_page() || is_single() ) { // 固定ページもしくは個別記事ページでのみ設定.
		$published_time = get_the_time( 'c' );
		$modified_time  = get_the_modified_date( 'c' );
		echo '<meta property="article:published_time" content="' . esc_html( $published_time ) . '">' . "\n";
		echo '<meta property="article:modified_time" content="' . esc_html( $modified_time ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'add_article_metadata' );

/**
 * メタデータの設定(twitter)
 */
function add_twitter_common_metadata() {
	// twitter:card設定.
	echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	// twitter:domain設定.
	$domain = substr( get_home_url( null, '', 'https' ), 8 ); // home_urlをhttps指定した上で取得して「https://」より後をドメインとして抜粋.
	echo '<meta name="twitter:domain" content="' . esc_html( $domain ) . '">' . "\n";
	// twitter:title設定.
	$title = get_ps_title(); // メタデータ用共通関数(title)を呼び出し.
	echo '<meta name="twitter:title" content="' . esc_html( $title ) . '">' . "\n";
	// twitter:description設定.
	$description = get_ps_description(); // メタデータ用共通関数(description)を呼び出し.
	echo '<meta name="twitter:description" content="' . esc_html( $description ) . '">' . "\n";
}
add_action( 'wp_head', 'add_twitter_common_metadata' );


/******** ウィジェット関連カスタマイズ */
/**
 * ウィジェット表示領域定義.
 */
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

/**
 * タグクラウドリンクからaria-labelを除去し，特定文字列をアイコンに置き換える.
 *
 * @param string $return タグクラウド文字列.
 * @return string $return タグクラウド文字列(aria-label除去・特定文字列のアイコン置き換え).
 */
function wp_tag_name_replace( $return ) {
	$return = preg_replace( '/aria-label=".*"/', '', $return ); // 置き換えの邪魔になるaria-labelを削除.
	$return = preg_replace( '/ style="font-size: .*pt;/', '', $return ); // font-sizeのスタイル指定を削除.
	$return = replace_tag_str( $return ); // タグ名の一部をアイコン置き換え.
	$return = preg_replace( '/<a (.*?)>/', '<a $1><span class="ps-icon ps-icon-tag"></span>', $return );
	return $return;
}
add_filter( 'wp_tag_cloud', 'wp_tag_name_replace' );

/**
 * カテゴリウィジェットカスタマイズ(リンクテキストをspanタグ内に格納).
 *
 * @param string $output カテゴリウィジェット出力文字列.
 * @param array  $args カテゴリウィジェットカスタマイズ配列.
 * @return string $replaced_html カテゴリウィジェット出力文字列(カスタマイズ済).
 */
function ps_category_widget( $output, $args ) {
	// リンクテキストを置き換え.
	// $1：href="リンク先" 部分.
	// $2：リンクテキスト.
	// $3：（投稿数を表示オプションつきの場合）投稿数部分.
	if ( '0' === $args['show_count'] ) { // 投稿数表示オプションOFFのとき.
		$replaced_html = preg_replace( '/<a (.*)>(.*)<\/a>/', '<a $1><span class="widget_category_link_text ps-icon ps-icon-category"> $2</span></a>', $output );
	} else { // 投稿数表示オプションONのとき.
		$replaced_html = preg_replace( '/<a (.*)>(.*)<\/a> \(([0-9,]*)\)/', '<a $1><span class="widget_category_link_text ps-icon ps-icon-category"> $2 ($3)</span></a>', $output );
	}
	return $replaced_html;
}
add_filter( 'wp_list_categories', 'ps_category_widget', 10, 2 );

/**
 * 年・月別アーカイブカスタムウィジェット
 */
class PhotoSoushi_Monthly_Archives extends WP_Widget {
	/**
	 * Widgetの登録
	 */
	function __construct() {
		parent::__construct(
			'photosoushi_monthly_archives',
			'PhotoSoushi 年・月別アーカイブ',
			array( 'description' => '年・月別アーカイブウィジェット.' )
		);
	}

	/**
	 * ウィジェット出力
	 */
	public function widget( $args, $instance ) {
		echo '<h2>Archives.</h2>';

		global $wpdb;
		// 最古の記事を取得.
		$oldest_post      = $wpdb->get_results(
			"
			SELECT *
			FROM $wpdb->posts
			WHERE post_status = 'publish'
			AND post_type = 'post'
			ORDER BY post_date ASC LIMIT 1
		"
		);
		$oldest_post_year = intval( substr( $oldest_post[0]->post_date, 0, 4 ) ); // 最古の記事の公開日の先頭4文字から年を抜粋.

		// 最新の記事を取得
		$newest_post      = $wpdb->get_results(
			"
			SELECT *
			FROM $wpdb->posts
			WHERE post_status = 'publish'
			AND post_type = 'post'
			ORDER BY post_date DESC LIMIT 1
		"
		);
		$newest_post_year = intval( substr( $newest_post[0]->post_date, 0, 4 ) ); // 最古の記事の公開日の先頭4文字から年を抜粋.

		// 後続のループ及び表示用の月・月表示名配列定義.
		$month_array = array(
			12 => 'Dec.',
			11 => 'Nov.',
			10 => 'Oct.',
			9  => 'Sep.',
			8  => 'Aug.',
			7  => 'Jul.',
			6  => 'Jun.',
			5  => 'May.',
			4  => 'Apr.',
			3  => 'Mar.',
			2  => 'Feb.',
			1  => 'Jan.',
		);

		// 最新年～最古年のループ処理.
		$process_year = $newest_post_year; // ループ処理で処理する年の設定.初期値として最新年を設定する.
		while ( $process_year >= $oldest_post_year ) {
			// 処理年の投稿件数をカウントし，有件の場合のみ処理中の年のアーカイブリンクを出力
			$yearly_post_list = get_posts(
				array(
					'post_per_page' => -1,
					'year'          => $process_year,
				)
			);

			if ( count( $yearly_post_list ) > 0 ) {
				// 年単位div開始タグと年別ヘッダの出力.
				echo '<div class="ps_archive_widget_year_wrapper">';
				echo '<span class="ps_archive_widget_year_header">' . $process_year . '</span>';

				// 全月を降順ループ処理.
				foreach ( $month_array as $month => $abb ) {
					// 処理中の月の投稿を取得.
					$monthly_post_list = get_posts(
						array(
							'post_per_page' => -1,
							'year'          => $process_year,
							'monthnum'      => $month,
						)
					);
					// 処理中の月の投稿件数が有件の場合，リンクを出力.
					if ( count( $monthly_post_list ) > 0 ) {
						echo '<a class="ps_archive_widget_month_link" href="' . esc_url( get_month_link( $process_year, $month ) ) . '"><span class="ps-icon ps-icon-calendar"></span>' . $abb . '</a>';
					} else { // 処理中の月の投稿がない場合，枠のみ出力.
						echo '<div class="ps_archive_widget_month_link"><span class="ps-icon ps-icon-calendar"></span>' . $abb . '</div>';
					}
				}
				// 年単位div終了タグの出力.
				echo '</div>';
			}
			// 処理対象の年をカウントダウン.
			$process_year = $process_year - 1;
		}
	}
}
register_widget( 'PhotoSoushi_Monthly_Archives' );


/******** ページネーションカスタマイズ ********/
function ps_pagination() {
	global $wp_query;
	$bignum = 999999999;
	// 1ページしかない一覧系ページの場合，ページネーションの出力は行わない.
	if ( $wp_query->max_num_pages <= 1 ) {
		return;
	}

	// ページネーションリンク構成用のベースURL文字列.
	$base_url = str_replace( $bignum, '%#%', esc_url( get_pagenum_link( $bignum ) ) );
	// 表示中の一覧系ページの1ページ目のリンク.
	// ページ数指定部を正規表現で除去.
	if ( is_category() || is_tag() || is_date() ) { // ホーム画面以外からのページネーションの場合.
		$first_page_url = preg_replace( '/\&(.*)=%#%/', '', esc_url( $base_url ) );
	} else {
		$first_page_url = preg_replace( '/\?(.*)=%#%/', '', esc_url( $base_url ) ); // ホーム画面からのページネーションの場合.
	}
	// 表示中の一覧系ページの前のページのリンク.
	if ( get_query_var( 'paged' ) === 2 ) { // 表示中のページが2ページ目の場合，前のページのURL=最初のページのURL.
		$prev_page_url = $first_page_url;
	} else { // 表示中のページが2ページ目以外の場合，現在のページ数-1ページ目のURLを取得.
		$prev_page_url = str_replace( '%#%', get_query_var( 'paged' ) - 1, esc_url( $base_url ) );
	}
	// 表示中の一覧系ページの次のページのリンク(1ページ目を表示中の場合，現在ページが0ページ目と判断されうるため補正).
	$next_page_url = str_replace( '%#%', max( 1, get_query_var( 'paged' ) ) + 1, esc_url( $base_url ) );
	// 表示中の一覧系ページの最後のページのリンク.
	$last_page_url = str_replace( '%#%', $wp_query->max_num_pages, esc_url( $base_url ) );

	// 1ページ目のリンク・前のページのリンク(表示中のページが1ページ目の場合は表示枠のみのdivを出力).
	if ( get_query_var( 'paged' ) >= 2 ) {
		echo '<a href=' . esc_url( $first_page_url ) . ' class="pagination_item">«</a>';
		echo '<a href=' . esc_url( $prev_page_url ) . ' class="pagination_item">‹</a>';
	} else {
		echo '<div class="pagination_item">«</div>';
		echo '<div class="pagination_item">‹</div>';
	}

	// 次のページ・最終ページのリンク(表示中のページが最終ページの場合は表示枠のみのdivを出力).
	if ( get_query_var( 'paged' ) < $wp_query->max_num_pages ) {
		echo '<a href=' . esc_url( $next_page_url ) . ' class="pagination_item">›</a>';
		echo '<a href=' . esc_url( $last_page_url ) . ' class="pagination_item">»</a>';
	} else {
		echo '<div class="pagination_item">›</div>';
		echo '<div class="pagination_item">»</div>';
	}
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
	$tag_str = preg_replace( '/Camera:(.*)/', '<span class="ps-icon ps-icon-camera"> $1</span> ', $tag_str );
	// "Lens:"のアイコン置き換え.
	$tag_str = preg_replace( '/Lens:(.*)/', '<span class="ps-icon ps-icon-lens"> $1</span> ', $tag_str );
	// "T*"の赤字化.
	$tag_str = str_replace( 'T*', '<span class="t-star">T*</span>', $tag_str );
	// "Location:"のアイコン置き換え.
	$tag_str = preg_replace( '/Location:(.*)/', '<span class="ps-icon ps-icon-pin"> $1</span> ', $tag_str );
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
