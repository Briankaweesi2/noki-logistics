<?php
defined( 'ABSPATH' ) || exit;

/**
 * Seed Polylang translations for the site's core pages, services and news.
 * Safe to re-run: it updates existing linked translations and creates only
 * missing ones. English remains the canonical source.
 */
function noki_seed_multilingual_core() {
	if ( ! function_exists( 'pll_set_post_language' ) || ! function_exists( 'pll_save_post_translations' ) ) return;

	$pages = [
		27 => [ 'template'=>'', 't'=>[
			'zh'=>['首页','shouye'],'fr'=>['Accueil','accueil'],'de'=>['Startseite','startseite'],'es'=>['Inicio','inicio'],'pl'=>['Strona główna','strona-glowna'] ] ],
		26 => [ 'template'=>'page-blog.php', 't'=>[
			'zh'=>['物流博客','wuliu-boke'],'fr'=>['Blog logistique','blog'],'de'=>['Logistik-Blog','blog'],'es'=>['Blog de logística','blog'],'pl'=>['Blog logistyczny','blog'] ] ],
		25 => [ 'template'=>'page-faq.php', 't'=>[
			'zh'=>['常见问题','changjian-wenti'],'fr'=>['FAQ','faq'],'de'=>['FAQ','faq'],'es'=>['Preguntas frecuentes','preguntas-frecuentes'],'pl'=>['FAQ','faq'] ] ],
		24 => [ 'template'=>'page-testimonials.php', 't'=>[
			'zh'=>['客户评价','kehu-pingjia'],'fr'=>['Témoignages','temoignages'],'de'=>['Kundenstimmen','kundenstimmen'],'es'=>['Testimonios','testimonios'],'pl'=>['Opinie klientów','opinie'] ] ],
		23 => [ 'template'=>'page-pricing.php', 't'=>[
			'zh'=>['价格','jiage'],'fr'=>['Tarifs','tarifs'],'de'=>['Preise','preise'],'es'=>['Precios','precios'],'pl'=>['Cennik','cennik'] ] ],
		22 => [ 'template'=>'page-join-us.php', 't'=>[
			'zh'=>['加入我们','jiaru-women'],'fr'=>['Rejoignez-nous','rejoignez-nous'],'de'=>['Karriere','karriere'],'es'=>['Únete a nosotros','unete'],'pl'=>['Kariera','kariera'] ] ],
		21 => [ 'template'=>'page-our-team.php', 't'=>[
			'zh'=>['我们的团队','women-de-tuandui'],'fr'=>['Notre équipe','notre-equipe'],'de'=>['Unser Team','unser-team'],'es'=>['Nuestro equipo','nuestro-equipo'],'pl'=>['Nasz zespół','nasz-zespol'] ] ],
		20 => [ 'template'=>'page-why-choose-us.php', 't'=>[
			'zh'=>['为何选择 Noki','weishenme-xuanze-noki'],'fr'=>['Pourquoi choisir Noki','pourquoi-choisir-noki'],'de'=>['Warum Noki','warum-noki'],'es'=>['Por qué elegir Noki','por-que-noki'],'pl'=>['Dlaczego Noki','dlaczego-noki'] ] ],
		10 => [ 'template'=>'page-contact.php', 't'=>[
			'zh'=>['联系我们','lianxi-women'],'fr'=>['Contact','contact'],'de'=>['Kontakt','kontakt'],'es'=>['Contacto','contacto'],'pl'=>['Kontakt','kontakt'] ] ],
		9 => [ 'template'=>'page-about.php', 't'=>[
			'zh'=>['关于我们','guanyu-women'],'fr'=>['À propos','a-propos'],'de'=>['Über uns','ueber-uns'],'es'=>['Sobre nosotros','sobre-nosotros'],'pl'=>['O nas','o-nas'] ] ],
	];

	foreach ( $pages as $source_id => $cfg ) {
		if ( ! get_post( $source_id ) ) continue;
		pll_set_post_language( $source_id, 'en' );
		$links = [ 'en' => $source_id ];
		foreach ( $cfg['t'] as $lang => $d ) {
			$id = pll_get_post( $source_id, $lang );
			$postarr = [
				'post_type'=>'page','post_status'=>'publish','post_title'=>$d[0],
				'post_name'=>$d[1],'post_content'=>'','post_excerpt'=>'','post_author'=>get_post_field( 'post_author', $source_id ),
			];
			if ( $id ) { $postarr['ID'] = $id; wp_update_post( $postarr ); }
			else { $id = wp_insert_post( $postarr ); if ( is_wp_error( $id ) ) continue; }
			if ( $cfg['template'] ) update_post_meta( $id, '_wp_page_template', $cfg['template'] );
			pll_set_post_language( $id, $lang );
			$links[ $lang ] = $id;
		}
		pll_save_post_translations( $links );
	}

	$services = noki_multilingual_service_data();
	foreach ( $services as $source_id => $translations ) {
		$src = get_post( $source_id ); if ( ! $src ) continue;
		pll_set_post_language( $source_id, 'en' );
		$links = [ 'en'=>$source_id ];
		foreach ( $translations as $lang=>$d ) {
			$id = pll_get_post( $source_id, $lang );
			$postarr = [
				'post_type'=>'noki_service','post_status'=>'publish','post_title'=>$d['title'],'post_name'=>$d['slug'],
				'post_excerpt'=>$d['excerpt'],'post_content'=>$d['content'],'post_author'=>$src->post_author,
			];
			if ( $id ) { $postarr['ID']=$id; wp_update_post( $postarr ); }
			else { $id=wp_insert_post( $postarr ); if ( is_wp_error( $id ) ) continue; }
			foreach ( [ '_service_icon','_service_features','_service_order','_thumbnail_id' ] as $mk ) {
				$v=get_post_meta( $source_id, $mk, true ); if ( '' !== $v ) update_post_meta( $id, $mk, $v );
			}
			update_post_meta( $id, 'rank_math_description', $d['excerpt'] );
			pll_set_post_language( $id, $lang ); $links[$lang]=$id;
		}
		pll_save_post_translations( $links );
	}

	$news = noki_multilingual_news_data();
	foreach ( $news as $source_id => $translations ) {
		$src = get_post( $source_id ); if ( ! $src ) continue;
		pll_set_post_language( $source_id, 'en' );
		$links=[ 'en'=>$source_id ];
		foreach ( $translations as $lang=>$d ) {
			$id=pll_get_post( $source_id, $lang );
			$postarr=[ 'post_type'=>'noki_news','post_status'=>'publish','post_title'=>$d['title'],'post_name'=>$d['slug'],
				'post_excerpt'=>$d['excerpt'],'post_content'=>$d['content'],'post_author'=>$src->post_author,'post_date'=>$src->post_date ];
			if ( $id ) { $postarr['ID']=$id; wp_update_post( $postarr ); }
			else { $id=wp_insert_post( $postarr ); if ( is_wp_error( $id ) ) continue; }
			$thumb=get_post_thumbnail_id( $source_id ); if ( $thumb ) set_post_thumbnail( $id, $thumb );
			update_post_meta( $id, 'rank_math_description', $d['excerpt'] );
			pll_set_post_language( $id, $lang ); $links[$lang]=$id;
		}
		pll_save_post_translations( $links );
	}
	update_option( 'noki_multilingual_core_seed', '2026-10-v2', false );
}

function noki_multilingual_service_data() {
	return [
	9001=>[
	'zh'=>['title'=>'坎帕拉空运','slug'=>'kantepala-kongyun','excerpt'=>'从坎帕拉和恩德培出发的快速空运服务，包含清关、追踪和门到门配送。','content'=>'<h2>经恩德培国际机场的快速可靠空运</h2><p>当货物不能等待时，Noki Logistics 通过空运帮助您快速送达。我们为进口商和出口商提供乌干达空运服务，连接坎帕拉与全球主要枢纽，并提供全程追踪、保险和清关。</p><h3>我们承运的货物</h3><ul><li>一般货物、易腐品和高价值货物的进出口空运</li><li>空运拼货与特快服务</li><li>温控及时间敏感货物</li><li>机场到门和完整门到门配送</li></ul><h3>空运与清关一站式服务</h3><p>我们的持证清关团队负责文件和海关手续，帮助货物顺利通过 URA。</p><h3>常见问题</h3><p><strong>空运需要多久？</strong> 大多数恩德培进出口线路门到门约需 2–6 天。</p><p><a href="/contact/">获取空运报价 →</a></p>'],
	'fr'=>['title'=>'Fret aérien à Kampala','slug'=>'fret-aerien-kampala','excerpt'=>'Fret aérien urgent depuis Kampala et Entebbe, avec douane, suivi et livraison porte à porte.','content'=>'<h2>Fret aérien rapide et fiable via Entebbe</h2><p>Lorsque votre marchandise ne peut pas attendre, Noki Logistics l’achemine par avion. Nous relions Kampala aux grands hubs mondiaux avec suivi, assurance et dédouanement de bout en bout.</p><h3>Ce que nous transportons</h3><ul><li>Fret import et export, marchandises générales, périssables et de valeur</li><li>Consolidation et services express</li><li>Expéditions sensibles au temps et à la température</li><li>Livraison aéroport-porte et porte-à-porte</li></ul><h3>Fret aérien et douane sous un même toit</h3><p>Notre équipe agréée gère les documents et formalités URA afin d’éviter les retards coûteux.</p><h3>FAQ</h3><p><strong>Quel délai ?</strong> La plupart des routes vers ou depuis Entebbe prennent 2 à 6 jours porte à porte.</p><p><a href="/contact/">Demander un devis aérien →</a></p>'],
	'de'=>['title'=>'Luftfracht Kampala','slug'=>'luftfracht-kampala','excerpt'=>'Zeitkritische Luftfracht ab Kampala und Entebbe mit Zollabwicklung, Tracking und Tür-zu-Tür-Lieferung.','content'=>'<h2>Schnelle, zuverlässige Luftfracht über Entebbe</h2><p>Wenn Ihre Fracht nicht warten kann, bringt Noki Logistics sie per Luftfracht ans Ziel. Wir verbinden Kampala mit weltweiten Hubs und übernehmen Tracking, Versicherung und Zollabwicklung.</p><h3>Was wir transportieren</h3><ul><li>Import- und Exportluftfracht</li><li>Konsolidierung und Expressdienste</li><li>Zeit- und temperaturempfindliche Sendungen</li><li>Flughafen-zu-Tür und Tür-zu-Tür</li></ul><h3>Luftfracht und Zoll aus einer Hand</h3><p>Unser lizenziertes Team erledigt Dokumentation und URA-Abfertigung, damit Ihre Fracht ohne unnötige Verzögerungen weiterläuft.</p><h3>FAQ</h3><p><strong>Wie lange dauert Luftfracht?</strong> Die meisten Strecken dauern 2–6 Tage von Tür zu Tür.</p><p><a href="/contact/">Luftfracht-Angebot anfordern →</a></p>'],
	'es'=>['title'=>'Carga aérea en Kampala','slug'=>'carga-aerea-kampala','excerpt'=>'Carga aérea urgente desde Kampala y Entebbe con aduanas, seguimiento y entrega puerta a puerta.','content'=>'<h2>Carga aérea rápida y confiable vía Entebbe</h2><p>Cuando su carga no puede esperar, Noki Logistics la mueve por aire. Conectamos Kampala con centros globales y gestionamos seguimiento, seguro y aduanas de principio a fin.</p><h3>Qué transportamos</h3><ul><li>Carga aérea de importación y exportación</li><li>Consolidación y servicios exprés</li><li>Envíos urgentes y sensibles a temperatura</li><li>Entrega aeropuerto-puerta y puerta a puerta</li></ul><h3>Carga aérea y aduanas en un solo lugar</h3><p>Nuestro equipo autorizado gestiona documentos y trámites de URA para evitar retrasos costosos.</p><h3>Preguntas frecuentes</h3><p><strong>¿Cuánto tarda?</strong> La mayoría de rutas desde o hacia Entebbe tardan entre 2 y 6 días puerta a puerta.</p><p><a href="/contact/">Solicitar cotización aérea →</a></p>'],
	'pl'=>['title'=>'Fracht lotniczy Kampala','slug'=>'fracht-lotniczy-kampala','excerpt'=>'Pilny fracht lotniczy z Kampali i Entebbe z odprawą celną, śledzeniem i dostawą door-to-door.','content'=>'<h2>Szybki i niezawodny fracht lotniczy przez Entebbe</h2><p>Gdy ładunek nie może czekać, Noki Logistics wysyła go drogą lotniczą. Łączymy Kampalę z globalnymi hubami, zapewniając śledzenie, ubezpieczenie i odprawę celną.</p><h3>Co przewozimy</h3><ul><li>Import i eksport lotniczy</li><li>Konsolidacja i usługi ekspresowe</li><li>Przesyłki pilne i wrażliwe na temperaturę</li><li>Dostawy lotnisko-drzwi i door-to-door</li></ul><h3>Fracht lotniczy i cło w jednym miejscu</h3><p>Nasz licencjonowany zespół prowadzi dokumentację i odprawę URA, aby ograniczyć opóźnienia.</p><h3>FAQ</h3><p><strong>Ile trwa fracht lotniczy?</strong> Większość tras zajmuje 2–6 dni door-to-door.</p><p><a href="/contact/">Poproś o wycenę frachtu lotniczego →</a></p>']
	],
	9002=>[
	'zh'=>['title'=>'蒙巴萨至坎帕拉海运','slug'=>'mombasa-kantepala-haiyun','excerpt'=>'经蒙巴萨港到坎帕拉的经济型整箱和拼箱海运，包含清关及内陆运输。','content'=>'<h2>经北部走廊的经济型海运</h2><p>Noki Logistics 提供从蒙巴萨到坎帕拉的整箱（FCL）和拼箱（LCL）海运，并经北部走廊运输至乌干达最终目的地，也可经达累斯萨拉姆中央走廊运输。</p><h3>FCL 还是 LCL？</h3><p>FCL 适合大批量货物；LCL 让较小货量共享集装箱，只按使用空间付费。</p><h3>海运、清关与内陆运输</h3><p>我们统一协调港口操作、URA 文件、边境手续及卡车运输，让整个供应链更顺畅。</p><h3>常见问题</h3><p><strong>海运需要多久？</strong> 根据起运港不同，海运加内陆运输通常约 4–8 周。</p><p><a href="/contact/">获取蒙巴萨—坎帕拉运输报价 →</a></p>'],
	'fr'=>['title'=>'Fret maritime de Mombasa à Kampala','slug'=>'fret-maritime-mombasa-kampala','excerpt'=>'Fret maritime FCL et LCL économique de Mombasa à Kampala, avec douane et transport intérieur.','content'=>'<h2>Transport maritime économique via le Corridor Nord</h2><p>Noki Logistics gère le fret maritime de Mombasa à Kampala en conteneurs complets (FCL) ou groupage (LCL), puis le transport routier jusqu’à votre destination en Ouganda.</p><h3>FCL ou LCL ?</h3><p>Le FCL convient aux volumes importants. Le LCL permet aux petits expéditeurs de partager un conteneur et de payer uniquement l’espace utilisé.</p><h3>Mer, douane et transport intérieur</h3><p>Nous coordonnons manutention portuaire, documents URA, formalités frontalières et livraison routière.</p><h3>FAQ</h3><p><strong>Quel délai ?</strong> Le transport maritime plus l’acheminement intérieur prend généralement 4 à 8 semaines selon l’origine.</p><p><a href="/contact/">Demander un devis Mombasa–Kampala →</a></p>'],
	'de'=>['title'=>'Seefracht von Mombasa nach Kampala','slug'=>'seefracht-mombasa-kampala','excerpt'=>'Kostengünstige FCL- und LCL-Seefracht von Mombasa nach Kampala inklusive Zoll und Inlandstransport.','content'=>'<h2>Kostengünstige Seefracht über den Northern Corridor</h2><p>Noki Logistics organisiert FCL- und LCL-Seefracht von Mombasa nach Kampala sowie den anschließenden Straßentransport bis zu Ihrem Ziel in Uganda.</p><h3>FCL oder LCL?</h3><p>FCL eignet sich für größere Mengen. Bei LCL teilen sich kleinere Versender einen Container und zahlen nur für den genutzten Raum.</p><h3>Seefracht, Zoll und Inlandstransport</h3><p>Wir koordinieren Hafenabwicklung, URA-Dokumente, Grenzformalitäten und Zustellung.</p><h3>FAQ</h3><p><strong>Wie lange dauert Seefracht?</strong> Insgesamt meist 4–8 Wochen, abhängig vom Ursprung.</p><p><a href="/contact/">Mombasa–Kampala-Angebot anfordern →</a></p>'],
	'es'=>['title'=>'Carga marítima de Mombasa a Kampala','slug'=>'carga-maritima-mombasa-kampala','excerpt'=>'Carga marítima FCL y LCL económica de Mombasa a Kampala con aduanas y transporte interior.','content'=>'<h2>Transporte marítimo económico por el Corredor Norte</h2><p>Noki Logistics gestiona carga marítima FCL y LCL desde Mombasa hasta Kampala y el transporte terrestre final en Uganda.</p><h3>¿FCL o LCL?</h3><p>FCL es ideal para grandes volúmenes. LCL permite compartir contenedor y pagar solo por el espacio utilizado.</p><h3>Mar, aduanas y transporte interior</h3><p>Coordinamos puerto, documentación URA, frontera y entrega terrestre como un solo proceso.</p><h3>Preguntas frecuentes</h3><p><strong>¿Cuánto tarda?</strong> Normalmente entre 4 y 8 semanas según el origen.</p><p><a href="/contact/">Solicitar cotización Mombasa–Kampala →</a></p>'],
	'pl'=>['title'=>'Fracht morski z Mombasy do Kampali','slug'=>'fracht-morski-mombasa-kampala','excerpt'=>'Ekonomiczny fracht morski FCL i LCL z Mombasy do Kampali z odprawą celną i transportem lądowym.','content'=>'<h2>Ekonomiczny transport morski przez Northern Corridor</h2><p>Noki Logistics obsługuje FCL i LCL z Mombasy do Kampali oraz dalszy transport drogowy do miejsca docelowego w Ugandzie.</p><h3>FCL czy LCL?</h3><p>FCL sprawdza się przy większych wolumenach. LCL pozwala współdzielić kontener i płacić tylko za wykorzystaną przestrzeń.</p><h3>Morze, cło i transport lądowy</h3><p>Koordynujemy port, dokumenty URA, odprawę graniczną i dostawę drogową.</p><h3>FAQ</h3><p><strong>Ile trwa fracht morski?</strong> Zwykle 4–8 tygodni zależnie od miejsca pochodzenia.</p><p><a href="/contact/">Poproś o wycenę Mombasa–Kampala →</a></p>']
	],
	9003=>[
	'zh'=>['title'=>'东非跨境公路货运','slug'=>'dongfei-kuajing-gonglu-huoyun','excerpt'=>'覆盖肯尼亚、坦桑尼亚、卢旺达、刚果（金）和南苏丹的可靠跨境卡车运输。','content'=>'<h2>东非可靠跨境卡车运输</h2><p>Noki Logistics 通过公路连接坎帕拉与内罗毕、蒙巴萨、基加利、布琼布拉、朱巴、戈马和达累斯萨拉姆。</p><h3>我们的公路货运服务</h3><ul><li>整车和零担运输</li><li>肯尼亚、坦桑尼亚、卢旺达、刚果（金）和南苏丹跨境运输</li><li>蒙巴萨和达累斯萨拉姆集装箱内陆运输</li><li>项目及重型货物运输</li></ul><h3>边境手续由我们处理</h3><p>我们负责清关和过境文件，让车辆保持运行。</p><p><a href="/contact/">获取公路货运报价 →</a></p>'],
	'fr'=>['title'=>'Fret routier transfrontalier en Afrique de l’Est','slug'=>'fret-routier-afrique-est','excerpt'=>'Transport routier fiable vers le Kenya, la Tanzanie, le Rwanda, la RDC et le Soudan du Sud.','content'=>'<h2>Transport routier fiable à travers l’Afrique de l’Est</h2><p>Noki Logistics relie Kampala à Nairobi, Mombasa, Kigali, Bujumbura, Juba, Goma et Dar es Salaam.</p><h3>Nos services routiers</h3><ul><li>Camions complets et lots partiels</li><li>Transport transfrontalier régional</li><li>Acheminement intérieur des conteneurs</li><li>Projets et charges lourdes</li></ul><h3>Nous gérons les frontières</h3><p>Notre équipe prend en charge dédouanement et documents de transit pour maintenir vos marchandises en mouvement.</p><p><a href="/contact/">Demander un devis routier →</a></p>'],
	'de'=>['title'=>'Grenzüberschreitende Straßentransporte in Ostafrika','slug'=>'strassenfracht-ostafrika','excerpt'=>'Zuverlässige Lkw-Transporte nach Kenia, Tansania, Ruanda, DRC und Südsudan.','content'=>'<h2>Zuverlässige grenzüberschreitende Lkw-Transporte</h2><p>Noki Logistics verbindet Kampala mit Nairobi, Mombasa, Kigali, Bujumbura, Juba, Goma und Dar es Salaam.</p><h3>Unsere Straßendienste</h3><ul><li>FTL und LTL</li><li>Regionale grenzüberschreitende Transporte</li><li>Container-Inlandtransport</li><li>Projekt- und Schwerlasttransporte</li></ul><h3>Wir kümmern uns um die Grenzen</h3><p>Unser Team übernimmt Zoll- und Transitdokumente, damit Ihre Fracht weiterfährt.</p><p><a href="/contact/">Straßenfracht-Angebot anfordern →</a></p>'],
	'es'=>['title'=>'Transporte terrestre transfronterizo en África Oriental','slug'=>'transporte-terrestre-africa-oriental','excerpt'=>'Camiones confiables hacia Kenia, Tanzania, Ruanda, RDC y Sudán del Sur.','content'=>'<h2>Transporte terrestre confiable en África Oriental</h2><p>Noki Logistics conecta Kampala con Nairobi, Mombasa, Kigali, Bujumbura, Juba, Goma y Dar es Salaam.</p><h3>Nuestros servicios terrestres</h3><ul><li>Camión completo y carga parcial</li><li>Transporte transfronterizo regional</li><li>Transporte interior de contenedores</li><li>Proyectos y carga pesada</li></ul><h3>Gestionamos las fronteras</h3><p>Nuestro equipo se ocupa del despacho y documentación de tránsito para mantener su carga en movimiento.</p><p><a href="/contact/">Solicitar cotización terrestre →</a></p>'],
	'pl'=>['title'=>'Transgraniczny transport drogowy w Afryce Wschodniej','slug'=>'transport-drogowy-afryka-wschodnia','excerpt'=>'Niezawodny transport drogowy do Kenii, Tanzanii, Rwandy, DRK i Sudanu Południowego.','content'=>'<h2>Niezawodny transport drogowy w Afryce Wschodniej</h2><p>Noki Logistics łączy Kampalę z Nairobi, Mombasą, Kigali, Bujumburą, Jubą, Gomą i Dar es Salaam.</p><h3>Nasze usługi drogowe</h3><ul><li>FTL i LTL</li><li>Transport transgraniczny</li><li>Transport kontenerów w głębi lądu</li><li>Ładunki projektowe i ciężkie</li></ul><h3>Obsługujemy granice</h3><p>Nasz zespół prowadzi odprawę i dokumenty tranzytowe, aby ładunek nie tracił czasu.</p><p><a href="/contact/">Poproś o wycenę transportu drogowego →</a></p>']
	],
	9004=>[
	'zh'=>['title'=>'乌干达清关服务','slug'=>'wuganda-qingguan','excerpt'=>'乌干达持证清关和货运代理服务，快速处理 URA 文件及边境手续。','content'=>'<h2>持证清关和货运代理</h2><p>清关延误会增加时间和成本。Noki Logistics 负责 URA 文件、HS 编码和边境手续，帮助您的货物快速、合规放行。</p><h3>我们的服务</h3><ul><li>进出口报关</li><li>HS 编码及税费计算</li><li>恩德培、蒙巴萨、马拉巴、布西亚等地清关</li><li>许可、豁免及合规支持</li></ul><h3>清关与货运一体化</h3><p>我们将清关与空运、海运和公路运输整合，提供从起点到最终目的地的无缝服务。</p><p><a href="/contact/">联系清关专家 →</a></p>'],
	'fr'=>['title'=>'Dédouanement en Ouganda','slug'=>'dedouanement-ouganda','excerpt'=>'Dédouanement et transit agréés en Ouganda, documents URA et formalités frontalières traités rapidement.','content'=>'<h2>Agents agréés de dédouanement et transit</h2><p>Les retards douaniers coûtent du temps et de l’argent. Noki Logistics gère les documents URA, la classification HS et les formalités frontalières afin d’obtenir une mainlevée rapide et conforme.</p><h3>Nos services</h3><ul><li>Déclarations import et export</li><li>Classification HS et calcul des droits</li><li>Dédouanement aux principaux postes</li><li>Permis, exemptions et conformité</li></ul><h3>Douane et fret ensemble</h3><p>Nous combinons le dédouanement avec le fret aérien, maritime et routier pour un parcours fluide de l’origine à la porte.</p><p><a href="/contact/">Parler à un agent en douane →</a></p>'],
	'de'=>['title'=>'Zollabfertigung in Uganda','slug'=>'zollabfertigung-uganda','excerpt'=>'Lizenzierte Zollabfertigung in Uganda mit URA-Dokumenten und schneller Grenzabwicklung.','content'=>'<h2>Lizenzierte Zoll- und Speditionsagenten</h2><p>Zollverzögerungen kosten Zeit und Geld. Noki Logistics übernimmt URA-Dokumente, HS-Klassifizierung und Grenzformalitäten für eine schnelle und korrekte Freigabe.</p><h3>Unsere Leistungen</h3><ul><li>Import- und Exportanmeldungen</li><li>HS-Klassifizierung und Abgabenberechnung</li><li>Abfertigung an wichtigen Grenzstellen</li><li>Genehmigungen und Compliance</li></ul><h3>Zoll und Fracht kombiniert</h3><p>Wir verbinden Zollabfertigung mit Luft-, See- und Straßentransport.</p><p><a href="/contact/">Mit einem Zollagenten sprechen →</a></p>'],
	'es'=>['title'=>'Despacho de aduanas en Uganda','slug'=>'aduanas-uganda','excerpt'=>'Despacho aduanero autorizado en Uganda con documentación URA y trámites fronterizos rápidos.','content'=>'<h2>Agentes autorizados de aduanas y expedición</h2><p>Los retrasos aduaneros cuestan tiempo y dinero. Noki Logistics gestiona documentación URA, clasificación HS y trámites fronterizos para liberar su carga de forma rápida y correcta.</p><h3>Qué hacemos</h3><ul><li>Declaraciones de importación y exportación</li><li>Clasificación HS y cálculo de impuestos</li><li>Despacho en los principales puntos fronterizos</li><li>Permisos y cumplimiento</li></ul><h3>Aduanas y transporte juntos</h3><p>Combinamos el despacho con transporte aéreo, marítimo y terrestre.</p><p><a href="/contact/">Hablar con un agente de aduanas →</a></p>'],
	'pl'=>['title'=>'Odprawa celna w Ugandzie','slug'=>'odprawa-celna-uganda','excerpt'=>'Licencjonowana odprawa celna w Ugandzie, dokumenty URA i szybka obsługa graniczna.','content'=>'<h2>Licencjonowani agenci celni i spedycyjni</h2><p>Opóźnienia celne kosztują czas i pieniądze. Noki Logistics obsługuje dokumenty URA, klasyfikację HS i formalności graniczne, aby ładunek został szybko i prawidłowo zwolniony.</p><h3>Co robimy</h3><ul><li>Deklaracje importowe i eksportowe</li><li>Klasyfikacja HS i obliczanie należności</li><li>Odprawa na głównych przejściach</li><li>Pozwolenia i zgodność</li></ul><h3>Cło i transport razem</h3><p>Łączymy odprawę z frachtem lotniczym, morskim i drogowym.</p><p><a href="/contact/">Porozmawiaj z agentem celnym →</a></p>']
	],
	9005=>[
	'zh'=>['title'=>'坎帕拉仓储','slug'=>'kantepala-cangchu','excerpt'=>'坎帕拉安全有序的仓储、库存管理及乌干达全国配送。','content'=>'<h2>坎帕拉安全仓储与配送</h2><p>Noki Logistics 提供灵活的坎帕拉仓储服务，包括安全存储、库存管理以及乌干达和区域配送。</p><h3>仓储服务</h3><ul><li>短期和长期安全存储</li><li>库存管理和报告</li><li>拣货、包装和配送</li><li>快速货物交叉转运</li></ul><p>可与海运结合，实现集装箱到港后的收货、存储和配送一体化。</p><p><a href="/contact/">咨询仓储服务 →</a></p>'],
	'fr'=>['title'=>'Entreposage à Kampala','slug'=>'entreposage-kampala','excerpt'=>'Entreposage sécurisé à Kampala avec gestion des stocks et distribution dans tout l’Ouganda.','content'=>'<h2>Stockage sécurisé et distribution à Kampala</h2><p>Noki Logistics propose un entreposage flexible à Kampala avec gestion des stocks et distribution en Ouganda et dans la région.</p><h3>Nos services</h3><ul><li>Stockage sécurisé court et long terme</li><li>Gestion des stocks et rapports</li><li>Préparation, emballage et distribution</li><li>Cross-docking</li></ul><p>Combinez l’entreposage avec le fret maritime pour une prise en charge complète à l’arrivée.</p><p><a href="/contact/">Demander des informations sur l’entreposage →</a></p>'],
	'de'=>['title'=>'Lagerhaltung in Kampala','slug'=>'lagerhaltung-kampala','excerpt'=>'Sichere Lagerung in Kampala mit Bestandsmanagement und Distribution in Uganda.','content'=>'<h2>Sichere Lagerung und Distribution in Kampala</h2><p>Noki Logistics bietet flexible Lagerlösungen mit Bestandsmanagement und Weiterverteilung in Uganda und der Region.</p><h3>Unsere Lagerleistungen</h3><ul><li>Kurz- und langfristige Lagerung</li><li>Bestandsmanagement und Reporting</li><li>Kommissionierung, Verpackung und Distribution</li><li>Cross-Docking</li></ul><p>In Kombination mit Seefracht erhalten Sie eine durchgängige Lösung vom Container bis zur Auslieferung.</p><p><a href="/contact/">Lagerangebot anfragen →</a></p>'],
	'es'=>['title'=>'Almacenamiento en Kampala','slug'=>'almacenamiento-kampala','excerpt'=>'Almacenamiento seguro en Kampala con gestión de inventario y distribución en Uganda.','content'=>'<h2>Almacenamiento y distribución seguros en Kampala</h2><p>Noki Logistics ofrece almacenamiento flexible con gestión de inventario y distribución en Uganda y la región.</p><h3>Servicios de almacén</h3><ul><li>Almacenamiento de corto y largo plazo</li><li>Gestión y reportes de inventario</li><li>Preparación, embalaje y distribución</li><li>Cross-docking</li></ul><p>Combine el almacén con carga marítima para una solución completa desde la llegada del contenedor.</p><p><a href="/contact/">Consultar almacenamiento →</a></p>'],
	'pl'=>['title'=>'Magazynowanie w Kampali','slug'=>'magazynowanie-kampala','excerpt'=>'Bezpieczne magazynowanie w Kampali z zarządzaniem zapasami i dystrybucją w Ugandzie.','content'=>'<h2>Bezpieczne magazynowanie i dystrybucja w Kampali</h2><p>Noki Logistics oferuje elastyczne magazynowanie, zarządzanie zapasami i dystrybucję w Ugandzie i regionie.</p><h3>Usługi magazynowe</h3><ul><li>Krótko- i długoterminowe składowanie</li><li>Zarządzanie zapasami i raportowanie</li><li>Kompletacja, pakowanie i dystrybucja</li><li>Cross-docking</li></ul><p>Połącz magazyn z frachtem morskim, aby uzyskać pełną obsługę po przybyciu kontenera.</p><p><a href="/contact/">Zapytaj o magazynowanie →</a></p>']
	],
	9006=>[
	'zh'=>['title'=>'坎帕拉特快配送','slug'=>'kantepala-tekuai-peisong','excerpt'=>'坎帕拉及乌干达全国当日和次日快递配送，提供追踪及签收证明。','content'=>'<h2>乌干达当日及次日快递</h2><p>针对紧急文件和包裹，Noki Logistics 在坎帕拉提供当日配送，在乌干达全国提供次日配送，并提供追踪和签收证明。</p><h3>快递服务</h3><ul><li>坎帕拉当日配送</li><li>全国次日配送</li><li>文件和包裹快递</li><li>企业定时及按需取件</li></ul><p><a href="/contact/">预约快递配送 →</a></p>'],
	'fr'=>['title'=>'Livraison express à Kampala','slug'=>'livraison-express-kampala','excerpt'=>'Livraison le jour même et le lendemain à Kampala et en Ouganda avec suivi et preuve de livraison.','content'=>'<h2>Courrier le jour même et le lendemain</h2><p>Pour les documents et colis urgents, Noki Logistics assure la livraison le jour même à Kampala et le lendemain dans le pays, avec suivi et preuve de réception.</p><h3>Services express</h3><ul><li>Livraison le jour même à Kampala</li><li>Livraison le lendemain dans tout le pays</li><li>Courrier documents et colis</li><li>Collectes programmées ou à la demande</li></ul><p><a href="/contact/">Réserver une livraison express →</a></p>'],
	'de'=>['title'=>'Expresslieferung in Kampala','slug'=>'expresslieferung-kampala','excerpt'=>'Same-Day- und Next-Day-Kurier in Kampala und Uganda mit Tracking und Zustellnachweis.','content'=>'<h2>Same-Day- und Next-Day-Kurier in Uganda</h2><p>Für dringende Dokumente und Pakete bietet Noki Logistics Same-Day-Lieferung in Kampala und Next-Day-Lieferung landesweit inklusive Tracking und Zustellnachweis.</p><h3>Expressdienste</h3><ul><li>Same-Day in Kampala</li><li>Next-Day landesweit</li><li>Dokumente und Pakete</li><li>Planmäßige und bedarfsgerechte Abholung</li></ul><p><a href="/contact/">Expresslieferung buchen →</a></p>'],
	'es'=>['title'=>'Entrega exprés en Kampala','slug'=>'entrega-expres-kampala','excerpt'=>'Mensajería el mismo día y al día siguiente en Kampala y Uganda con seguimiento y prueba de entrega.','content'=>'<h2>Mensajería el mismo día y al día siguiente</h2><p>Para documentos y paquetes urgentes, Noki Logistics ofrece entrega el mismo día en Kampala y al día siguiente en todo el país, con seguimiento y comprobante de recepción.</p><h3>Servicios exprés</h3><ul><li>Entrega el mismo día en Kampala</li><li>Entrega al día siguiente en todo el país</li><li>Documentos y paquetes</li><li>Recogidas programadas y bajo demanda</li></ul><p><a href="/contact/">Reservar entrega exprés →</a></p>'],
	'pl'=>['title'=>'Dostawa ekspresowa w Kampali','slug'=>'dostawa-ekspresowa-kampala','excerpt'=>'Kurier tego samego i następnego dnia w Kampali i Ugandzie ze śledzeniem i potwierdzeniem dostawy.','content'=>'<h2>Kurier tego samego i następnego dnia</h2><p>Dla pilnych dokumentów i paczek Noki Logistics oferuje dostawę tego samego dnia w Kampali i następnego dnia w całej Ugandzie, ze śledzeniem i potwierdzeniem odbioru.</p><h3>Usługi ekspresowe</h3><ul><li>Dostawa tego samego dnia w Kampali</li><li>Następny dzień w całym kraju</li><li>Kurier dokumentów i paczek</li><li>Odbiory planowane i na żądanie</li></ul><p><a href="/contact/">Zamów dostawę ekspresową →</a></p>']
	]
	];
}

function noki_multilingual_news_data() {
	$base = [
	34=>[
		'zh'=>['全新蒙巴萨海运拼箱服务正式上线','mombasa-haiyun-pinxang-fuwu','小批量货物也能以更低成本运输——全新的 LCL 拼箱服务让您共享集装箱空间。','<p>我们现已推出蒙巴萨—坎帕拉线路的 <strong>LCL 拼箱服务</strong>。小批量进口无需支付整箱费用，只需按实际使用空间付费。</p><p>服务按固定班期运行，并包含清关和坎帕拉门到门配送。</p>'],
		'fr'=>['Nouveau service de groupage maritime via Mombasa','groupage-maritime-mombasa','Expédiez de petits volumes à moindre coût grâce à notre nouveau service LCL Mombasa–Kampala.','<p>Nous lançons un nouveau <strong>service de groupage LCL</strong> sur le corridor Mombasa–Kampala. Les petits importateurs peuvent partager un conteneur et payer uniquement le volume utilisé.</p><p>Le service comprend le dédouanement et la livraison à Kampala.</p>'],
		'de'=>['Neuer Seefracht-Sammelservice über Mombasa','seefracht-sammelservice-mombasa','Kleinere Sendungen günstiger verschicken – mit unserem neuen LCL-Service Mombasa–Kampala.','<p>Wir haben einen neuen <strong>LCL-Sammelservice</strong> auf der Strecke Mombasa–Kampala gestartet. Kleinere Importe teilen sich Containerraum und zahlen nur für das genutzte Volumen.</p><p>Zollabfertigung und Zustellung in Kampala sind enthalten.</p>'],
		'es'=>['Nuevo servicio de consolidación marítima vía Mombasa','consolidacion-maritima-mombasa','Envíe cargas pequeñas a menor costo con nuestro nuevo servicio LCL Mombasa–Kampala.','<p>Lanzamos un nuevo <strong>servicio de consolidación LCL</strong> en el corredor Mombasa–Kampala. Los importadores pequeños comparten espacio y pagan solo por el volumen utilizado.</p><p>Incluye aduanas y entrega en Kampala.</p>'],
		'pl'=>['Nowa usługa konsolidacji morskiej przez Mombasę','konsolidacja-morska-mombasa','Mniejsze ładunki taniej dzięki nowej usłudze LCL Mombasa–Kampala.','<p>Uruchomiliśmy nową <strong>usługę konsolidacji LCL</strong> na trasie Mombasa–Kampala. Mniejsi importerzy dzielą przestrzeń kontenera i płacą tylko za wykorzystaną objętość.</p><p>Usługa obejmuje odprawę celną i dostawę w Kampali.</p>']
	],
	36=>[
		'zh'=>['在坎帕拉国际贸易博览会与 Noki Logistics 见面','kantepala-guoji-maoyi-bolan-hui','欢迎到我们的展位了解货运、清关和仓储服务。','<p>Noki Logistics 将参加今年的 <strong>坎帕拉国际贸易博览会</strong>。欢迎与我们的团队见面，了解如何简化供应链，并获取展会专属运输优惠。</p>'],
		'fr'=>['Rencontrez Noki Logistics à la Kampala International Trade Expo','noki-kampala-trade-expo','Venez parler fret, douane et entreposage avec notre équipe.','<p>Noki Logistics exposera à la <strong>Kampala International Trade Expo</strong>. Venez rencontrer notre équipe, découvrir comment simplifier votre chaîne logistique et profiter d’une offre spéciale salon.</p>'],
		'de'=>['Treffen Sie Noki Logistics auf der Kampala International Trade Expo','noki-kampala-trade-expo','Besuchen Sie unseren Stand für Fracht, Zoll und Lagerlösungen.','<p>Noki Logistics ist auf der <strong>Kampala International Trade Expo</strong> vertreten. Treffen Sie unser Team und erfahren Sie, wie wir Ihre Lieferkette vereinfachen können.</p>'],
		'es'=>['Conozca a Noki Logistics en la Kampala International Trade Expo','noki-kampala-trade-expo','Visite nuestro stand para hablar de carga, aduanas y almacenamiento.','<p>Noki Logistics participará en la <strong>Kampala International Trade Expo</strong>. Conozca al equipo y descubra cómo podemos simplificar su cadena de suministro.</p>'],
		'pl'=>['Spotkaj Noki Logistics na Kampala International Trade Expo','noki-kampala-trade-expo','Odwiedź nasze stoisko i porozmawiaj o transporcie, cle i magazynowaniu.','<p>Noki Logistics będzie wystawcą na <strong>Kampala International Trade Expo</strong>. Spotkaj nasz zespół i dowiedz się, jak możemy uprościć Twój łańcuch dostaw.</p>']
	],
	38=>[
		'zh'=>['恩廷达扩建仓库现已投入使用','entinda-cangku-kuojian','坎帕拉新增安全仓储空间，为客户提供更快配送。','<p>为满足不断增长的需求，我们已<strong>扩建坎帕拉恩廷达的仓储设施</strong>，提供更大的安全空间、更好的库存管理和更快的配送。</p>'],
		'fr'=>['Notre entrepôt agrandi de Ntinda est désormais ouvert','entrepot-ntinda-agrandi','Davantage d’espace sécurisé et une distribution plus rapide à Kampala.','<p>Pour répondre à la demande, nous avons <strong>agrandi notre entrepôt de Ntinda à Kampala</strong>, avec plus d’espace sécurisé, une meilleure gestion des stocks et une distribution plus rapide.</p>'],
		'de'=>['Erweitertes Lager in Ntinda eröffnet','lager-ntinda-erweitert','Mehr sicherer Lagerraum und schnellere Distribution in Kampala.','<p>Wir haben unser <strong>Lager in Ntinda, Kampala, erweitert</strong>. Mehr sichere Fläche ermöglicht bessere Bestandsverwaltung und schnellere Distribution.</p>'],
		'es'=>['Ampliación del almacén de Ntinda ya abierta','almacen-ntinda-ampliado','Más espacio seguro y distribución más rápida en Kampala.','<p>Hemos <strong>ampliado nuestro almacén en Ntinda, Kampala</strong>, ofreciendo más espacio seguro, mejor gestión de inventario y distribución más rápida.</p>'],
		'pl'=>['Rozbudowany magazyn w Ntinda już otwarty','magazyn-ntinda-rozbudowany','Więcej bezpiecznej przestrzeni i szybsza dystrybucja w Kampali.','<p><strong>Rozbudowaliśmy magazyn w Ntinda w Kampali</strong>, zapewniając więcej bezpiecznej przestrzeni, lepsze zarządzanie zapasami i szybszą dystrybucję.</p>']
	],
	40=>[
		'zh'=>['马拉巴边境 24/7 清关服务台正式启用','malaba-24-7-qingguan','全天候清关帮助货物昼夜保持流动。','<p>我们的持证清关团队现已在<strong>马拉巴边境提供 24/7 清关服务</strong>，帮助减少等待时间和滞箱成本。</p>'],
		'fr'=>['Bureau de dédouanement 24/7 ouvert à Malaba','douane-malaba-24-7','Le dédouanement 24h/24 permet à vos marchandises de continuer leur route.','<p>Notre équipe agréée exploite désormais un <strong>bureau douanier 24/7 à la frontière de Malaba</strong>, réduisant les temps d’attente et les frais de surestaries.</p>'],
		'de'=>['24/7-Zollstelle an der Grenze Malaba eröffnet','zoll-malaba-24-7','Rund-um-die-Uhr-Abfertigung hält Ihre Fracht in Bewegung.','<p>Unser lizenziertes Team betreibt jetzt eine <strong>24/7-Zollstelle in Malaba</strong>, um Wartezeiten und Standkosten zu reduzieren.</p>'],
		'es'=>['Mesa de aduanas 24/7 inaugurada en Malaba','aduanas-malaba-24-7','El despacho continuo mantiene su carga en movimiento día y noche.','<p>Nuestro equipo autorizado opera ahora una <strong>mesa de aduanas 24/7 en Malaba</strong>, reduciendo esperas y costos de demora.</p>'],
		'pl'=>['Punkt odprawy celnej 24/7 na granicy Malaba','odprawa-malaba-24-7','Całodobowa odprawa utrzymuje ładunek w ruchu.','<p>Nasz licencjonowany zespół prowadzi teraz <strong>punkt odprawy 24/7 na granicy Malaba</strong>, ograniczając czas oczekiwania i koszty przestoju.</p>']
	],
	42=>[
		'zh'=>['免费进口商研讨会：掌握清关与 Incoterms','jinkoushang-yantaohui','参加我们的免费半日研讨会，学习清关、Incoterms 和降低运输成本的方法。','<p>Noki Logistics 将在坎帕拉举办<strong>免费进口商半日研讨会</strong>，讲解清关、FOB/CIF/EXW 等 Incoterms 以及降低到岸成本的实用方法。</p>'],
		'fr'=>['Atelier gratuit pour importateurs : douane et Incoterms','atelier-importateurs-incoterms','Atelier gratuit à Kampala sur la douane, les Incoterms et la réduction des coûts.','<p>Noki Logistics organise à Kampala un <strong>atelier gratuit d’une demi-journée pour les importateurs</strong> sur le dédouanement, les Incoterms et la réduction du coût rendu.</p>'],
		'de'=>['Kostenloser Importeur-Workshop: Zoll und Incoterms','importeur-workshop-incoterms','Kostenloser Workshop zu Zoll, Incoterms und niedrigeren Versandkosten.','<p>Noki Logistics veranstaltet in Kampala einen <strong>kostenlosen halbtägigen Workshop für Importeure</strong> zu Zollabfertigung, Incoterms und der Senkung von Gesamtkosten.</p>'],
		'es'=>['Taller gratuito para importadores: aduanas e Incoterms','taller-importadores-incoterms','Taller gratuito sobre aduanas, Incoterms y reducción de costos de envío.','<p>Noki Logistics organiza en Kampala un <strong>taller gratuito de medio día para importadores</strong> sobre despacho aduanero, Incoterms y reducción de costos totales.</p>'],
		'pl'=>['Bezpłatne warsztaty dla importerów: cło i Incoterms','warsztaty-importerzy-incoterms','Bezpłatne warsztaty o odprawie, Incoterms i obniżaniu kosztów transportu.','<p>Noki Logistics organizuje w Kampali <strong>bezpłatne półdniowe warsztaty dla importerów</strong> dotyczące odprawy celnej, Incoterms i sposobów obniżania kosztów całkowitych.</p>']
	],
	44=>[
		'zh'=>['通过新承运商合作加快刚果（金）配送','gangguo-peisong-hezuo','新的区域合作让前往戈马和刚果（金）东部的公路运输更快、更可靠。','<p>我们通过<strong>新的承运商合作伙伴关系加强了刚果（金）区域网络</strong>。前往戈马和刚果（金）东部的客户现在可获得更快、更可靠的运输和更好的可视性。</p>'],
		'fr'=>['Livraisons plus rapides vers la RDC grâce à de nouveaux partenaires','livraisons-rdc-partenaires','De nouveaux partenariats accélèrent le transport routier vers Goma et l’est de la RDC.','<p>Nous avons renforcé notre réseau avec de <strong>nouveaux transporteurs partenaires en RDC</strong>. Les clients vers Goma et l’est du pays bénéficient de transports plus rapides et plus fiables.</p>'],
		'de'=>['Schnellere Lieferungen in die DRC durch neue Partner','lieferungen-drc-partner','Neue Partnerschaften ermöglichen schnellere und zuverlässigere Straßentransporte nach Goma und Ost-DRC.','<p>Wir haben unser regionales Netzwerk mit <strong>neuen Transportpartnern für die DRC</strong> erweitert. Sendungen nach Goma und in den Osten werden schneller und transparenter abgewickelt.</p>'],
		'es'=>['Entregas más rápidas a la RDC mediante nuevas alianzas','entregas-rdc-alianzas','Nuevas alianzas mejoran el transporte terrestre a Goma y al este de la RDC.','<p>Hemos fortalecido nuestra red con <strong>nuevos transportistas asociados en la RDC</strong>. Los clientes hacia Goma y el este del país obtienen transporte más rápido y confiable.</p>'],
		'pl'=>['Szybsze dostawy do DRK dzięki nowym partnerstwom','dostawy-drk-partnerzy','Nowe partnerstwa oznaczają szybszy i bardziej niezawodny transport do Gomy i wschodniej DRK.','<p>Wzmocniliśmy sieć regionalną dzięki <strong>nowym partnerom transportowym obsługującym DRK</strong>. Klienci wysyłający do Gomy i wschodniej części kraju zyskują szybszy i bardziej niezawodny transport.</p>']
	]
	];
	$out=[];
	foreach($base as $id=>$langs){ foreach($langs as $lang=>$v){ $out[$id][$lang]=['title'=>$v[0],'slug'=>$v[1],'excerpt'=>$v[2],'content'=>$v[3]]; } }
	return $out;
}


add_action( 'rest_api_init', function () {
	register_rest_route( 'noki/v1', '/seed-translations', [
		'methods'  => 'POST',
		'permission_callback' => function () { return current_user_can( 'manage_options' ); },
		'callback' => function () {
			noki_seed_multilingual_core();
			return rest_ensure_response( [
				'success' => true,
				'message' => 'Core multilingual translations seeded.',
				'version' => get_option( 'noki_multilingual_core_seed', '' ),
			] );
		},
	] );
} );


add_action( 'rest_api_init', function () {
	register_rest_route( 'noki/v1', '/inspect-skylang', [
		'methods' => 'GET',
		'permission_callback' => function () { return current_user_can( 'manage_options' ); },
		'callback' => function () {
			$base = WP_PLUGIN_DIR . '/skylang-auto-translator';
			$out = [];
			if ( ! is_dir( $base ) ) return rest_ensure_response( [ 'error' => 'SkyLang directory not found' ] );
			$it = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $base ) );
			foreach ( $it as $file ) {
				if ( ! $file->isFile() || 'php' !== strtolower( $file->getExtension() ) ) continue;
				$lines = @file( $file->getPathname() );
				if ( ! $lines ) continue;
				foreach ( $lines as $n => $line ) {
					if ( preg_match( '/wp_ajax_|translate_post|translate_content|bulk_translate|google_translate|class .*translate|function .*translate/i', $line ) ) {
						$out[] = [ 'file' => str_replace( $base . '/', '', $file->getPathname() ), 'line' => $n + 1, 'text' => trim( $line ) ];
						if ( count( $out ) >= 250 ) break 2;
					}
				}
			}
			return rest_ensure_response( $out );
		},
	] );
} );


add_action( 'rest_api_init', function () {
	register_rest_route( 'noki/v1', '/translate-blog', [
		'methods' => 'POST',
		'permission_callback' => function () { return current_user_can( 'manage_options' ); },
		'callback' => function ( WP_REST_Request $request ) {
			$ids = array_values( array_filter( array_map( 'absint', (array) $request->get_param( 'ids' ) ) ) );
			$force = (bool) $request->get_param( 'force' );
			$out = [];
			foreach ( $ids as $post_id ) {
				if ( 'post' !== get_post_type( $post_id ) ) {
					$out[ $post_id ] = [ 'success' => false, 'message' => 'Not a standard post.' ];
					continue;
				}
				if ( ! function_exists( 'skylang_translate_post' ) ) {
					$out[ $post_id ] = [ 'success' => false, 'message' => 'SkyLang helper unavailable.' ];
					continue;
				}
				$result = skylang_translate_post( $post_id, $force );
				if ( is_wp_error( $result ) ) {
					$out[ $post_id ] = [ 'success' => false, 'message' => $result->get_error_message() ];
				} else {
					$out[ $post_id ] = [ 'success' => true, 'result' => $result ];
				}
			}
			return rest_ensure_response( $out );
		},
	] );
} );


add_action( 'rest_api_init', function () {
	register_rest_route( 'noki/v1', '/translation-coverage', [
		'methods' => 'POST',
		'permission_callback' => function () { return current_user_can( 'manage_options' ); },
		'callback' => function ( WP_REST_Request $request ) {
			$ids = array_values( array_filter( array_map( 'absint', (array) $request->get_param( 'ids' ) ) ) );
			$langs = [ 'en', 'zh', 'fr', 'de', 'es', 'pl' ];
			$out = [];
			foreach ( $ids as $post_id ) {
				foreach ( $langs as $lang ) {
					$out[ $post_id ][ $lang ] = function_exists( 'pll_get_post' ) ? (int) pll_get_post( $post_id, $lang ) : 0;
				}
			}
			return rest_ensure_response( $out );
		},
	] );
} );


add_action( 'rest_api_init', function () {
	register_rest_route( 'noki/v1', '/google-test', [
		'methods' => 'POST',
		'permission_callback' => function () { return current_user_can( 'manage_options' ); },
		'callback' => function ( WP_REST_Request $request ) {
			if ( empty( $GLOBALS['skylang_plugin'] ) ) return new WP_Error( 'no_skylang', 'SkyLang unavailable.' );
			$ref = new ReflectionMethod( $GLOBALS['skylang_plugin'], 'call_google_translate_api_batch' );
			$ref->setAccessible( true );
			$batch = [ [ 'id' => 1, 'text' => (string) ( $request->get_param( 'text' ) ?: 'Get a free quote today.' ) ] ];
			$result = $ref->invoke( $GLOBALS['skylang_plugin'], $batch, 'en', (string) ( $request->get_param( 'lang' ) ?: 'fr' ) );
			return rest_ensure_response( $result );
		},
	] );
} );


function noki_collect_rendered_ui_strings() {
	$urls = [
		home_url( '/' ),
		get_permalink( 9 ), get_permalink( 10 ), get_permalink( 20 ), get_permalink( 21 ),
		get_permalink( 22 ), get_permalink( 23 ), get_permalink( 24 ), get_permalink( 25 ),
		get_permalink( 26 ),
		get_post_type_archive_link( 'noki_service' ),
		get_permalink( 9001 ),
		get_post_type_archive_link( 'noki_news' ),
		get_permalink( 34 ),
		get_permalink( 9050 ),
	];
	$strings = [];
	foreach ( array_filter( array_unique( $urls ) ) as $url ) {
		$res = wp_remote_get( $url, [ 'timeout' => 20, 'redirection' => 3, 'headers' => [ 'Accept-Language' => 'en-US,en;q=0.9' ] ] );
		if ( is_wp_error( $res ) || 200 !== (int) wp_remote_retrieve_response_code( $res ) ) continue;
		$html = wp_remote_retrieve_body( $res );
		if ( ! $html ) continue;
		$dom = new DOMDocument();
		libxml_use_internal_errors( true );
		$dom->loadHTML( '<?xml encoding="utf-8" ?>' . $html, LIBXML_NOERROR | LIBXML_NOWARNING );
		libxml_clear_errors();
		$xp = new DOMXPath( $dom );
		foreach ( $xp->query( '//body//text()[normalize-space(.) != "" and not(ancestor::script) and not(ancestor::style) and not(ancestor::noscript) and not(ancestor::svg)]' ) as $node ) {
			$text = preg_replace( '/\s+/u', ' ', trim( $node->nodeValue ) );
			if ( ! $text || mb_strlen( $text ) < 2 || mb_strlen( $text ) > 600 ) continue;
			if ( ! preg_match( '/[A-Za-z]/', $text ) ) continue;
			if ( preg_match( '/^(?:https?:\/\/|www\.|\+?[0-9\s()\-]+$)/i', $text ) ) continue;
			if ( in_array( $text, [ 'Noki Logistics', 'WhatsApp', 'LinkedIn', 'Facebook', 'Instagram', 'X', 'TikTok' ], true ) ) continue;
			$strings[ $text ] = true;
		}
	}
	$list = array_keys( $strings );
	sort( $list, SORT_NATURAL | SORT_FLAG_CASE );
	update_option( 'noki_ui_string_catalog', $list, false );
	return $list;
}

add_action( 'rest_api_init', function () {
	register_rest_route( 'noki/v1', '/collect-ui-strings', [
		'methods' => 'POST',
		'permission_callback' => function () { return current_user_can( 'manage_options' ); },
		'callback' => function () {
			$list = noki_collect_rendered_ui_strings();
			return rest_ensure_response( [ 'count' => count( $list ), 'sample' => array_slice( $list, 0, 20 ) ] );
		},
	] );

	register_rest_route( 'noki/v1', '/translate-ui-batch', [
		'methods' => 'POST',
		'permission_callback' => function () { return current_user_can( 'manage_options' ); },
		'callback' => function ( WP_REST_Request $request ) {
			$lang = sanitize_key( (string) $request->get_param( 'lang' ) );
			if ( ! in_array( $lang, [ 'zh', 'fr', 'de', 'es', 'pl' ], true ) ) return new WP_Error( 'bad_lang', 'Unsupported language.' );
			$offset = max( 0, absint( $request->get_param( 'offset' ) ) );
			$limit  = min( 80, max( 1, absint( $request->get_param( 'limit' ) ?: 60 ) ) );
			$list = get_option( 'noki_ui_string_catalog', [] );
			if ( ! is_array( $list ) || ! $list ) $list = noki_collect_rendered_ui_strings();
			$slice = array_slice( $list, $offset, $limit );
			if ( ! $slice ) return rest_ensure_response( [ 'done' => true, 'offset' => $offset, 'total' => count( $list ) ] );
			if ( empty( $GLOBALS['skylang_plugin'] ) ) return new WP_Error( 'no_skylang', 'SkyLang unavailable.' );
			$ref = new ReflectionMethod( $GLOBALS['skylang_plugin'], 'call_google_translate_api_batch' );
			$ref->setAccessible( true );
			$auto = get_option( 'noki_ui_auto_translations', [] );
			if ( ! is_array( $auto ) ) $auto = [];
			if ( $request->get_param( 'reset' ) ) $auto[ $lang ] = [];
			if ( empty( $auto[ $lang ] ) || ! is_array( $auto[ $lang ] ) ) $auto[ $lang ] = [];
			foreach ( array_chunk( $slice, 20, true ) as $chunk ) {
				$batch = [];
				foreach ( $chunk as $idx => $text ) $batch[] = [ 'id' => (int) $idx, 'text' => $text ];
				$result = $ref->invoke( $GLOBALS['skylang_plugin'], $batch, 'en', $lang );
				if ( is_wp_error( $result ) ) return $result;
				foreach ( (array) $result as $row ) {
					$id = isset( $row['id'] ) ? (int) $row['id'] : -1;
					if ( $id >= 0 && isset( $slice[ $id ] ) && isset( $row['translatedText'] ) ) {
						$translated = trim( html_entity_decode( (string) $row['translatedText'], ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
						if ( $translated && $translated !== $slice[ $id ] ) $auto[ $lang ][ $slice[ $id ] ] = $translated;
					}
				}
			}
			update_option( 'noki_ui_auto_translations', $auto, false );
			$next = $offset + count( $slice );
			return rest_ensure_response( [ 'done' => $next >= count( $list ), 'offset' => $offset, 'next_offset' => $next, 'translated' => count( $slice ), 'total' => count( $list ), 'stored' => count( $auto[ $lang ] ) ] );
		},
	] );
} );
