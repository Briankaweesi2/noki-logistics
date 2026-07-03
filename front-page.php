<?php
/**
 * Front Page — Noki Logistics
 * Premium homepage modelled on a modern logistics layout.
 */
get_header();

$phone    = get_theme_mod( 'noki_phone', '+256 772 540 483' );
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'noki_whatsapp', '+256772540483' ) );
$tpl      = get_template_directory_uri();

/* Stats (Customizer-driven) */
$stats = [
	[ get_theme_mod( 'noki_stat_1_num', '500+' ),  get_theme_mod( 'noki_stat_1_lbl', 'Shipments Delivered' ) ],
	[ get_theme_mod( 'noki_stat_2_num', '10+' ),   get_theme_mod( 'noki_stat_2_lbl', 'Years of Experience' ) ],
	[ get_theme_mod( 'noki_stat_3_num', '98%' ),   get_theme_mod( 'noki_stat_3_lbl', 'On-Time Delivery' ) ],
	[ get_theme_mod( 'noki_stat_4_num', '24/7' ),  get_theme_mod( 'noki_stat_4_lbl', 'Customer Support' ) ],
];

/* Services (CPT with rich fallback) */
$services      = noki_get_services( 6 );
$service_cards = [];
if ( $services ) {
	foreach ( $services as $s ) {
		$service_cards[] = [
			'icon'  => get_post_meta( $s->ID, '_service_icon', true ) ?: 'fa-truck',
			'title' => get_the_title( $s ),
			'desc'  => wp_trim_words( wp_strip_all_tags( $s->post_content ), 18 ),
			'link'  => get_permalink( $s ),
			'img'   => noki_service_img( $s, 'noki-card' ),
		];
	}
} else {
	$service_cards = [
		[ 'icon' => 'fa-plane',     'title' => 'Air Freight',       'desc' => 'Time-critical cargo flown through Entebbe and major hubs worldwide with full tracking and customs handling.',        'link' => home_url( '/services' ), 'img' => $tpl . '/images/service-air.jpg' ],
		[ 'icon' => 'fa-ship',      'title' => 'Sea Freight',       'desc' => 'Cost-effective FCL and LCL ocean shipping via Mombasa and Dar es Salaam corridors to and from Uganda.',           'link' => home_url( '/services' ), 'img' => $tpl . '/images/service-sea.jpg' ],
		[ 'icon' => 'fa-truck',     'title' => 'Road Transport',    'desc' => 'Reliable cross-border trucking across the East African Community — Kenya, Tanzania, Rwanda, DRC and South Sudan.', 'link' => home_url( '/services' ), 'img' => $tpl . '/images/service-road.jpg' ],
		[ 'icon' => 'fa-box-open',  'title' => 'Customs Brokerage', 'desc' => 'Licensed clearing and forwarding that moves your goods through URA and border posts without costly delays.',         'link' => home_url( '/services' ), 'img' => $tpl . '/images/service-customs.jpg' ],
		[ 'icon' => 'fa-warehouse', 'title' => 'Warehousing',       'desc' => 'Secure, organised storage and inventory management with distribution from our Kampala facilities.',                'link' => home_url( '/services' ), 'img' => $tpl . '/images/service-warehouse.jpg' ],
		[ 'icon' => 'fa-bolt',      'title' => 'Express Delivery',  'desc' => 'Same-day and next-day courier services across Kampala and nationwide for urgent documents and parcels.',            'link' => home_url( '/services' ), 'img' => $tpl . '/images/service-express.jpg' ],
	];
}

/* Testimonials */
$testimonials = noki_get_testimonials( 3 );
?>

<!-- ============ HERO SLIDER ============ -->
<?php
$hero_defaults = [
	[
		'img'   => $tpl . '/images/hero-1.jpg',
		'badge' => 'Trusted freight partner across East Africa',
		'title' => 'Moving your cargo <span class="grad">further, faster</span> &amp; safer',
		'lead'  => 'From Kampala to the world — air, sea and road freight, customs clearance and warehousing you can rely on.',
		'cta1'  => [ 'Get a Free Quote', home_url( '/contact' ) ],
		'cta2'  => [ 'Explore Services', home_url( '/services' ) ],
	],
	[
		'img'   => $tpl . '/images/hero-2.jpg',
		'badge' => 'Global reach, local expertise',
		'title' => 'Air, sea &amp; road freight, <span class="grad">handled end to end</span>',
		'lead'  => 'One trusted partner for your entire supply chain — across East Africa and beyond.',
		'cta1'  => [ 'Our Services', home_url( '/services' ) ],
		'cta2'  => [ 'Get a Quote', home_url( '/contact' ) ],
	],
	[
		'img'   => $tpl . '/images/hero-3.jpg',
		'badge' => 'Cross-border specialists',
		'title' => 'Reliable delivery across <span class="grad">East Africa</span>',
		'lead'  => 'Kenya, Tanzania, Rwanda, DRC and South Sudan — on time, every time.',
		'cta1'  => [ 'Get a Free Quote', home_url( '/contact' ) ],
		'cta2'  => [ 'Contact Us', home_url( '/contact' ) ],
	],
];
// Merge ACF-entered content over the defaults (defaults used when a field is empty).
$hero_slides = [];
foreach ( $hero_defaults as $idx => $d ) {
	$n       = $idx + 1;
	$heading = noki_field( "hero{$n}_heading", '' );
	if ( '' !== $heading ) {
		$hl    = noki_field( "hero{$n}_highlight", '' );
		$title = esc_html( $heading ) . ( '' !== $hl ? ' <span class="grad">' . esc_html( $hl ) . '</span>' : '' );
	} else {
		$title = $d['title'];
	}
	$b1 = noki_field( "hero{$n}_btn1", null );
	$b2 = noki_field( "hero{$n}_btn2", null );
	$hero_slides[] = [
		'img'   => noki_field( "hero{$n}_image", $d['img'] ),
		'badge' => noki_field( "hero{$n}_badge", $d['badge'] ),
		'title' => $title,
		'lead'  => noki_field( "hero{$n}_lead", $d['lead'] ),
		'cta1'  => ( is_array( $b1 ) && ! empty( $b1['url'] ) ) ? [ $b1['title'] ?: $d['cta1'][0], $b1['url'] ] : $d['cta1'],
		'cta2'  => ( is_array( $b2 ) && ! empty( $b2['url'] ) ) ? [ $b2['title'] ?: $d['cta2'][0], $b2['url'] ] : $d['cta2'],
	];
}
?>
<section class="hero-slider" id="hero-slider" aria-label="Featured highlights">
	<div class="hero-slides">
		<?php foreach ( $hero_slides as $i => $s ) : ?>
			<div class="hero-slide<?php echo 0 === $i ? ' active' : ''; ?>" style="background-image:url('<?php echo esc_url( $s['img'] ); ?>')">
				<div class="hero-slide-overlay"></div>
				<div class="container">
					<div class="hero-slide-content">
						<span class="hero-badge"><span class="dot"></span> <?php echo esc_html( $s['badge'] ); ?></span>
						<h1><?php echo wp_kses_post( $s['title'] ); ?></h1>
						<p class="hero-lead"><?php echo esc_html( $s['lead'] ); ?></p>
						<div class="hero-actions">
							<a href="<?php echo esc_url( $s['cta1'][1] ); ?>" class="btn btn-primary btn-lg"><?php echo esc_html( $s['cta1'][0] ); ?> <i class="fas fa-arrow-right"></i></a>
							<a href="<?php echo esc_url( $s['cta2'][1] ); ?>" class="btn btn-white btn-lg"><?php echo esc_html( $s['cta2'][0] ); ?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>

	<button class="hero-arrow prev" id="hero-prev" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
	<button class="hero-arrow next" id="hero-next" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>

	<div class="hero-dots" id="hero-dots">
		<?php foreach ( $hero_slides as $i => $s ) : ?>
			<button class="hero-dot<?php echo 0 === $i ? ' active' : ''; ?>" data-slide="<?php echo esc_attr( $i ); ?>" aria-label="Go to slide <?php echo esc_attr( $i + 1 ); ?>"></button>
		<?php endforeach; ?>
	</div>
</section>

<div class="hero-logos-band">
	<div class="container">
		<span class="hlb-label">Proudly moving goods for businesses of every size</span>
		<div class="logo-row">
			<span>Importers</span><span>Manufacturers</span><span>Retailers</span><span>NGOs</span><span>SMEs</span><span>E-commerce</span>
		</div>
	</div>
</div>

<!-- ============ INTRO STATEMENT ============ -->
<?php
$intro_raw  = noki_field( 'intro_statement', '' );
$intro_html = '' !== $intro_raw
	? preg_replace( '/\*(.+?)\*/', '<em>$1</em>', esc_html( $intro_raw ) )
	: "We're more than a freight company — we're your dedicated partner in <em>supply-chain success</em> across Uganda and the region.";
$intro_metrics = [
	[ noki_field( 'intro_metric1_num', '15' ), noki_field( 'intro_metric1_suffix', '' ),  noki_field( 'intro_metric1_label', 'Countries Reached' ) ],
	[ noki_field( 'intro_metric2_num', '500' ), noki_field( 'intro_metric2_suffix', '+' ), noki_field( 'intro_metric2_label', 'Shipments Handled' ) ],
	[ noki_field( 'intro_metric3_num', '98' ), noki_field( 'intro_metric3_suffix', '%' ),  noki_field( 'intro_metric3_label', 'On-Time Rate' ) ],
];
?>
<section class="section bg-soft">
	<div class="container intro-statement" data-aos="fade-up">
		<span class="kicker center"><?php echo esc_html( noki_field( 'intro_kicker', 'Who we are' ) ); ?></span>
		<p class="big"><?php echo wp_kses( $intro_html, [ 'em' => [] ] ); ?></p>
		<div class="intro-meta">
			<?php foreach ( $intro_metrics as $mtr ) : ?>
				<div class="item"><div class="num counter" data-target="<?php echo esc_attr( $mtr[0] ); ?>" data-suffix="<?php echo esc_attr( $mtr[1] ); ?>">0</div><div class="lbl"><?php echo esc_html( $mtr[2] ); ?></div></div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ SOLUTIONS ============ -->
<section class="section">
	<div class="container">
		<div class="solutions-head">
			<div class="section-head" data-aos="fade-up">
				<span class="kicker">What we offer</span>
				<h2>How we can help you move</h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/services' ) ); ?>" class="btn btn-dark" data-aos="fade-up">All Services <i class="fas fa-arrow-right"></i></a>
		</div>

		<div class="solutions-grid">
			<?php foreach ( $service_cards as $i => $card ) : ?>
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

<!-- ============ STATS BAND ============ -->
<section class="section-sm">
	<div class="container">
		<div class="stats-band" data-aos="zoom">
			<div class="stats-grid">
				<?php foreach ( $stats as $st ) :
					preg_match( '/^(\d+)/', $st[0], $m );
					$num    = $m[1] ?? '';
					$suffix = '' !== $num ? trim( substr( $st[0], strlen( $num ) ) ) : '';
					?>
					<div class="stat-cell">
						<div class="num">
							<?php if ( '' !== $num ) : ?>
								<span class="counter" data-target="<?php echo esc_attr( $num ); ?>" data-suffix="<?php echo esc_attr( $suffix ); ?>">0</span>
							<?php else : ?>
								<?php echo esc_html( $st[0] ); ?>
							<?php endif; ?>
						</div>
						<div class="lbl"><?php echo esc_html( $st[1] ); ?></div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- ============ FEATURE ROW ============ -->
<section class="section">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center"><?php echo esc_html( noki_field( 'whyus_kicker', 'Why Noki' ) ); ?></span>
			<h2><?php echo esc_html( noki_field( 'whyus_heading', "Built for businesses that can't afford delays" ) ); ?></h2>
		</div>
		<?php
		$features = [
			[ noki_field( 'feature1_icon', 'fa-route' ),   noki_field( 'feature1_title', 'Delivering goods reliably' ), noki_field( 'feature1_text', 'Every shipment is planned, tracked and insured. You get clear timelines and proactive updates from pickup to final delivery.' ) ],
			[ noki_field( 'feature2_icon', 'fa-microchip' ), noki_field( 'feature2_title', 'Cutting-edge tracking' ),   noki_field( 'feature2_text', 'Real-time visibility on your cargo and transparent, flat-rate pricing — no hidden charges, no surprises at the border.' ) ],
			[ noki_field( 'feature3_icon', 'fa-headset' ),  noki_field( 'feature3_title', 'Personalised service' ),     noki_field( 'feature3_text', 'A dedicated coordinator for your account who understands your business and is reachable on call or WhatsApp 24/7.' ) ],
		];
		?>
		<div class="feature-row">
			<?php foreach ( $features as $ft ) : ?>
				<div class="feature-card" data-aos="fade-up">
					<div class="ic"><i class="fas <?php echo esc_attr( $ft[0] ); ?>"></i></div>
					<h3><?php echo esc_html( $ft[1] ); ?></h3>
					<p><?php echo esc_html( $ft[2] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ SPECIAL HIGHLIGHTS (News & Events) ============ -->
<?php
$news_posts = noki_get_news( 4 );
$news_url   = get_post_type_archive_link( 'noki_news' ) ?: home_url( '/news' );
$news_items = [];
if ( $news_posts ) {
	foreach ( $news_posts as $np ) {
		$news_items[] = [
			'type'    => noki_news_type( $np->ID ),
			'date'    => get_the_date( 'M j, Y', $np ),
			'title'   => get_the_title( $np ),
			'excerpt' => wp_trim_words( wp_strip_all_tags( $np->post_excerpt ?: $np->post_content ), 22 ),
			'link'    => get_permalink( $np ),
			'img'     => get_the_post_thumbnail_url( $np, 'noki-card' ),
		];
	}
} else {
	$news_items = [
		[ 'type' => 'News',         'date' => 'Jun 24, 2026', 'title' => 'New sea-freight consolidation service via Mombasa now live', 'excerpt' => 'Ship smaller loads at lower cost — our new LCL consolidation lets you share container space on the Mombasa–Kampala route.', 'link' => $news_url, 'img' => $tpl . '/images/service-sea.jpg' ],
		[ 'type' => 'Event',        'date' => 'Jun 18, 2026', 'title' => 'Meet Noki Logistics at the Kampala International Trade Expo', 'excerpt' => 'Visit our stand to talk freight, customs and warehousing with the team.', 'link' => $news_url, 'img' => $tpl . '/images/about-team.jpg' ],
		[ 'type' => 'Announcement', 'date' => 'Jun 10, 2026', 'title' => 'Expanded warehouse facility now open in Ntinda', 'excerpt' => 'More secure storage and faster distribution for our clients.', 'link' => $news_url, 'img' => $tpl . '/images/service-warehouse.jpg' ],
		[ 'type' => 'News',         'date' => 'Jun 02, 2026', 'title' => '24/7 customs clearance desk launched at Malaba border', 'excerpt' => 'Round-the-clock clearing to keep your cargo moving.', 'link' => $news_url, 'img' => $tpl . '/images/service-customs.jpg' ],
	];
}
$feat = $news_items[0];
$rest = array_slice( $news_items, 1, 3 );
?>
<section class="section">
	<div class="container">
		<div class="solutions-head">
			<div class="section-head" style="margin-bottom:0" data-aos="fade-up">
				<span class="kicker">Special highlights</span>
				<h2>Discover Noki Logistics!</h2>
			</div>
			<a href="<?php echo esc_url( $news_url ); ?>" class="btn btn-dark" data-aos="fade-up">View All News <i class="fas fa-arrow-right"></i></a>
		</div>

		<div class="highlights-grid">
			<a class="highlight-featured" href="<?php echo esc_url( $feat['link'] ); ?>" data-aos="fade-right">
				<?php if ( ! empty( $feat['img'] ) ) : ?>
					<img src="<?php echo esc_url( $feat['img'] ); ?>" alt="<?php echo esc_attr( $feat['title'] ); ?>">
				<?php else : ?>
					<div class="ph"></div>
				<?php endif; ?>
				<div class="hf-body">
					<div class="hi-meta" style="display:flex;align-items:center;gap:.7rem">
						<span class="news-tag"><?php echo esc_html( $feat['type'] ); ?></span>
						<span class="news-date"><i class="far fa-calendar"></i> <?php echo esc_html( $feat['date'] ); ?></span>
					</div>
					<h3><?php echo esc_html( $feat['title'] ); ?></h3>
					<p><?php echo esc_html( $feat['excerpt'] ); ?></p>
					<span class="link-arrow" style="color:#fff">Read more <i class="fas fa-arrow-right"></i></span>
				</div>
			</a>

			<div class="highlight-list">
				<?php foreach ( $rest as $it ) : ?>
					<div class="highlight-item" data-aos="fade-left">
						<div class="hi-thumb">
							<?php if ( ! empty( $it['img'] ) ) : ?>
								<a href="<?php echo esc_url( $it['link'] ); ?>"><img src="<?php echo esc_url( $it['img'] ); ?>" alt="<?php echo esc_attr( $it['title'] ); ?>"></a>
							<?php else : ?>
								<div class="ph"><i class="fas fa-newspaper"></i></div>
							<?php endif; ?>
						</div>
						<div class="hi-body">
							<div class="hi-meta">
								<span class="news-tag"><?php echo esc_html( $it['type'] ); ?></span>
								<span class="news-date"><?php echo esc_html( $it['date'] ); ?></span>
							</div>
							<h4><a href="<?php echo esc_url( $it['link'] ); ?>"><?php echo esc_html( $it['title'] ); ?></a></h4>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>

<!-- ============ ABOUT SPLIT ============ -->
<section class="section bg-soft">
	<div class="container">
		<?php
		$about_img_default = file_exists( get_template_directory() . '/images/about-team.jpg' ) ? $tpl . '/images/about-team.jpg' : '';
		$about_img = noki_field( 'about_image', $about_img_default );
		$about_checks = [
			[ noki_field( 'about_check1_title', 'Door-to-door coordination' ), noki_field( 'about_check1_text', 'One point of contact for the entire journey.' ) ],
			[ noki_field( 'about_check2_title', 'Customs expertise' ),         noki_field( 'about_check2_text', 'Licensed clearing agents who know URA inside-out.' ) ],
			[ noki_field( 'about_check3_title', 'Transparent pricing' ),       noki_field( 'about_check3_text', 'Clear quotes upfront — what we say is what you pay.' ) ],
		];
		$about_btn = noki_field( 'about_btn', null );
		$about_btn_url  = ( is_array( $about_btn ) && ! empty( $about_btn['url'] ) ) ? $about_btn['url'] : home_url( '/about' );
		$about_btn_text = ( is_array( $about_btn ) && ! empty( $about_btn['title'] ) ) ? $about_btn['title'] : 'More About Us';
		?>
		<div class="split">
			<div class="split-img" data-aos="fade-right">
				<?php if ( $about_img ) : ?>
					<img src="<?php echo esc_url( $about_img ); ?>" alt="The Noki Logistics team">
				<?php else : ?>
					<div class="ph"><i class="fas fa-people-carry-box"></i></div>
				<?php endif; ?>
				<div class="split-badge"><div class="n">10+</div><div class="t">Years moving<br>East Africa</div></div>
			</div>
			<div class="split-content" data-aos="fade-left">
				<span class="kicker"><?php echo esc_html( noki_field( 'about_kicker', 'Success hinges on collaboration' ) ); ?></span>
				<h2><?php echo esc_html( noki_field( 'about_heading', 'Your goods, handled like our own' ) ); ?></h2>
				<p><?php echo esc_html( noki_field( 'about_text', 'Noki Logistics was built on a simple belief: logistics should make your life easier, not harder. We combine local knowledge of Ugandan and regional trade routes with global freight partnerships to move your cargo smoothly, affordably and on time.' ) ); ?></p>
				<ul class="check-list">
					<?php foreach ( $about_checks as $ch ) : ?>
						<li><i class="fas fa-check"></i><div><strong><?php echo esc_html( $ch[0] ); ?></strong><span><?php echo esc_html( $ch[1] ); ?></span></div></li>
					<?php endforeach; ?>
				</ul>
				<a href="<?php echo esc_url( $about_btn_url ); ?>" class="btn btn-primary"><?php echo esc_html( $about_btn_text ); ?> <i class="fas fa-arrow-right"></i></a>
			</div>
		</div>
	</div>
</section>

<!-- ============ TESTIMONIALS ============ -->
<section class="section">
	<div class="container">
		<div class="marquee" style="margin-bottom:clamp(2.5rem,5vw,4rem)">
			<div class="marquee-track">
				<span>Importers</span><span>•</span><span>Manufacturers</span><span>•</span><span>Retailers</span><span>•</span><span>NGOs &amp; Aid</span><span>•</span><span>E-commerce</span><span>•</span><span>Wholesalers</span><span>•</span>
				<span>Importers</span><span>•</span><span>Manufacturers</span><span>•</span><span>Retailers</span><span>•</span><span>NGOs &amp; Aid</span><span>•</span><span>E-commerce</span><span>•</span><span>Wholesalers</span><span>•</span>
			</div>
		</div>

		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">Client stories</span>
			<h2>What our clients say</h2>
		</div>

		<div class="tst-grid">
			<?php if ( $testimonials ) : ?>
				<?php foreach ( $testimonials as $t ) :
					$role     = get_post_meta( $t->ID, '_testimonial_role', true );
					$company  = get_post_meta( $t->ID, '_testimonial_company', true );
					$rating   = (int) ( get_post_meta( $t->ID, '_testimonial_rating', true ) ?: 5 );
					$initials = strtoupper( substr( get_the_title( $t ), 0, 2 ) );
					?>
					<div class="tst-card" data-aos="fade-up">
						<div class="quote-mark">&ldquo;</div>
						<div class="stars"><?php echo esc_html( str_repeat( '★', $rating ) . str_repeat( '☆', 5 - $rating ) ); ?></div>
						<div class="body"><?php echo wp_kses_post( wpautop( $t->post_content ) ); ?></div>
						<div class="tst-author">
							<?php if ( has_post_thumbnail( $t ) ) : echo get_the_post_thumbnail( $t, 'noki-thumb', [ 'class' => 'av' ] ); else : ?>
								<div class="av"><?php echo esc_html( $initials ); ?></div>
							<?php endif; ?>
							<div>
								<strong><?php echo esc_html( get_the_title( $t ) ); ?></strong>
								<span><?php echo esc_html( trim( $role . ( $company ? ', ' . $company : '' ), ', ' ) ); ?></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else :
				$fallback_t = [
					[ 'Noki cleared our container through Mombasa and delivered to Kampala days ahead of schedule. Their customs team saved us a fortune in demurrage.', 'James Okello', 'Operations Manager, Kampala Hardware', 'JO' ],
					[ 'We ship temperature-sensitive products and Noki has never let us down. Real-time updates and a coordinator who actually picks up the phone.', 'Aisha Nakato', 'Founder, FreshGrocer UG', 'AN' ],
					[ 'Reliable cross-border trucking to Juba and Goma at fair prices. Noki has become an extension of our own logistics team.', 'Samuel Niyonzima', 'Supply Chain Lead, RegionTrade', 'SN' ],
				];
				foreach ( $fallback_t as $ft ) : ?>
					<div class="tst-card" data-aos="fade-up">
						<div class="quote-mark">&ldquo;</div>
						<div class="stars">★★★★★</div>
						<div class="body"><p><?php echo esc_html( $ft[0] ); ?></p></div>
						<div class="tst-author">
							<div class="av"><?php echo esc_html( $ft[3] ); ?></div>
							<div><strong><?php echo esc_html( $ft[1] ); ?></strong><span><?php echo esc_html( $ft[2] ); ?></span></div>
						</div>
					</div>
				<?php endforeach;
			endif; ?>
		</div>
	</div>
</section>

<!-- ============ VALUES (dark) ============ -->
<section class="section bg-dark">
	<div class="container">
		<div class="split" style="margin-bottom:clamp(2rem,4vw,3rem);align-items:end">
			<div class="section-head" style="margin-bottom:0" data-aos="fade-right">
				<span class="kicker"><?php echo esc_html( noki_field( 'values_kicker', 'Our values' ) ); ?></span>
				<h2><?php echo wp_kses( noki_field( 'values_heading', 'The principles behind every<br>shipment we move' ), [ 'br' => [] ] ); ?></h2>
			</div>
			<p data-aos="fade-left" style="color:#a89f94"><?php echo esc_html( noki_field( 'values_intro', "These aren't just words on a wall — they shape how we quote, how we communicate, and how we treat your cargo at every stage of the journey." ) ); ?></p>
		</div>
		<div class="values-list">
			<?php
			$value_defaults = [
				[ 'fa-shield-halved', 'Reliability',    'We do what we say. Deadlines are commitments, and your cargo arrives safe, on time, every time.' ],
				[ 'fa-lightbulb',     'Innovation',     'From real-time tracking to smarter routing, we invest in tools that give you visibility and control.' ],
				[ 'fa-leaf',          'Sustainability', 'Efficient routing and consolidated loads that reduce waste, emissions and unnecessary cost.' ],
				[ 'fa-handshake',     'Customer-first', 'Your business goals drive our decisions. We succeed only when your supply chain runs smoothly.' ],
			];
			$values = [];
			foreach ( $value_defaults as $vi => $vd ) {
				$vn = $vi + 1;
				$values[] = [
					sprintf( '%02d', $vn ),
					noki_field( "value{$vn}_icon", $vd[0] ),
					noki_field( "value{$vn}_title", $vd[1] ),
					noki_field( "value{$vn}_text", $vd[2] ),
				];
			}
			foreach ( $values as $v ) : ?>
				<div class="value-item" data-aos="fade-up">
					<div class="vnum"><?php echo esc_html( $v[0] ); ?></div>
					<div class="vbody"><h3><?php echo esc_html( $v[2] ); ?></h3><p><?php echo esc_html( $v[3] ); ?></p></div>
					<div class="vicon"><i class="fas <?php echo esc_attr( $v[1] ); ?>"></i></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ============ BLOG PREVIEW ============ -->
<?php $recent = get_posts( [ 'posts_per_page' => 3 ] ); if ( $recent ) : ?>
<section class="section bg-soft">
	<div class="container">
		<div class="solutions-head">
			<div class="section-head" style="margin-bottom:0" data-aos="fade-up">
				<span class="kicker">Insights</span>
				<h2>From our logistics blog</h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn-dark" data-aos="fade-up">All Articles <i class="fas fa-arrow-right"></i></a>
		</div>
		<div class="blog-grid">
			<?php foreach ( $recent as $post ) : setup_postdata( $post ); ?>
				<article class="blog-card" data-aos="fade-up">
					<a href="<?php the_permalink(); ?>" class="blog-thumb">
						<?php if ( has_post_thumbnail() ) : the_post_thumbnail( 'noki-blog', [ 'alt' => get_the_title() ] ); else : ?>
							<div class="ph"><i class="fas fa-newspaper"></i></div>
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
			<?php endforeach; wp_reset_postdata(); ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- ============ CTA ============ -->
<?php
$cta_b1 = noki_field( 'cta_btn1', null );
$cta_b1_url  = ( is_array( $cta_b1 ) && ! empty( $cta_b1['url'] ) ) ? $cta_b1['url'] : home_url( '/contact' );
$cta_b1_text = ( is_array( $cta_b1 ) && ! empty( $cta_b1['title'] ) ) ? $cta_b1['title'] : 'Get a Free Quote';
$cta_b2 = noki_field( 'cta_btn2', null );
$has_b2 = is_array( $cta_b2 ) && ! empty( $cta_b2['url'] );
?>
<section class="section">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<span class="kicker center" style="color:rgba(255,255,255,.85)">Ready when you are</span>
			<h2><?php echo esc_html( noki_field( 'cta_heading', "Let's move your cargo with confidence" ) ); ?></h2>
			<p><?php echo esc_html( noki_field( 'cta_text', "Get a free, no-obligation quote today. Tell us what you are shipping and we handle the rest by air, sea or road." ) ); ?></p>
			<div class="cta-actions">
					<a href="<?php echo esc_url( $cta_b1_url ); ?>" class="btn btn-white btn-lg"><?php echo esc_html( $cta_b1_text ); ?> <i class="fas fa-arrow-right"></i></a>
					<?php if ( $has_b2 ) : ?>
						<a href="<?php echo esc_url( $cta_b2['url'] ); ?>" class="btn btn-ghost btn-lg" style="color:#fff;border-color:rgba(255,255,255,.4)"><?php echo esc_html( $cta_b2['title'] ?: 'Learn More' ); ?></a>
					<?php else : ?>
						<a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-lg" style="color:#fff;border-color:rgba(255,255,255,.4)"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
					<?php endif; ?>
				</div>
		</div>
	</div>
</section>

<?php get_footer();
