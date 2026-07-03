<?php get_header(); the_post();
$phone    = get_theme_mod( 'noki_phone', '+256 772 540 483' );
$tel      = preg_replace( '/\s+/', '', $phone );
$id       = get_the_ID();
$loc      = get_post_meta( $id, '_job_location', true );
$type     = get_post_meta( $id, '_job_type', true );
$dept     = get_post_meta( $id, '_job_dept', true );
$closing  = get_post_meta( $id, '_job_closing', true );
$apply    = noki_job_apply_link( $id );
$expired  = $closing && strtotime( $closing ) < strtotime( date( 'Y-m-d' ) );
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">Careers</span>
		<h1><?php the_title(); ?></h1>
		<p class="breadcrumb">
			<a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo;
			<a href="<?php echo esc_url( home_url( '/join-us' ) ); ?>">Careers</a> &rsaquo;
			<?php the_title(); ?>
		</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="content-grid">

			<main>
				<div class="job-meta" style="margin-bottom:1.5rem;flex-wrap:wrap">
					<?php if ( $loc ) : ?><span><i class="fas fa-location-dot"></i> <?php echo esc_html( $loc ); ?></span><?php endif; ?>
					<?php if ( $type ) : ?><span><i class="fas fa-clock"></i> <?php echo esc_html( $type ); ?></span><?php endif; ?>
					<?php if ( $dept ) : ?><span><i class="fas fa-layer-group"></i> <?php echo esc_html( $dept ); ?></span><?php endif; ?>
					<?php if ( $closing ) : ?><span><i class="fas fa-calendar-xmark"></i> Closes <?php echo esc_html( date_i18n( 'M j, Y', strtotime( $closing ) ) ); ?></span><?php endif; ?>
				</div>

				<?php if ( $expired ) : ?>
					<p style="background:#fdecea;border:1px solid #f5c2c0;color:#b32d2e;padding:1rem 1.25rem;border-radius:var(--radius-lg);font-weight:600">This position has closed. Please see our current openings.</p>
				<?php endif; ?>

				<div class="post-content"><?php the_content(); ?></div>

				<?php if ( ! $expired ) : ?>
				<div class="cta-band" style="margin-top:2.5rem;padding:2.5rem;">
					<h2 style="font-size:1.8rem;">Interested in this role?</h2>
					<p>Send your CV and a short note about why you'd like to join Noki Logistics.</p>
					<div class="cta-actions">
						<a href="<?php echo esc_url( $apply ); ?>" class="btn btn-white"><i class="fas fa-paper-plane"></i> Apply for this Job</a>
						<a href="<?php echo esc_url( noki_whatsapp_link( 'Hi Noki Logistics, I would like to apply for the ' . get_the_title() . ' position.' ) ); ?>" target="_blank" rel="noopener" class="btn btn-ghost" style="color:#fff;border-color:rgba(255,255,255,.4)"><i class="fab fa-whatsapp"></i> Apply via WhatsApp</a>
					</div>
				</div>
				<?php endif; ?>
			</main>

			<aside class="sidebar">
				<div class="sidebar-widget">
					<h4>Other openings</h4>
					<?php
					$others = noki_get_jobs();
					$has_others = false;
					if ( $others ) : foreach ( $others as $j ) :
						if ( $j->ID === $id ) { continue; }
						$has_others = true; ?>
						<a href="<?php echo esc_url( get_permalink( $j ) ); ?>" style="display:flex;justify-content:space-between;align-items:center;padding:.7rem 0;border-bottom:1px solid var(--line);font-family:var(--font-head);font-weight:600;font-size:.92rem;color:var(--ink)">
							<?php echo esc_html( get_the_title( $j ) ); ?> <i class="fas fa-chevron-right" style="font-size:.7rem;"></i>
						</a>
					<?php endforeach; endif;
					if ( ! $has_others ) : ?>
						<p style="color:var(--muted);margin:0">No other openings right now.</p>
					<?php endif; ?>
					<a href="<?php echo esc_url( home_url( '/join-us' ) ); ?>" class="link-arrow" style="margin-top:1rem;display:inline-block">All careers <i class="fas fa-arrow-right"></i></a>
				</div>
				<div class="sidebar-widget sidebar-cta">
					<h4>No perfect fit?</h4>
					<p>Send us your CV anyway — we're always glad to hear from talented people.</p>
					<a href="<?php echo esc_url( noki_job_apply_link( $id ) ); ?>" class="btn btn-white btn-sm" style="width:100%;margin-top:.5rem;">Send Your CV</a>
				</div>
				<div class="sidebar-widget">
					<h4>Talk to us</h4>
					<p><i class="fas fa-phone" style="color:var(--primary);margin-right:.5rem;"></i><a href="tel:<?php echo esc_attr( $tel ); ?>" style="color:var(--ink);font-weight:600;"><?php echo esc_html( $phone ); ?></a></p>
				</div>
			</aside>
		</div>
	</div>
</section>

<?php get_footer(); ?>
