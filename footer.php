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