<?php defined('ABSPATH') || exit;

wp_reset_postdata();

global $post;

$loop = get_posts('numberposts=1&order=ASC');

$first = $loop[0]->ID;

if (empty($first)):
	
	$first = false;

endif;

if (!empty(get_option('sticky_posts')[0])):
	
	$first = get_option('sticky_posts')[0];

endif;

$sticky_id = get_theme_mod('sticky-post-section-post', esc_attr($first));

global $wp_query;

$filters = get_theme_mod('blog-filter-toggle', esc_attr(1));

$sticky_section_toggle = get_theme_mod('sticky-post-section-toggle', esc_attr(1));


if (!empty($_GET['sticky_section'])):
	
	$sticky_section_toggle = $_GET['sticky_section'];

endif;


$sticky_section_type = get_theme_mod('sticky-post-section-type', esc_attr('header'));

if (!empty($_GET['sticky_section_type'])):
	
	$sticky_section_type = $_GET['sticky_section_type'];

endif;

$columns = get_theme_mod('blog-number-of-grid-column', esc_attr(3));

if ((is_archive() || is_search()) && !is_category()):
	
	$columns = get_theme_mod('blog-number-of-grid-column-archive', esc_attr(3));

endif;

if (!empty($_GET['columns'])):
	
	$columns = $_GET['columns'];

endif;

$offset = get_theme_mod('blog-grid-offset', esc_attr(15));

if (!empty($_GET['offset'])):
	
	$offset = $_GET['offset'];

endif;

$pagination_style = get_theme_mod('blog-pagination-type', esc_attr('default'));

if (!empty($_GET['pagination_type'])):
	
	$pagination_style = $_GET['pagination_type'];

endif;

$paged = max(1, get_query_var('paged'));

$classes = [];

if ($sticky_section_toggle && $sticky_section_type === 'header' && (is_home() || is_category())):
	
	get_template_part('template-parts/blog/sticky-header');

endif;

if ($sticky_section_toggle && $sticky_section_type === 'sidebar' && (is_home() || is_category())):
	
	array_push($classes, esc_attr('sidebar-sticky'));

endif;

if ((!$sticky_section_toggle || $sticky_section_type === 'sidebar') && (is_home() || is_category())):
	
	array_push($classes, esc_attr('top-section'));

endif;

if (!class_exists('FSD_Core')):
	
	array_push($classes, esc_attr('blog-default'));

endif;

$classes = implode(' ', $classes);

if (class_exists('FSD_Core')):
	
	?>
	
	<div class="blog-wrapper <?php echo esc_attr($classes); ?>">
		
		<?php
		
		if (is_search()):
			
			?>
			
			<div class="archive-page-header">
				
				<div class="inner-wrapper container">
					
					<h1 class="page-title">
						
						<?php
						
						echo esc_html(get_search_query());
						
						?>
					
					</h1>
					
					<?php if (is_search()):
						
						global $wp_query;
						
						$results_count = $wp_query->found_posts;
						
						?>
						
						<span class="results">

                    <?php echo esc_html($results_count . ' ') . esc_html__('Results', 'levre'); ?>

                </span>
					
					<?php endif; ?>
				
				</div>
			
			</div>
		
		<?php
		
		endif;
		
		?>
		
		<div class="inner-wrapper container">
			
			<?php
			
			if ((is_home() || is_category()) && $filters && class_exists('FSD_Core')):
				
				get_template_part('template-parts/blog/filter');
			
			endif;
			
			?>
			
			<div class="bottom-side">
				
				<?php
				
				if ($sticky_section_toggle && $sticky_section_type === 'sidebar' && (is_home() || is_category())):
					
					get_template_part('template-parts/blog/sticky-sidebar');
				
				endif;
				
				?>
				
				<div class="blog-grid-wrapper">
					
					<div class="blog-grid <?php echo esc_attr('columns-' . $columns); ?>">
						
						<?php
						
						if (have_posts()) : while (have_posts()) :the_post();
							
							$category = get_the_category();
							
							$date = get_the_date();
							
							$title = get_the_title();
							
							?>
							
							<article <?php post_class('post-article blog-card'); ?>>
								
								<div class="post-inner">
									
									<?php if (has_post_thumbnail()): ?>
										
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
									
									<?php endif; ?>
									
									<div class="post-body">
										
										<?php if (!empty($category) || !empty($date)): ?>
											
											<div class="meta-wrapper">
												
												<?php if (!empty($category)): ?>
													
													<a class="category-name meta-item"
													   href="<?php echo esc_url(get_category_link($category[0]->term_id)); ?>">
														
														<?php echo esc_html($category[0]->name); ?>
													
													</a>
												
												<?php endif; ?>
												
												<?php if (!empty($date)): ?>
													
													<p class="date meta-item">
														
														<?php echo esc_html($date); ?>
													
													</p>
												
												<?php endif; ?>
											
											</div>
										
										<?php endif; ?>
										
										<?php if (!empty($title)): ?>
											
											<?php if (class_exists('FSD_Core')): ?>
												
												<h6 class="post-title body-5">
													
													<a href="<?php the_permalink(); ?>">
														
														<?php echo esc_html(wp_trim_words($title, 10, '...')); ?>
													
													</a>
												
												</h6>
											
											<?php else: ?>
												
												<h4 class="post-title-default">
													
													<a href="<?php the_permalink(); ?>">
														
														<?php echo esc_html(wp_trim_words($title, 10, '...')); ?>
													
													</a>
												
												</h4>
											
											<?php endif; ?>
										
										<?php endif; ?>
									
									</div>
								
								</div>
							
							</article>
						
						<?php
						
						endwhile;
						
						else:
						
						endif;
						
						?>
					
					</div>
					
					<?php
					
					/* check max num pages */
					if ($wp_query->max_num_pages > 1):
						
						?>
						
						<!-- pagination wrapper -->
						<div class="pagination-wrapper <?php echo esc_attr('pagination-' . $pagination_style); ?>">
							
							<?php
							
							/* if pagination style == default */
							if ($pagination_style === 'default'):
								
								/* paginate links */
								echo paginate_links([
										'current' => $paged,
										'prev_text' => '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/right-pagination-arrow.svg') . '"
                             alt="' . esc_attr__('Next', 'levre') . '" class="next-arrow">',
										'next_text' => '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/right-pagination-arrow.svg') . '"
                             alt="' . esc_attr__('Next', 'levre') . '" class="next-arrow">',
										'type' => 'list',
										'end_size' => 1,
										'mid_size' => 5,
								]);
							
							/* if pagination style == load-more */
							elseif ($pagination_style === 'load-more'): ?>
								
								<!-- load more button -->
								<p class="load-more-button fs-button dark-border-style">
									
									<?php echo esc_html__('Load More', 'levre'); ?>
								
								</p>
							
							<?php endif; ?>
						
						</div>
					
					<?php endif; ?>
				
				</div>
			
			</div>
		
		</div>
	
	</div>

<?php else: ?>
	
	<div class="blog-list-wrapper">
		
		<div class="inner-wrapper container <?php if (is_active_sidebar('blog-sidebar')): ?>sidebar-enabled<?php endif; ?>">
			
			<div class="blog-list   <?php if (is_active_sidebar('blog-sidebar')): ?> sidebar-enabled <?php endif; ?>">
				
				<?php
				
				if (have_posts()) :
					
					while (have_posts()) :the_post();
						
						if (get_the_ID() !== $sticky_id):
							
							$category = get_the_category();
							
							$date = get_the_date();
							
							$title = get_the_title();
							
							$excerpt = get_the_excerpt();
							
							?>
							
							<article <?php post_class('post-article blog-list-item'); ?>>
								
								<div class="post-inner">
									
									<ul class="meta-list">
										
										<?php if (!empty($category)): ?>
											
											<li class="category-item meta-item">
												
												<a href="<?php echo esc_url(get_term_link($category[0]->term_id)); ?>"
												   class="category-link">
													
													<?php echo esc_html($category[0]->name); ?>
												
												</a>
											
											</li>
										
										<?php endif; ?>
										
										<li class="meta-item date-item">
											
											<?php echo esc_html($date); ?>
										
										</li>
									
									</ul>
									
									<div class="title-wrapper">
										
										<h1 class="title">
											
											<a href="<?php the_permalink(); ?>">
												
												<?php echo esc_html(wp_trim_words($title, 10, '...')); ?>
											
											</a>
										
										</h1>
									
									</div>
									
									<div class="excerpt-wrapper">
										
										<p class="excerpt body-6">
											
											<?php echo esc_html(wp_trim_words($excerpt, 30, '...')); ?>
										
										</p>
									
									</div>
									
									<a href="<?php the_permalink(); ?>"
									   class="read-more-button fs-button dark-border-style">
										
										<?php echo esc_html__('Read More', 'levre'); ?>
									
									</a>
								
								</div>
							
							</article>
						
						<?php
						
						endif;
					
					endwhile;
				
				endif;
				
				?>
			
			</div>
			
			<?php if (is_active_sidebar('blog-sidebar')): ?>
				
				<div class="sidebar-wrapper">
					
					<?php dynamic_sidebar('blog-sidebar'); ?>
				
				</div>
			
			<?php endif; ?>
		
		</div>
		
		<div class="container pagination-wrapper">
			
			<?php
			
			/* check max num pages */
			if ($wp_query->max_num_pages > 1):
				
				?>
				
				<!-- pagination wrapper -->
				<div class="pagination-wrapper <?php echo esc_attr('pagination-' . $pagination_style); ?>">
					
					<?php
					
					/* if pagination style == default */
					if ($pagination_style === 'default'):
						
						/* paginate links */
						echo paginate_links([
								'current' => $paged,
								'prev_text' => '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/right-pagination-arrow.svg') . '"
                             alt="' . esc_attr__('Next', 'levre') . '" class="next-arrow">',
								'next_text' => '<img src="' . esc_url(get_template_directory_uri() . '/assets/img/right-pagination-arrow.svg') . '"
                             alt="' . esc_attr__('Next', 'levre') . '" class="next-arrow">',
								'type' => 'list',
								'end_size' => 1,
								'mid_size' => 5,
						]);
					
					/* if pagination style == load-more */
					elseif ($pagination_style === 'load-more'): ?>
						
						<!-- load more button -->
						<p class="load-more-button fs-button dark-border-style">
							
							<?php echo esc_html__('Load More', 'levre'); ?>
						
						</p>
					
					<?php endif; ?>
				
				</div>
			
			<?php endif; ?>
		
		</div>
	
	</div>

<?php endif; ?>

<?php wp_reset_postdata(); ?>