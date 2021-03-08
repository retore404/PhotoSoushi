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

get_header(); ?>
			<section id="content-header">
				<h3>
					<!--開いているページがカテゴリ・タグ・月別の一覧ページかの判定-->
					<?php if ( is_category() || is_tag() || is_date() ) : ?>
						<!--開いている一覧ページがカテゴリ・タグ・月別の一覧ページのとき，カテゴリ名・タグ名・月を表示する-->
							<!--開いている一覧ページがカテゴリ別ページのとき-->
							<?php if ( is_category() ) : ?>
								Category: <?php single_cat_title(); ?>
							<!--開いている一覧ページがタグ別ページのとき-->
							<?php elseif ( is_tag() ) : ?>
								Tag: <?php echo replace_tag_name( single_cat_title( '', false ) ); ?>
							<!--開いている一覧ページが月別ページのとき-->
							<?php elseif ( is_date() ) : ?>
								Posts in  <?php echo get_post_time( 'M. Y' ); ?>
							<?php endif; ?>
					<!--開いている一覧ページがカテゴリ・タグ別ページ・月別アーカイブでない=普通の記事一覧のとき-->
					<?php else : ?>
						Posts.
					<?php endif; ?>
				</h3>
			</section>
			<?php if ( have_posts() ) : ?>
			<section id="grid-container-index">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<section class="post-container">
						<a href="<?php the_permalink(); ?>">
							<section class="post-each">
								<div class="post-each-thumbnail-wrapper">
									<div class="post-each-thumbnail">
										<img src="<?php echo catch_first_image(); ?>" alt="<?php the_title(); ?>"  class="hover" />
									</div>
								</div>
								<span class="post-date"><?php echo get_the_date( 'Y-m-d' ); ?></span><br>
								<span class="post-title"><?php the_title(); ?></span><br>
								<span class="post-excerpt"><?php the_excerpt(); ?></span>
							</section>
						</a>
					</section>
				<?php endwhile; ?>
			</section>
			<?php endif; ?>
			<!--ページネーション-->
			<section id="pagination">
				<?php
				if ( function_exists( 'the_pagination' ) ) {
					the_pagination();}
				?>
			</section>
			<!--メイン領域下のウィジェットスペース-->
			<?php dynamic_sidebar( 'main_widget1' ); ?>
<?php get_footer(); ?>
