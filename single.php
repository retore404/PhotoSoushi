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
			<section id="content">
				<?php
				if ( have_posts() ) :
					the_post();
					?>
					<article class="grid-container-article">
						<span id="single-date"><?php echo get_the_date(); ?></span>
						<h2 id="single-title"><?php the_title(); ?></h2>
						<!--自動補正ありの本文-->
						<?php the_content(); ?>                    
						<section id="single-article-info">
							<?php if ( has_category() ) : ?>
								<div class="single-category-tags-wrapper"><span class="single-category-tags">Category: 
								<?php
								if ( the_category( ', ' ) ) {
									the_category();}
								?>
								</span></div>
							<?php endif; ?>
							<?php if ( has_tag() ) : ?>
								<div class="single-category-tags-wrapper"><span class="single-category-tags">
									<?php
									$tags_array = get_the_tags(); // 表示中の記事のタグの配列を取得.
									if ( $tags_array ) { // タグが存在するとき.
										$tag_str = 'Tag(s):<br>'; // 表示用の文字列.
										foreach ( $tags_array as $t ) {
											$tag_str = $tag_str . '<a href="' . get_tag_link( $t->term_id ) . '">' . replace_tag_str( $t->name ) . '</a>, ';
										}
										$tag_str = rtrim( $tag_str, ', ' ); // 末尾の不要な「, 」を削除.
										echo wp_kses_post( $tag_str ); // 出力.
									}
									?>
								</span></div>
							<?php endif; ?>
						</section>
						<section id="share">
							<a href="https://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo rawurlencode( get_the_title() . ' | ' . get_bloginfo( 'name' ) . "\n" ); ?>" target="_blank" rel="noopener" class="share-icon" aria-label="share on twitter"><span class="ps-sns-icon-twitter"></span></a>
							<a href="http://b.hatena.ne.jp/entry/<?php the_permalink(); ?>" target="_blank" rel="noopener" class="share-icon" aria-label="bookmark on hatena"><span class="ps-sns-icon-hatenabookmark"></span></a>
							<a href="https://social-plugins.line.me/lineit/share?url=<?php the_permalink(); ?>" target="_blank" rel="noopener" class="share-icon" aria-label="share on LINE"><span class="ps-sns-icon-line"></span></a>
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank" rel="noopener" class="share-icon" aria-label="share on Facebook"><span class="ps-sns-icon-facebook"></span></a>
							<a href="https://getpocket.com/save?url=<?php the_permalink(); ?>" target="_blank" rel="noopener" class="share-icon"><span class="ps-sns-icon-pocket" aria-label="save on Pocket"></span></a>
							<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>" target="_blank" rel="noopener" class="share-icon"><span class="ps-sns-icon-pinterest" aria-label="share on Pinterest"></span></a>
						</section>
						<section id="comments">
							<?php
								comments_template();
							?>
						</section>
						<section id="post-links">
							<?php next_post_link( '%link', '« next' ); ?>
							|
							<?php previous_post_link( '%link', 'prev »' ); ?>
						</section>
					</article>
				<?php endif; ?>
			</section>
<?php get_footer(); ?>
