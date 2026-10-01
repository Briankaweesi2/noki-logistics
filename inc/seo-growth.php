<?php
/**
 * Noki SEO growth layer.
 *
 * Works alongside Rank Math. It adds business schema, strong defaults for
 * important landing pages, and seeds commercial search landing pages.
 */
defined( 'ABSPATH' ) || exit;

/* ---------------------------
 * Rank Math title/description defaults
 * --------------------------- */
function noki_rank_math_title( $title ) {
	if ( is_front_page() ) {
		return 'Logistics Company in Uganda | Freight, Customs & Warehousing | Noki Logistics';
	}
	if ( is_post_type_archive( 'noki_service' ) ) {
		return 'Logistics Services in Uganda | Air, Sea, Road & Customs | Noki Logistics';
	}
	if ( is_post_type_archive( 'noki_news' ) ) {
		return 'Noki Logistics News & Updates | Uganda & East Africa';
	}
	return $title;
}
add_filter( 'rank_math/frontend/title', 'noki_rank_math_title', 30 );

function noki_rank_math_description( $description ) {
	if ( is_front_page() ) {
		return 'Noki Logistics provides freight forwarding, air and sea freight, road transport, customs clearance, warehousing and delivery across Uganda and East Africa.';
	}
	if ( is_post_type_archive( 'noki_service' ) ) {
		return 'Explore Noki Logistics services in Uganda: air freight, sea freight, regional road transport, customs clearance, warehousing and express delivery.';
	}
	if ( is_post_type_archive( 'noki_news' ) ) {
		return 'Company news, logistics updates and events from Noki Logistics in Uganda and across East Africa.';
	}
	return $description;
}
add_filter( 'rank_math/frontend/description', 'noki_rank_math_description', 30 );

/* ---------------------------
 * LocalBusiness / Organization schema
 * --------------------------- */
function noki_rank_math_local_business_schema( $data, $jsonld ) {
	if ( is_admin() ) {
		return $data;
	}

	$phone   = get_theme_mod( 'noki_phone', '+256 200 946 366' );
	$email   = get_theme_mod( 'noki_email', 'info@nokilogistics.com' );
	$address = get_theme_mod( 'noki_address', 'Plot No. 53/55 Semawata Road, Elgon Rise, Ntinda, Kampala' );
	$logo_id = get_theme_mod( 'custom_logo' );
	$logo    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : get_template_directory_uri() . '/images/noki-logo.svg';

	$same_as = array_values( array_filter( [
		get_theme_mod( 'noki_facebook' ),
		get_theme_mod( 'noki_twitter' ),
		get_theme_mod( 'noki_linkedin', 'https://www.linkedin.com/company/nokilogistics' ),
		get_theme_mod( 'noki_instagram' ),
		get_theme_mod( 'noki_tiktok' ),
		get_theme_mod( 'noki_youtube' ),
	] ) );

	$data['noki_logistics_business'] = [
		'@type'       => [ 'Organization', 'LocalBusiness' ],
		'@id'         => home_url( '/#organization' ),
		'name'        => 'Noki Logistics',
		'url'         => home_url( '/' ),
		'logo'        => [
			'@type' => 'ImageObject',
			'url'   => $logo,
		],
		'image'       => $logo,
		'description' => 'Freight forwarding, air and sea freight, road transport, customs clearance, warehousing and delivery services across Uganda and East Africa.',
		'telephone'   => $phone,
		'email'       => $email,
		'address'     => [
			'@type'           => 'PostalAddress',
			'streetAddress'   => $address,
			'addressLocality' => 'Kampala',
			'addressCountry'  => 'UG',
		],
		'areaServed'   => [
			[ '@type' => 'Country', 'name' => 'Uganda' ],
			[ '@type' => 'Place', 'name' => 'East Africa' ],
		],
		'sameAs'       => $same_as,
	];

	return $data;
}
add_filter( 'rank_math/json_ld', 'noki_rank_math_local_business_schema', 40, 2 );

/* ---------------------------
 * Commercial landing pages
 * --------------------------- */
function noki_seed_seo_landing_pages_2026() {
	if ( get_option( 'noki_seo_landing_pages_2026_10_v1' ) ) {
		return;
	}

	$pages = [
		[
			'slug' => 'logistics-company-uganda',
			'title' => 'Logistics Company in Uganda',
			'keyword' => 'logistics company in Uganda',
			'seo_title' => 'Logistics Company in Uganda | Noki Logistics',
			'seo_desc' => 'Looking for a logistics company in Uganda? Noki Logistics handles freight forwarding, customs clearance, warehousing and delivery across Uganda and East Africa.',
			'content' => <<<'HTML'
<p>Noki Logistics helps businesses move cargo into, out of and across Uganda with one coordinated logistics team. We support importers, exporters, manufacturers, retailers, NGOs and growing companies that need reliable freight, customs and delivery support.</p>
<h2>End-to-end logistics services in Uganda</h2>
<p>Our services include <a href="/services/">air freight, sea freight, road transport, customs clearance, warehousing and express delivery</a>. Instead of managing several disconnected providers, customers can work with one team from pickup through final delivery.</p>
<h2>Local knowledge with regional reach</h2>
<p>Uganda is landlocked, so international cargo often depends on the Mombasa and Dar es Salaam corridors as well as Entebbe International Airport. Noki coordinates the inland and cross-border stages needed to keep cargo moving efficiently.</p>
<h2>Why businesses choose Noki Logistics</h2>
<ul><li>Clear shipment communication and a dedicated point of contact</li><li>Freight coordination by air, sea and road</li><li>Customs and documentation support</li><li>Warehousing and distribution in Kampala</li><li>Regional trucking across East Africa</li></ul>
<p>Planning a shipment? <a href="/contact/">Request a logistics quote</a> with the origin, destination, cargo type, weight or volume and preferred delivery date.</p>
HTML
		],
		[
			'slug' => 'freight-forwarding-uganda',
			'title' => 'Freight Forwarding in Uganda',
			'keyword' => 'freight forwarding Uganda',
			'seo_title' => 'Freight Forwarding Uganda | Noki Logistics',
			'seo_desc' => 'Freight forwarding in Uganda for imports, exports and regional cargo. Noki coordinates air, sea and road freight, customs and final delivery.',
			'content' => <<<'HTML'
<p>Noki Logistics provides freight forwarding for businesses importing into Uganda, exporting from Uganda and moving cargo across East Africa. We coordinate the shipment journey so documentation, transport, customs and delivery work together.</p>
<h2>Air, sea and road freight coordination</h2>
<p>Choose air freight for urgent and higher-value cargo, sea freight for larger cost-sensitive shipments, and road freight for regional distribution. Many shipments require a combination of these modes.</p>
<h2>Freight forwarding that includes the inland journey</h2>
<p>For sea cargo entering through Mombasa or Dar es Salaam, arrival at port is only part of the movement. We help coordinate the inland road leg, customs processes and delivery to Kampala or another Ugandan destination.</p>
<h2>Better shipment visibility</h2>
<p>Customers receive practical updates around collection, departure, arrival, clearance and delivery so procurement and operations teams can plan with confidence.</p>
<p>See our <a href="/services/">freight and logistics services</a> or <a href="/contact/">request a freight-forwarding quote</a>.</p>
HTML
		],
		[
			'slug' => 'air-freight-uganda',
			'title' => 'Air Freight in Uganda',
			'keyword' => 'air freight Uganda',
			'seo_title' => 'Air Freight Uganda | Entebbe Cargo Services | Noki Logistics',
			'seo_desc' => 'Air freight services in Uganda through Entebbe for urgent imports and exports, with customs coordination and final delivery from Noki Logistics.',
			'content' => <<<'HTML'
<p>When speed matters, Noki Logistics coordinates air freight into and out of Uganda through Entebbe International Airport and global airline networks.</p>
<h2>When air freight is the right choice</h2>
<p>Air freight is well suited to urgent stock, spare parts, samples, valuable goods and time-sensitive commercial cargo. Shipment dimensions and actual or volumetric weight affect pricing, so accurate packed measurements are important.</p>
<h2>From airport arrival to final delivery</h2>
<p>Our support can include shipment coordination, document review, customs clearance and delivery after release. That gives businesses one operational view instead of separate airport, customs and trucking arrangements.</p>
<h2>Prepare before cargo departs</h2>
<p>Commercial invoices, packing lists, product descriptions and any required permits should be checked early to reduce avoidable delays on arrival.</p>
<p><a href="/contact/">Request an air-freight quote</a> with your origin airport or supplier city, cargo weight, dimensions and delivery location in Uganda.</p>
HTML
		],
		[
			'slug' => 'sea-freight-uganda',
			'title' => 'Sea Freight to Uganda',
			'keyword' => 'sea freight Uganda',
			'seo_title' => 'Sea Freight Uganda | Mombasa & Dar es Salaam | Noki Logistics',
			'seo_desc' => 'Sea freight to Uganda via Mombasa and Dar es Salaam, including FCL/LCL coordination, customs support and inland delivery to Kampala.',
			'content' => <<<'HTML'
<p>Noki Logistics coordinates sea freight for Ugandan importers and exporters using the Mombasa and Dar es Salaam corridors. We support both full-container and consolidated cargo depending on shipment size and budget.</p>
<h2>FCL and LCL options</h2>
<p>Full-container-load shipping can be efficient for larger volumes, while less-than-container-load consolidation helps smaller shipments share container space. The right choice depends on cargo volume, frequency and urgency.</p>
<h2>Port-to-Kampala coordination</h2>
<p>Because Uganda is landlocked, a sea shipment needs reliable inland transport after port arrival. We coordinate the transition from port handling and customs to road freight into Uganda.</p>
<h2>Reduce avoidable storage costs</h2>
<p>Early document review, clear consignee information and timely clearance preparation can reduce unnecessary port and terminal delays.</p>
<p><a href="/contact/">Ask Noki Logistics for a sea-freight quote</a> with your origin, cargo volume, container requirement and Ugandan delivery point.</p>
HTML
		],
		[
			'slug' => 'customs-clearance-uganda',
			'title' => 'Customs Clearance in Uganda',
			'keyword' => 'customs clearance Uganda',
			'seo_title' => 'Customs Clearance Uganda | Clearing & Forwarding | Noki Logistics',
			'seo_desc' => 'Customs clearance and clearing & forwarding support in Uganda for imports and exports, with freight coordination and delivery from Noki Logistics.',
			'content' => <<<'HTML'
<p>Noki Logistics supports customs clearance for commercial imports and exports in Uganda, helping customers prepare shipment information and coordinate the movement after release.</p>
<h2>Prepare documents before arrival</h2>
<p>Commercial invoices, packing lists, transport documents and product-specific permits should be checked early. Consistency between documents reduces preventable delays.</p>
<h2>Clear communication on duties and logistics costs</h2>
<p>Government duties and taxes are separate from many freight and handling charges. We encourage clear landed-cost planning so customers understand what is payable and what is included in the logistics scope.</p>
<h2>Customs plus delivery</h2>
<p>Clearance is most useful when it connects directly to transport. Noki can coordinate the next leg from airport, border or regional port to your final destination.</p>
<p>For an upcoming import or export, <a href="/contact/">send us your shipment documents and route details</a> for guidance and a quotation.</p>
HTML
		],
		[
			'slug' => 'warehousing-kampala',
			'title' => 'Warehousing in Kampala',
			'keyword' => 'warehousing Kampala',
			'seo_title' => 'Warehousing Kampala | Storage & Distribution | Noki Logistics',
			'seo_desc' => 'Warehousing in Kampala with secure storage, inventory support and distribution. Connect storage with freight and delivery through Noki Logistics.',
			'content' => <<<'HTML'
<p>Noki Logistics provides warehousing support in Kampala for businesses that need secure storage connected to transport and distribution.</p>
<h2>Storage that supports your supply chain</h2>
<p>A good warehouse should make receiving, stock control, picking and dispatch easier. We help customers plan storage around cargo volume, packaging, turnover and distribution needs.</p>
<h2>Connect inbound freight and outbound delivery</h2>
<p>Combining warehousing with transport reduces handovers and gives businesses clearer accountability from arrival through customer or branch delivery.</p>
<h2>Suitable for growing businesses</h2>
<p>Warehousing can help importers hold stock closer to customers, consolidate inventory and improve delivery planning across Kampala and Uganda.</p>
<p><a href="/contact/">Request a warehousing quotation</a> with your expected pallet/carton volume, storage period and distribution requirements.</p>
HTML
		],
		[
			'slug' => 'shipping-china-to-uganda',
			'title' => 'Shipping from China to Uganda',
			'keyword' => 'shipping from China to Uganda',
			'seo_title' => 'Shipping from China to Uganda | Air & Sea Freight | Noki',
			'seo_desc' => 'Shipping from China to Uganda by air or sea with freight coordination, customs support and delivery. Get a tailored quote from Noki Logistics.',
			'content' => <<<'HTML'
<p>Noki Logistics helps Ugandan businesses coordinate shipping from China by air or sea, from supplier handover through customs and final delivery.</p>
<h2>Air freight from China to Uganda</h2>
<p>Air freight works well for urgent, lighter and higher-value cargo. Pricing depends on weight and dimensions, so ask your supplier for final packed measurements.</p>
<h2>Sea freight from China to Uganda</h2>
<p>Sea freight is usually better for larger commercial shipments. Cargo typically enters East Africa through a regional port before continuing by road into Uganda.</p>
<h2>Consolidate and plan documentation early</h2>
<p>If you buy from several suppliers, consolidation can reduce fragmented shipments. Invoices, packing lists and product requirements should be reviewed before cargo leaves China.</p>
<p>For a quote, <a href="/contact/">send the supplier city, cargo weight, dimensions and Ugandan delivery location</a>.</p>
HTML
		],
		[
			'slug' => 'shipping-dubai-to-uganda',
			'title' => 'Shipping from Dubai to Uganda',
			'keyword' => 'shipping from Dubai to Uganda',
			'seo_title' => 'Shipping from Dubai to Uganda | Freight Services | Noki',
			'seo_desc' => 'Ship cargo from Dubai and the UAE to Uganda by air or sea. Noki Logistics coordinates freight, customs support and final delivery.',
			'content' => <<<'HTML'
<p>Dubai and the UAE are major sourcing hubs for Ugandan businesses. Noki Logistics coordinates air and sea freight from the UAE into Uganda, including customs support and final delivery.</p>
<h2>Choose air freight for speed</h2>
<p>Air freight is practical for urgent stock, electronics, spare parts, samples and other time-sensitive cargo.</p>
<h2>Choose sea freight for larger volumes</h2>
<p>Sea freight can offer a lower transport cost per unit for heavier and bulkier shipments. The plan should include the inland journey from the regional port to Uganda.</p>
<h2>Compare the full landed journey</h2>
<p>Ask for a scope that explains pickup, origin handling, international freight, customs support and delivery so you can compare total cost rather than one freight rate.</p>
<p><a href="/contact/">Request a Dubai-to-Uganda freight quote</a> with your pickup location, cargo details and delivery address.</p>
HTML
		],
		[
			'slug' => 'mombasa-to-kampala-freight',
			'title' => 'Mombasa to Kampala Freight',
			'keyword' => 'Mombasa to Kampala freight',
			'seo_title' => 'Mombasa to Kampala Freight | Road Cargo | Noki Logistics',
			'seo_desc' => 'Mombasa to Kampala freight and inland cargo transport with customs coordination, container movement and delivery support from Noki Logistics.',
			'content' => <<<'HTML'
<p>The Mombasa–Kampala corridor is one of the most important freight routes for Ugandan importers. Noki Logistics coordinates inland cargo movement from Mombasa toward Kampala and other Ugandan destinations.</p>
<h2>Plan before the vessel arrives</h2>
<p>Shipping documents, customs information and inland transport arrangements should be prepared early so the cargo can move efficiently once released.</p>
<h2>Container and consolidated cargo</h2>
<p>Different cargo types require different inland plans. Full containers, consolidated cargo and specialised loads need suitable vehicles, scheduling and delivery arrangements.</p>
<h2>One point of coordination</h2>
<p>Customers benefit when port, customs, road transport and final delivery are managed as one connected movement rather than separate jobs.</p>
<p><a href="/contact/">Request a Mombasa-to-Kampala freight quote</a> with the container or cargo details and final delivery location.</p>
HTML
		],
	];

	$all_ready = true;
	foreach ( $pages as $page ) {
		$existing = get_page_by_path( $page['slug'], OBJECT, 'page' );
		if ( $existing ) {
			$post_id = (int) $existing->ID;
		} else {
			$post_id = wp_insert_post( [
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $page['title'],
				'post_name'    => $page['slug'],
				'post_content' => $page['content'],
				'post_excerpt' => $page['seo_desc'],
			], true );
			if ( is_wp_error( $post_id ) ) {
				$all_ready = false;
				continue;
			}
		}

		update_post_meta( $post_id, 'rank_math_title', $page['seo_title'] );
		update_post_meta( $post_id, 'rank_math_description', $page['seo_desc'] );
		update_post_meta( $post_id, 'rank_math_focus_keyword', $page['keyword'] );

		if ( function_exists( 'pll_set_post_language' ) ) {
			pll_set_post_language( $post_id, 'en' );
		}
	}

	if ( $all_ready ) {
		update_option( 'noki_seo_landing_pages_2026_10_v1', 1, false );
	}
}
add_action( 'init', 'noki_seed_seo_landing_pages_2026', 35 );

/* ---------------------------
 * Helpful SEO admin panel
 * --------------------------- */
function noki_seo_dashboard_widget() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	wp_add_dashboard_widget( 'noki_seo_status', 'Noki SEO & Google Growth', 'noki_seo_dashboard_widget_cb' );
}
add_action( 'wp_dashboard_setup', 'noki_seo_dashboard_widget' );

function noki_seo_dashboard_widget_cb() {
	echo '<p><strong>Rank Math:</strong> ' . ( defined( 'RANK_MATH_VERSION' ) ? 'Active' : 'Check plugin status' ) . '</p>';
	echo '<p><strong>Priority:</strong> Keep Google Business Profile details identical to this website: company name, Kampala address, phone, hours and website.</p>';
	echo '<p><strong>Content:</strong> New commercial landing pages target high-intent searches such as logistics company Uganda, freight forwarding Uganda, air freight, sea freight, customs clearance, warehousing and major import routes.</p>';
	echo '<p><strong>Google Search Console:</strong> Connect/verify the property in Rank Math and submit the Rank Math sitemap. Review queries and indexing monthly.</p>';
}
