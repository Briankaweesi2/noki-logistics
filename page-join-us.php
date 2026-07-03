<?php
/*
Template Name: Join Us
*/
get_header();
$email = get_theme_mod( 'noki_email', 'info@nokilogistics.com' );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Careers</span>
		<h1>Build your future with Noki</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a> &rsaquo; Join Us</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">Why work here</span>
			<h2>More than a job — a community</h2>
			<p>We're a growing team of people passionate about moving East Africa forward. If you care about doing great work, you'll fit right in.</p>
		</div>
		<div class="perks-grid">
			<div class="perk" data-aos="fade-up"><div class="ic"><i class="fas fa-chart-line"></i></div><h4>Growth</h4><p>Real opportunities to learn and advance as we scale.</p></div>
			<div class="perk" data-aos="fade-up"><div class="ic"><i class="fas fa-people-roof"></i></div><h4>Great team</h4><p>Supportive colleagues who have your back.</p></div>
			<div class="perk" data-aos="fade-up"><div class="ic"><i class="fas fa-scale-balanced"></i></div><h4>Fair pay</h4><p>Competitive compensation and recognition.</p></div>
			<div class="perk" data-aos="fade-up"><div class="ic"><i class="fas fa-handshake-angle"></i></div><h4>Purpose</h4><p>Work that keeps Ugandan businesses moving.</p></div>
		</div>
	</div>
</section>

<section class="section bg-soft">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">Open positions</span>
			<h2>Current openings</h2>
			<p>Don't see your role? We're always glad to hear from talented people — send us your CV.</p>
		</div>
		<div class="job-list">
			<?php
			$jobs = function_exists( 'noki_get_jobs' ) ? noki_get_jobs() : [];
			if ( $jobs ) :
				foreach ( $jobs as $job ) :
					$loc     = get_post_meta( $job->ID, '_job_location', true );
					$type    = get_post_meta( $job->ID, '_job_type', true );
					$dept    = get_post_meta( $job->ID, '_job_dept', true );
					$closing = get_post_meta( $job->ID, '_job_closing', true );
					?>
					<div class="job-card" data-aos="fade-up">
						<div>
							<h3><a href="<?php echo esc_url( get_permalink( $job ) ); ?>"><?php echo esc_html( get_the_title( $job ) ); ?></a></h3>
							<div class="job-meta">
								<?php if ( $loc ) : ?><span><i class="fas fa-location-dot"></i><?php echo esc_html( $loc ); ?></span><?php endif; ?>
								<?php if ( $type ) : ?><span><i class="fas fa-clock"></i><?php echo esc_html( $type ); ?></span><?php endif; ?>
								<?php if ( $dept ) : ?><span><i class="fas fa-layer-group"></i><?php echo esc_html( $dept ); ?></span><?php endif; ?>
								<?php if ( $closing ) : ?><span><i class="fas fa-calendar-xmark"></i>Closes <?php echo esc_html( date_i18n( 'M j, Y', strtotime( $closing ) ) ); ?></span><?php endif; ?>
							</div>
						</div>
						<a href="<?php echo esc_url( get_permalink( $job ) ); ?>" class="btn btn-dark btn-sm">View &amp; Apply <i class="fas fa-arrow-right"></i></a>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<div class="job-card" data-aos="fade-up" style="justify-content:center;text-align:center">
					<div>
						<h3 style="margin-bottom:.4rem">No open positions right now</h3>
						<p style="margin:0;color:var(--muted)">We're always glad to hear from talented people — send us your CV using the button below and we'll keep you in mind.</p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<h2>Ready to join us?</h2>
			<p>Send your CV and a short note about why you'd like to work with Noki Logistics.</p>
			<div class="cta-actions">
				<a href="mailto:<?php echo esc_attr( $email ); ?>?subject=Career%20Application" class="btn btn-primary btn-lg"><i class="fas fa-paper-plane"></i> Send Your CV</a>
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-ghost btn-lg" style="color:#fff;border-color:rgba(255,255,255,.4)">Contact Us</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer();
