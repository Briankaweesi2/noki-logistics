<?php
/*
Template Name: Testimonials
*/
get_header();
$testimonials = noki_get_testimonials( -1 );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Client stories</span>
		<h1>What our clients say</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a> &rsaquo; Testimonials</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">Trusted across East Africa</span>
			<h2>Real results, real businesses</h2>
			<p>From importers and manufacturers to NGOs and e-commerce sellers — here's what working with Noki feels like.</p>
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
							<div><strong><?php echo esc_html( get_the_title( $t ) ); ?></strong><span><?php echo esc_html( trim( $role . ( $company ? ', ' . $company : '' ), ', ' ) ); ?></span></div>
						</div>
					</div>
				<?php endforeach; ?>
			<?php else :
				$fallback = [
					[ 'Noki cleared our container through Mombasa and delivered to Kampala days ahead of schedule. Their customs team saved us a fortune in demurrage.', 'James Okello', 'Operations Manager, Kampala Hardware', 'JO' ],
					[ 'We ship temperature-sensitive products and Noki has never let us down. Real-time updates and a coordinator who actually picks up the phone.', 'Aisha Nakato', 'Founder, FreshGrocer UG', 'AN' ],
					[ 'Reliable cross-border trucking to Juba and Goma at fair prices. Noki has become an extension of our own logistics team.', 'Samuel Niyonzima', 'Supply Chain Lead, RegionTrade', 'SN' ],
					[ 'As an online seller, fast delivery is everything. Noki handles our nationwide dispatch and our customers are happier for it.', 'Patience Aceng', 'Owner, KlaMart Online', 'PA' ],
					[ 'Their warehousing and distribution freed up our cash and our storeroom. Professional, organised and always on time.', 'David Mugisha', 'Procurement, BuildWell Ltd', 'DM' ],
					[ 'Air freight from China was seamless — documentation, clearance and delivery all handled. I just had to receive my goods.', 'Sarah Namuli', 'Director, Bella Cosmetics', 'SN' ],
				];
				foreach ( $fallback as $ft ) : ?>
					<div class="tst-card" data-aos="fade-up">
						<div class="quote-mark">&ldquo;</div>
						<div class="stars">★★★★★</div>
						<div class="body"><p><?php echo esc_html( $ft[0] ); ?></p></div>
						<div class="tst-author"><div class="av"><?php echo esc_html( $ft[3] ); ?></div><div><strong><?php echo esc_html( $ft[1] ); ?></strong><span><?php echo esc_html( $ft[2] ); ?></span></div></div>
					</div>
				<?php endforeach;
			endif; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<h2>Join hundreds of happy shippers</h2>
			<p>Experience logistics you can actually rely on. Get your free quote today.</p>
			<div class="cta-actions"><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary btn-lg">Get a Free Quote <i class="fas fa-arrow-right"></i></a></div>
		</div>
	</div>
</section>

<?php get_footer();
