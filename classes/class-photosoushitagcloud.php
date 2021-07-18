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

/** カスタムウィジェット定義. */
class PhotoSoushiTagCloud extends WP_Widget {
	/**
	 * Widget設定.
	 */
	public function __construct() {
		parent::__construct(
			'photo_soushi_tag_cloud', // Base ID.
			'PhotoSoushiタグクラウド', // ウィジェット名.
			array( 'description' => 'タグ名に含まれる"Camera:", "Lens:", "Location:"を置き換えて出力するタグクラウド' )
		);
	}

	/**
	 * Widget内容の定義.
	 *
	 * @param array $args ウィジェットの引数.
	 * @param array $instance DB保存値.
	 */
	public function widget( $args, $instance ) {
		echo wp_kses_post( $args['before_widget'] ); // before_widgetの出力.
		echo wp_kses_post( $args['before_title'] ); // before_titleの出力.
		echo 'Tags'; // ウィジェットタイトル.
		echo wp_kses_post( $args['after_title'] ); // after_titleの出力.
		$tag_clouds = wp_tag_cloud(
			array(
				'echo' => false,
			)
		); // タグクラウドの出力文字列を変数に格納.
		$tag_clouds = replace_tag_name( $tag_clouds );
		echo wp_kses_post( $tag_clouds );
		echo wp_kses_post( $args['after_widget'] ); // after_widgetの出力.
	}
}
