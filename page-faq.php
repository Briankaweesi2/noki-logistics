<?php
/*
Template Name: FAQ
*/
get_header();
$phone    = get_theme_mod( 'noki_phone', '+256 772 540 483' );
$whatsapp = preg_replace( '/[^0-9]/', '', get_theme_mod( 'noki_whatsapp', '+256772540483' ) );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Help centre</span>
		<h1>Frequently asked questions</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a> &rsaquo; FAQ</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">Got questions?</span>
			<h2>Everything you need to know</h2>
			<p>Can't find your answer below? Call or WhatsApp us — we're happy to help.</p>
		</div>

		<div class="faq-list">
			<?php
			$faqs = noki_default_faqs();
			// Editable in wp-admin: Pages → FAQ → Questions. Falls back to the list above.
			$rows = noki_rows( 'faq_items' );
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

<section class="section bg-soft">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<h2>Still have questions?</h2>
			<p>Our team is ready to help with anything about your shipment.</p>
			<div class="cta-actions">
				<a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>" class="btn btn-primary btn-lg"><i class="fas fa-phone"></i> Call Us</a>
				<a href="https://wa.me/<?php echo esc_attr( $whatsapp ); ?>" target="_blank" rel="noopener" class="btn btn-ghost btn-lg" style="color:#fff;border-color:rgba(255,255,255,.4)"><i class="fab fa-whatsapp"></i> WhatsApp Us</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer();
