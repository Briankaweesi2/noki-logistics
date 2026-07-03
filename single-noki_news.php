<?php get_header(); the_post();
$news_url = get_post_type_archive_link( 'noki_news' ) ?: home_url( '/news' );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker"><?php echo esc_html( noki_news_type( get_the_ID() ) ); ?></span>
		<h1><?php the_title(); ?></h1>
		<p class="breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo;
			<a href="<?php echo esc_url( $news_url ); ?>">News &amp; Events</a> &rsaquo;
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
					<span><i class="fas fa-tag"></i> <?php echo esc_html( noki_news_type( get_the_ID() ) ); ?></span>
				</div>

				<?php if ( has_post_thumbnail() ) : ?>
					<div class="post-thumb"><?php the_post_thumbnail( 'noki-hero', [ 'alt' => get_the_title() ] ); ?></div>
				<?php endif; ?>

				<div class="post-content"><?php the_content(); ?></div>

				<?php echo noki_social_share( get_permalink(), get_the_title() ); ?>

				<div style="margin-top:2.5rem">
					<a href="<?php echo esc_url( $news_url ); ?>" class="btn btn-ghost"><i class="fas fa-arrow-left"></i> Back to News &amp; Events</a>
				</div>
			</main>

			<aside class="sidebar">
				<div class="sidebar-widget">
					<h4>Latest news</h4>
					<?php
					$recent = get_posts( [ 'post_type' => 'noki_news', 'posts_per_page' => 5, 'post__not_in' => [ get_the_ID() ] ] );
					if ( $recent ) : foreach ( $recent as $rp ) : ?>
						<a href="<?php echo esc_url( get_permalink( $rp ) ); ?>" style="display:flex;gap:.75rem;align-items:center;padding:.65rem 0;border-bottom:1px solid var(--line);">
							<?php if ( has_post_thumbnail( $rp->ID ) ) : ?>
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( $rp->ID, 'thumbnail' ) ); ?>" style="width:56px;height:44px;object-fit:cover;border-radius:8px;flex-shrink:0;" alt="">
							<?php endif; ?>
							<span style="font-size:.88rem;font-weight:600;line-height:1.35;color:var(--ink);font-family:var(--font-head);"><?php echo esc_html( $rp->post_title ); ?></span>
						</a>
					<?php endforeach; else : ?>
						<p style="color:var(--muted);font-size:.9rem;">More news coming soon.</p>
					<?php endif; ?>
				</div>
				<div class="sidebar-widget sidebar-cta">
					<h4>Need to ship something?</h4>
					<p>Get a free quote within 2 hours — by air, sea or road.</p>
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-white btn-sm" style="width:100%;margin-top:.5rem;">Get a Quote</a>
				</div>
			</aside>
		</div>
	</div>
</section>

<?php get_footer(); ?>
