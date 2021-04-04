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
		'テーマ設定',
		'manage_options',
		'mytheme-settings',
		'create_mytheme_settings_page'
	);
}

/**
 * テーマ用の設定値を作成します.
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
}

/**
 * 設定値をサニタイズ.
 *
 * @param array $options PhotoSoushiテーマオプションの設定値を持つ配列.
 * @return array $options PhotoSoushiテーマオプションの設定値を持つ配列(サニタイズ済).
 */
function sanitize_photo_soushi_theme_options( $options ) {
	$new_options = array();

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

	return $new_options;
}

/**
 * テーマ設定ページ描画.
 */
function create_mytheme_settings_page() { ?>
	<div class="wrap">  
		<h1>テーマ設定</h1>  
		<form method="post" action="options.php">  
			<?php settings_fields( 'photo_soushi_theme_options_group' ); ?>
			<?php do_settings_sections( 'photo_soushi_theme_options_group' ); ?>
			<?php $options = get_option( 'photo_soushi_theme_options' ); ?>
			<h2>タグ置き換え設定</h2>			
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
		<?php submit_button(); ?>  
		</form>
	</div>
	<?php
}
