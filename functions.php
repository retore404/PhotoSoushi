<?php

// 記事中1枚目の画像をアイキャッチ化する
function catch_first_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches [1] [0];

  if(empty($first_img)){ //Defines a default image
      $dir = get_template_directory_uri();
      $first_img = "$dir/images/thumbnail.png";
  }
return $first_img;
}

// リサイズ画像の自動生成を停止する
function disable_image_sizes( $new_sizes ) {
	unset($new_sizes['thumbnail']);
	unset($new_sizes['medium']);
	unset($new_sizes['large']);
	unset($new_sizes['medium_large']);
	unset($new_sizes['1536x1536']);
	unset($new_sizes['2048x2048']);
	return $new_sizes;
}
add_filter('intermediate_image_sizes_advanced', 'disable_image_sizes');
add_filter('big_image_size_threshold', '__return_false');

// 画像のwidth/height自動指定を除去
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
 
function remove_width_attribute( $html ) {
$html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
return $html;
}

// タイトルタグを自動生成
add_theme_support( 'title-tag' );


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