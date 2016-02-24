<?php

/**
 * Template Name: Wskazania (zscript)
 */

/** Force Layout */
add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );
add_filter( 'genesis_site_layout', '__genesis_return_full_width_content' );
ob_start();
include('wskazania_source/index.php');
$string = ob_get_clean();
ob_end_flush();

$GLOBALS['zContent'] = $string;
function my_the_content_filter($content) {
    $content = $GLOBALS['zContent'].$content;
    return $content;
}

add_filter( 'the_content', 'my_the_content_filter' );

genesis();




