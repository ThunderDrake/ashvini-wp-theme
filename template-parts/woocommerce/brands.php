<?php defined('ABSPATH') || exit;

$terms = get_terms("brands");

$alphas = range('a', 'z');

?>

<div class="brands-main-archive-wrapper">
	
	<div class="brands-header">
		
		<div class="container">
			
			<ul class="letters-list">
				
				<li class="letter-item" data-letter="#">
					
					<a href="#">
						
						<?php echo esc_html('#'); ?>
					
					</a>
				
				</li>
				
				<?php
				
				foreach ($alphas as $letter):
					
					?>
					
					<li class="letter-item" data-letter="<?php echo esc_attr($letter); ?>">
						
						<a href="#<?php echo esc_attr($letter); ?>">
							
							<?php echo esc_html(strtoupper($letter)); ?>
						
						</a>
					
					</li>
				
				<?php
				
				endforeach;
				
				?>
			
			</ul>
		
		</div>
	
	</div>
	
	<?php if (!empty($terms)): ?>
		
		<div class="brands-body">
			
			<div class="container">
				
				<ul class="brands-list">
					
					<li class="brand-item" data-letter="#" id="#">
						
						<h2 class="letter-title">
							
							<?php echo esc_html('#'); ?>
						
						</h2>
						
						<ul class="brands-children-list">
							
							<?php foreach ($terms as $term): ?>
								
								<?php
								
								$first_letter = strtolower($term->name[0]);
								
								if (!in_array($first_letter, $alphas)):
									
									?>
									
									<li class="term-item">
										
										<a href="<?php echo esc_url(get_term_link($term->term_id)); ?>">
											
											<?php echo esc_html($term->name); ?>
										
										</a>
									
									</li>
								
								<?php endif; ?>
							
							<?php endforeach; ?>
						
						</ul>
					
					</li>
					
					<?php foreach ($alphas as $letter):
						
						$check = false;
						
						foreach ($terms as $term): ?>
							
							<?php
							
							$first_letter = strtolower($term->name[0]);
							
							if ($first_letter === $letter):
								
								$check = true;
							
							endif;
						
						endforeach;
						
						if ($check):
							
							?>
							
							<li class="brand-item" data-letter="<?php echo esc_attr($letter); ?>"
							    id="<?php echo esc_attr($letter); ?>">
								
								<h2 class="letter-title">
									
									<?php echo esc_html(strtoupper($letter)); ?>
								
								</h2>
								
								<ul class="brands-children-list">
									
									<?php foreach ($terms as $term): ?>
										
										<?php
										
										$first_letter = strtolower($term->name[0]);
										
										if ($first_letter === $letter):
											
											?>
											
											<li class="term-item">
												
												<a href="<?php echo esc_url(get_term_link($term->term_id)); ?>">
													
													<?php echo esc_html($term->name); ?>
												
												</a>
											
											</li>
										
										<?php endif; ?>
									
									<?php endforeach; ?>
								
								</ul>
							
							</li>
						
						<?php
						
						endif;
					
					endforeach;
					
					?>
				
				</ul>
			
			</div>
		
		</div>
	
	<?php endif; ?>

</div>