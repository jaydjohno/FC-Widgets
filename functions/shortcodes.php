<?php

function copyright_function() 
{
    $startYear = 2020; 
    $currentYear = date('Y');
    
    if ( $startYear != $currentYear ) 
    {
        return 'Copyright &copy; ' . $startYear . ' - ' . $currentYear . ' All rights reserved';
    }
    else
    {
        return 'Copyright &copy; ' . $startYear . ' All rights reserved';
    }
    
}

add_shortcode('copyright', 'copyright_function');

function give_profile_name()
{
    $user = wp_get_current_user();
	
    $name = $user->display_name; 
    
    return '<i class="far fa-user-circle"></i> &nbsp;&nbsp;' . $name;
}

add_shortcode('profile_name', 'give_profile_name');

add_filter( 'wp_nav_menu_objects', 'my_user_name' );
function my_user_name( $menu_items ) 
{
    foreach ( $menu_items as $menu_item ) 
    {
        if ( '#profile_name#' == $menu_item->title ) 
        {
            global $shortcode_tags;
            
            if ( isset( $shortcode_tags['profile_name'] ) ) 
            {
                // Or do_shortcode(), if you must.
                $menu_item->title = call_user_func( $shortcode_tags['profile_name'] );
            }    
        }
    }

    return $menu_items;
} 