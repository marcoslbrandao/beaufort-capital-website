<?php
/**
 * O cabeçalho do site — aparece em todas as páginas.
 * wp_head() é obrigatório: é o "gancho" onde o WordPress e os
 * plugins injetam <meta>, CSS, scripts de analytics etc.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="bf-header">
	<div class="wrap nav-row">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
			<span class="mark">BC</span> <?php bloginfo( 'name' ); ?>
		</a>

		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => 'nav',
			'container_class'=> 'primary',
			'menu_class'     => 'primary-menu',
			'fallback_cb'    => false,
		) );
		?>

		<a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="nav-cta">Enquire Now</a>
	</div>
</header>
