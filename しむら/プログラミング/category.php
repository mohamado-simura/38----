<?php get_header(); ?>

<style>
.pagination {
	margin: 30px 0;
	text-align: center;
}

.pagination-prev,
.pagination-next {
	margin: 10px 0;
}

.pagination-prev a,
.pagination-next a {
	display: inline-block;
	padding: 8px 14px;
	border: 1px solid #ccc;
	text-decoration: none;
}

.pagination-numbers ul {
	list-style: none;
	margin: 15px 0;
	padding: 0;
	display: inline-flex;
	gap: 8px;
}

.pagination-numbers li {
	display: inline-block;
}

.pagination-numbers a,
.pagination-numbers span {
	display: inline-block;
	padding: 8px 12px;
	border: 1px solid #ccc;
	text-decoration: none;
	line-height: 1;
}

.pagination-numbers .current {
	font-weight: bold;
	background: #f5f5f5;
}
</style> 

<div id="wrapper" class="clearfix">

	<div id="content" class="subpage blog clearfix">

		<?php if (function_exists('yoast_breadcrumb')) : ?>
			<?php yoast_breadcrumb('<p id="breadcrumbs">', '</p>'); ?>
		<?php endif; ?>

		<h1>最新情報<span>-<?php single_cat_title(); ?>-</span></h1>

		<div id="contentBlog">

			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>

					<section>
						<article class="clearfix">

							<div class="blogThumbnail">
								<a href="<?php the_permalink(); ?>">
									<?php if (function_exists('catch_that_image')) : ?>
										<img class="DB" src="<?php echo esc_url(catch_that_image()); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
									<?php else : ?>
										<img class="DB" src="<?php echo esc_url(get_template_directory_uri() . '/images/common/no-thumb.png'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
									<?php endif; ?>
								</a>
							</div>

							<div class="blogTextarea clearfix">
								<div class="clearfix">
									<time datetime="<?php echo esc_attr(get_the_date('Y-m-d')); ?>">
										<?php echo esc_html(get_the_date('Y年m月d日(D)')); ?>
									</time>
									<?php the_category(', '); ?>
								</div>

								<h2>
									<a href="<?php the_permalink(); ?>">
										<?php the_title(); ?>
									</a>
								</h2>

								<p><?php the_excerpt(); ?></p>
							</div>

						</article>
					</section>

				<?php endwhile; ?>

				<div class="pagination">

					<div class="pagination-prev">
						<?php previous_posts_link('&laquo; Newer news'); ?>
					</div>

					<div class="pagination-numbers">
						<?php
						global $wp_query;

						$big = 999999999;

						echo paginate_links(array(
							'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
							'format'    => '?paged=%#%',
							'current'   => max(1, get_query_var('paged')),
							'total'     => $wp_query->max_num_pages,
							'mid_size'  => 2,
							'prev_next' => false,
							'type'      => 'list',
						));
						?>
					</div>

					<div class="pagination-next">
						<?php next_posts_link('Older news &raquo;'); ?>
					</div>

				</div>

			<?php else : ?>
				<p>投稿がありません。</p>
			<?php endif; ?>

		</div>

		<?php get_sidebar(1); ?>

	</div>

</div>

<?php get_footer(); ?>