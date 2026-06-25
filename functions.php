<?php
/**
 * Beaufort 2026 — functions.php
 *
 * Ponto de entrada do tema. Aqui registramos:
 * - os arquivos CSS/JS (enqueue)
 * - os menus de navegação
 * - os Custom Post Types (Transactions, News)
 * - os campos extras (via ACF, quando o plugin estiver instalado)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Segurança: impede acesso direto ao arquivo.
}

define( 'BEAUFORT_THEME_VERSION', '0.1.0' );

/**
 * Carrega o CSS e o JS do tema.
 */
function beaufort_enqueue_assets() {
	wp_enqueue_style(
		'beaufort-main',
		get_template_directory_uri() . '/assets/css/main.css',
		array(),
		BEAUFORT_THEME_VERSION
	);

	wp_enqueue_script(
		'beaufort-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		BEAUFORT_THEME_VERSION,
		true // carrega no rodapé
	);
}
add_action( 'wp_enqueue_scripts', 'beaufort_enqueue_assets' );

/**
 * Registra os locais de menu (Header e Footer).
 */
function beaufort_register_menus() {
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'beaufort-2026' ),
		'footer'  => __( 'Footer Navigation', 'beaufort-2026' ),
	) );
}
add_action( 'init', 'beaufort_register_menus' );

/**
 * Suporte a recursos do tema.
 */
function beaufort_theme_support() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'gallery', 'caption' ) );
}
add_action( 'after_setup_theme', 'beaufort_theme_support' );

/**
 * Carrega os arquivos auxiliares.
 * cada Custom Post Type fica em seu próprio arquivo dentro de /inc
 * para manter functions.php pequeno e organizado.
 */
require_once get_template_directory() . '/inc/cpt-transactions.php';
require_once get_template_directory() . '/inc/cpt-news.php';
