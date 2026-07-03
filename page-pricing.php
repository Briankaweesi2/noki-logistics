<?php
/*
Template Name: Pricing
*/
get_header();
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'noki_whatsapp', '+256772540483' ) );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Pricing</span>
		<h1>Clear, fair pricing</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a> &rsaquo; Pricing</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">How pricing works</span>
			<h2>No hidden fees, ever</h2>
			<p>Freight pricing depends on weight, volume, route and urgency — so every quote is tailored. The packages below show what's included; contact us for an exact, itemised quote within 2 hours.</p>
		</div>

		<div class="pricing-grid">
			<?php
			// Editable in wp-admin: Pages → Pricing → Packages. Falls back to these defaults.
			$default_tiers = [
				[ 'tag' => 'Essentials', 'title' => 'Domestic Delivery', 'desc' => 'Fast, reliable movement of parcels and goods within Uganda.', 'price' => 'From quote', 'note' => '/ shipment', 'featured' => false, 'button' => 'Get a Quote',
					'features' => [ 'Same-day & next-day options', 'Kampala & nationwide coverage', 'Live tracking updates', 'Proof of delivery' ] ],
				[ 'tag' => 'Most popular', 'title' => 'Import / Export', 'desc' => 'End-to-end air & sea freight with full customs handling.', 'price' => 'Custom', 'note' => '/ consignment', 'featured' => true, 'button' => 'Get a Quote',
					'features' => [ 'Air & sea freight (FCL/LCL)', 'Licensed customs clearing', 'Door-to-door coordination', 'Dedicated coordinator', 'Cargo insurance options' ] ],
				[ 'tag' => 'Business', 'title' => 'Contract Logistics', 'desc' => 'Ongoing freight, warehousing & distribution for growing businesses.', 'price' => 'Tailored', 'note' => '/ month', 'featured' => false, 'button' => 'Talk to Sales',
					'features' => [ 'Volume & retainer rates', 'Warehousing & inventory', 'Regional cross-border trucking', 'Account management & reporting' ] ],
			];
			$rows = noki_rows( 'pricing_tiers' );
			$tiers = [];
			if ( $rows ) {
				foreach ( $rows as $r ) {
					$feat = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $r['tier_features'] ) ) );
					$tiers[] = [ 'tag' => $r['tier_tag'], 'title' => $r['tier_title'], 'desc' => $r['tier_desc'], 'price' => $r['tier_price'], 'note' => $r['tier_note'], 'featured' => ! empty( $r['tier_featured'] ), 'button' => $r['tier_button'] ?: 'Get a Quote', 'features' => $feat ];
				}
			} else {
				$tiers = $default_tiers;
			}
			foreach ( $tiers as $t ) :
				$btn_class = $t['featured'] ? 'btn-white' : 'btn-ghost';
			?>
				<div class="price-card<?php echo $t['featured'] ? ' featured' : ''; ?>" data-aos="fade-up">
					<span class="price-tag"><?php echo esc_html( $t['tag'] ); ?></span>
					<h3><?php echo esc_html( $t['title'] ); ?></h3>
					<p class="desc"><?php echo esc_html( $t['desc'] ); ?></p>
					<div class="price"><?php echo esc_html( $t['price'] ); ?><small> <?php echo esc_html( $t['note'] ); ?></small></div>
					<ul>
						<?php foreach ( $t['features'] as $f ) : ?>
							<li><i class="fas fa-check"></i> <?php echo esc_html( $f ); ?></li>
						<?php endforeach; ?>
					</ul>
					<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn <?php echo esc_attr( $btn_class ); ?>" style="width:100%"><?php echo esc_html( $t['button'] ); ?></a>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="text-center" style="margin-top:2rem;color:var(--muted)">Prices are quoted in UGX or USD depending on the route. Ask about volume discounts for regular shippers.</p>
	</div>
</section>

<section class="section bg-soft">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">Questions</span>
			<h2>Pricing FAQs</h2>
		</div>
		<div class="faq-list">
			<?php
			$faqs = [
				[ 'How quickly will I get a quote?', 'For most shipments we send an itemised quote within 2 hours during business hours — often much faster on WhatsApp.' ],
				[ 'What affects the price of freight?', 'Mainly weight, volume (cubic measure), origin and destination, mode (air/sea/road) and how urgently you need it. Customs duties and taxes are separate and set by URA.' ],
				[ 'Do you offer discounts for regular shipments?', 'Yes — businesses that ship regularly can move onto volume or retainer rates. Talk to our sales team about a contract arrangement.' ],
				[ 'Are customs duties included?', 'Our service fee is separate from government duties and taxes. We always show these clearly so you know the full landed cost upfront.' ],
			];
			// Editable in wp-admin: Pages → Pricing → Pricing FAQs. Falls back to the list above.
			$rows = noki_rows( 'pricing_faqs' );
			if ( $rows ) {
				$faqs = [];
				foreach ( $rows as $r ) { $faqs[] = [ $r['question'], $r['answer'] ]; }
			}
			foreach ( $faqs as $f ) : ?>
				<div class="faq-item" data-aos="fade-up">
					<button class="faq-q" type="button"><?php echo esc_html( $f[0] ); ?> <span class="ic"><i class="fas fa-plus"></i></span></button>
					<div class="faq-a"><div class="faq-a-inner"><?php echo nl2br( esc_html( $f[1] ) ); ?></div></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<h2>Get your custom quote</h2>
			<p>Tell us what you're shipping and we'll send a clear, itemised price.</p>
			<div class="cta-actions">
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary btn-lg">Request a Quote <i class="fas fa-arrow-right"></i></a>
				<a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-lg" style="color:#fff;border-color:rgba(255,255,255,.4)"><i class="fab fa-whatsapp"></i> WhatsApp Us</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer();
