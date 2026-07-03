<?php
/**
 * Noki Logistics — ACF field definitions (code-based, portable).
 *
 * Fields register automatically when the free "Advanced Custom Fields"
 * plugin is active. Templates read them via noki_field() with hard-coded
 * fallbacks, so the site works whether or not fields are filled in.
 *
 * Phase 1: Homepage (front page). Inner pages come in Phase 2.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', 'noki_register_acf_fields' );
function noki_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$fields = [];

	/* helper closures to keep this readable */
	$text = function ( $name, $label, $instr = '' ) {
		return [ 'key' => 'field_noki_' . $name, 'label' => $label, 'name' => $name, 'type' => 'text', 'instructions' => $instr ];
	};
	$area = function ( $name, $label, $instr = '' ) {
		return [ 'key' => 'field_noki_' . $name, 'label' => $label, 'name' => $name, 'type' => 'textarea', 'rows' => 3, 'instructions' => $instr ];
	};
	$img = function ( $name, $label, $instr = '' ) {
		return [ 'key' => 'field_noki_' . $name, 'label' => $label, 'name' => $name, 'type' => 'image', 'return_format' => 'url', 'preview_size' => 'medium', 'instructions' => $instr ];
	};
	$link = function ( $name, $label, $instr = '' ) {
		return [ 'key' => 'field_noki_' . $name, 'label' => $label, 'name' => $name, 'type' => 'link', 'return_format' => 'array', 'instructions' => $instr ];
	};
	$tab = function ( $label ) {
		return [ 'key' => 'field_noki_tab_' . sanitize_title( $label ), 'label' => $label, 'type' => 'tab', 'placement' => 'top' ];
	};
	$msg = function ( $label, $text ) {
		return [ 'key' => 'field_noki_msg_' . sanitize_title( $label ), 'label' => $label, 'type' => 'message', 'message' => $text ];
	};

	/* ---- HERO SLIDER (3 slides) ---- */
	$fields[] = $tab( 'Hero Slider' );
	$fields[] = $msg( 'About the hero', 'The homepage top banner rotates through these 3 slides. Leave a slide\'s image empty to use the built-in photo. Each heading shows the "highlight" words in the brand colour.' );
	foreach ( [ 1, 2, 3 ] as $i ) {
		$fields[] = $msg( "Slide {$i}", "<strong>Slide {$i}</strong>" );
		$fields[] = $text( "hero{$i}_badge", "Slide {$i} — Badge (small pill text)" );
		$fields[] = $text( "hero{$i}_heading", "Slide {$i} — Heading" );
		$fields[] = $text( "hero{$i}_highlight", "Slide {$i} — Highlighted words", 'Shown in the orange/gradient colour, appended after the heading.' );
		$fields[] = $area( "hero{$i}_lead", "Slide {$i} — Subtext" );
		$fields[] = $img( "hero{$i}_image", "Slide {$i} — Background image" );
		$fields[] = $link( "hero{$i}_btn1", "Slide {$i} — Primary button" );
		$fields[] = $link( "hero{$i}_btn2", "Slide {$i} — Secondary button" );
	}

	/* ---- INTRO STATEMENT ---- */
	$fields[] = $tab( 'Intro' );
	$fields[] = $text( 'intro_kicker', 'Kicker (small label)' );
	$fields[] = $area( 'intro_statement', 'Statement', 'Wrap words in *asterisks* to colour them, e.g. "your partner in *supply-chain success*".' );
	foreach ( [ 1, 2, 3 ] as $i ) {
		$fields[] = $text( "intro_metric{$i}_num", "Metric {$i} — Number (e.g. 500)" );
		$fields[] = $text( "intro_metric{$i}_suffix", "Metric {$i} — Suffix (e.g. + or %)" );
		$fields[] = $text( "intro_metric{$i}_label", "Metric {$i} — Label" );
	}

	/* ---- WHY US (feature row) ---- */
	$fields[] = $tab( 'Why Us' );
	$fields[] = $text( 'whyus_kicker', 'Kicker' );
	$fields[] = $text( 'whyus_heading', 'Heading' );
	foreach ( [ 1, 2, 3 ] as $i ) {
		$fields[] = $text( "feature{$i}_icon", "Card {$i} — Icon (Font Awesome class, e.g. fa-route)" );
		$fields[] = $text( "feature{$i}_title", "Card {$i} — Title" );
		$fields[] = $area( "feature{$i}_text", "Card {$i} — Text" );
	}

	/* ---- ABOUT SPLIT ---- */
	$fields[] = $tab( 'About' );
	$fields[] = $text( 'about_kicker', 'Kicker' );
	$fields[] = $text( 'about_heading', 'Heading' );
	$fields[] = $area( 'about_text', 'Paragraph' );
	$fields[] = $img( 'about_image', 'Image' );
	foreach ( [ 1, 2, 3 ] as $i ) {
		$fields[] = $text( "about_check{$i}_title", "Checklist {$i} — Title" );
		$fields[] = $text( "about_check{$i}_text", "Checklist {$i} — Text" );
	}
	$fields[] = $link( 'about_btn', 'Button' );

	/* ---- VALUES ---- */
	$fields[] = $tab( 'Values' );
	$fields[] = $text( 'values_kicker', 'Kicker' );
	$fields[] = $text( 'values_heading', 'Heading' );
	$fields[] = $area( 'values_intro', 'Intro paragraph' );
	foreach ( [ 1, 2, 3, 4 ] as $i ) {
		$fields[] = $text( "value{$i}_title", "Value {$i} — Title" );
		$fields[] = $area( "value{$i}_text", "Value {$i} — Text" );
		$fields[] = $text( "value{$i}_icon", "Value {$i} — Icon (Font Awesome class)" );
	}

	/* ---- FINAL CTA ---- */
	$fields[] = $tab( 'Call to action' );
	$fields[] = $text( 'cta_heading', 'Heading' );
	$fields[] = $area( 'cta_text', 'Text' );
	$fields[] = $link( 'cta_btn1', 'Primary button' );
	$fields[] = $link( 'cta_btn2', 'Secondary button' );

	acf_add_local_field_group( [
		'key'      => 'group_noki_home',
		'title'    => 'Homepage Content',
		'fields'   => $fields,
		'location' => [ [ [ 'param' => 'page_type', 'operator' => '==', 'value' => 'front_page' ] ] ],
		'menu_order' => 0,
		'position'   => 'normal',
		'style'      => 'default',
		'active'     => true,
		'description'=> 'Editable content for the Noki homepage.',
	] );
}
