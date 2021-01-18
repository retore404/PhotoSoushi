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
    <hr>
    <?php endif; ?>
</div>
<div id="comment-form">
    <?php
        $comments_args = array(
            'fields' => array(
                'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><br> ' .
                            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '""' . $aria_req . ' /></p>',
                'email'  => '',
    	        'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label><br> ' .
    		    			'<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '"/></p>',
    		),
    		'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
    	);
      comment_form($comments_args);
    ?>
</div>