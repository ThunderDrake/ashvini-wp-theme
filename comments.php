<?php defined('ABSPATH') || exit;

/* check if password required */
if (post_password_required()) :
	
	/* exit */
	return;

endif;

?>

<!-- comments area -->
<div id="comments" class="comments-area <?php echo esc_attr(get_option('show_avatars') ? 'show-avatars' : ''); ?>">
	
	<?php
	
	/* check if have_comments === true */
	if (have_comments()) :
		
		?>
		
		<!-- comment list -->
		<ol class="comment-list">
			
			<?php
			
			/* list comments */
			wp_list_comments(
					[
							'avatar_size' => 60,
							'style' => 'ol',
							'short_ping' => true,
					]
			);
			
			?>
		
		</ol>
		
		<?php
		
		/* comments pagination */
		the_comments_pagination(
				[
						'before_page_number' => esc_html__('Page ', 'levre'),
						'mid_size' => 0,
						'prev_text' => '',
						'next_text' => '',
				]
		);
		
		/* check if comments open */
		if (!comments_open()) : ?>
			
			<!-- no comments -->
			<p class="no-comments">
				
				<?php echo esc_html__('Comments are closed.', 'levre'); ?>
			
			</p>
		
		<?php
		
		endif;
	
	endif;
	
	/* comments form */
	comment_form(
			[
					'logged_in_as' => null,
					'title_reply' => esc_html__('Post a comment', 'levre'),
					'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title">',
					'title_reply_after' => '</h3>',
			]
	);
	
	?>

</div>