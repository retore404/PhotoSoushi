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
 * 年・月別アーカイブカスタムウィジェット
 */
class PhotoSoushi_Monthly_Archives extends WP_Widget {
	/**
	 * Widgetの登録
	 */
	public function __construct() {
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
