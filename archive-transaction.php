<?php
/**
 * archive-transaction.php
 *
 * Archive template for the "transaction" CPT — lists all transactions
 * with WordPress native pagination. Registered at slug /transactions/.
 *
 * Card markup intentionally mirrors the deal tape on front-page.php so
 * the two surfaces stay visually consistent without duplicating CSS.
 */

get_header();
?>

<section class="archive-hero">
	<div class="wrap">
		<span class="eyebrow">Deal Tape</span>
		<h1>All Transactions</h1>
		<p class="lead">Our full track record of completed development finance facilities across England, Scotland and Wales.</p>
	</div>
</section>

<section class="transactions-archive">
	<div class="wrap">

		<?php if ( have_posts() ) : ?>

			<div class="txn-grid">
				<?php while ( have_posts() ) : the_post(); ?>
					<a href="<?php the_permalink(); ?>" class="deal txn-card">
						<span class="tag"><?php the_title(); ?></span>
						<h4><?php echo esc_html( get_the_excerpt() ); ?></h4>
					</a>
				<?php endwhile; ?>
			</div>

			<div class="txn-pagination">
				<?php
				the_posts_pagination( array(
					'prev_text' => '&larr;&nbsp;Previous',
					'next_text' => 'Next&nbsp;&rarr;',
					'mid_size'  => 2,
				) );
				?>
			</div>

		<?php else : ?>

			<p class="txn-empty">
				<?php if ( is_user_logged_in() ) : ?>
					No transactions published yet.
					<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=transaction' ) ); ?>">Add the first one &rarr;</a>
				<?php else : ?>
					No transactions found.
				<?php endif; ?>
			</p>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
