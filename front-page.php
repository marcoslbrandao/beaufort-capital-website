<?php
/**
 * front-page.php
 *
 * Este é o template que o WordPress usa especificamente para a
 * home page (diferente de index.php, que é o fallback genérico).
 *
 * O HTML/CSS aqui é baseado no draft estático que já validamos —
 * a diferença é que a seção "Recent Transactions" agora busca os
 * posts do tipo "transaction" automaticamente em vez de ter o
 * conteúdo fixo no código.
 */

get_header();
?>

<section class="hero">
	<div class="wrap hero-inner">
		<span class="eyebrow">UK Development Finance &middot; Est. 50+ years of track record</span>
		<h1>Capital that builds <em>what Britain needs next.</em></h1>
		<p class="lead">Senior, stretched senior, mezzanine and equity facilities from £10m to £100m — for developers who need a partner that moves at the pace of their project.</p>
		<div class="hero-actions">
			<a href="<?php echo esc_url( home_url( '/contact-us' ) ); ?>" class="btn-primary">Discuss a Project</a>
			<a href="<?php echo esc_url( home_url( '/transactions' ) ); ?>" class="btn-ghost">View Recent Transactions</a>
		</div>
	</div>

	<div class="wrap ledger">
		<div class="ledger-item">
			<div class="ledger-num"><span class="gold">£10&ndash;100m</span></div>
			<div class="ledger-label">Senior facility size per project</div>
		</div>
		<div class="ledger-item">
			<div class="ledger-num">from <span class="gold">5.25%</span></div>
			<div class="ledger-label">Cost of finance, over reference rate*</div>
		</div>
		<div class="ledger-item">
			<div class="ledger-num">up to <span class="gold">85%</span></div>
			<div class="ledger-label">Loan to cost across facility types</div>
		</div>
		<div class="ledger-item">
			<div class="ledger-num"><span class="gold">45+</span> yrs</div>
			<div class="ledger-label">Combined team experience in UK real estate</div>
		</div>
	</div>
</section>

<section class="numbers-band">
	<div class="wrap section-head">
		<span class="eyebrow">Beaufort in Numbers</span>
		<h2>A track record you can underwrite against.</h2>
	</div>
	<div class="wrap numbers-grid">
		<div class="num-cell"><div class="big">12+</div><div class="desc">Years supporting development projects across England, Scotland and Wales</div></div>
		<div class="num-cell"><div class="big">10,000+</div><div class="desc">Residential homes funded by our team</div></div>
		<div class="num-cell"><div class="big">20,000+</div><div class="desc">PBSA beds funded by our team</div></div>
		<div class="num-cell"><div class="big">£2.6bn+</div><div class="desc">GDV of development projects supported</div></div>
	</div>
</section>

<section class="tape-section">
	<div class="wrap tape-head">
		<div class="section-head" style="margin-bottom:0;">
			<span class="eyebrow">Recent Transactions</span>
			<h2>Live deal tape.</h2>
		</div>
	</div>

	<div class="tape">
		<div class="tape-track">
			<?php
			// Busca as 8 transações mais recentes cadastradas no painel do WordPress.
			$transactions = new WP_Query( array(
				'post_type'      => 'transaction',
				'posts_per_page' => 8,
			) );

			if ( $transactions->have_posts() ) :
				while ( $transactions->have_posts() ) :
					$transactions->the_post();
					?>
					<a href="<?php the_permalink(); ?>" class="deal">
						<span class="tag"><?php the_title(); ?></span>
						<h4><?php the_excerpt(); ?></h4>
					</a>
					<?php
				endwhile;
				wp_reset_postdata();
			else :
				// Enquanto não há Transactions cadastradas no painel, mostra um aviso amigável
				// só visível no admin (logado) para lembrar de cadastrar o conteúdo.
				if ( is_user_logged_in() ) {
					echo '<p class="deal">Nenhuma Transaction cadastrada ainda. Adicione em wp-admin &rarr; Transactions.</p>';
				}
			endif;
			?>
		</div>
	</div>

	<div class="tape-cta">
		<a href="<?php echo esc_url( home_url( '/transactions' ) ); ?>" class="btn-ghost">View All Transactions</a>
	</div>
</section>

<?php
get_footer();
