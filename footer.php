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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
			<footer>
				<div id="grid-container-footer" class="widget-wrapper">
					<!--フッターのウィジェットスペース-->
					<!--フッターのウィジェットスペース(左)-->
					<div>
						<?php dynamic_sidebar( 'footer_widget1' ); ?>
					</div>
					<!--フッターのウィジェットスペース(右)-->
					<div>
						<?php dynamic_sidebar( 'footer_widget2' ); ?>
					</div>
				</div>
			</footer>
			</section>
	</body>
</html>
