<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "site-content" div and all content after.
 *
 * @package WordPress
 * @subpackage  Aga_ma_smaka_2015
 * @since Aga ma smaka 1.0
 */
?>
<?php get_sidebar(); ?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer" role="contentinfo">
		<div class="site-info">
			<?php
				/**
				 * Fires before the Twenty Fifteen footer text for footer customization.
				 *
				 * @since Aga ma smaka 1.0
				 */
				do_action( 'agamasmaka_credits' );
			?>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'agamasmaka' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'agamasmaka' ), 'WordPress' ); ?></a>
		</div><!-- .site-info -->
	</footer><!-- .site-footer -->



</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
