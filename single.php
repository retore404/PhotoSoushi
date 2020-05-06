<?php get_header(); ?>
    <section id="content">
        <div id="content-wrap" class="container-fluid">
            <div class="col-md-6 offset-md-3 row">
                <div class="col-md-12">
                    <?php if(have_posts()): the_post(); ?>
                        <div class="single-date"><?php echo get_the_date(); ?></div>
                        <div><h3><?php the_title(); ?></h3></div>
                        <?php if(has_category() ): ?>
                            <div class="single-category-tags-wrapper"><span class="single-category-tags">Category: <?php if (the_category(', '))  the_category(); ?></span></div>
                        <?php endif; ?>
                        <?php if(has_tag() ): ?>
                            <div class="single-category-tags-wrapper"><span class="single-category-tags">Tag(s): <?php if (the_tags('', ', '))  the_tags(); ?></span></div>
                        <?php endif; ?>
                        <div class="single-post-body">
                            <!--自動補正ありの本文-->
                            <?php the_content(); ?>
                        </div>
                        <hr>
                        <div id="comments">
                        <?php
                            comments_template();
                        ?>
                        </div>
                    <?php endif; ?> 
                </div>           
            </div>
        </div>
    </section>
<?php get_footer(); ?>