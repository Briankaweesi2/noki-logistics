<?php
/*
Template Name: About Us
*/
get_header();
$tpl = get_template_directory_uri();
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Who we are</span>
		<h1>About Noki Logistics</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; About Us</p>
	</div>
</div>

<!-- Story split -->
<section class="section">
	<div class="container">
		<div class="split">
			<div class="split-img" data-aos="fade-right">
				<?php
				$default_img = file_exists( get_template_directory() . '/images/about-team.jpg' ) ? $tpl . '/images/about-team.jpg' : '';
				$about_img   = noki_f( 'about_image', $default_img );
				if ( $about_img ) : ?>
					<img src="<?php echo esc_url( $about_img ); ?>" alt="The Noki Logistics team">
				<?php else : ?>
					<div class="ph"><i class="fas fa-people-group"></i></div>
				<?php endif; ?>
				<div class="split-badge"><div class="n">10+</div><div class="t">Years of<br>excellence</div></div>
			</div>
			<div class="split-content" data-aos="fade-left">
				<span class="kicker">Our story</span>
				<h2><?php echo esc_html( noki_f( 'about_story_title', 'Connecting Uganda to the world' ) ); ?></h2>
				<p><?php echo nl2br( esc_html( noki_f( 'about_story_p1', "Noki Logistics was founded with one clear mission: to make international and domestic shipping simple, reliable and affordable for Ugandan businesses. We've grown from a small courier service into a full-service freight company handling air, sea and road shipments across East Africa." ) ) ); ?></p>
				<p><?php echo nl2br( esc_html( noki_f( 'about_story_p2', 'Based in Ntinda, Kampala, our team of experienced logistics professionals manages hundreds of shipments every month — from single parcels to full container loads — with the same care for every client.' ) ) ); ?></p>
				<ul class="check-list">
					<li><i class="fas fa-check"></i><div><strong>Licensed clearing &amp; forwarding</strong><span>Recognised customs agents at every major border.</span></div></li>
					<li><i class="fas fa-check"></i><div><strong>Regional network</strong><span>Trusted partners across Kenya, Tanzania, Rwanda, DRC &amp; South Sudan.</span></div></li>
					<li><i class="fas fa-check"></i><div><strong>End-to-end handling</strong><span>Pickup, documentation, clearance, tracking and delivery.</span></div></li>
				</ul>
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary">Work With Us <i class="fas fa-arrow-right"></i></a>
			</div>
		</div>
	</div>
</section>

<!-- Values -->
<section class="section bg-soft">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">What drives us</span>
			<h2>Our mission &amp; values</h2>
			<p>Every decision we make is rooted in these core principles.</p>
		</div>
		<div class="values-grid">
			<?php
			$values = [
				[ '🚀', 'Speed', 'We move fast without cutting corners. Your time matters, and we treat every deadline as our own.' ],
				[ '🛡️', 'Reliability', 'When we say we will deliver, we deliver. Our track record speaks for itself.' ],
				[ '🤝', 'Integrity', 'Honest pricing, clear communication and no surprises. We build trust through consistency.' ],
				[ '🔍', 'Transparency', 'Real-time updates, open invoicing and direct access to our team at every step.' ],
				[ '🌍', 'Local expertise', 'Deep knowledge of East African trade routes, customs regulations and market conditions.' ],
				[ '💡', 'Innovation', 'Continuously improving our systems and processes to serve you better.' ],
			];
			// Editable in wp-admin: Pages → Who We Are → Values. Falls back to the list above.
			$rows = noki_rows( 'about_values' );
			if ( $rows ) {
				$values = [];
				foreach ( $rows as $r ) { $values[] = [ $r['value_emoji'], $r['value_title'], $r['value_text'] ]; }
			}
			foreach ( $values as $v ) : ?>
				<div class="vg-card" data-aos="fade-up">
					<span class="emoji"><?php echo esc_html( $v[0] ); ?></span>
					<h3><?php echo esc_html( $v[1] ); ?></h3>
					<p><?php echo esc_html( $v[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- Stats band -->
<section class="section-sm">
	<div class="container">
		<div class="stats-band" data-aos="zoom">
			<div class="stats-grid">
				<?php
				$stats = [
					[ get_theme_mod( 'noki_stat_1_num', '500+' ), get_theme_mod( 'noki_stat_1_lbl', 'Shipments Delivered' ) ],
					[ get_theme_mod( 'noki_stat_2_num', '10+' ),  get_theme_mod( 'noki_stat_2_lbl', 'Years of Experience' ) ],
					[ get_theme_mod( 'noki_stat_3_num', '98%' ),  get_theme_mod( 'noki_stat_3_lbl', 'On-Time Delivery' ) ],
					[ get_theme_mod( 'noki_stat_4_num', '24/7' ), get_theme_mod( 'noki_stat_4_lbl', 'Customer Support' ) ],
				];
				foreach ( $stats as $s ) : ?>
					<div class="stat-cell">
						<div class="num"><?php echo esc_html( $s[0] ); ?></div>
						<div class="lbl"><?php echo esc_html( $s[1] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- CTA -->
<section class="section">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<h2>Let's move your business forward</h2>
			<p>Get in touch today for a free logistics consultation and quote.</p>
			<div class="cta-actions">
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-white btn-lg">Get a Free Quote <i class="fas fa-arrow-right"></i></a>
				<a href="<?php echo esc_url( home_url( '/services' ) ); ?>" class="btn btn-ghost btn-lg" style="color:#fff;border-color:rgba(255,255,255,.4)">View Services</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer();
