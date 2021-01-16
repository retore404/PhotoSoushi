<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head(); ?>
    </head>
    <body>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.13.0/css/all.css" integrity="sha384-Bfad6CLCknfcloXFOyFnlgtENryhrpZCe29RTifKEixXQZ38WheV+i/6YWSzkz3V" crossorigin="anonymous"> 
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css">
        <div class="grid-container-root">
            <header>
                <div id="title-div">
                    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo('name'); ?></a></h1>
                </div>
            </header>
<!-- ヘッダ終了 -->
            <section id="content-header">
                <div class="section-title">
                    <h3>
                        <!--開いている一覧ページがカテゴリ別ページのとき-->
                        <?php if(is_category() ): ?>
                            Category: <?php single_cat_title(); ?>
                        <!--開いている一覧ページがタグ別ページのとき-->
                        <?php elseif(is_tag() ): ?>
                            Tag: <?php echo replace_tag_name(single_cat_title('', false)); ?>
                        <!--開いている一覧ページがカテゴリ・タグ別ページでない=普通の記事一覧のとき-->
                        <?php else: ?>
                            Posts.
                        <?php endif; ?>
                    </h3>
                </div>
            </section>
            <section id="content" class="grid-container-index">
                    <?php if(have_posts()): while(have_posts()): the_post(); ?>
                        <div class="col-sm-4">
                            <a href="<?php the_permalink(); ?>">
                                <article class="post-each">
                                    <div class="post-each-thumbnail-wrapper">
                                        <div class="post-each-thumbnail">
                                            <img src="<?php echo catch_first_image(); ?>" alt="<?php the_title(); ?>"  class="hover" />
                                        </div>
                                    </div>
                                    <span class="post-date"><?php echo get_the_date( 'Y-m-d' ); ?></span><br>
                                    <span class="post-title"><?php the_title(); ?></span><br>
                                    <span class="post-excerpt"><?php the_excerpt(); ?></span>
                                </article>
                            </a>
                            <hr class="d-block d-sm-none">
                        </div>                                                
                    <?php endwhile; endif; ?>
            </section>
            <!--ページネーション-->
            <section id="pagination">
                <div class="col-sm-4 offset-sm-4">
                    <?php if( function_exists("the_pagination") ) the_pagination(); ?>
                </div>
            </section>
            <!--メイン領域下のウィジェットスペース-->
            <div class="col-xl-6 offset-xl-3 widget-wrapper row">
                <?php if ( dynamic_sidebar('main_widget1') ) : else : endif; ?>
            </div>
            <!--フッタ開始部-->
            <footer>
                <div class="grid-container-footer widget-wrapper">
                    <!--フッターのウィジェットスペース-->
                    <!--フッターのウィジェットスペース(左)-->
                    <div>
                        <?php if ( dynamic_sidebar('footer_widget1') ) : else : endif; ?>
                    </div>
                    <!--フッターのウィジェットスペース(右)-->
                    <div>
                        <?php if ( dynamic_sidebar('footer_widget2') ) : else : endif; ?>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>