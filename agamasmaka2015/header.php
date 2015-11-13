<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage  Aga_ma_smaka_2015
 * @since Aga ma smaka 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<!--[if lt IE 9]>
	<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
	<![endif]-->
	<script>(function(){document.documentElement.className='js'})();</script>
	<!-- WP-HEAD START -->
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-53928463-1', 'auto');
  ga('send', 'pageview');

</script>





<div id="page" class="hfeed site">
	<?php /*<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'agamasmaka' ); ?></a>*/ ?>
	<header id="masthead" class="site-header" role="banner">
		<?php $header_image = get_header_image(); if(!empty($header_image)) : ?>
			<a href="<?php echo esc_url(home_url( '/' )); ?>" rel="home"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
		<?php endif; ?>
		<?php
		$description = get_bloginfo( 'description', 'display' );
		if(($description || is_customize_preview()) && !empty($header_image)):
		?>
		<div class="site-branding">
			<?php
			if(is_front_page() && is_home()): ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<?php else: ?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
			<?php endif;
			//$description = get_bloginfo( 'description', 'display' );
			if($description || is_customize_preview()): ?>
				<p class="site-description"><?php echo $description; ?></p>
			<?php endif;
			?>
			<button class="secondary-toggle"><?php _e( 'Menu and widgets', 'agamasmaka' ); ?></button>
		</div><!-- .site-branding -->
		<?php endif; ?>
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav id="site-navigation" class="main-navigation<?php if(is_active_sidebar('sidebar-0')) echo ' searchmargin'; ?>" role="navigation">
				<?php
				// Primary navigation menu.
				wp_nav_menu( array(
					'menu_class'     => 'nav-menu',
					'theme_location' => 'primary',
				) );
				?>
				<form method="get" id="searchform" action="<?php bloginfo('url'); ?>/">
					<label class="hidden" for="s"><?php _e('Szukaj przepisu'); ?></label>
					<input type="text" value="SZUKAJ PRZEPISU" name="s" id="s" onfocus="if (this.value == 'SZUKAJ PRZEPISU') {this.value = '';}" onblur="if (this.value == '') {this.value = 'SZUKAJ PRZEPISU';}" />
					<?php /*<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" />*/ ?>
					<button type="submit" id="searchsubmit" value=" " ><span class="genericon genericon-search"></span></button>

				</form>

			</nav><!-- .main-navigation -->
		<?php endif; ?>
	</header><!-- .site-header -->
	<?php //get_template_part( 'test', 'helper' ); ?>
	<div id="content" class="site-content <?php if((!is_home() * !is_front_page() * !is_page()) && (has_nav_menu('primary') || has_nav_menu('social') || is_active_sidebar('sidebar-1'))) echo 'site-content-sidebar'; ?>" >
