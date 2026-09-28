<?php
// Fallback — front-page.php handles the homepage; archive.php handles archives.
// This file is required by WordPress but rarely rendered directly.
get_header(); ?>
<div class="page-banner">
	<div class="container">
		<span class="kicker">Insights</span>
		<h1>Logistics Blog</h1>
		<p>Practical freight, customs, warehousing and cross-border logistics guidance for businesses in Uganda and East Africa.</p>
	</div>
</div>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="blog-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="blog-card">
						<a href="<?php the_permalink(); ?>" class="blog-thumb">
							<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'noki-blog', [ 'alt' => get_the_title(), 'loading' => 'lazy' ] ); else : ?>
								<img src="<?php echo esc_url( noki_blog_fallback_img( get_the_ID() ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy">
							<?php endif; ?>
						</a>
						<div class="blog-body">
							<?php $cat = get_the_category(); ?>
							<span class="blog-tag"><?php echo $cat ? esc_html( $cat[0]->name ) : 'Logistics'; ?></span>
							<div class="blog-meta"><?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( get_the_author() ); ?></div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="link-arrow">Read article <i class="fas fa-arrow-right"></i></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php the_posts_pagination( [
				'mid_size'  => 2,
				'prev_text' => '<i class="fas fa-arrow-left"></i> Previous',
				'next_text' => 'Next <i class="fas fa-arrow-right"></i>',
			] ); ?>
		<?php else : ?>
			<p style="text-align:center;color:var(--muted);">Nothing here yet.</p>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
