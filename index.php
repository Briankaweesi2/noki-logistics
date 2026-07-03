<?php
// Fallback — front-page.php handles the homepage; archive.php handles archives.
// This file is required by WordPress but rarely rendered directly.
get_header(); ?>
<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="blog-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="blog-card">
						<a href="<?php the_permalink(); ?>" class="blog-thumb">
							<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'noki-blog', [ 'alt' => get_the_title() ] ); else : ?>
								<div class="ph"><i class="fas fa-newspaper"></i></div>
							<?php endif; ?>
						</a>
						<div class="blog-body">
							<div class="blog-meta"><?php echo esc_html( get_the_date() ); ?></div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 18 ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="link-arrow">Read article <i class="fas fa-arrow-right"></i></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<p style="text-align:center;color:var(--muted);">Nothing here yet.</p>
		<?php endif; ?>
	</div>
</section>
<?php get_footer(); ?>
