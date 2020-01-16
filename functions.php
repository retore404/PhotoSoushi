<?php
// アイキャッチ画像を有効にする
add_theme_support('post-thumbnails');

//アイキャッチ画像の定義
add_action( 'after_setup_theme', 'baw_theme_setup' );
function baw_theme_setup() {
 add_image_size('page_eyecatch-image', 640, 360, true );
}

// サムネイル画像のimgタグからwidthとheightの指定を削除
add_filter( 'post_thumbnail_html', 'custom_attribute' );
function custom_attribute( $html ){
    // width height を削除する
    $html = preg_replace('/(width|height)="\d*"\s/', '', $html);
    return $html;
}

// ウィジェット
register_sidebar( array(
    'name' => __( 'MainWidget1' ),
    'id' => 'main_widget1',
    'before_widget' => '<div><h3>Features.</h3>',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
) );

register_sidebar( array(
    'name' => __( 'Footer Widget1' ),
    'id' => 'footer_widget1',
    'before_widget' => '<div>',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
) );

register_sidebar( array(
    'name' => __( 'Footer Widget2' ),
    'id' => 'footer_widget2',
    'before_widget' => '<div>',
    'after_widget' => '</div>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
) );

// ページネーション
function the_pagination() {
    global $wp_query;
    $bignum = 999999999;
    if ( $wp_query->max_num_pages <= 1 )
      return;
    echo '<nav class="pagination">';
    echo paginate_links( array(
      'base'         => str_replace( $bignum, '%#%', esc_url( get_pagenum_link($bignum) ) ),
      'format'       => '',
      'current'      => max( 1, get_query_var('paged') ),
      'total'        => $wp_query->max_num_pages,
      'prev_text'    => '<<',
      'next_text'    => '>>',
      'type'         => 'list',
      'end_size'     => 3,
      'mid_size'     => 3
    ) );
    echo '</nav>';
  }