<div id="comment-wrap">
	<?php
	/* If the post is password protected */
	if ( post_password_required() ) : ?>
		<h2 class="comment-title">
			<?php _e('This post is password protected. Please enter the password to view comments', 'pantomime'); ?>
		</h4>
	<?php return; endif; ?>
	
	
	<?php
	/* If the post has comments, show these things */
	if ( have_comments() ) : ?>
		<h2 class="comment-title">
			<?php comments_number( __( 'No Response Yet', 'pantomime'), __( 'One Response for This Thought', 'pantomime'), __( '% Responses for This Thought', 'pantomime')); ?>
		</h2>		
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-nav clearfix">
				<div class="comment-prev">
					<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'pantomime' ) ); ?>
				</div>
				<div class="comment-next">
					<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'pantomime' ) ); ?>
				</div>
			</div><!-- .comment-nav -->
		<?php endif; ?>
		
		<ol id="comment-list" class="clearfix">
			<?php wp_list_comments(array('callback' => 'pantomime_comment_item')); ?>
		</ol>	

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="comment-nav clearfix bottom">
				<div class="comment-prev">
					<?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'pantomime' ) ); ?>
				</div>
				<div class="comment-next">
					<?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'pantomime' ) ); ?>
				</div>
			</div><!-- .comment-nav -->
		<?php endif; ?>

	<?php
	/* If there's no comment yet, show this message instead */
	elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<h4 class="section-title">
			<?php _e('No Response Yet', 'pantomime'); ?>
		</h4>
		<p id="noresponse-message"><?php _e('There is no response for this thought.', 'pantomime'); ?></p>
	<?php
		endif;
		if (!comments_open()) : /* Show this message is the comment is already closed*/
	?>
		<div id="comment-closed-message" class="emboss">
			<h4 class="section-title"><?php _e( 'The comment is closed', 'pantomime' ); ?></h4>
			<p><?php echo of_get_option('pantomime_closed_comment_message', __('Sorry but we have decided to close the comment section for this post.', 'pantomime')); ?></p>
		</div>
	<?php
		endif;
		comment_form(); ?>	
</div>