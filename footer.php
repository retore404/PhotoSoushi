        <footer>
            <div id="content-wrap" class="container-fluid">
                <div class="col-xl-6 offset-xl-3 row">
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
    </body>
</html>