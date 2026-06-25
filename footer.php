<?php
/**
 * O rodapé do site — aparece em todas as páginas.
 * wp_footer() é obrigatório: é onde scripts (JS) são injetados
 * pelo WordPress e por plugins.
 */
?>
<footer class="bf-footer">
	<div class="wrap footer-top">
		<div class="footer-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
				<span class="mark">BC</span> <?php bloginfo( 'name' ); ?>
			</a>
			<p>Development finance for proven UK property developers. Senior, stretched senior, mezzanine and equity facilities from £10m to £100m.</p>
		</div>

		<div>
			<h4>Navigate</h4>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer',
				'container'      => false,
				'menu_class'     => 'footer-menu',
				'fallback_cb'    => false,
			) );
			?>
		</div>

		<div>
			<h4>Contact</h4>
			<p>7 Curzon Street<br>London W1J 5HG<br>United Kingdom</p>
			<a href="tel:+442036212246">+44 (0) 20 3621 2246</a>
			<a href="mailto:enquiries@beaufortcapital.co.uk">enquiries@beaufortcapital.co.uk</a>
		</div>

		<div>
			<h4>Newsletter</h4>
			<p>Stay informed on transactions and market views.</p>
			<!-- TODO: ligar este formulário ao Mailchimp (eepurl.com/dCxwv5) -->
			<div class="newsletter-row">
				<input type="email" placeholder="Your email">
				<button>Subscribe</button>
			</div>
		</div>
	</div>

	<div class="wrap footer-bottom">
		<span>&copy; <?php echo esc_html( date( 'Y' ) ); ?> Beaufort Capital Management UK Limited</span>
		<div class="legal-links">
			<a href="<?php echo esc_url( home_url( '/legal-information' ) ); ?>">Legal Information</a>
			<a href="<?php echo esc_url( home_url( '/cookie-policy' ) ); ?>">Cookie Policy</a>
		</div>
	</div>

	<p class="disclaimer">
		Beaufort Capital Management UK Limited (BCM UK) provides this Website for general information purposes only. Nothing on this Website constitutes an offer, advice, invitation or solicitation by BCM UK or its affiliates to enter into any lending or investment activity. BCM UK is an Appointed Representative of Sapia Partners LLP, which is authorised and regulated by the Financial Conduct Authority (FRN 550103).
	</p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
