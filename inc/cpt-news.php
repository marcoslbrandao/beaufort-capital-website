<?php
/**
 * Custom Post Type: News
 *
 * Centraliza as notícias da Beaufort dentro do próprio WordPress
 * (hoje a seção "News" do menu aponta para fora do site, em
 * beaufortcapital.co.uk/news/ — provavelmente um subdomínio ou
 * serviço externo). Trazer isso para dentro do WP ajuda no SEO,
 * porque o conteúdo passa a viver no domínio principal.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function beaufort_register_cpt_news() {
	$labels = array(
		'name'          => __( 'News', 'beaufort-2026' ),
		'singular_name' => __( 'News Item', 'beaufort-2026' ),
		'add_new_item'  => __( 'Add News Item', 'beaufort-2026' ),
		'edit_item'     => __( 'Edit News Item', 'beaufort-2026' ),
		'all_items'     => __( 'All News', 'beaufort-2026' ),
	);

	register_post_type( 'beaufort_news', array(
		'labels'        => $labels,
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'news' ),
		'menu_icon'     => 'dashicons-megaphone',
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'  => true,
	) );
}
add_action( 'init', 'beaufort_register_cpt_news' );
