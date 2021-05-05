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
 * テーマ設定をメニューに追加.
 */
function add_photo_soushi_theme_menu() {
	add_menu_page(
		'テーマ設定',
		'PhotoSoushiテーマ設定',
		'manage_options',
		'photo-soushi-theme-settings',
		'create_photo_soushi_theme_settings_page'
	);
}

/**
 * テーマ用の設定値を作成.
 */
function register_photo_soushi_theme_settings() {
	register_setting(
		'photo_soushi_theme_options_group',
		'photo_soushi_theme_options',
		'sanitize_photo_soushi_theme_options'
	);
}

if ( is_admin() ) {
	add_action( 'admin_menu', 'add_photo_soushi_theme_menu' );
	add_action( 'admin_init', 'register_photo_soushi_theme_settings' );
	add_action( 'admin_menu', 'photo_soushi_enque_styles' ); // functions.phpに定義するスタイル読み込みを管理ページにおいても適用.
}

/**
 * 設定値をサニタイズ.
 *
 * @param array $options PhotoSoushiテーマオプションの設定値を持つ配列.
 * @return array $options PhotoSoushiテーマオプションの設定値を持つ配列(サニタイズ済).
 */
function sanitize_photo_soushi_theme_options( $options ) {
	$new_options = array();

	// ダークテーマ設定のサニタイズ.
	if ( isset( $options['setting_dark_theme'] ) ) {
		$new_options['setting_dark_theme'] = sanitize_text_field( $options['setting_dark_theme'] );
	}

	// タグ置き換え設定の（レンズ）サニタイズ.
	if ( isset( $options['setting_tag_replace_lens'] ) ) {
		$new_options['setting_tag_replace_lens'] = sanitize_text_field( $options['setting_tag_replace_lens'] );
	}

	// タグ置き換え設定（T*）のサニタイズ.
	if ( isset( $options['setting_tag_replace_tstar'] ) ) {
		$new_options['setting_tag_replace_tstar'] = sanitize_text_field( $options['setting_tag_replace_tstar'] );
	}

	// タグ置き換え設定（Location）のサニタイズ.
	if ( isset( $options['setting_tag_replace_location'] ) ) {
		$new_options['setting_tag_replace_location'] = sanitize_text_field( $options['setting_tag_replace_location'] );
	}

	// 年・月表示フォーマット設定のサニタイズ.
	if ( isset( $options['setting_ym_format'] ) ) {
		$new_options['setting_ym_format'] = sanitize_text_field( $options['setting_ym_format'] );
	}

	return $new_options;
}

/**
 * テーマ設定ページ描画.
 */
function create_photo_soushi_theme_settings_page() { ?>
	<div class="wrap">  
		<h1>テーマ設定</h1>  
		<form method="post" action="options.php">  
			<?php settings_fields( 'photo_soushi_theme_options_group' ); ?>
			<?php do_settings_sections( 'photo_soushi_theme_options_group' ); ?>
			<?php $options = get_option( 'photo_soushi_theme_options' ); ?>
			<h3>背景色設定</h3>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">ダークモード設定</th>
					<td>
						<?php $option_dark_theme = isset( $options['setting_dark_theme'] ) ? esc_attr( $options['setting_dark_theme'] ) : 'Light'; ?>
						<label for="setting_dark_theme_light" class="visually-hidden">ライトモード（デフォルト）　</label>
						<input type="radio" id="setting_dark_theme_light" name="photo_soushi_theme_options[setting_dark_theme]" value="Light" <?php checked( $option_dark_theme, 'Light' ); ?>> ライトモード（デフォルト）　
						<label for="setting_dark_theme_dark" class="visually-hidden">ダークモード　</label>
						<input type="radio" id="setting_dark_theme_dark" name="photo_soushi_theme_options[setting_dark_theme]" value="Dark" <?php checked( $option_dark_theme, 'Dark' ); ?>> ダークモード　
						<label for="setting_dark_theme_prefers" class="visually-hidden">クライアントの設定に従う　</label>
						<input type="radio" id="setting_dark_theme_prefers" name="photo_soushi_theme_options[setting_dark_theme]" value="Prefers" <?php checked( $option_dark_theme, 'Prefers' ); ?>> クライアントの設定に従う　
					</td>
				</tr>
			</table>

			<h3>タグ置き換え設定</h3>			
			<table class="form-table">
				<tr valign="top">
					<th scope="row">"Lens:" のアイコン置き換え</th>
					<td>
						<?php $option_tag_replace_lens = isset( $options['setting_tag_replace_lens'] ) ? esc_attr( $options['setting_tag_replace_lens'] ) : 'ON'; ?>
						<input type="radio" name="photo_soushi_theme_options[setting_tag_replace_lens]" value="ON" <?php checked( $option_tag_replace_lens, 'ON' ); ?>> ON
						<input type="radio" name="photo_soushi_theme_options[setting_tag_replace_lens]" value="OFF" <?php checked( $option_tag_replace_lens, 'OFF' ); ?>> OFF
					</td>
				</tr>
				<tr>
					<th scope="row">"T*" の赤字化</th>
					<td>
						<?php $option_tag_replace_tstar = isset( $options['setting_tag_replace_tstar'] ) ? esc_attr( $options['setting_tag_replace_tstar'] ) : 'ON'; ?>
						<input type="radio" name="photo_soushi_theme_options[setting_tag_replace_tstar]" value="ON" <?php checked( $option_tag_replace_tstar, 'ON' ); ?>> ON
						<input type="radio" name="photo_soushi_theme_options[setting_tag_replace_tstar]" value="OFF" <?php checked( $option_tag_replace_tstar, 'OFF' ); ?>> OFF
					</td>
				</tr>
				<tr>
					<th scope="row">"Location:" のアイコン化</th>
					<td>
						<?php $option_tag_replace_location = isset( $options['setting_tag_replace_location'] ) ? esc_attr( $options['setting_tag_replace_location'] ) : 'ON'; ?>
						<input type="radio" name="photo_soushi_theme_options[setting_tag_replace_location]" value="ON" <?php checked( $option_tag_replace_location, 'ON' ); ?>> ON
						<input type="radio" name="photo_soushi_theme_options[setting_tag_replace_location]" value="OFF" <?php checked( $option_tag_replace_location, 'OFF' ); ?>> OFF
					</td>
				</tr>
			</table>
			<h3>月別アーカイブページヘッダ部の年・月表示フォーマット設定</h3>
			<table class="form-table">
				<tr>
					<th scope="row">年・月表示フォーマット</th>
					<td>
						<?php $option_ym_format = isset( $options['setting_ym_format'] ) ? esc_attr( $options['setting_ym_format'] ) : 'M. Y'; ?>
						<input type="radio" name="photo_soushi_theme_options[setting_ym_format]" value="M. Y" <?php checked( $option_ym_format, 'M. Y' ); ?>> "M. Y" (e.g. Apr. 2021)　
						<input type="radio" name="photo_soushi_theme_options[setting_ym_format]" value="Y-m" <?php checked( $option_ym_format, 'Y-m' ); ?>> "Y-m" (e.g. 2021-04)
					</td>
				</tr>
			</table>
		<?php submit_button(); ?>  
		</form>
	</div>
	<?php
}
