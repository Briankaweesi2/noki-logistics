<?php
defined( 'ABSPATH' ) || exit;

/* ===========================
   THEME SETUP
=========================== */
function noki_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ] );
	add_theme_support( 'custom-logo', [ 'width' => 200, 'height' => 80, 'flex-width' => true ] );
	add_theme_support( 'customize-selective-refresh-widgets' );

	register_nav_menus( [
		'primary' => __( 'Primary Navigation', 'noki-logistics' ),
		'footer'  => __( 'Footer Navigation', 'noki-logistics' ),
	] );

	add_image_size( 'noki-hero',    1200, 700, true );
	add_image_size( 'noki-card',    600,  400, true );
	add_image_size( 'noki-blog',    800,  500, true );
	add_image_size( 'noki-thumb',   400,  260, true );
}
add_action( 'after_setup_theme', 'noki_setup' );

/* ===========================
   ENQUEUE ASSETS
=========================== */
function noki_enqueue() {
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css2?family=Karla:wght@400;500;600;700&family=Poppins:wght@500;600;700;800&display=swap', [], null );
	wp_enqueue_style( 'noki-style', get_stylesheet_uri(), [ 'google-fonts' ], '2.4.0' );
	wp_enqueue_style( 'noki-icons', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css', [], '6.5.0' );
	wp_enqueue_script( 'noki-main', get_template_directory_uri() . '/js/main.js', [], '2.4.0', true );
	wp_localize_script( 'noki-main', 'nokiData', [
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'nonce'   => wp_create_nonce( 'noki_nonce' ),
	] );
}
add_action( 'wp_enqueue_scripts', 'noki_enqueue' );

/* ===========================
   ACF FIELDS (editable content)
   Field groups are defined in code so they appear automatically when the
   free "Advanced Custom Fields" plugin is active. Templates keep their
   hard-coded text as a fallback, so nothing breaks if ACF is inactive/empty.
=========================== */
require_once get_template_directory() . '/inc/acf-fields.php';

/**
 * Return an ACF field value, falling back to a default when ACF is
 * inactive or the field is empty. Use everywhere instead of get_field().
 *
 * @param string $name    Field name.
 * @param mixed  $default Fallback value (usually the current hard-coded text).
 * @param int|null $post_id Optional post/page ID.
 */
function noki_field( $name, $default = '', $post_id = null ) {
	if ( function_exists( 'get_field' ) ) {
		$val = get_field( $name, $post_id );
		if ( $val !== null && $val !== '' && $val !== false ) {
			return $val;
		}
	}
	return $default;
}

/* ===========================
   WIDGET AREAS
=========================== */
function noki_widgets_init() {
	register_sidebar( [
		'name'          => __( 'Blog Sidebar', 'noki-logistics' ),
		'id'            => 'blog-sidebar',
		'before_widget' => '<div class="sidebar-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4>',
		'after_title'   => '</h4>',
	] );
}
add_action( 'widgets_init', 'noki_widgets_init' );

/* ===========================
   CUSTOM POST TYPES
=========================== */
function noki_register_cpts() {
	// Services
	register_post_type( 'noki_service', [
		'labels'  => [
			'name'          => __( 'Services', 'noki-logistics' ),
			'singular_name' => __( 'Service', 'noki-logistics' ),
			'add_new_item'  => __( 'Add New Service', 'noki-logistics' ),
			'edit_item'     => __( 'Edit Service', 'noki-logistics' ),
		],
		'public'       => true,
		'show_in_rest' => true,
		'has_archive'  => 'services',
		'rewrite'      => [ 'slug' => 'services' ],
		'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		'menu_icon'    => 'dashicons-truck',
		'menu_position' => 5,
	] );

	// News & Events
	register_post_type( 'noki_news', [
		'labels'  => [
			'name'          => __( 'News & Events', 'noki-logistics' ),
			'singular_name' => __( 'News Item', 'noki-logistics' ),
			'add_new_item'  => __( 'Add News / Event', 'noki-logistics' ),
			'edit_item'     => __( 'Edit News / Event', 'noki-logistics' ),
			'menu_name'     => __( 'News & Events', 'noki-logistics' ),
		],
		'public'        => true,
		'show_in_rest'  => true,
		'has_archive'   => 'news',
		'rewrite'       => [ 'slug' => 'news' ],
		'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		'menu_icon'     => 'dashicons-megaphone',
		'menu_position' => 6,
	] );

	// News type taxonomy (News / Events / Announcements)
	register_taxonomy( 'news_type', 'noki_news', [
		'labels'            => [
			'name'          => __( 'News Types', 'noki-logistics' ),
			'singular_name' => __( 'News Type', 'noki-logistics' ),
		],
		'public'            => true,
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => [ 'slug' => 'news-type' ],
	] );

	// Testimonials
	register_post_type( 'noki_testimonial', [
		'labels'  => [
			'name'          => __( 'Testimonials', 'noki-logistics' ),
			'singular_name' => __( 'Testimonial', 'noki-logistics' ),
		],
		'public'       => false,
		'show_ui'      => true,
		'show_in_rest' => true,
		'supports'     => [ 'title', 'editor', 'thumbnail' ],
		'menu_icon'    => 'dashicons-format-quote',
		'menu_position' => 6,
	] );
}
add_action( 'init', 'noki_register_cpts' );

/* ===========================
   CUSTOM META BOXES
=========================== */
function noki_add_meta_boxes() {
	add_meta_box( 'noki_service_meta', __( 'Service Details', 'noki-logistics' ), 'noki_service_meta_cb', 'noki_service', 'normal', 'high' );
	add_meta_box( 'noki_testimonial_meta', __( 'Testimonial Details', 'noki-logistics' ), 'noki_testimonial_meta_cb', 'noki_testimonial', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'noki_add_meta_boxes' );

function noki_service_meta_cb( $post ) {
	wp_nonce_field( 'noki_service_save', 'noki_service_nonce' );
	$icon     = get_post_meta( $post->ID, '_service_icon', true );
	$features = get_post_meta( $post->ID, '_service_features', true );
	$order    = get_post_meta( $post->ID, '_service_order', true );
	?>
	<table class="form-table">
		<tr>
			<th><label for="service_icon">Font Awesome Icon class</label></th>
			<td><input type="text" id="service_icon" name="service_icon" value="<?php echo esc_attr( $icon ); ?>" class="regular-text" placeholder="e.g. fa-plane" /></td>
		</tr>
		<tr>
			<th><label for="service_features">Key Features (one per line)</label></th>
			<td><textarea id="service_features" name="service_features" rows="5" class="large-text"><?php echo esc_textarea( $features ); ?></textarea></td>
		</tr>
		<tr>
			<th><label for="service_order">Display Order</label></th>
			<td><input type="number" id="service_order" name="service_order" value="<?php echo esc_attr( $order ); ?>" class="small-text" /></td>
		</tr>
	</table>
	<?php
}

function noki_testimonial_meta_cb( $post ) {
	wp_nonce_field( 'noki_testimonial_save', 'noki_testimonial_nonce' );
	$role    = get_post_meta( $post->ID, '_testimonial_role', true );
	$company = get_post_meta( $post->ID, '_testimonial_company', true );
	$rating  = get_post_meta( $post->ID, '_testimonial_rating', true ) ?: 5;
	?>
	<table class="form-table">
		<tr>
			<th><label for="testimonial_role">Role / Job Title</label></th>
			<td><input type="text" id="testimonial_role" name="testimonial_role" value="<?php echo esc_attr( $role ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="testimonial_company">Company</label></th>
			<td><input type="text" id="testimonial_company" name="testimonial_company" value="<?php echo esc_attr( $company ); ?>" class="regular-text" /></td>
		</tr>
		<tr>
			<th><label for="testimonial_rating">Rating (1–5)</label></th>
			<td><input type="number" id="testimonial_rating" name="testimonial_rating" value="<?php echo esc_attr( $rating ); ?>" min="1" max="5" class="small-text" /></td>
		</tr>
	</table>
	<?php
}

function noki_save_meta( $post_id ) {
	// Service
	if ( isset( $_POST['noki_service_nonce'] ) && wp_verify_nonce( $_POST['noki_service_nonce'], 'noki_service_save' ) ) {
		update_post_meta( $post_id, '_service_icon', sanitize_text_field( $_POST['service_icon'] ?? '' ) );
		update_post_meta( $post_id, '_service_features', sanitize_textarea_field( $_POST['service_features'] ?? '' ) );
		update_post_meta( $post_id, '_service_order', absint( $_POST['service_order'] ?? 0 ) );
	}
	// Testimonial
	if ( isset( $_POST['noki_testimonial_nonce'] ) && wp_verify_nonce( $_POST['noki_testimonial_nonce'], 'noki_testimonial_save' ) ) {
		update_post_meta( $post_id, '_testimonial_role', sanitize_text_field( $_POST['testimonial_role'] ?? '' ) );
		update_post_meta( $post_id, '_testimonial_company', sanitize_text_field( $_POST['testimonial_company'] ?? '' ) );
		update_post_meta( $post_id, '_testimonial_rating', absint( $_POST['testimonial_rating'] ?? 5 ) );
	}
}
add_action( 'save_post', 'noki_save_meta' );

/* ===========================
   CONTACT FORM AJAX HANDLER
=========================== */
function noki_handle_contact() {
	check_ajax_referer( 'noki_nonce', 'nonce' );

	$name    = sanitize_text_field( $_POST['name'] ?? '' );
	$email   = sanitize_email( $_POST['email'] ?? '' );
	$phone   = sanitize_text_field( $_POST['phone'] ?? '' );
	$subject = sanitize_text_field( $_POST['subject'] ?? '' );
	$message = sanitize_textarea_field( $_POST['message'] ?? '' );
	// Optional shipment/quote fields.
	$origin  = sanitize_text_field( $_POST['origin'] ?? '' );
	$dest    = sanitize_text_field( $_POST['destination'] ?? '' );
	$cargo   = sanitize_text_field( $_POST['cargo'] ?? '' );

	if ( ! $name || ! $email || ! $message ) {
		wp_send_json_error( [ 'message' => 'Please fill in all required fields.' ] );
	}

	if ( ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
	}

	// Send to the business inbox (and the WordPress admin email as a backup).
	$to      = 'nokilogistics@gmail.com';
	$admin   = get_option( 'admin_email' );
	$headers = [ 'Content-Type: text/html; charset=UTF-8', "Reply-To: {$name} <{$email}>" ];
	if ( $admin && $admin !== $to ) {
		$headers[] = 'Cc: ' . $admin;
	}
	$ship    = '';
	if ( $origin || $dest || $cargo ) {
		$ship = '<p><strong>Origin:</strong> ' . esc_html( $origin ) . '</p>'
			. '<p><strong>Destination:</strong> ' . esc_html( $dest ) . '</p>'
			. '<p><strong>Cargo (weight / volume / type):</strong> ' . esc_html( $cargo ) . '</p>';
	}
	$body    = "<h3>New Quote / Contact Request</h3>
		<p><strong>Name:</strong> {$name}</p>
		<p><strong>Email:</strong> {$email}</p>
		<p><strong>Phone:</strong> {$phone}</p>
		<p><strong>Service:</strong> {$subject}</p>"
		. $ship .
		"<p><strong>Message:</strong></p>
		<p>" . nl2br( $message ) . '</p>';

	$sent = wp_mail( $to, "Quote request: {$subject}", $body, $headers );

	// Build a WhatsApp message so the visitor can also send the same details to Noki.
	$wa_text = "New quote request%0A"
		. "Name: {$name}%0A"
		. "Phone: {$phone}%0A"
		. "Service: {$subject}%0A"
		. ( $origin ? "Origin: {$origin}%0A" : '' )
		. ( $dest ? "Destination: {$dest}%0A" : '' )
		. ( $cargo ? "Cargo: {$cargo}%0A" : '' )
		. "Message: {$message}";
	$wa_num = preg_replace( '/[^0-9]/', '', get_theme_mod( 'noki_whatsapp', '+256772540483' ) );
	$wa_url = 'https://wa.me/' . $wa_num . '?text=' . rawurlencode( html_entity_decode( str_replace( '%0A', "\n", $wa_text ) ) );

	if ( $sent ) {
		wp_send_json_success( [
			'message'  => 'Thank you! Your request has been sent — opening WhatsApp so you can send it to us there too.',
			'whatsapp' => $wa_url,
		] );
	} else {
		// Email failed (common on shared hosts without SMTP) — still let them reach us on WhatsApp.
		wp_send_json_success( [
			'message'  => 'Opening WhatsApp so you can send your request to us directly.',
			'whatsapp' => $wa_url,
		] );
	}
}
add_action( 'wp_ajax_noki_contact', 'noki_handle_contact' );
add_action( 'wp_ajax_nopriv_noki_contact', 'noki_handle_contact' );

/* ===========================
   NEWSLETTER AJAX HANDLER
=========================== */
function noki_handle_newsletter() {
	check_ajax_referer( 'noki_nonce', 'nonce' );
	$email = sanitize_email( $_POST['email'] ?? '' );
	if ( ! is_email( $email ) ) {
		wp_send_json_error( [ 'message' => 'Please enter a valid email address.' ] );
	}
	// Store in options as simple list (upgrade to Mailchimp/Brevo plugin later)
	$subscribers = get_option( 'noki_newsletter_subscribers', [] );
	if ( in_array( $email, $subscribers, true ) ) {
		wp_send_json_error( [ 'message' => 'You are already subscribed!' ] );
	}
	$subscribers[] = $email;
	update_option( 'noki_newsletter_subscribers', $subscribers );
	wp_send_json_success( [ 'message' => 'Thank you for subscribing!' ] );
}
add_action( 'wp_ajax_noki_newsletter', 'noki_handle_newsletter' );
add_action( 'wp_ajax_nopriv_noki_newsletter', 'noki_handle_newsletter' );

/* ===========================
   HELPERS
=========================== */
function noki_get_services( $limit = -1 ) {
	return get_posts( [
		'post_type'      => 'noki_service',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => 'meta_value_num',
		'meta_key'       => '_service_order',
		'order'          => 'ASC',
	] );
}

function noki_get_testimonials( $limit = 6 ) {
	return get_posts( [
		'post_type'      => 'noki_testimonial',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => 'rand',
	] );
}

function noki_get_news( $limit = 4 ) {
	return get_posts( [
		'post_type'      => 'noki_news',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
	] );
}

/* First News Type term name for a news item (e.g. "News" / "Event"). */
function noki_news_type( $post_id ) {
	$terms = get_the_terms( $post_id, 'news_type' );
	return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : 'News';
}

function noki_star_rating( $rating ) {
	$rating = (int) $rating;
	$html   = '<div class="testimonial-stars">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$html .= $i <= $rating ? '★' : '☆';
	}
	return $html . '</div>';
}

function noki_excerpt( $post, $length = 20 ) {
	$text = has_excerpt( $post->ID ) ? get_the_excerpt( $post ) : wp_trim_words( get_the_content( null, false, $post ), $length );
	return $text;
}

function noki_social_share( $url, $title ) {
	return sprintf(
		'<div class="post-share"><span>Share:</span>
		<a href="https://www.facebook.com/sharer/sharer.php?u=%s" target="_blank" rel="noopener"><i class="fab fa-facebook-f"></i></a>
		<a href="https://twitter.com/intent/tweet?url=%s&text=%s" target="_blank" rel="noopener"><i class="fab fa-x-twitter"></i></a>
		<a href="https://wa.me/?text=%s%%20%s" target="_blank" rel="noopener"><i class="fab fa-whatsapp"></i></a>
		</div>',
		rawurlencode( $url ), rawurlencode( $url ), rawurlencode( $title ), rawurlencode( $title ), rawurlencode( $url )
	);
}

/* ===========================
   ADMIN CUSTOMISATIONS
=========================== */
function noki_dashboard_widgets() {
	wp_add_dashboard_widget( 'noki_edit_guide', '✏️  Edit Your Website — Quick Guide', 'noki_edit_guide_cb', null, null, 'normal', 'high' );
}
add_action( 'wp_dashboard_setup', 'noki_dashboard_widgets' );

function noki_edit_guide_cb() {
	$card = function ( $icon, $title, $desc, $btn, $url, $btn2 = '', $url2 = '' ) {
		echo '<div style="border:1px solid #e2e4e7;border-radius:8px;padding:14px 16px;margin-bottom:12px;background:#fff;">'
			. '<p style="margin:0 0 4px;font-size:14px;font-weight:600;">' . $icon . ' ' . esc_html( $title ) . '</p>'
			. '<p style="margin:0 0 10px;color:#50575e;">' . wp_kses_post( $desc ) . '</p>'
			. '<a class="button button-primary" href="' . esc_url( $url ) . '">' . esc_html( $btn ) . '</a>';
		if ( $btn2 ) {
			echo ' <a class="button" href="' . esc_url( $url2 ) . '">' . esc_html( $btn2 ) . '</a>';
		}
		echo '</div>';
	};
	echo '<p style="font-size:13px;color:#50575e;margin-top:0;">Everything you need to run the site is below. No coding required — just click, type, and press <strong>Publish</strong> or <strong>Update</strong>.</p>';

	$card( '📝', 'Blog articles', '<strong>Add a new article:</strong> title, your text, a <strong>Featured Image</strong>, a category, then <strong>Publish</strong>.<br><strong>Edit an existing one:</strong> click “Edit existing posts”, then click any article’s title in the list, change it, and press <strong>Update</strong>. Use <em>Trash</em> under a title to remove it.', 'Add a blog post', admin_url( 'post-new.php' ), 'Edit existing posts', admin_url( 'edit.php' ) );

	$card( '📣', 'News &amp; Events', '<strong>Add news / an event:</strong> title, text, a <strong>Featured Image</strong>, a <strong>News Type</strong> (News / Event / Announcement), then <strong>Publish</strong> — it shows in “Special Highlights” on the homepage and the News page.<br><strong>Edit an existing one:</strong> click “Edit existing news”, then click any item’s title, change it, and press <strong>Update</strong>.', 'Add news / event', admin_url( 'post-new.php?post_type=noki_news' ), 'Edit existing news', admin_url( 'edit.php?post_type=noki_news' ) );

	$card( '🚚', 'Services', 'Edit what appears in the Services menu and cards — title, description, and a Font Awesome icon.', 'Manage services', admin_url( 'edit.php?post_type=noki_service' ) );

	$card( '⭐', 'Testimonials', 'Add client reviews (name, role/company, rating, quote) that appear across the site.', 'Manage testimonials', admin_url( 'edit.php?post_type=noki_testimonial' ) );

	$card( '📞', 'Contact details, social links &amp; stats', 'Change the phone, WhatsApp, email, address, opening hours, the homepage numbers, and your Facebook / X / Instagram / TikTok / LinkedIn links — all in one place.', 'Open site settings', admin_url( 'customize.php?autofocus[section]=noki_options' ) );

	$card( '🖼️', 'Photos &amp; files', 'Upload or replace images here first, then insert them into a post or page.', 'Open Media Library', admin_url( 'upload.php' ) );

	echo '<div style="border:1px dashed #c3c4c7;border-radius:8px;padding:12px 16px;background:#f6f7f7;font-size:13px;color:#50575e;">'
		. '<strong>Need to change the wording or photos on the Home, Who&nbsp;We&nbsp;Are, Team, Pricing or FAQ pages?</strong><br>'
		. 'Those pages use a fixed, designed layout. Send the new text/photos to your web person and they will update it quickly, or ask to have those pages switched to click-to-edit fields.'
		. '</div>';
}

/* Theme Customizer options */
function noki_customizer( $wp_customize ) {
	$wp_customize->add_section( 'noki_options', [ 'title' => 'Noki Theme Options', 'priority' => 30 ] );

	$fields = [
		'noki_phone'      => [ 'label' => 'Phone Number', 'default' => '+256 772 540 483' ],
		'noki_whatsapp'   => [ 'label' => 'WhatsApp Number', 'default' => '+256772540483' ],
		'noki_email'      => [ 'label' => 'Email Address', 'default' => 'info@nokilogistics.com' ],
		'noki_address'    => [ 'label' => 'Address', 'default' => 'Plot No. 53/55 Semawata Road, Elgon Rise, Ntinda, Kampala' ],
		'noki_hours'      => [ 'label' => 'Business Hours', 'default' => 'Mon – Sat: 8:00am – 6:30pm' ],
		'noki_stat_1_num' => [ 'label' => 'Stat 1 Number', 'default' => '500+' ],
		'noki_stat_1_lbl' => [ 'label' => 'Stat 1 Label', 'default' => 'Shipments Delivered' ],
		'noki_stat_2_num' => [ 'label' => 'Stat 2 Number', 'default' => '10+' ],
		'noki_stat_2_lbl' => [ 'label' => 'Stat 2 Label', 'default' => 'Years Experience' ],
		'noki_stat_3_num' => [ 'label' => 'Stat 3 Number', 'default' => '98%' ],
		'noki_stat_3_lbl' => [ 'label' => 'Stat 3 Label', 'default' => 'On-Time Delivery' ],
		'noki_stat_4_num' => [ 'label' => 'Stat 4 Number', 'default' => '24/7' ],
		'noki_stat_4_lbl' => [ 'label' => 'Stat 4 Label', 'default' => 'Customer Support' ],
		'noki_facebook'   => [ 'label' => 'Facebook URL', 'default' => '' ],
		'noki_twitter'    => [ 'label' => 'X (Twitter) URL', 'default' => '' ],
		'noki_linkedin'   => [ 'label' => 'LinkedIn URL', 'default' => '' ],
		'noki_instagram'  => [ 'label' => 'Instagram URL', 'default' => '' ],
		'noki_tiktok'     => [ 'label' => 'TikTok URL', 'default' => '' ],
		'noki_youtube'    => [ 'label' => 'YouTube URL', 'default' => '' ],
	];

	foreach ( $fields as $id => $args ) {
		$wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
		$wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'noki_options', 'type' => 'text' ] );
	}
}
add_action( 'customize_register', 'noki_customizer' );

/* ===========================================================
   RESTORE CODED THEME  (undo leftover Elementor / Xpro state)
   These make the theme render its own header/footer/templates
   even if Xpro Theme Builder or Elementor is still active or a
   page still has a stale "elementor_header_footer" template.
=========================================================== */

// 1. Force the theme's own header.php / footer.php (bypass Xpro Theme Builder override).
add_filter( 'xpro_theme_builder_header_enabled', '__return_false', 99 );
add_filter( 'xpro_theme_builder_footer_enabled', '__return_false', 99 );

// 2. Force page-{slug}.php templates over any stale assigned template (e.g. elementor_header_footer).
function noki_force_page_templates( $template ) {
	if ( is_front_page() ) {
		$fp = locate_template( 'front-page.php' );
		if ( $fp ) {
			return $fp;
		}
	}
	if ( is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		$map  = [
			'about'          => 'page-about.php',
			'why-choose-us'  => 'page-why-choose-us.php',
			'our-team'       => 'page-our-team.php',
			'join-us'        => 'page-join-us.php',
			'pricing'        => 'page-pricing.php',
			'testimonials'   => 'page-testimonials.php',
			'faq'            => 'page-faq.php',
			'contact'        => 'page-contact.php',
		];
		if ( isset( $map[ $slug ] ) ) {
			$found = locate_template( $map[ $slug ] );
			if ( $found ) {
				return $found;
			}
		}
	}
	return $template;
}
add_filter( 'template_include', 'noki_force_page_templates', 999 );

// 3. Ignore Elementor's stored page content on these pages (templates provide their own layout).
add_filter( 'elementor/frontend/builder_content_data', function ( $data, $post_id ) {
	$slug = get_post_field( 'post_name', $post_id );
	$coded = [ 'about', 'why-choose-us', 'our-team', 'join-us', 'pricing', 'testimonials', 'faq', 'contact', 'home' ];
	if ( in_array( $slug, $coded, true ) ) {
		return [];
	}
	return $data;
}, 10, 2 );

/* ===========================
   CLICK-TO-EDIT PAGE FIELDS (ACF)
   Makes the fixed marketing pages editable in wp-admin with plain
   labelled boxes. Everything falls back to the built-in design when a
   field is empty or ACF is inactive, so the site never breaks.
=========================== */

// Safe single-field read with a fallback default.
function noki_f( $name, $default = '', $post_id = false ) {
	if ( function_exists( 'get_field' ) ) {
		$v = get_field( $name, $post_id );
		if ( $v !== null && $v !== '' && $v !== false && $v !== [] ) {
			return $v;
		}
	}
	return $default;
}

// Safe repeater read — returns rows array or [] .
function noki_rows( $name, $post_id = false ) {
	if ( function_exists( 'get_field' ) ) {
		$v = get_field( $name, $post_id );
		if ( is_array( $v ) && $v ) {
			return $v;
		}
	}
	return [];
}

// --- Custom ACF location rule: "Page Slug" (portable across installs) ---
add_filter( 'acf/location/rule_types', function ( $choices ) {
	$choices['Noki']['noki_page_slug'] = 'Page Slug';
	return $choices;
} );
add_filter( 'acf/location/rule_values/noki_page_slug', function ( $choices ) {
	$choices['home']     = 'Home page';
	$choices['about']    = 'Who We Are';
	$choices['our-team'] = 'Team';
	$choices['pricing']  = 'Pricing';
	$choices['faq']      = 'FAQ';
	return $choices;
} );
add_filter( 'acf/location/rule_match/noki_page_slug', function ( $match, $rule, $options ) {
	$post_id = 0;
	if ( ! empty( $options['post_id'] ) ) {
		$post_id = $options['post_id'];
	} elseif ( isset( $_GET['post'] ) ) {
		$post_id = absint( $_GET['post'] );
	}
	if ( ! $post_id ) {
		return false;
	}
	$slug = get_post_field( 'post_name', $post_id );
	return ( '==' === $rule['operator'] ) ? ( $slug === $rule['value'] ) : ( $slug !== $rule['value'] );
}, 10, 3 );

// --- Register the field groups ---
add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	$loc = function ( $slug ) {
		return [ [ [ 'param' => 'noki_page_slug', 'operator' => '==', 'value' => $slug ] ] ];
	};

	// ---------- FAQ ----------
	acf_add_local_field_group( [
		'key'      => 'group_noki_faq',
		'title'    => 'FAQ — Questions & Answers',
		'location' => $loc( 'faq' ),
		'fields'   => [ [
			'key' => 'field_faq_items', 'label' => 'Questions', 'name' => 'faq_items',
			'type' => 'repeater', 'button_label' => 'Add question', 'layout' => 'block',
			'sub_fields' => [
				[ 'key' => 'field_faq_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text' ],
				[ 'key' => 'field_faq_a', 'label' => 'Answer', 'name' => 'answer', 'type' => 'textarea', 'rows' => 3 ],
			],
		] ],
	] );

	// ---------- Team ----------
	acf_add_local_field_group( [
		'key'      => 'group_noki_team',
		'title'    => 'Team Members',
		'location' => $loc( 'our-team' ),
		'fields'   => [ [
			'key' => 'field_team_members', 'label' => 'Team members', 'name' => 'team_members',
			'type' => 'repeater', 'button_label' => 'Add team member', 'layout' => 'block',
			'sub_fields' => [
				[ 'key' => 'field_tm_photo', 'label' => 'Photo', 'name' => 'member_photo', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'thumbnail' ],
				[ 'key' => 'field_tm_name', 'label' => 'Name', 'name' => 'member_name', 'type' => 'text' ],
				[ 'key' => 'field_tm_role', 'label' => 'Role / title', 'name' => 'member_role', 'type' => 'text' ],
			],
		] ],
	] );

	// ---------- Pricing ----------
	acf_add_local_field_group( [
		'key'      => 'group_noki_pricing',
		'title'    => 'Pricing Packages',
		'location' => $loc( 'pricing' ),
		'fields'   => [
			[
				'key' => 'field_price_tiers', 'label' => 'Packages', 'name' => 'pricing_tiers',
				'type' => 'repeater', 'button_label' => 'Add package', 'layout' => 'block',
				'sub_fields' => [
					[ 'key' => 'field_pt_tag', 'label' => 'Small tag (e.g. Most popular)', 'name' => 'tier_tag', 'type' => 'text' ],
					[ 'key' => 'field_pt_title', 'label' => 'Package name', 'name' => 'tier_title', 'type' => 'text' ],
					[ 'key' => 'field_pt_desc', 'label' => 'Short description', 'name' => 'tier_desc', 'type' => 'textarea', 'rows' => 2 ],
					[ 'key' => 'field_pt_price', 'label' => 'Price (e.g. From quote)', 'name' => 'tier_price', 'type' => 'text' ],
					[ 'key' => 'field_pt_note', 'label' => 'Price note (e.g. / shipment)', 'name' => 'tier_note', 'type' => 'text' ],
					[ 'key' => 'field_pt_features', 'label' => 'Features (one per line)', 'name' => 'tier_features', 'type' => 'textarea', 'rows' => 5 ],
					[ 'key' => 'field_pt_btn', 'label' => 'Button label', 'name' => 'tier_button', 'type' => 'text', 'default_value' => 'Get a Quote' ],
					[ 'key' => 'field_pt_feat', 'label' => 'Highlight this package?', 'name' => 'tier_featured', 'type' => 'true_false', 'ui' => 1 ],
				],
			],
			[
				'key' => 'field_price_faqs', 'label' => 'Pricing FAQs', 'name' => 'pricing_faqs',
				'type' => 'repeater', 'button_label' => 'Add question', 'layout' => 'block',
				'sub_fields' => [
					[ 'key' => 'field_pf_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text' ],
					[ 'key' => 'field_pf_a', 'label' => 'Answer', 'name' => 'answer', 'type' => 'textarea', 'rows' => 3 ],
				],
			],
		],
	] );

	// ---------- Who We Are (about) ----------
	acf_add_local_field_group( [
		'key'      => 'group_noki_about',
		'title'    => 'Who We Are — Story & Values',
		'location' => $loc( 'about' ),
		'fields'   => [
			[ 'key' => 'field_ab_title', 'label' => 'Story heading', 'name' => 'about_story_title', 'type' => 'text' ],
			[ 'key' => 'field_ab_p1', 'label' => 'Story paragraph 1', 'name' => 'about_story_p1', 'type' => 'textarea', 'rows' => 4 ],
			[ 'key' => 'field_ab_p2', 'label' => 'Story paragraph 2', 'name' => 'about_story_p2', 'type' => 'textarea', 'rows' => 4 ],
			[ 'key' => 'field_ab_img', 'label' => 'Story photo', 'name' => 'about_image', 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium' ],
			[
				'key' => 'field_ab_values', 'label' => 'Values', 'name' => 'about_values',
				'type' => 'repeater', 'button_label' => 'Add value', 'layout' => 'block',
				'sub_fields' => [
					[ 'key' => 'field_av_emoji', 'label' => 'Icon (emoji)', 'name' => 'value_emoji', 'type' => 'text' ],
					[ 'key' => 'field_av_title', 'label' => 'Title', 'name' => 'value_title', 'type' => 'text' ],
					[ 'key' => 'field_av_text', 'label' => 'Description', 'name' => 'value_text', 'type' => 'textarea', 'rows' => 2 ],
				],
			],
		],
	] );

} );

/* Default FAQ list — shared by the FAQ template and FAQ schema so they never drift. */
function noki_default_faqs() {
	return [
		[ 'What types of freight does Noki handle?', 'We handle air freight, sea freight (FCL and LCL), road and cross-border transport, customs clearance, warehousing and express courier delivery — for everything from a single parcel to full container loads.' ],
		[ 'Which countries and routes do you cover?', 'We move cargo to and from Uganda and across the East African Community — Kenya, Tanzania, Rwanda, DRC and South Sudan — as well as international air and sea routes via Entebbe, Mombasa and Dar es Salaam.' ],
		[ 'How do I get a quote?', 'Send us your cargo details through the contact form, by phone or on WhatsApp. We respond with a clear, itemised quote within about 2 hours during business hours.' ],
		[ 'How long does shipping take?', 'It depends on the route and mode. Express domestic delivery can be same-day; air freight typically takes a few days; sea freight is several weeks. We give you a realistic timeline with every quote.' ],
		[ 'Can I track my shipment?', 'Yes. You get proactive updates and can check on your cargo at any time through your dedicated coordinator — by call or WhatsApp.' ],
		[ 'Do you handle customs clearance?', 'Absolutely. Our licensed clearing agents manage URA documentation and border formalities so your goods move through without costly delays.' ],
		[ 'Is my cargo insured?', 'We offer comprehensive cargo insurance options that protect your goods from pickup to final delivery. Ask us to include cover in your quote.' ],
		[ 'How is pricing calculated?', 'Mainly by weight, volume, route and urgency. Government duties and taxes are shown separately so you always see the full landed cost upfront — no hidden fees.' ],
		[ 'What payment methods do you accept?', 'We accept bank transfer, mobile money and other common methods. Payment terms can be arranged for regular business clients.' ],
		[ 'Do you offer warehousing?', 'Yes — secure, organised storage with inventory management and distribution from our Kampala facilities, available short- or long-term.' ],
	];
}

/* ===========================
   SEO: JSON-LD STRUCTURED DATA
   LocalBusiness (site-wide), Service (service pages), FAQPage (FAQ),
   BreadcrumbList (inner pages). No plugin required.
=========================== */
function noki_schema_ld() {
	$name    = get_bloginfo( 'name' );
	$home    = home_url( '/' );
	$logo    = get_template_directory_uri() . '/images/noki-logo.svg';
	$phone   = get_theme_mod( 'noki_phone', '+256 772 540 483' );
	$email   = get_theme_mod( 'noki_email', 'info@nokilogistics.com' );
	$address = get_theme_mod( 'noki_address', 'Plot No. 53/55 Semawata Road, Elgon Rise, Ntinda, Kampala' );

	// Social links (only those set in Customizer).
	$sameas = [];
	foreach ( [ 'noki_facebook', 'noki_twitter', 'noki_instagram', 'noki_tiktok', 'noki_linkedin', 'noki_youtube' ] as $mod ) {
		$u = get_theme_mod( $mod );
		if ( $u ) {
			$sameas[] = esc_url_raw( $u );
		}
	}

	$graph = [];

	// --- LocalBusiness (site-wide) ---
	$business = [
		'@type'       => 'MovingCompany',
		'@id'         => $home . '#business',
		'name'        => $name,
		'url'         => $home,
		'logo'        => $logo,
		'image'       => get_template_directory_uri() . '/images/hero-1.jpg',
		'telephone'   => $phone,
		'email'       => $email,
		'priceRange'  => '$$',
		'description' => 'Freight and logistics company in Kampala, Uganda — air freight, sea freight, road transport, customs clearance and warehousing across East Africa.',
		'address'     => [
			'@type'           => 'PostalAddress',
			'streetAddress'   => 'Plot No. 53/55 Semawata Road, Elgon Rise, Ntinda',
			'addressLocality' => 'Kampala',
			'addressCountry'  => 'UG',
		],
		'geo'         => [ '@type' => 'GeoCoordinates', 'latitude' => 0.3583, 'longitude' => 32.6144 ],
		'areaServed'  => [ 'Uganda', 'Kenya', 'Tanzania', 'Rwanda', 'DRC', 'South Sudan', 'East Africa' ],
		'openingHoursSpecification' => [ [
			'@type'     => 'OpeningHoursSpecification',
			'dayOfWeek' => [ 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ],
			'opens'     => '08:00',
			'closes'    => '18:30',
		] ],
	];
	if ( $sameas ) {
		$business['sameAs'] = $sameas;
	}
	$graph[] = $business;

	// --- WebSite ---
	$graph[] = [
		'@type' => 'WebSite',
		'@id'   => $home . '#website',
		'url'   => $home,
		'name'  => $name,
		'publisher' => [ '@id' => $home . '#business' ],
	];

	// --- Service (on single service pages) ---
	if ( is_singular( 'noki_service' ) ) {
		$graph[] = [
			'@type'           => 'Service',
			'name'            => get_the_title(),
			'serviceType'     => get_the_title(),
			'description'     => wp_strip_all_tags( get_the_excerpt() ),
			'url'             => get_permalink(),
			'provider'        => [ '@id' => $home . '#business' ],
			'areaServed'      => [ 'Uganda', 'East Africa' ],
		];
	}

	// --- FAQPage (FAQ + Pricing pages, from ACF or template defaults) ---
	if ( is_page( [ 'faq' ] ) || is_page( [ 'pricing' ] ) ) {
		$faq_rows = function_exists( 'noki_rows' ) ? noki_rows( is_page( 'pricing' ) ? 'pricing_faqs' : 'faq_items' ) : [];
		$pairs    = [];
		foreach ( $faq_rows as $r ) {
			if ( ! empty( $r['question'] ) && ! empty( $r['answer'] ) ) {
				$pairs[] = [ $r['question'], $r['answer'] ];
			}
		}
		// Fall back to the template's default FAQs (FAQ page) so schema is present even before ACF is filled.
		if ( ! $pairs && is_page( 'faq' ) ) {
			$pairs = noki_default_faqs();
		}
		$faqs = [];
		foreach ( $pairs as $p ) {
			$faqs[] = [
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $p[0] ),
				'acceptedAnswer' => [ '@type' => 'Answer', 'text' => wp_strip_all_tags( $p[1] ) ],
			];
		}
		if ( $faqs ) {
			$graph[] = [ '@type' => 'FAQPage', 'mainEntity' => $faqs ];
		}
	}

	// --- BreadcrumbList (inner pages & singles) ---
	if ( ! is_front_page() && ( is_page() || is_singular() ) ) {
		$items = [ [ '@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => $home ] ];
		$items[] = [ '@type' => 'ListItem', 'position' => 2, 'name' => wp_strip_all_tags( get_the_title() ), 'item' => get_permalink() ];
		$graph[] = [ '@type' => 'BreadcrumbList', 'itemListElement' => $items ];
	}

	$data = [ '@context' => 'https://schema.org', '@graph' => $graph ];
	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
}
add_action( 'wp_head', 'noki_schema_ld', 20 );

/* ===========================
   SEO / CONVERSION: WhatsApp deep link helper
=========================== */
function noki_whatsapp_link( $message = '' ) {
	$num = preg_replace( '/[^0-9]/', '', get_theme_mod( 'noki_whatsapp', '+256772540483' ) );
	$url = 'https://wa.me/' . $num;
	if ( $message ) {
		$url .= '?text=' . rawurlencode( $message );
	}
	return $url;
}

/* ===========================
   Service image with theme fallback
   Imported service pages have no featured image — fall back to a matching
   theme photo based on the service's Font Awesome icon (or slug).
=========================== */
function noki_service_img( $post, $size = 'noki-card' ) {
	$url = get_the_post_thumbnail_url( $post, $size );
	if ( $url ) {
		return $url;
	}
	$id   = is_object( $post ) ? $post->ID : $post;
	$icon = get_post_meta( $id, '_service_icon', true );
	$slug = get_post_field( 'post_name', $id );
	$base = get_template_directory_uri() . '/images/';
	$map  = [
		'fa-plane'     => 'service-air.jpg',
		'fa-ship'      => 'service-sea.jpg',
		'fa-truck'     => 'service-road.jpg',
		'fa-box-open'  => 'service-customs.jpg',
		'fa-warehouse' => 'service-warehouse.jpg',
		'fa-bolt'      => 'service-express.jpg',
	];
	if ( isset( $map[ $icon ] ) ) {
		return $base . $map[ $icon ];
	}
	// Fallback by slug keyword.
	foreach ( [ 'air' => 'service-air.jpg', 'sea' => 'service-sea.jpg', 'road' => 'service-road.jpg', 'customs' => 'service-customs.jpg', 'warehous' => 'service-warehouse.jpg', 'express' => 'service-express.jpg' ] as $kw => $file ) {
		if ( false !== strpos( $slug, $kw ) ) {
			return $base . $file;
		}
	}
	return $base . 'service-air.jpg';
}

/* ===========================
   CAREERS / JOBS
   CPT with detail pages, admin upload, and automatic expiry by closing date.
=========================== */
function noki_register_jobs_cpt() {
	register_post_type( 'noki_job', [
		'labels' => [
			'name'          => __( 'Jobs', 'noki-logistics' ),
			'singular_name' => __( 'Job', 'noki-logistics' ),
			'add_new_item'  => __( 'Add New Job', 'noki-logistics' ),
			'edit_item'     => __( 'Edit Job', 'noki-logistics' ),
			'menu_name'     => __( 'Careers / Jobs', 'noki-logistics' ),
		],
		'public'        => true,
		'show_in_rest'  => true,
		'has_archive'   => 'careers',
		'rewrite'       => [ 'slug' => 'careers' ],
		'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
		'menu_icon'     => 'dashicons-groups',
		'menu_position' => 7,
	] );
}
add_action( 'init', 'noki_register_jobs_cpt' );

// Job details meta box.
add_action( 'add_meta_boxes', function () {
	add_meta_box( 'noki_job_meta', __( 'Job Details', 'noki-logistics' ), 'noki_job_meta_cb', 'noki_job', 'normal', 'high' );
} );
function noki_job_meta_cb( $post ) {
	wp_nonce_field( 'noki_job_save', 'noki_job_nonce' );
	$loc     = get_post_meta( $post->ID, '_job_location', true );
	$type    = get_post_meta( $post->ID, '_job_type', true );
	$dept    = get_post_meta( $post->ID, '_job_dept', true );
	$closing = get_post_meta( $post->ID, '_job_closing', true );
	$apply   = get_post_meta( $post->ID, '_job_apply', true );
	?>
	<table class="form-table">
		<tr><th><label for="job_location">Location</label></th>
			<td><input type="text" id="job_location" name="job_location" value="<?php echo esc_attr( $loc ); ?>" class="regular-text" placeholder="e.g. Kampala (Ntinda)"></td></tr>
		<tr><th><label for="job_type">Employment type</label></th>
			<td><input type="text" id="job_type" name="job_type" value="<?php echo esc_attr( $type ); ?>" class="regular-text" placeholder="e.g. Full-time"></td></tr>
		<tr><th><label for="job_dept">Department</label></th>
			<td><input type="text" id="job_dept" name="job_dept" value="<?php echo esc_attr( $dept ); ?>" class="regular-text" placeholder="e.g. Operations"></td></tr>
		<tr><th><label for="job_closing">Closing date</label></th>
			<td><input type="date" id="job_closing" name="job_closing" value="<?php echo esc_attr( $closing ); ?>">
			<p class="description">The job hides itself automatically after this date. Leave empty to keep it open indefinitely.</p></td></tr>
		<tr><th><label for="job_apply">Apply email or link (optional)</label></th>
			<td><input type="text" id="job_apply" name="job_apply" value="<?php echo esc_attr( $apply ); ?>" class="regular-text" placeholder="Defaults to your company email"></td></tr>
	</table>
	<?php
}
add_action( 'save_post_noki_job', function ( $post_id ) {
	if ( ! isset( $_POST['noki_job_nonce'] ) || ! wp_verify_nonce( $_POST['noki_job_nonce'], 'noki_job_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( [ 'job_location' => '_job_location', 'job_type' => '_job_type', 'job_dept' => '_job_dept', 'job_closing' => '_job_closing', 'job_apply' => '_job_apply' ] as $field => $key ) {
		if ( isset( $_POST[ $field ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
		}
	}
} );

// Show closing date + status in the admin Jobs list.
add_filter( 'manage_noki_job_posts_columns', function ( $cols ) {
	$cols['job_closing'] = 'Closing date';
	return $cols;
} );
add_action( 'manage_noki_job_posts_custom_column', function ( $col, $post_id ) {
	if ( 'job_closing' === $col ) {
		$c = get_post_meta( $post_id, '_job_closing', true );
		if ( ! $c ) {
			echo '<em>Open (no date)</em>';
		} else {
			$expired = strtotime( $c ) < strtotime( date( 'Y-m-d' ) );
			echo esc_html( date_i18n( 'M j, Y', strtotime( $c ) ) ) . ( $expired ? ' <strong style="color:#b32d2e">(expired)</strong>' : '' );
		}
	}
}, 10, 2 );

/**
 * Get currently-open jobs (closing date empty or today/future).
 */
function noki_get_jobs( $limit = -1 ) {
	return get_posts( [
		'post_type'      => 'noki_job',
		'posts_per_page' => $limit,
		'post_status'    => 'publish',
		'orderby'        => 'meta_value',
		'meta_key'       => '_job_closing',
		'order'          => 'ASC',
		'meta_query'     => [
			'relation' => 'OR',
			[ 'key' => '_job_closing', 'compare' => 'NOT EXISTS' ],
			[ 'key' => '_job_closing', 'value' => '', 'compare' => '=' ],
			[ 'key' => '_job_closing', 'value' => date( 'Y-m-d' ), 'compare' => '>=', 'type' => 'DATE' ],
		],
	] );
}

// Apply link for a job (custom, or company email fallback).
function noki_job_apply_link( $post ) {
	$id    = is_object( $post ) ? $post->ID : $post;
	$apply = get_post_meta( $id, '_job_apply', true );
	$title = get_the_title( $id );
	if ( $apply && filter_var( $apply, FILTER_VALIDATE_URL ) ) {
		return esc_url( $apply );
	}
	$mail = ( $apply && is_email( $apply ) ) ? $apply : get_theme_mod( 'noki_email', 'info@nokilogistics.com' );
	return 'mailto:' . antispambot( $mail ) . '?subject=' . rawurlencode( 'Application: ' . $title );
}

// Daily auto-expiry: move past-deadline jobs to draft so they drop off the site.
add_action( 'init', function () {
	if ( ! wp_next_scheduled( 'noki_expire_jobs' ) ) {
		wp_schedule_event( time() + 300, 'daily', 'noki_expire_jobs' );
	}
} );
add_action( 'noki_expire_jobs', 'noki_do_expire_jobs' );
function noki_do_expire_jobs() {
	$expired = get_posts( [
		'post_type'      => 'noki_job',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'meta_query'     => [
			[ 'key' => '_job_closing', 'value' => date( 'Y-m-d' ), 'compare' => '<', 'type' => 'DATE' ],
		],
	] );
	foreach ( $expired as $job ) {
		wp_update_post( [ 'ID' => $job->ID, 'post_status' => 'draft' ] );
	}
}

// Send the /careers job archive to the styled Join Us page (single job pages still work).
add_action( 'template_redirect', function () {
	if ( is_post_type_archive( 'noki_job' ) ) {
		wp_safe_redirect( home_url( '/join-us/' ), 302 );
		exit;
	}
} );

/* Short service label for nav/footer (pages keep their full SEO titles). */
function noki_service_short_label( $service ) {
	$title = is_object( $service ) ? get_the_title( $service ) : (string) $service;
	$low   = strtolower( $title );
	$map   = [
		'air'          => 'Air Freight',
		'sea'          => 'Sea Freight',
		'cross-border' => 'Road Transport',
		'road'         => 'Road Transport',
		'customs'      => 'Customs Clearance',
		'warehous'     => 'Warehousing',
		'express'      => 'Express Delivery',
		'courier'      => 'Express Delivery',
	];
	foreach ( $map as $kw => $short ) {
		if ( false !== strpos( $low, $kw ) ) {
			return $short;
		}
	}
	// Fallback: first 3 words.
	$words = preg_split( '/\s+/', trim( $title ) );
	return count( $words ) > 3 ? implode( ' ', array_slice( $words, 0, 3 ) ) : $title;
}
