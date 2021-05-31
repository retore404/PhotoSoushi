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

<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="s" class="visually-hidden">Search: </label>
	<section class="search-field-wrapper">
		<span class="ps-icon-search"></span>
		<input type="text" value="" placeholder="Search." name="s" id="s" class="search-field" />
	</section>
</form>
