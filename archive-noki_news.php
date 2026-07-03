<?php get_header(); ?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Stay in the loop</span>
		<h1>News &amp; Events</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; News &amp; Events</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<?php if ( have_posts() ) : ?>
			<div class="blog-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<article class="blog-card" data-aos="fade-up">
						<a href="<?php the_permalink(); ?>" class="blog-thumb">
							<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'noki-blog', [ 'alt' => get_the_title() ] ); else : ?>
								<div class="ph"><i class="fas fa-bullhorn"></i></div>
							<?php endif; ?>
						</a>
						<div class="blog-body">
							<span class="blog-tag"><?php echo esc_html( noki_news_type( get_the_ID() ) ); ?></span>
							<div class="blog-meta"><i class="far fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?></div>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="link-arrow">Read more <i class="fas fa-arrow-right"></i></a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>

			<?php the_posts_pagination( [ 'prev_text' => '<i class="fas fa-arrow-left"></i>', 'next_text' => '<i class="fas fa-arrow-right"></i>' ] ); ?>
		<?php else : ?>
			<div style="text-align:center;padding:4rem 0;">
				<i class="fas fa-bullhorn" style="font-size:3rem;color:var(--line);margin-bottom:1rem;display:block;"></i>
				<h3>No news yet</h3>
				<p style="color:var(--muted);">Check back soon for company news and upcoming events.</p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
