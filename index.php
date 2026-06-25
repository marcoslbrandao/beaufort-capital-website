<?php
/**
 * index.php
 *
 * Todo tema WordPress PRECISA ter esse arquivo — é o template
 * de fallback usado quando não existe um template mais específico
 * (front-page.php, page.php, single.php, etc.) para a página atual.
 * Por enquanto deixamos algo simples.
 */

get_header();
?>

<main class="wrap" style="padding:64px 32px;">
	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>
			<article>
				<h1><?php the_title(); ?></h1>
				<div><?php the_content(); ?></div>
			</article>
			<?php
		endwhile;
	else :
		echo '<p>Nothing found.</p>';
	endif;
	?>
</main>

<?php
get_footer();
