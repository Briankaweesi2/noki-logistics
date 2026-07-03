<?php get_header(); the_post(); ?>

<div class="page-banner">
	<div class="container">
		<h1><?php the_title(); ?></h1>
		<p class="breadcrumb"><a href="<?php echo esc_url( home_url() ); ?>">Home</a> &rsaquo; <?php the_title(); ?></p>
	</div>
</div>

<section class="section">
	<div class="container">
		<div class="post-content" style="max-width:820px;margin:auto;">
			<?php the_content(); ?>
		</div>
	</div>
</section>

<?php get_footer(); ?>
