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
function add_mytheme_menu() {
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
	add_action( 'admin_menu', 'add_mytheme_menu' );
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

	// 設定値例1のサニタイズ.
	if ( isset( $options['setting_ex1'] ) ) {
		$new_options['setting_ex1'] = sanitize_text_field( $options['setting_ex1'] );
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
			<table class="form-table">
				<tr valign="top">
					<th scope="row">設定値例1</th>
					<td>
						<?php $option = isset( $options['setting_ex1'] ) ? esc_attr( $options['setting_ex1'] ) : ''; ?>
						<input type="text" name="photo_soushi_theme_options[setting_ex1]" value="<?php echo esc_attr( $option ); ?>">
					</td>
				</tr>
			</table>  
		<?php submit_button(); ?>  
		</form>
	</div>
	<?php
}
