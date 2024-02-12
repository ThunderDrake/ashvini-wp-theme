<?php defined('ABSPATH') || exit;

$author_url = get_author_posts_url($post->post_author);

$author_name = get_the_author_meta('display_name', $post->post_author);

$image_id = get_post_thumbnail_id(get_the_ID());

$date = get_the_date();

$category = get_the_category();

$tags = get_the_tags();

$single_blog_share = get_theme_mod('single-blog-share', esc_attr(0));

$single_blog_share_list = get_theme_mod('single-blog-share-list');

$single_blog_tags = get_theme_mod('single-blog-tags', esc_attr(1));

$single_blog_navigation = get_theme_mod('single-blog-navigation', esc_attr(1));

$single_blog_recent_posts = get_theme_mod('single-blog-recent-posts', esc_attr(0));

$posts_per_page = get_theme_mod('single-blog-recent-posts-number', esc_attr(4));

$single_blog_comments = get_theme_mod('single-blog-comments', esc_attr(1));

/* next prev post */
$prev_post = get_previous_post();

/* gen next post */
$next_post = get_next_post();


?>


<div class="single-post-wrapper">
	
	<header class="single-post-header">
		
		<?php if (has_post_thumbnail()): ?>
			
			<div class="left-side">
				
				<?php
				
				if (class_exists('FSD_Helper')):
					
					echo FSD_Helper::render_image($image_id,
							'fs-square-size-large',
							['sizes' => implode(',', [
									'(max-width: 300px) 300px',
									'(max-width: 540px) 540px',
							]),
									'srcset' => implode(',', [
											esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-extra-small')) . ' 300w',
											esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-small')) . ' 540w',
											esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-medium')) . ' 768w',
											esc_url(wp_get_attachment_image_url($image_id, 'fs-square-size-large')) . ' 1024w',
									]),
									'loading' => 'lazy',
									'alt' => get_the_title()
							], false);
				
				else:
					
					the_post_thumbnail();
				
				endif;
				
				
				?>
			
			</div>
		
		<?php endif; ?>
		
		<div class="right-side <?php if (!has_post_thumbnail()): ?>without-image<?php endif; ?>">
			
			<div class="content-wrapper">
				
				<ul class="meta-wrapper">
					
					<?php if (!empty($category)): ?>
						
						<?php foreach ($category as $category_item): ?>
							
							<li class="meta-item">
								
								<a class="category-name meta-item"
								   href="<?php echo esc_url(get_category_link($category_item->term_id)); ?>">
									
									<?php echo esc_html($category_item->name); ?>
								
								</a>
							
							</li>
						
						<?php endforeach; ?>
					
					<?php endif; ?>
					
					
					<li class="date meta-item">
						
						<?php echo esc_html($date); ?>
					
					</li>
				
				</ul>
				
				<h1 class="post-title">
					
					<?php echo esc_html(wp_trim_words(get_the_title(), 10, '...')); ?>
				
				</h1>
				
				<a class="author-wrapper" href="<?php echo esc_url($author_url); ?>">
					
					<?php echo esc_html('By ' . $author_name); ?>
				
				</a>
			
			</div>
		
		</div>
	
	</header>
	
	<div class="single-post-body entry-content">
		
		<?php
		
		if (function_exists('elementor_load_plugin_textdomain')):
			
			/* page content */
			the_content();
		
		else:
			
			if (have_posts()) :
				
				while (have_posts()) : the_post();
					
					?>
					
					<div class="container">
						
						<?php the_content(); ?>
						
						<?php
						
						global $multipage;
						
						if (0 !== $multipage): ?>
							
							<div class="entry-navigation">
								
								<?php
								
								wp_link_pages([
										'link_before' => '<div class="link">',
										'link_after' => '</div>',
								]);
								
								?>
							
							</div>
						
						<?php
						
						endif;
						
						?>
					
					</div>
				
				<?php
				
				endwhile;
			
			endif;
		
		endif;
		
		?>
	
	</div>
	
	<div class="single-post-footer">
		
		<div class="inner-wrapper container">
			
			<?php if (!empty($tags) && $single_blog_tags): ?>
				
				<div class="tags-wrapper">
					
					<h3 class="footer-title">
						
						<?php echo esc_html__('Tags', 'levre'); ?>
					
					</h3>
					
					<ul class="tags-list">
						
						<?php foreach ($tags as $tag): ?>
							
							<li class="tag">
								
								<a href="<?php echo esc_url(get_term_link($tag->term_id)); ?>">
									
									<?php echo esc_html($tag->name); ?>
								
								</a>
							
							</li>
						
						<?php endforeach; ?>
					
					</ul>
				
				</div>
			
			<?php endif; ?>
			
			<?php if ($single_blog_share && !empty($single_blog_share_list)): ?>
				
				<div class="share-wrapper">
					
					<h3 class="footer-title">
						
						<?php echo esc_html__('Share', 'levre'); ?>
					
					</h3>
					
					<?php if ($single_blog_share && $single_blog_share_list): ?>
						
						<!-- Share Wrapper -->
						<div class="share-list">
							
							<?php if (in_array('twitter', $single_blog_share_list)): ?>
								
								<!-- Twitter Share Link -->
								<?php FSD_Helper::the_twitter_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('pinterest', $single_blog_share_list)): ?>
								
								<!-- Pinterest Share Link -->
								<?php FSD_Helper::the_pinterest_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('facebook', $single_blog_share_list)): ?>
								
								<!-- Facebook Share Link -->
								<?php FSD_Helper::the_facebook_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('vk', $single_blog_share_list)): ?>
								
								<!-- VK Share Link -->
								<?php FSD_Helper::the_vk_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('linkedin', $single_blog_share_list)): ?>
								
								<!-- Linkedin Share Link -->
								<?php FSD_Helper::the_linkedin_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('odnoklassniki', $single_blog_share_list)): ?>
								
								<!-- Odnoklassniki Share Link -->
								<?php FSD_Helper::the_odnoklassniki_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('tumblr', $single_blog_share_list)): ?>
								
								<!-- Tumblr Share Link -->
								<?php FSD_Helper::the_tumblr_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('google', $single_blog_share_list)): ?>
								
								<!-- Google Share Link -->
								<?php FSD_Helper::the_google_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('digg', $single_blog_share_list)): ?>
								
								<!-- Digg Share Link -->
								<?php FSD_Helper::the_digg_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('reddit', $single_blog_share_list)): ?>
								
								<!-- Reddit Share Link -->
								<?php FSD_Helper::the_reddit_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('stumbleupon', $single_blog_share_list)): ?>
								
								<!-- Stumbleupon Share Link -->
								<?php FSD_Helper::the_stumbleupon_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('pocket', $single_blog_share_list)): ?>
								
								<!-- Pocket Share Link -->
								<?php FSD_Helper::the_pocket_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('whatsapp', $single_blog_share_list)): ?>
								
								<!-- Whatsapp Share Link -->
								<?php FSD_Helper::the_whatsapp_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('xing', $single_blog_share_list)): ?>
								
								<!-- Xing Share Link -->
								<?php FSD_Helper::the_xing_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('email', $single_blog_share_list)): ?>
								
								<!-- Email Share Link -->
								<?php FSD_Helper::the_email_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('telegram', $single_blog_share_list)): ?>
								
								<!-- Telegram Share Link -->
								<?php FSD_Helper::the_telegram_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
							
							<?php if (in_array('skype', $single_blog_share_list)): ?>
								
								<!-- Skype Share Link -->
								<?php FSD_Helper::the_skype_share_link_render(get_the_ID()); ?>
							
							<?php endif; ?>
						
						</div>
					
					<?php endif; ?>
				
				</div>
			
			<?php endif;
			
			if ($single_blog_navigation && (!empty($prev_post) || !empty($next_post))): ?>
				
				<div class="single-post-navigation <?php if (!$single_blog_share): ?>single-post-navigation-default<?php endif; ?>">
					
					<?php if (!empty($prev_post)): ?>
						
						<div class="prev-box nav-box">
							
							<?php if (has_post_thumbnail($prev_post->ID)): ?>
								
								<div class="image-side">
									
									<a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"
									   class="link-overlay"></a>
									
									<?php
									
									if (class_exists('FSD_Helper')):
										
										$prev_image_id = get_post_thumbnail_id($prev_post->ID);
										
										echo FSD_Helper::render_image($prev_image_id,
												'fs-square-size-extra-small',
												['sizes' => implode(',', [
														'(max-width: 300px) 300px',
												]),
														'srcset' => implode(',', [
																esc_url(wp_get_attachment_image_url($prev_image_id, 'fs-square-size-extra-small')) . ' 300w',
														]),
														'loading' => 'lazy',
														'alt' => get_the_title()
												], false);
									
									else:
										
										echo get_the_post_thumbnail($prev_post->ID);
									
									endif;
									
									?>
								
								</div>
							
							<?php endif; ?>
							
							<div class="content-side">

                                   <span class="upper-text">

                                        <?php echo esc_html__('Previous Article', 'levre'); ?>

                                   </span>
								
								<h6 class="post-title">
									
									<a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">
										
										<?php echo esc_html(wp_trim_words(get_the_title($prev_post->ID), 10, '...')); ?>
									
									</a>
								
								</h6>
							
							</div>
						
						</div>
					
					<?php else: ?>
						
						<br>
					
					<?php endif; ?>
					
					<?php if (!empty($next_post)): ?>
						
						<div class="next-box nav-box">
							
							<div class="content-side">

                                   <span class="upper-text">

                                        <?php echo esc_html__('Next Article', 'levre'); ?>

                                   </span>
								
								<h6 class="post-title">
									
									<a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">
										
										<?php echo esc_html(wp_trim_words(get_the_title($next_post->ID), 10, '...')); ?>
									
									</a>
								
								</h6>
							
							</div>
							
							<?php if (has_post_thumbnail($next_post->ID)): ?>
								
								<div class="image-side">
									
									<a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>"
									   class="link-overlay"></a>
									
									<?php
									
									if (class_exists('FSD_Helper')):
										
										$next_image_id = get_post_thumbnail_id($next_post->ID);
										
										echo FSD_Helper::render_image($next_image_id,
												'fs-square-size-extra-small',
												['sizes' => implode(',', [
														'(max-width: 300px) 300px',
												]),
														'srcset' => implode(',', [
																esc_url(wp_get_attachment_image_url($next_image_id, 'fs-square-size-extra-small')) . ' 300w',
														]),
														'loading' => 'lazy',
														'alt' => get_the_title()
												], false);
									else:
										
										echo get_the_post_thumbnail($next_post->ID);
									
									endif;
									
									
									?>
								
								</div>
							
							<?php endif; ?>
						
						</div>
					
					<?php else: ?>
						
						<br>
					
					<?php endif; ?>
				
				</div>
			
			<?php
			
			endif;
			
			if ($single_blog_recent_posts): ?>
				
				<div class="recent-posts-wrapper">
					
					<h1 class="recent-posts-title">
						
						<?php echo esc_html__('Related articles', 'levre'); ?>
					
					</h1>
					
					<div class="recent-posts-grid-wrapper">
						
						<div class="recent-posts-grid">
							
							<?php
							
							$args = [
									'order' => 'DESC',
									'posts_per_page' => $posts_per_page,
									'ignore_sticky_posts' => true,
							];
							
							$recent_query = new WP_Query($args);
							
							if ($recent_query->have_posts()) :
								
								while ($recent_query->have_posts()) : $recent_query->the_post();
									
									$category = get_the_category();
									
									$date = get_the_date();
									
									?>
									
									<article <?php post_class('post-article blog-card'); ?>>
										
										<div class="post-inner">
											
											<div class="post-header">
												
												<a href="<?php the_permalink(); ?>" class="link-overlay"></a>
												
												<?php
												
												if (class_exists('FSD_Helper')):
													
													$image_id = get_post_thumbnail_id(get_the_ID());
													
													echo FSD_Helper::render_image($image_id,
															'fs-vertical-size-medium',
															['sizes' => implode(',', [
																	'(max-width: 300px) 300px',
																	'(max-width: 540px) 540px',
															]),
																	'srcset' => implode(',', [
																			esc_url(wp_get_attachment_image_url($image_id, 'fs-vertical-size-extra-small')) . ' 300w',
																			esc_url(wp_get_attachment_image_url($image_id, 'fs-vertical-size-small')) . ' 540w',
																	]),
																	'loading' => 'lazy',
																	'alt' => get_the_title()
															], false);
												
												else:
													
													the_post_thumbnail();
												
												endif;
												
												?>
											
											</div>
											
											<div class="post-body">
												
												<div class="meta-wrapper">
													
													<?php if (!empty($category)): ?>
														
														<a class="category-name meta-item"
														   href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>">
															
															<?php echo esc_html($category[0]->name); ?>
														
														</a>
													
													<?php endif; ?>
													
													<p class="date meta-item">
														
														<?php echo esc_html($date); ?>
													
													</p>
												
												</div>
												
												<h6 class="post-title body-5">
													
													<a href="<?php the_permalink(); ?>">
														
														<?php echo esc_html(wp_trim_words(get_the_title(), 10, '...')); ?>
													
													</a>
												
												</h6>
											
											</div>
										
										</div>
									
									</article>
								
								<?php
								
								endwhile;
							
							endif;
							
							?>
						
						</div>
					
					</div>
				
				</div>
			
			<?php endif;
			
			if ($single_blog_comments && (comments_open() || get_comments_number())) :
				
				$comments_count = get_comments_number();
				
				?>
				
				<!-- post-comments -->
				<div class="single-post-comments">
					
					<h3 class="comments-title">
						
						<?php
						
						echo sprintf(_n('%s comment on ' . get_the_title(), '%s comments on ' . get_the_title(), $comments_count, 'levre'), $comments_count);
						
						?>
					
					</h3>
					
					<?php comments_template(); ?>
				
				</div>
			
			<?php endif; ?>
		
		</div>
	
	</div>

</div>