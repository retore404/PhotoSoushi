			<footer>
				<div id="grid-container-footer" class="widget-wrapper">
					<!--フッターのウィジェットスペース-->
					<!--フッターのウィジェットスペース(左)-->
					<div>
						<?php if (dynamic_sidebar('footer_widget1')) : else : endif; ?>
					</div>
					<!--フッターのウィジェットスペース(右)-->
					<div>
						<?php if (dynamic_sidebar('footer_widget2')) : else : endif; ?>
					</div>
				</div>
			</footer>
			</section>
	</body>
</html>