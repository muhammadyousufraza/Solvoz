<?php

function brainaddons_login_page()
{

    $options = get_option('brainaddons_settings', array());
    $page    = array_key_exists('login_page', $options) ? get_post($options['login_page']) : false;

    return $page;
}

function ba_related_posts_args($post_id)
{
    $categories = get_the_terms($post_id, 'category');
    if (empty($categories) || is_wp_error($categories)) {
        $categories = array();
    }
    $category_list = wp_list_pluck($categories, 'term_id');
    $related_args  = array(
        'post_type'      => 'post',
        'posts_per_page' => 6,
        'no_found_rows'  => true,
        'post_status'    => 'publish',
        'post__not_in'   => array($post_id),
        'orderby'        => 'rand',
        'category__in'   => $category_list,

    );

    return $related_args;
}
