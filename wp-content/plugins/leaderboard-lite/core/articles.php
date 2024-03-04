<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
function leaderBoardArticle(){
    $labels = array(
        'name'                => _x( 'LB Articles', 'Post Type General Name', 'twentythirteen' ),
        'singular_name'       => _x( 'LeaderBoard Article', 'Post Type Singular Name', 'twentythirteen' ),
        'menu_name'           => __( 'LB Articles', 'twentythirteen' ),
        'parent_item_colon'   => __( 'Parent Article', 'twentythirteen' ),
        'all_items'           => __( 'All Articles', 'twentythirteen' ),
        'view_item'           => __( 'View Article', 'twentythirteen' ),
        'add_new_item'        => __( 'Add New Article', 'twentythirteen' ),
        'add_new'             => __( 'Add New', 'twentythirteen' ),
        'edit_item'           => __( 'Edit Article', 'twentythirteen' ),
        'update_item'         => __( 'Update Article', 'twentythirteen' ),
        'search_items'        => __( 'Search Article', 'twentythirteen' ),
        'not_found'           => __( 'Not Found', 'twentythirteen' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentythirteen' ),
    );
    $args = array(
        'label'               => __( 'lbd_article', 'twentythirteen' ),
        'description'         => __( 'LB Articles', 'twentythirteen' ),
        'labels'              => $labels,
        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
        'taxonomies'          => array( 'article_cats' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'lbd_article', $args );
}
add_action( 'init', 'leaderBoardArticle', 0 );
/****************************/
add_action( 'init', 'create_topics_LBD_taxonomy', 0 );
function create_topics_LBD_taxonomy() {
  $labels = array(
    'name' => _x( 'Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Categories' ),
    'popular_items' => __( 'Popular Categories' ),
    'all_items' => __( 'All Categories' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Category' ), 
    'update_item' => __( 'Update Category' ),
    'add_new_item' => __( 'Add New Category' ),
    'new_item_name' => __( 'New Category Name' ),
    'separate_items_with_commas' => __( 'Separate Categories with commas' ),
    'add_or_remove_items' => __( 'Add or remove Categories' ),
    'choose_from_most_used' => __( 'Choose from the most used Categories' ),
    'menu_name' => __( 'Categories' ),
  ); 
  register_taxonomy('article_cats','lbd_article',array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'article_cat' ),
  ));
}