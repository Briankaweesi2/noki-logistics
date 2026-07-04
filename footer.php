<?php
$phone    = get_theme_mod( 'noki_phone', '+256 772 540 483' );
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'noki_whatsapp', '+256772540483' ) );
$email    = get_theme_mod( 'noki_email', 'info@nokilogistics.com' );
$address  = get_theme_mod( 'noki_address', 'Plot No. 53/55 Semawata Road, Elgon Rise, Ntinda, Kampala' );
$tel      = preg_replace( '/\s+/', '', $phone );

// Five brand icons, always shown. Links come from Appearance → Customize → Noki Theme Options.
$socials = [
	'noki_facebook'  => [ 'fa-brands fa-facebook-f', 'Facebook' ],
	'noki_twitter'   => [ 'fa-brands fa-x-twitter', 'X (Twitter)' ],
	'noki_instagram' => [ 'fa-brands fa-instagram', 'Instagram' ],
	'noki_tiktok'    => [ 'fa-brands fa-tiktok', 'TikTok' ],
	'noki_linkedin'  => [ 'fa-brands fa-linkedin-in', 'LinkedIn' ],
];
?>
</main><!-- #main -->

<footer class="site-footer">
	<div class="container">
		<div class="footer-top">

			<div class="footer-brand footer-col">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo" aria-label="<?php bloginfo( 'name' ); ?> — home">
					<img src="<?php echo esc_url( get_template_directory_uri() . '/images/noki-logo-white.svg' ); ?>" alt="<?php bloginfo( 'name' ); ?>">
				</a>
				<p>Your trusted partner for efficient, reliable freight and supply-chain solutions across Uganda and East Africa. Air, sea and road — delivered with speed and care.</p>
				<div class="footer-social">
					<?php foreach ( $socials as $mod => $d ) :
						$url = get_theme_mod( $mod );
						?>
						<a href="<?php echo $url ? esc_url( $url ) : '#'; ?>"<?php echo $url ? ' target="_blank" rel="noopener"' : ''; ?> aria-label="<?php echo esc_attr( $d[1] ); ?>"><i class="<?php echo esc_attr( $d[0] ); ?>"></i></a>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="footer-col">
				<h4>Company</h4>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/about' ) ); ?>"><i class="fas fa-angle-right"></i> About Us</a></li>
					<li><a href="<?php echo esc_url( home_url( '/why-choose-us' ) ); ?>"><i class="fas fa-angle-right"></i> Why Choose Us</a></li>
					<li><a href="<?php echo esc_url( home_url( '/pricing' ) ); ?>"><i class="fas fa-angle-right"></i> Pricing</a></li>
					<li><a href="<?php echo esc_url( home_url( '/join-us' ) ); ?>"><i class="fas fa-angle-right"></i> Careers</a></li>
					<li><a href="<?php echo esc_url( home_url( '/faq' ) ); ?>"><i class="fas fa-angle-right"></i> FAQ</a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'noki_news' ) ?: home_url( '/news' ) ); ?>"><i class="fas fa-angle-right"></i> News &amp; Events</a></li>
					<li><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>"><i class="fas fa-angle-right"></i> Contact</a></li>
				</ul>
			</div>

			<div class="footer-col">
				<h4>Services</h4>
				<ul>
					<?php
					$footer_services = noki_get_services( 6 );
					if ( $footer_services ) {
						foreach ( $footer_services as $fs ) {
							echo '<li><a href="' . esc_url( get_permalink( $fs ) ) . '"><i class="fas fa-angle-right"></i> ' . esc_html( noki_service_short_label( $fs ) ) . '</a></li>';
						}
					} else {
						$defaults = [ 'Air Freight', 'Sea Freight', 'Road Transport', 'Customs Brokerage', 'Warehousing', 'Express Delivery' ];
						foreach ( $defaults as $d ) {
							echo '<li><a href="' . esc_url( home_url( '/services' ) ) . '"><i class="fas fa-angle-right"></i> ' . esc_html( $d ) . '</a></li>';
						}
					}
					?>
				</ul>
			</div>

			<div class="footer-col footer-news">
				<h4>Get in touch</h4>
				<ul class="footer-contact">
					<li><i class="fas fa-location-dot"></i> <span><?php echo esc_html( $address ); ?></span></li>
					<li><i class="fas fa-phone"></i> <a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $phone ); ?></a></li>
					<li><i class="fas fa-envelope"></i> <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
				</ul>
				<p>Subscribe for logistics tips &amp; updates.</p>
				<form id="newsletter-form" novalidate>
					<input type="email" name="email" placeholder="Your email address" required aria-label="Email address">
					<button type="submit" aria-label="Subscribe"><i class="fas fa-paper-plane"></i></button>
				</form>
				<p class="msg" aria-live="polite"></p>
			</div>

		</div>

		<div class="footer-bottom">
			<p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
			<div class="footer-badges">
				<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>">Privacy Policy</a>
				<a href="<?php echo esc_url( home_url( '/terms' ) ); ?>">Terms of Service</a>
			</div>
		</div>
	</div>
</footer>
<!-- noki-deploy-check: 2.4.2 -->
<?php wp_footer(); ?>
</body>
</html>
