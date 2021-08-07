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

?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php wp_head(); ?>
		<?php
		// URLの設定.
		$url = catch_first_image( 'png' ); // 画像のURLを格納.
		echo '<meta property="og:image" content="' . esc_url( $url ) . '">' . "\n";
		if ( substr( $url, 0, 5 ) === 'https' ) { // 取得した画像のURLがhttpsから始まるとき，secure_urlとしても指定.
			echo '<meta property="og:image:secure_url" content="' . esc_url( $url ) . '">' . "\n";
		}		
		?>
	</head>
	<body>
		<section id="grid-container-root">
			<header>
				<h1 id="header-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			</header>
