<?php get_header(); the_post(); ?>

<div class="page-banner">
	<div class="container">
		<?php $cat = get_the_category(); if ( $cat ) : ?><span class="kicker"><?php echo esc_html( $cat[0]->name ); ?></span><?php endif; ?>
		<h1><?php the_title(); ?></h1>
		<p class="breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo;
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ?: home_url( '/blog' ) ); ?>">Blog</a> &rsaquo;
			<?php the_title(); ?>
		</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="content-grid">

			<main>
				<div class="post-meta">
					<span><i class="fas fa-calendar"></i> <?php echo esc_html( get_the_date() ); ?></span>
					<span><i class="fas fa-user"></i> <?php the_author(); ?></span>
				</div>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-thumb"><?php the_post_thumbnail( 'noki-hero', [ 'alt' => get_the_title() ] ); ?></div>
				<?php endif; ?>

				<div class="post-content"><?php the_content(); ?></div>

				<?php echo noki_social_share( get_permalink(), get_the_title() ); ?>

				<div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:2.5rem;">
					<?php $prev = get_previous_post(); $next = get_next_post();
					if ( $prev ) : ?>
						<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" style="background:var(--bg-soft);padding:1.25rem;border-radius:var(--radius);display:block;border:1px solid var(--line);">
							<span style="font-size:.75rem;color:var(--muted);display:block;margin-bottom:.25rem;">← Previous</span>
							<strong style="font-size:.92rem;color:var(--ink);font-family:var(--font-head);"><?php echo esc_html( get_the_title( $prev ) ); ?></strong>
						</a>
					<?php endif;
					if ( $next ) : ?>
						<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" style="background:var(--bg-soft);padding:1.25rem;border-radius:var(--radius);display:block;text-align:right;border:1px solid var(--line);">
							<span style="font-size:.75rem;color:var(--muted);display:block;margin-bottom:.25rem;">Next →</span>
							<strong style="font-size:.92rem;color:var(--ink);font-family:var(--font-head);"><?php echo esc_html( get_the_title( $next ) ); ?></strong>
						</a>
					<?php endif; ?>
				</div>
			</main>

			<aside class="sidebar">
				<?php if ( is_active_sidebar( 'blog-sidebar' ) ) :
					dynamic_sidebar( 'blog-sidebar' );
				else : ?>
					<div class="sidebar-widget">
						<h4>Recent articles</h4>
						<?php $recent = get_posts( [ 'posts_per_page' => 5, 'post__not_in' => [ get_the_ID() ] ] );
						foreach ( $recent as $rp ) : ?>
							<a href="<?php echo esc_url( get_permalink( $rp ) ); ?>" style="display:flex;gap:.75rem;align-items:center;padding:.65rem 0;border-bottom:1px solid var(--line);">
								<?php if ( has_post_thumbnail( $rp->ID ) ) : ?>
									<img src="<?php echo esc_url( get_the_post_thumbnail_url( $rp->ID, 'thumbnail' ) ); ?>" style="width:56px;height:44px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="">
								<?php endif; ?>
								<span style="font-size:.88rem;font-weight:600;line-height:1.35;color:var(--ink);font-family:var(--font-head);"><?php echo esc_html( $rp->post_title ); ?></span>
							</a>
						<?php endforeach; ?>
					</div>
					<div class="sidebar-widget sidebar-cta">
						<h4>Need a quote?</h4>
						<p>Get a free logistics quote within 2 hours.</p>
						<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-white btn-sm" style="width:100%;margin-top:.5rem;">Request Quote</a>
					</div>
				<?php endif; ?>
			</aside>
		</div>
	</div>
</section>

<?php get_footer(); ?>
