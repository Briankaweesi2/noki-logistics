<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$phone     = get_theme_mod( 'noki_phone', '+256 200 946 366' );
$whatsapp  = get_theme_mod( 'noki_whatsapp', '+256772540483' );
$email     = get_theme_mod( 'noki_email', 'info@nokilogistics.com' );
$hours     = get_theme_mod( 'noki_hours', 'Mon – Sat: 8:00am – 6:30pm' );
$wa_clean  = preg_replace( '/[^0-9]/', '', $whatsapp );
$tel_clean = preg_replace( '/\s+/', '', $phone );

$socials = [
	'noki_facebook'  => 'fa-facebook-f',
	'noki_twitter'   => 'fa-x-twitter',
	'noki_linkedin'  => 'fa-linkedin-in',
	'noki_instagram' => 'fa-instagram',
	'noki_tiktok'    => 'fa-tiktok',
	'noki_youtube'   => 'fa-youtube',
];

// Services used to build the mega-menu (falls back to defaults before any are added).
$mega_services = noki_get_services( 6 );
$mega_defaults = [
	[ 'fa-plane',     'Air Freight',      'services' ],
	[ 'fa-ship',      'Sea Freight',      'services' ],
	[ 'fa-truck',     'Road Transport',   'services' ],
	[ 'fa-box-open',  'Customs Clearing', 'services' ],
	[ 'fa-warehouse', 'Warehousing',      'services' ],
	[ 'fa-bolt',      'Express Delivery', 'services' ],
];
?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'noki-logistics' ); ?></a>

<!-- Top Bar -->
<div class="top-bar">
	<div class="container">
		<div class="top-bar-left">
			<span class="hide-sm"><i class="fas fa-clock"></i> <?php echo esc_html( $hours ); ?></span>
			<a href="tel:<?php echo esc_attr( $tel_clean ); ?>"><i class="fas fa-phone"></i> <?php echo esc_html( $phone ); ?></a>
			<a href="https://wa.me/<?php echo esc_attr( $wa_clean ); ?>" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i> <?php esc_html_e( 'WhatsApp', 'noki-logistics' ); ?></a>
		</div>
		<div class="top-bar-right">
			<a class="hide-sm" href="mailto:<?php echo esc_attr( $email ); ?>"><i class="fas fa-envelope"></i> <?php echo esc_html( $email ); ?></a>
			<div class="top-bar-social">
				<?php foreach ( $socials as $mod => $icon ) :
					$url = get_theme_mod( $mod );
					if ( $url ) : ?>
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener"><i class="fab <?php echo esc_attr( $icon ); ?>"></i></a>
					<?php endif;
				endforeach; ?>
			</div>
		</div>
	</div>
</div>

<!-- Header -->
<header class="site-header" id="site-header">
	<div class="container">
		<div class="header-inner">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php bloginfo( 'name' ); ?> — home">
				<?php if ( has_custom_logo() ) : the_custom_logo(); else : ?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/images/noki-logo.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
				<?php endif; ?>
			</a>

			<nav class="primary-nav" id="primary-nav" aria-label="Primary">
				<?php if ( false ) : // coded nav forced (ignore DB menu) ?>
					<?php wp_nav_menu( [ 'theme_location' => 'primary', 'container' => false ] ); ?>
				<?php else : ?>
				<ul>
										<li class="has-mega">
						<a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><?php esc_html_e( 'Who We Are', 'noki-logistics' ); ?></a>
						<div class="mega">
							<div class="mega-feature">
								<span class="kicker"><?php esc_html_e( 'About Noki', 'noki-logistics' ); ?></span>
								<h4><?php esc_html_e( 'A logistics partner you can count on', 'noki-logistics' ); ?></h4>
								<p><?php esc_html_e( '10+ years moving cargo across East Africa with reliability, transparency and care.', 'noki-logistics' ); ?></p>
								<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="link-arrow" style="color:#ff7a45"><?php esc_html_e( 'Our story', 'noki-logistics' ); ?> <i class="fas fa-arrow-right"></i></a>
							</div>
							<div class="mega-col">
								<h5><?php esc_html_e( 'Company', 'noki-logistics' ); ?></h5>
								<a class="mega-link" href="<?php echo esc_url( home_url( '/why-choose-us' ) ); ?>"><i class="fas fa-circle-check"></i><span><strong><?php esc_html_e( 'Why Choose Us', 'noki-logistics' ); ?></strong><?php esc_html_e( 'What sets us apart', 'noki-logistics' ); ?></span></a>
								<a class="mega-link" href="<?php echo esc_url( home_url( '/our-team' ) ); ?>"><i class="fas fa-users"></i><span><strong><?php esc_html_e( 'Our Team', 'noki-logistics' ); ?></strong><?php esc_html_e( 'The people behind Noki', 'noki-logistics' ); ?></span></a>
								<a class="mega-link" href="<?php echo esc_url( home_url( '/join-us' ) ); ?>"><i class="fas fa-briefcase"></i><span><strong><?php esc_html_e( 'Join Us', 'noki-logistics' ); ?></strong><?php esc_html_e( 'Careers & openings', 'noki-logistics' ); ?></span></a>
							</div>
							<div class="mega-col">
								<h5><?php esc_html_e( 'Resources', 'noki-logistics' ); ?></h5>
								<a class="mega-link" href="<?php echo esc_url( home_url( '/pricing' ) ); ?>"><i class="fas fa-tags"></i><span><strong><?php esc_html_e( 'Pricing', 'noki-logistics' ); ?></strong><?php esc_html_e( 'Clear, fair rates', 'noki-logistics' ); ?></span></a>
								<a class="mega-link" href="<?php echo esc_url( home_url( '/testimonials' ) ); ?>"><i class="fas fa-star"></i><span><strong><?php esc_html_e( 'Testimonials', 'noki-logistics' ); ?></strong><?php esc_html_e( 'What clients say', 'noki-logistics' ); ?></span></a>
								<a class="mega-link" href="<?php echo esc_url( home_url( '/faq' ) ); ?>"><i class="fas fa-circle-question"></i><span><strong><?php esc_html_e( 'FAQ', 'noki-logistics' ); ?></strong><?php esc_html_e( 'Common questions', 'noki-logistics' ); ?></span></a>
							</div>
						</div>
					</li>
					<li class="has-mega">
						<a href="<?php echo esc_url( home_url( '/services' ) ); ?>"><?php esc_html_e( 'Services', 'noki-logistics' ); ?></a>
						<div class="mega">
							<div class="mega-feature">
								<span class="kicker">Noki Logistics</span>
								<h4><?php esc_html_e( 'End-to-end supply chain, handled with precision', 'noki-logistics' ); ?></h4>
								<p><?php esc_html_e( 'Air, sea and road freight plus customs and warehousing — one trusted partner across East Africa.', 'noki-logistics' ); ?></p>
								<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="link-arrow" style="color:#ff7a45"><?php esc_html_e( 'Get a quote', 'noki-logistics' ); ?> <i class="fas fa-arrow-right"></i></a>
							</div>
							<div class="mega-col">
								<h5><?php esc_html_e( 'Freight', 'noki-logistics' ); ?></h5>
								<?php
								$col1 = $mega_services ? array_slice( $mega_services, 0, 3 ) : array_slice( $mega_defaults, 0, 3 );
								foreach ( $col1 as $s ) :
									if ( is_object( $s ) ) {
										$icon = get_post_meta( $s->ID, '_service_icon', true ) ?: 'fa-truck';
										$title = noki_service_short_label( $s );
										$link = get_permalink( $s );
										$desc = wp_trim_words( wp_strip_all_tags( $s->post_content ), 6 );
									} else {
										[ $icon, $title, $slug ] = $s; $link = home_url( '/' . $slug ); $desc = __( 'Reliable & insured', 'noki-logistics' );
									} ?>
									<a class="mega-link" href="<?php echo esc_url( $link ); ?>">
										<i class="fas <?php echo esc_attr( $icon ); ?>"></i>
										<span><strong><?php echo esc_html( $title ); ?></strong><?php echo esc_html( $desc ); ?></span>
									</a>
								<?php endforeach; ?>
							</div>
							<div class="mega-col">
								<h5><?php esc_html_e( 'Logistics', 'noki-logistics' ); ?></h5>
								<?php
								$col2 = $mega_services ? array_slice( $mega_services, 3, 3 ) : array_slice( $mega_defaults, 3, 3 );
								foreach ( $col2 as $s ) :
									if ( is_object( $s ) ) {
										$icon = get_post_meta( $s->ID, '_service_icon', true ) ?: 'fa-box-open';
										$title = noki_service_short_label( $s );
										$link = get_permalink( $s );
										$desc = wp_trim_words( wp_strip_all_tags( $s->post_content ), 6 );
									} else {
										[ $icon, $title, $slug ] = $s; $link = home_url( '/' . $slug ); $desc = __( 'Fast & secure', 'noki-logistics' );
									} ?>
									<a class="mega-link" href="<?php echo esc_url( $link ); ?>">
										<i class="fas <?php echo esc_attr( $icon ); ?>"></i>
										<span><strong><?php echo esc_html( $title ); ?></strong><?php echo esc_html( $desc ); ?></span>
									</a>
								<?php endforeach; ?>
							</div>
						</div>
					</li>
															<li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><?php esc_html_e( 'Contact', 'noki-logistics' ); ?></a></li>
				</ul>
				<?php endif; ?>
			</nav>

			<div class="header-actions">
				<?php noki_language_switcher(); ?>
				<a href="tel:<?php echo esc_attr( $tel_clean ); ?>" class="header-phone">
					<i class="fas fa-phone"></i>
					<span><small><?php esc_html_e( 'Call us anytime', 'noki-logistics' ); ?></small><?php echo esc_html( $phone ); ?></span>
				</a>
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary"><?php esc_html_e( 'Get a Quote', 'noki-logistics' ); ?> <i class="fas fa-arrow-right"></i></a>
				<button class="menu-toggle" id="menu-toggle" aria-label="<?php esc_attr_e( 'Toggle navigation', 'noki-logistics' ); ?>" aria-expanded="false">
					<span></span><span></span><span></span>
				</button>
			</div>
		</div>
	</div>
</header>
<div class="nav-overlay" id="nav-overlay"></div>

<!-- WhatsApp Float -->
<a class="wa-float" href="https://wa.me/<?php echo esc_attr( $wa_clean ); ?>" target="_blank" rel="noopener" title="<?php esc_attr_e( 'Chat on WhatsApp', 'noki-logistics' ); ?>" aria-label="<?php esc_attr_e( 'Chat on WhatsApp', 'noki-logistics' ); ?>">
	<i class="fab fa-whatsapp"></i>
</a>

<main id="main">
