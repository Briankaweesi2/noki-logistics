<?php
/**
 * Blog page template — guarantees the /blog page lists all published posts
 * with reliable pagination even when WordPress is configured with a static page.
 */
get_header();

$paged = max( 1, get_query_var( 'paged' ), get_query_var( 'page' ) );
$blog_query = new WP_Query( [
	'post_type'           => 'post',
	'post_status'         => 'publish',
	'posts_per_page'      => 12,
	'paged'               => $paged,
	'ignore_sticky_posts' => false,
] );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Insights</span>
		<h1>Logistics Blog</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; Blog</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<?php if ( $blog_query->have_posts() ) : ?>
			<div class="blog-grid">
				<?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
					<article class="blog-card" data-aos="fade-up">
						<a href="<?php the_permalink(); ?>" class="blog-thumb">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'noki-blog', [ 'alt' => get_the_title(), 'loading' => 'lazy' ] ); ?>
							<?php else : ?>
								<div class="ph"><i class="fas fa-newspaper"></i></div>
							<?php endif; ?>
						</a>
						<div class="blog-body">
							<?php $cat = get_the_category(); ?>
							<span class="blog-tag"><?php echo $cat ? esc_html( $cat[0]->name ) : 'Logistics'; ?></span>
							<div class="blog-meta"><?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( get_the_author() ); ?></div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 24 ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="link-arrow">Read article <i class="fas fa-arrow-right"></i></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<nav class="pagination navigation" aria-label="Blog pagination">
				<div class="nav-links">
					<?php echo wp_kses_post( paginate_links( [
						'total'     => $blog_query->max_num_pages,
						'current'   => $paged,
						'mid_size'  => 2,
						'prev_text' => '<i class="fas fa-arrow-left"></i> Previous',
						'next_text' => 'Next <i class="fas fa-arrow-right"></i>',
					] ) ); ?>
				</div>
			</nav>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<div class="blog-empty-state">
				<i class="fas fa-pen-nib"></i>
				<h3>No posts yet</h3>
				<p>Check back soon — we're working on more logistics insights.</p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer();