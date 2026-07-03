<?php
/*
Template Name: Our Team
*/
get_header();
?>

<div class="page-banner">
	<div class="container">
		<span class="kicker">The people</span>
		<h1>Meet the Noki team</h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <a href="<?php echo esc_url( home_url( '/about' ) ); ?>">About</a> &rsaquo; Our Team</p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="section-head center" data-aos="fade-up">
			<span class="kicker center">Behind every shipment</span>
			<h2>Experienced people who care</h2>
			<p>The people who move your cargo — a team that blends deep knowledge of East African trade with a genuine commitment to your success.</p>
		</div>
		<div class="team-grid">
			<?php
			$tpl  = get_template_directory_uri();
			$team = [
				[ 'team-1', 'Ibrahim Kiribira', 'Country Director' ],
				[ 'team-2', 'Jean Kule Marie', 'Operations Manager' ],
				[ 'team-3', 'Shamim Nassanga', 'Customer Experience Manager' ],
				[ 'team-4', 'Nicholas Olweny', 'Head of Finance' ],
				[ 'team-5', 'Annette Martha Nantongo', 'Business Development Executive' ],
				[ 'team-6', 'Emmanuel Oluma', 'Operations Associate' ],
				[ 'team-7', 'Peruth Nairuba', 'Customer Experience Executive' ],
				[ 'team-8', 'Nasser Tibamwenda', 'Customer Field Support' ],
				[ 'team-9', 'Patricia Nyakana', 'Graduate Trainee, Finance' ],
			];
			// Editable in wp-admin: Pages → Team → Team members. Falls back to the list above.
			$rows = noki_rows( 'team_members' );
			$members = [];
			if ( $rows ) {
				foreach ( $rows as $r ) {
					$members[] = [ $r['member_photo'], $r['member_name'], $r['member_role'] ];
				}
			} else {
				foreach ( $team as $m ) {
					$members[] = [ $tpl . '/images/team/' . $m[0] . '.jpg', $m[1], $m[2] ];
				}
			}
			foreach ( $members as $m ) : ?>
				<div class="team-card" data-aos="fade-up">
					<img src="<?php echo esc_url( $m[0] ); ?>" alt="<?php echo esc_attr( $m[1] . ' — ' . $m[2] ); ?>" loading="lazy">
					<div class="team-info"><strong><?php echo esc_html( $m[1] ); ?></strong><span><?php echo esc_html( $m[2] ); ?></span></div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section bg-dark">
	<div class="container">
		<div class="split" style="align-items:center">
			<div class="section-head" style="margin-bottom:0" data-aos="fade-right">
				<span class="kicker">Our culture</span>
				<h2>One team, one promise</h2>
			</div>
			<div data-aos="fade-left">
				<p style="color:#a89f94">Whatever your cargo, you deal with real people who pick up the phone, answer your questions and treat your shipment as if it were their own. That accountability is the heart of how we work.</p>
				<a href="<?php echo esc_url( home_url( '/join-us' ) ); ?>" class="btn btn-primary" style="margin-top:1.2rem">Join Our Team <i class="fas fa-arrow-right"></i></a>
			</div>
		</div>
	</div>
</section>

<section class="section">
	<div class="container">
		<div class="cta-band" data-aos="zoom">
			<h2>Work with a team that delivers</h2>
			<p>Get in touch and meet the people who'll move your cargo.</p>
			<div class="cta-actions"><a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn-primary btn-lg">Contact Us <i class="fas fa-arrow-right"></i></a></div>
		</div>
	</div>
</section>

<?php get_footer();
