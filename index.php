<?php get_header(); ?>
    <section id="content">
        <div id="content-wrap" class="container">
            <div class="col-md-10 offset-md-1 row">
                <div class="col-md-12">
                    <div class="section-title">
                        <h3 class="post-section">Recent Post.</h3>
                    </div>
                </div>
                <div id="main" class="col-md-12 row">
                    <?php if(have_posts()): while(have_posts()): the_post(); ?>
                        <div class="col-md-4">
                            <div class="post-each">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if( has_post_thumbnail() ): ?>
                                        <?php the_post_thumbnail('page_eyecatch-image'); ?>
                                    <?php else: ?>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/thumbnail.png">
                                    <?php endif; ?>                                    
                                </a><br>
                                <span class="post-date"><?php echo get_the_date( 'Y-m-d' ); ?></span><br>
                                <a href="#"><span class="post-title"><?php the_title(); ?></span></a><br>
                                <span class="post-excerpt"><?php the_excerpt(); ?></span>
                            </div>
                        </div>                                                
                    <?php endwhile; endif; ?>
                    <div class="col-md-12 row">
                        <div class="col-md-4 offset-md-4" style="text-align:center;">
                            Older Posts.
                        </div>
                    </div>
                </div>
                <!--メイン領域下のウィジェットスペース-->
                <div class="col-md-12">
                    <?php if ( dynamic_sidebar('main_widget1') ) : else : endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>