<?php
/*
Template Name: Contact
*/
get_header();

$phone    = get_theme_mod( 'noki_phone', '+256 772 540 483' );
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'noki_whatsapp', '+256772540483' ) );
$email    = get_theme_mod( 'noki_email', 'info@nokilogistics.com' );
$address  = get_theme_mod( 'noki_address', 'Plot No. 53/55 Semawata Road, Elgon Rise, Ntinda, Kampala' );
$hours    = get_theme_mod( 'noki_hours', 'Mon – Sat: 8:00am – 6:30pm' );
$tel      = preg_replace( '/\s+/', '', $phone );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Get in touch</span>
		<h1>Let's talk about your shipment</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; Contact</p>
	</div>
</div>

<section class="section">
	<div class="container">

		<div class="contact-info-grid">
			<div class="ci-card" data-aos="fade-up">
				<div class="ic"><i class="fas fa-location-dot"></i></div>
				<h3>Visit our office</h3>
				<p><?php echo esc_html( $address ); ?></p>
			</div>
			<div class="ci-card" data-aos="fade-up">
				<div class="ic"><i class="fas fa-headset"></i></div>
				<h3>Call or WhatsApp</h3>
				<p><a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $phone ); ?></a></p>
				<p><a href="<?php echo esc_url( noki_whatsapp_link( 'Hi Noki Logistics, I would like a freight quote.' ) ); ?>" target="_blank" rel="noopener" style="color:var(--primary);font-weight:600"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a></p>
			</div>
			<div class="ci-card" data-aos="fade-up">
				<div class="ic"><i class="fas fa-clock"></i></div>
				<h3>Working hours</h3>
				<p><?php echo esc_html( $hours ); ?></p>
				<p style="color:var(--primary);font-weight:600">Emergency line: 24/7</p>
			</div>
		</div>

		<div class="contact-grid">
			<div class="contact-form-wrap" data-aos="fade-right">
				<h2 style="font-size:1.8rem;margin-bottom:.5rem">Get a free quote</h2>
				<p style="margin-bottom:1.5rem">Tell us about your shipment and our team will send an itemised quote within 2 hours during business hours.</p>

				<form id="contact-form" novalidate>
					<div class="form-row">
						<div class="form-field">
							<label for="contact-name">Full name *</label>
							<input type="text" id="contact-name" name="name" placeholder="Your full name" required>
						</div>
						<div class="form-field">
							<label for="contact-email">Email address *</label>
							<input type="email" id="contact-email" name="email" placeholder="your@email.com" required>
						</div>
					</div>
					<div class="form-row">
						<div class="form-field">
							<label for="contact-phone">Phone number</label>
							<input type="tel" id="contact-phone" name="phone" placeholder="+256 7XX XXX XXX">
						</div>
						<div class="form-field">
							<label for="quote-type">Service needed</label>
							<select id="quote-type" name="subject">
								<option value="">Select a service…</option>
								<option value="Air Freight">Air Freight</option>
								<option value="Sea Freight">Sea Freight</option>
								<option value="Road Transport">Road Transport</option>
								<option value="Customs Clearance">Customs Clearance</option>
								<option value="Warehousing">Warehousing</option>
								<option value="Express Delivery">Express Delivery</option>
								<option value="General Enquiry">General Enquiry</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-field">
							<label for="quote-origin">Origin (from)</label>
							<input type="text" id="quote-origin" name="origin" placeholder="e.g. Guangzhou, China / Mombasa">
						</div>
						<div class="form-field">
							<label for="quote-dest">Destination (to)</label>
							<input type="text" id="quote-dest" name="destination" placeholder="e.g. Kampala, Uganda">
						</div>
					</div>
					<div class="form-field">
						<label for="quote-cargo">Cargo details</label>
						<input type="text" id="quote-cargo" name="cargo" placeholder="Weight / volume / type of goods">
					</div>
					<div class="form-field">
						<label for="contact-message">Message *</label>
						<textarea id="contact-message" name="message" placeholder="Describe your shipment or enquiry…" required></textarea>
					</div>
					<button type="submit" class="btn btn-primary btn-lg" style="width:100%"><i class="fas fa-paper-plane"></i> Get My Free Quote</button>
					<p class="form-msg" aria-live="polite"></p>
				</form>
			</div>

			<div data-aos="fade-left">
				<div class="map-embed">
					<iframe
						src="https://www.google.com/maps?q=Ntinda,Kampala,Uganda&output=embed"
						loading="lazy" referrerpolicy="no-referrer-when-downgrade"
						title="Noki Logistics location map"></iframe>
				</div>
				<div class="sidebar-widget sidebar-cta" style="margin-top:1.5rem">
					<h4>Fastest way to reach us</h4>
					<p>Prefer to chat? Message us on WhatsApp for the quickest response — usually within minutes.</p>
					<a href="<?php echo esc_url( noki_whatsapp_link( 'Hi Noki Logistics, I would like a freight quote.' ) ); ?>" target="_blank" rel="noopener" class="btn btn-white btn-sm" style="width:100%;margin-top:.5rem"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
				</div>
			</div>
		</div>

	</div>
</section>

<?php get_footer();
