<div id="comments">
<?php if (have_comments()) :?>
	<h3>Comments.</h3>
	<ul id="comments-list">
	<?php wp_list_comments(array(
			'avatar_size'=>0,
			'style'=>'ul',
			'type'=>'comment',
		)); ?>
	</ul>
<?php endif; ?>
<?php comment_form(); ?>
</div>