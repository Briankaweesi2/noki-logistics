<?php get_header(); ?>
<section class="error-404">
	<div class="container">
		<h1>404</h1>
		<h2>Page Not Found</h2>
		<p>Sorry, the page you're looking for doesn't exist or has been moved.</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary btn-lg">Back to Home</a>
	</div>
</section>
<?php get_footer(); ?>
