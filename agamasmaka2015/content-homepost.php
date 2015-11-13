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
	<?php //agamasmaka_post_thumbnail(308,308); ?>
<?php //echo get_the_post_thumbnail(); ?> 
<?php if ( has_post_thumbnail() ) : ?>
	<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	<?php the_post_thumbnail( 'medium' ); ?>
	</a>
<?php else: ?>
<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
	<img src="<?php echo get_template_directory_uri().'/img/no_image.png'; ?>" alt="Brak zdjęcia" />
	</a>
<?php endif; ?>
	<!-- Post Thumb Test -->
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