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
            <section id="content">
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
                                <div class="single-category-tags-wrapper"><span class="single-category-tags">
                                    <?php 
                                        $tags_array = get_the_tags(); //表示中の記事のタグの配列を取得
                                        if($tags_array) { // タグが存在するとき
                                            $tag_str = "Tag(s): "; // 表示用の文字列
                                            foreach ($tags_array as $tag) {
                                                $tag_str = $tag_str . '<a href="'. get_tag_link($tag->term_id) . '">' .  replace_tag_name($tag->name) . '</a>, ';
                                            }
                                            $tag_str = rtrim($tag_str, ', '); //末尾の不要な「, 」を削除
                                            echo $tag_str; //出力
                                        }
                                    ?>
                                </span></div>
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
                        <div class="post-links">
                        <?php next_post_link('<< %link'); ?>
                        |
                        <?php previous_post_link('%link >>'); ?>
                        </div>
                    </main>
                <?php endif; ?>
            </section>
            <!--フッタ開始部-->
            <footer>
                <div class="grid-container-footer">
                    <div class="col-xl-6 offset-xl-3 row widget-wrapper">
                        <!--フッターのウィジェットスペース-->
                        <!--フッターのウィジェットスペース(左)-->
                        <div class="col-sm-6 col-xs-12">
                            <?php if ( dynamic_sidebar('footer_widget1') ) : else : endif; ?>
                        </div>
                        <!--フッターのウィジェットスペース(右)-->
                        <div class="col-sm-6 col-xs-12">
                            <?php if ( dynamic_sidebar('footer_widget2') ) : else : endif; ?>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>