<?php
/**
 * Custom Post Type: Transactions
 *
 * Hoje cada "transação" (ex: "Retirement Living Development, Surrey")
 * é HTML fixo na home page. Aqui ela passa a ser um tipo de conteúdo
 * próprio — o cliente (ou você) cria uma "Transaction" pelo painel do
 * WordPress, sem tocar em código, e ela aparece automaticamente na
 * home page e na página /transactions/.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function beaufort_register_cpt_transactions() {
	$labels = array(
		'name'          => __( 'Transactions', 'beaufort-2026' ),
		'singular_name' => __( 'Transaction', 'beaufort-2026' ),
		'add_new_item'  => __( 'Add New Transaction', 'beaufort-2026' ),
		'edit_item'     => __( 'Edit Transaction', 'beaufort-2026' ),
		'all_items'     => __( 'All Transactions', 'beaufort-2026' ),
	);

	register_post_type( 'transaction', array(
		'labels'        => $labels,
		'public'        => true,
		'has_archive'   => true,
		'rewrite'       => array( 'slug' => 'transactions' ),
		'menu_icon'     => 'dashicons-portfolio',
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'show_in_rest'  => true, // habilita o editor de bloco / Gutenberg
	) );
}
add_action( 'init', 'beaufort_register_cpt_transactions' );

/**
 * Campos extras de cada Transaction (Asset Class, Localização, GDV).
 *
 * Por enquanto isso é só um placeholder simples via meta box nativo.
 * Quando instalarmos o plugin ACF (Advanced Custom Fields), substituímos
 * isso por campos mais amigáveis no painel — Asset Class, Location, GDV
 * como dropdowns/inputs dedicados em vez de texto livre.
 */
