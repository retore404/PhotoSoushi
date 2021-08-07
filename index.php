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
				
		<?php
		// URLの設定.
		$url = catch_first_image( 'png' ); // 画像のURLを格納.
		echo '<meta property="og:image" content="' . esc_url( $url ) . '">' . "\n";
		if ( substr( $url, 0, 5 ) === 'https' ) { // 取得した画像のURLがhttpsから始まるとき，secure_urlとしても指定.
			echo '<meta property="og:image:secure_url" content="' . esc_url( $url ) . '">' . "\n";
		}		
		?>
				<h2>
					<!--開いている一覧ページがアーカイブページのとき-->
					<?php if ( is_archive() ) : ?>
						<!--開いている一覧ページがカテゴリ別ページのとき-->
						<?php if ( is_category() ) : ?>
							Category: <?php single_cat_title(); ?>
						<!--開いている一覧ページがタグ別ページのとき-->
						<?php elseif ( is_tag() ) : ?>
							Tag: <?php echo wp_kses_post( replace_tag_str( single_cat_title( '', false ) ) ); ?>
						<!--開いている一覧ページが月別ページのとき-->
						<?php elseif ( is_date() ) : ?>
							Posts in  <?php echo esc_html( get_post_time( 'M. Y' ) ); ?>
						<?php endif; ?>
						<!--アーカイブページの共通表示（表示中ページ数・全ページ数）.ただし，1ページ目の場合は関数が0を返すため，1に置き換える. -->
						(<?php echo esc_html( get_query_var( 'paged' ) === 0 ? '1' : get_query_var( 'paged' ) ); ?>/<?php echo esc_html( $wp_query->max_num_pages ); ?>)
					<!--開いている一覧ページがアーカイブページでないとき-->
					<?php else : ?>
						Posts.
					<?php endif; ?>
				</h2>
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
										<!--レイアウトシフト防止のためwidth/height属性を指定しブラウザにアスペクト比を通知.当面3:2前提の記載. -->
										<img loading="lazy" src="<?php echo esc_url( catch_first_image() ); ?>" alt="<?php the_title(); ?>"  class="hover" width="6000" height="4000" />
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
