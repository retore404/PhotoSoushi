<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title><?php bloginfo('name'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <?php wp_enqueue_script('jquery'); ?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
</head>
<body>
    <header>
        <div id="title_wrapper" class="container">
            <div id="title-div" class="col-md-10 offset-md-1">
                <h1><?php bloginfo('name'); ?></h1>
            </div>        
        </div>
    </header>

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
    <footer>
                <!--フッターのウィジェットスペース-->
                <div class="col-md-12 row">
                    <!--フッターのウィジェットスペース(左)-->
                    <div class="col-md-6">
                        <?php if ( dynamic_sidebar('footer_widget1') ) : else : endif; ?>
                    </div>
                    <!--フッターのウィジェットスペース(右)-->
                    <div class="col-md-6">
                        <?php if ( dynamic_sidebar('footer_widget2') ) : else : endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </footer>
</body>
</html>