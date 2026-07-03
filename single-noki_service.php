<?php get_header(); the_post();
$phone    = get_theme_mod( 'noki_phone', '+256 772 540 483' );
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'noki_whatsapp', '+256772540483' ) );
$tel      = preg_replace( '/\s+/', '', $phone );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Service</span>
		<h1><?php the_title(); ?></h1>
		<p class="breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo;
			<a href="<?php echo esc_url( home_url( '/services' ) ); ?>">Services</a> &rsaquo;
			<?php the_title(); ?>
		</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="content-grid">

			<main>
				<div class="post-thumb"><img src="<?php echo esc_url( noki_service_img( get_the_ID(), 'noki-hero' ) ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>"></div>

				<div class="post-content"><?php the_content(); ?></div>

				<?php
				$features = get_post_meta( get_the_ID(), '_service_features', true );
				$feat_arr = $features ? array_filter( array_map( 'trim', explode( "\n", $features ) ) ) : [];
				if ( $feat_arr ) : ?>
					<div style="background:var(--bg-soft);border:1px solid var(--line);border-radius:var(--radius-lg);padding:2rem;margin-top:2rem;">
						<h3 style="margin-bottom:1.2rem;">Key features</h3>
						<ul class="check-list" style="margin:0;">
							<?php foreach ( $feat_arr as $feat ) : ?>
								<li><i class="fas fa-check"></i><div><strong><?php echo esc_html( $feat ); ?></strong></div></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endif; ?>

				<div class="cta-band" style="margin-top:2.5rem;padding:2.5rem;">
					<h2 style="font-size:1.8rem;">Need this service?</h2>
					<p>Get a free, detailed quote within 2 hours.</p>
					<div class="cta-actions">
						<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-white">Request a Quote <i class="fas fa-arrow-right"></i></a>
					</div>
				</div>
			</main>

			<aside class="sidebar">
				<div class="sidebar-widget">
					<h4>All services</h4>
					<?php $all_services = noki_get_services();
					if ( $all_services ) : foreach ( $all_services as $svc ) : ?>
						<a href="<?php echo esc_url( get_permalink( $svc ) ); ?>" style="display:flex;justify-content:space-between;align-items:center;padding:.7rem 0;border-bottom:1px solid var(--line);font-family:var(--font-head);font-weight:600;font-size:.92rem;<?php echo get_the_ID() === $svc->ID ? 'color:var(--primary);' : 'color:var(--ink);'; ?>">
							<?php echo esc_html( $svc->post_title ); ?> <i class="fas fa-chevron-right" style="font-size:.7rem;"></i>
						</a>
					<?php endforeach; endif; ?>
				</div>
				<div class="sidebar-widget sidebar-cta">
					<h4>Get a free quote</h4>
					<p>Tell us about your shipment and we'll send a detailed quote within 2 hours.</p>
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-white btn-sm" style="width:100%;margin-top:.5rem;">Request Quote</a>
				</div>
				<div class="sidebar-widget">
					<h4>Talk to us</h4>
					<p style="margin-bottom:.8rem;"><i class="fas fa-phone" style="color:var(--primary);margin-right:.5rem;"></i><a href="tel:<?php echo esc_attr( $tel ); ?>" style="color:var(--ink);font-weight:600;"><?php echo esc_html( $phone ); ?></a></p>
					<p><i class="fab fa-whatsapp" style="color:var(--primary);margin-right:.5rem;"></i><a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" style="color:var(--ink);font-weight:600;">WhatsApp Chat</a></p>
				</div>
			</aside>
		</div>
	</div>
</section>

<?php get_footer(); ?>
