<?php get_header(); ?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">What we offer</span>
		<h1>Our Services</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; Services</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">End-to-end logistics</span>
			<h2>Freight solutions for every need</h2>
			<p>Comprehensive freight and logistics services tailored to your business across Uganda and East Africa.</p>
		</div>

		<?php
		$services = noki_get_services();
		if ( $services ) :
			$cards = [];
			foreach ( $services as $s ) {
				$cards[] = [
					'icon'  => get_post_meta( $s->ID, '_service_icon', true ) ?: 'fa-truck',
					'title' => get_the_title( $s ),
					'desc'  => wp_trim_words( wp_strip_all_tags( $s->post_content ), 18 ),
					'link'  => get_permalink( $s ),
					'img'   => get_the_post_thumbnail_url( $s, 'noki-card' ),
				];
			}
		else :
			$tpl   = get_template_directory_uri();
			$cards = [
				[ 'icon' => 'fa-plane',     'title' => 'Air Freight',       'desc' => 'Time-critical cargo flown through Entebbe and major hubs worldwide with full tracking and customs handling.',        'link' => home_url( '/contact' ), 'img' => $tpl . '/images/service-air.jpg' ],
				[ 'icon' => 'fa-ship',      'title' => 'Sea Freight',       'desc' => 'Cost-effective FCL and LCL ocean shipping via Mombasa and Dar es Salaam corridors to and from Uganda.',           'link' => home_url( '/contact' ), 'img' => $tpl . '/images/service-sea.jpg' ],
				[ 'icon' => 'fa-truck',     'title' => 'Road Transport',    'desc' => 'Reliable cross-border trucking across the East African Community at fair, transparent rates.',                     'link' => home_url( '/contact' ), 'img' => $tpl . '/images/service-road.jpg' ],
				[ 'icon' => 'fa-box-open',  'title' => 'Customs Brokerage', 'desc' => 'Licensed clearing and forwarding that moves your goods through URA and border posts without costly delays.',         'link' => home_url( '/contact' ), 'img' => $tpl . '/images/service-customs.jpg' ],
				[ 'icon' => 'fa-warehouse', 'title' => 'Warehousing',       'desc' => 'Secure, organised storage and inventory management with distribution from our Kampala facilities.',                'link' => home_url( '/contact' ), 'img' => $tpl . '/images/service-warehouse.jpg' ],
				[ 'icon' => 'fa-bolt',      'title' => 'Express Delivery',  'desc' => 'Same-day and next-day courier services across Kampala and nationwide for urgent documents and parcels.',            'link' => home_url( '/contact' ), 'img' => $tpl . '/images/service-express.jpg' ],
			];
		endif;
		?>

		<div class="solutions-grid">
			<?php foreach ( $cards as $i => $card ) : ?>
				<a class="solution-card<?php echo 0 === $i ? ' tall' : ''; ?>" href="<?php echo esc_url( $card['link'] ); ?>" data-aos="fade-up">
					<?php if ( ! empty( $card['img'] ) ) : ?>
						<img class="solution-bg" src="<?php echo esc_url( $card['img'] ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>">
					<?php else : ?>
						<div class="solution-bg-fallback"></div>
					<?php endif; ?>
					<div class="solution-icon"><i class="fas <?php echo esc_attr( $card['icon'] ); ?>"></i></div>
					<div class="solution-inner">
						<h3><?php echo esc_html( $card['title'] ); ?></h3>
						<p><?php echo esc_html( $card['desc'] ); ?></p>
						<span class="solution-more">Learn more <i class="fas fa-arrow-right"></i></span>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<h2>Not sure which service you need?</h2>
			<p>Talk to our logistics experts — we'll recommend the best solution for your cargo and budget.</p>
			<div class="cta-actions">
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-white btn-lg"><i class="fas fa-headset"></i> Speak to an Expert</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
