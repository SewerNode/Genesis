<?php
/**
 * The template for displaying link post formats
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage  Aga_ma_smaka_2015
 * @since Aga ma smaka 1.0
 */
?>
<?php $postlink= get_permalink(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class('homepost'); ?>>
	<?php agamasmaka_post_thumbnail(); ?>
	<!-- Test1: <?php echo esc_url( the_permalink() ) ?> // -->
	<!-- Test2: <?php echo esc_url( agamasmaka_get_link_url() ) ?> // -->
	<header class="entry-header homepost-header">
		<?php
			if ( is_single() ) :
				the_title( sprintf('<h1 class="entry-title"><a href="%s">', $postlink), '</a></h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s">', $postlink), '</a></h2>' );
			endif;
		?>
	</header>
	<!-- .entry-header -->

		<?php edit_post_link( __( 'Edit', 'agamasmaka' ), '<span class="edit-link">', '</span>' ); ?>

	<!-- .entry-footer -->

</article><!-- #post-## -->
