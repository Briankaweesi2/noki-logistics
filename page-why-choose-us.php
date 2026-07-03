<?php
/*
Template Name: Why Choose Us
*/
get_header();
$tpl = get_template_directory_uri();
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Why Noki</span>
		<h1>Why businesses choose Noki</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a> &rsaquo; Why Choose Us</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">The Noki difference</span>
			<h2>Logistics that works the way you do</h2>
			<p>We've built our reputation on doing the simple things exceptionally well — clear pricing, real communication and cargo that arrives on time.</p>
		</div>
		<div class="feature-row">
			<div class="feature-card" data-aos="fade-up"><div class="ic"><i class="fas fa-clock"></i></div><h3>On-time, every time</h3><p>A 98% on-time delivery record backed by proactive planning and live tracking on every shipment.</p></div>
			<div class="feature-card" data-aos="fade-up"><div class="ic"><i class="fas fa-hand-holding-dollar"></i></div><h3>Transparent pricing</h3><p>Clear, itemised quotes upfront. No hidden charges, no surprise fees at the border.</p></div>
			<div class="feature-card" data-aos="fade-up"><div class="ic"><i class="fas fa-user-tie"></i></div><h3>Dedicated coordinator</h3><p>One point of contact who knows your account and is reachable by call or WhatsApp 24/7.</p></div>
			<div class="feature-card" data-aos="fade-up"><div class="ic"><i class="fas fa-file-signature"></i></div><h3>Customs expertise</h3><p>Licensed clearing agents who navigate URA and regional border posts without costly delays.</p></div>
			<div class="feature-card" data-aos="fade-up"><div class="ic"><i class="fas fa-globe-africa"></i></div><h3>Regional reach</h3><p>Trusted partners across Kenya, Tanzania, Rwanda, DRC and South Sudan — and the world beyond.</p></div>
			<div class="feature-card" data-aos="fade-up"><div class="ic"><i class="fas fa-shield-halved"></i></div><h3>Fully insured cargo</h3><p>Comprehensive cover from pickup to final delivery, so your goods are protected end-to-end.</p></div>
		</div>
	</div>
</section>

<!-- Comparison / numbers -->
<section class="section-sm">
	<div class="container">
		<div class="stats-band" data-aos="zoom">
			<div class="stats-grid">
				<div class="stat-cell"><div class="num"><span class="counter" data-target="98" data-suffix="%">0</span></div><div class="lbl">On-Time Delivery</div></div>
				<div class="stat-cell"><div class="num"><span class="counter" data-target="500" data-suffix="+">0</span></div><div class="lbl">Shipments Handled</div></div>
				<div class="stat-cell"><div class="num"><span class="counter" data-target="15" data-suffix="">0</span></div><div class="lbl">Countries Reached</div></div>
				<div class="stat-cell"><div class="num"><span class="counter" data-target="2" data-suffix="hr">0</span></div><div class="lbl">Avg. Quote Time</div></div>
			</div>
		</div>
	</div>
</section>

<!-- Process -->
<section class="section bg-soft">
	<div class="container">
		<div class="split">
			<div class="split-content" data-aos="fade-right">
				<span class="kicker">How it works</span>
				<h2>Simple, from quote to delivery</h2>
				<ul class="check-list">
					<li><i class="fas fa-check"></i><div><strong>1. Tell us what you're shipping</strong><span>Share your cargo details by form, call or WhatsApp.</span></div></li>
					<li><i class="fas fa-check"></i><div><strong>2. Get a clear quote in ~2 hours</strong><span>Transparent, itemised pricing with no surprises.</span></div></li>
					<li><i class="fas fa-check"></i><div><strong>3. We handle the logistics</strong><span>Pickup, documentation, customs and transport — all managed.</span></div></li>
					<li><i class="fas fa-check"></i><div><strong>4. Track to the doorstep</strong><span>Live updates until your goods are safely delivered.</span></div></li>
				</ul>
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary">Start a Shipment <i class="fas fa-arrow-right"></i></a>
			</div>
			<div class="split-img" data-aos="fade-left">
				<?php if ( file_exists( get_template_directory() . '/images/why-choose.jpg' ) ) : ?>
					<img src="<?php echo esc_url( $tpl . '/images/why-choose.jpg' ); ?>" alt="Noki Logistics operations">
				<?php else : ?>
					<div class="ph"><i class="fas fa-route"></i></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<span class="kicker center">Ready when you are</span>
			<h2>See the difference for yourself</h2>
			<p>Get a free quote and experience logistics done right.</p>
			<div class="cta-actions"><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary btn-lg">Get a Free Quote <i class="fas fa-arrow-right"></i></a></div>
		</div>
	</div>
</section>

<?php get_footer();
