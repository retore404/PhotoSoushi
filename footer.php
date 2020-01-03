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