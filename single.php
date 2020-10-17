<?php get_header(); ?>
    <section id="content">
        <div id="content-wrap" class="container-fluid">
            <div class="row">
                <div class="col-xl-6 offset-xl-3">
                    <?php if(have_posts()): the_post(); ?>
                        <main class="wrapper">
                            <div class="single-date"><?php echo get_the_date(); ?></div>
                            <div class="single-title"><h3><?php the_title(); ?></h3></div>
                            <div class="single-post-spacer">
                            </div>
                                <!--自動補正ありの本文-->
                                <?php the_content(); ?>
                            <hr>
                            <div class="article-info">
                                <?php if(has_category() ): ?>
                                    <div class="single-category-tags-wrapper"><span class="single-category-tags">Category: <?php if (the_category(', '))  the_category(); ?></span></div>
                                <?php endif; ?>
                                <?php if(has_tag() ): ?>
                                    <div class="single-category-tags-wrapper"><span class="single-category-tags">Tag(s): <?php if (the_tags('', ', '))  the_tags(); ?></span></div>
                                <?php endif; ?>
                            </div>
                            <hr>
                            <div class="share">
                                <span>Share.</span><br>
                                <a href="https://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo urlencode(get_the_title() . " | " . get_bloginfo('name') . "\n" ); ?>" target="_blank"><i class="fab fa-twitter"></i></a>
                                <a href="http://b.hatena.ne.jp/entry/<?php the_permalink(); ?>" target="_blank"><i class="fa fa-hatena"></i></a>
                            </div>
                            <hr>
                            <div id="comments">
                            <?php
                                comments_template();
                            ?>
                            </div>
                        </main>
                    <?php endif; ?>         
                </div>
            </div>
        </div>
    </section>
<?php get_footer(); ?>