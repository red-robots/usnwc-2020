<?php 
/*
 * Custom Post Types 
 * DASH ICONS = https://developer.wordpress.org/resource/dashicons/
 * Example: 'menu_icon' => 'dashicons-admin-users'
*/

add_action('init', 'js_custom_init', 1);
function js_custom_init() {
    $post_types = array(
        array(
            'post_type' => 'activity',
            'menu_name' => 'Activities',
            'plural'    => 'Activities',
            'single'    => 'Activity',
            'menu_icon' => 'dashicons-format-quote',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'pass',
            'menu_name' => 'Passes',
            'plural'    => 'Passes',
            'single'    => 'Pass',
            'menu_icon' => 'dashicons-location',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'race',
            'menu_name' => 'Race Series',
            'plural'    => 'Races',
            'single'    => 'Race',
            'menu_icon' => 'dashicons-location',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'music',
            'menu_name' => 'River Jam',
            'plural'    => 'Music',
            'single'    => 'Music ',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'festival',
            'menu_name' => 'Festival',
            'plural'    => 'Festival',
            'single'    => 'Festival ',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'festival_activity',
            'menu_name' => 'Festival Activities',
            'plural'    => 'Festival Activities',
            'single'    => 'Festival Activity',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'camp',
            'menu_name' => 'Camps',
            'plural'    => 'Camps',
            'single'    => 'Camp',
            'menu_icon' => 'dashicons-location',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'story',
            'menu_name' => 'Stories',
            'plural'    => 'Stories',
            'single'    => 'Story',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'films',
            'menu_name' => 'Films',
            'plural'    => 'Films',
            'single'    => 'Film',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'brewery',
            'menu_name' => 'Breweries',
            'plural'    => 'Breweries',
            'single'    => 'Brewery',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'faqs',
            'menu_name' => 'FAQs',
            'plural'    => 'FAQs',
            'single'    => 'FAQ',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
        array(
            'post_type' => 'job',
            'menu_name' => 'Jobs',
            'plural'    => 'Jobs',
            'single'    => 'Job',
            'menu_icon' => 'dashicons-groups',
            'supports'  => array('title','editor')
        ),
    );
    
    if($post_types) {
        foreach ($post_types as $p) {
            $p_type = ( isset($p['post_type']) && $p['post_type'] ) ? $p['post_type'] : ""; 
            $single_name = ( isset($p['single']) && $p['single'] ) ? $p['single'] : "Custom Post"; 
            $plural_name = ( isset($p['plural']) && $p['plural'] ) ? $p['plural'] : "Custom Post"; 
            $menu_name = ( isset($p['menu_name']) && $p['menu_name'] ) ? $p['menu_name'] : $p['plural']; 
            $menu_icon = ( isset($p['menu_icon']) && $p['menu_icon'] ) ? $p['menu_icon'] : "dashicons-admin-post"; 
            $supports = ( isset($p['supports']) && $p['supports'] ) ? $p['supports'] : array('title','editor','custom-fields','thumbnail'); 
            $taxonomies = ( isset($p['taxonomies']) && $p['taxonomies'] ) ? $p['taxonomies'] : array(); 
            $parent_item_colon = ( isset($p['parent_item_colon']) && $p['parent_item_colon'] ) ? $p['parent_item_colon'] : ""; 
            $menu_position = ( isset($p['menu_position']) && $p['menu_position'] ) ? $p['menu_position'] : 20; 
            
            if($p_type) {
                
                $labels = array(
                    'name' => _x($plural_name, 'post type general name'),
                    'singular_name' => _x($single_name, 'post type singular name'),
                    'add_new' => _x('Add New', $single_name),
                    'add_new_item' => __('Add New ' . $single_name),
                    'edit_item' => __('Edit ' . $single_name),
                    'new_item' => __('New ' . $single_name),
                    'view_item' => __('View ' . $single_name),
                    'search_items' => __('Search ' . $plural_name),
                    'not_found' =>  __('No ' . $plural_name . ' found'),
                    'not_found_in_trash' => __('No ' . $plural_name . ' found in Trash'), 
                    'parent_item_colon' => $parent_item_colon,
                    'menu_name' => $menu_name
                );
            
            
                $args = array(
                    'labels' => $labels,
                    'public' => true,
                    'publicly_queryable' => true,
                    'show_ui' => true, 
                    'show_in_menu' => true, 
                    'show_in_rest' => true,
                    'query_var' => true,
                    'rewrite' => true,
                    'capability_type' => 'post',
                    'has_archive' => false, 
                    'hierarchical' => false, // 'false' acts like posts 'true' acts like pages
                    'menu_position' => $menu_position,
                    'menu_icon'=> $menu_icon,
                    'supports' => $supports
                ); 
                
                register_post_type($p_type,$args); // name used in query
                
            }
            
        }
    }
}

// Add new taxonomy, make it hierarchical (like categories)
// add_action( 'init', 'ii_custom_taxonomies', 0 );
// function ii_custom_taxonomies() {
//         $posts = array(
//             array(
//                 'post_type' => array('pass', 'activity', 'faqs'),
//                 'menu_name' => 'Pass Type',
//                 'plural'    => 'Pass Types',
//                 'single'    => 'Pass Type',
//                 'taxonomy'  => 'pass',
//                 'rewrite'   => 'pass'
//             ),
//             array(
//                 'post_type' => array('race_series'),
//                 'menu_name' => 'Race Status',
//                 'plural'    => 'Race Status',
//                 'single'    => 'Race Status',
//                 'taxonomy'  => 'race_status',
//                 'rewrite'   => 'race-status'
//             ),
//         );
    
//     if($posts) {
//         foreach($posts as $p) {
//             $p_type = ( isset($p['post_type']) && $p['post_type'] ) ? $p['post_type'] : ""; 
//             $single_name = ( isset($p['single']) && $p['single'] ) ? $p['single'] : "Custom Post"; 
//             $plural_name = ( isset($p['plural']) && $p['plural'] ) ? $p['plural'] : "Custom Post"; 
//             $menu_name = ( isset($p['menu_name']) && $p['menu_name'] ) ? $p['menu_name'] : $p['plural'];
//             $taxonomy = ( isset($p['taxonomy']) && $p['taxonomy'] ) ? $p['taxonomy'] : "";
//             $rewrite = ( isset($p['rewrite']) && $p['rewrite'] ) ? $p['rewrite'] : $taxonomy;
            
            
//             if( $taxonomy && $p_type ) {
//                 $labels = array(
//                     'name' => _x( $menu_name, 'taxonomy general name' ),
//                     'singular_name' => _x( $single_name, 'taxonomy singular name' ),
//                     'search_items' =>  __( 'Search ' . $plural_name ),
//                     'popular_items' => __( 'Popular ' . $plural_name ),
//                     'all_items' => __( 'All ' . $plural_name ),
//                     'parent_item' => __( 'Parent ' .  $single_name),
//                     'parent_item_colon' => __( 'Parent ' . $single_name . ':' ),
//                     'edit_item' => __( 'Edit ' . $single_name ),
//                     'update_item' => __( 'Update ' . $single_name ),
//                     'add_new_item' => __( 'Add New ' . $single_name ),
//                     'new_item_name' => __( 'New ' . $single_name ),
//                   );

//               register_taxonomy($taxonomy,array($p_type), array(
//                 'hierarchical' => true,
//                 'labels' => $labels,
//                 'show_ui' => true,
//                 'show_in_rest' => true,
//                 'show_admin_column' => true,
//                 'query_var' => true,
//                 'rewrite' => array( 'slug' => $rewrite ),
//               ));
//             }
            
//         }
//     }
// }
/*
##############################################

    Custom Taxonomies
*/
add_action( 'init', 'build_taxonomies', 0 );
 
function build_taxonomies() {
// cusotm tax
    register_taxonomy( 
        'pass_type', 
        array('activity', 'pass'),
     array( 
        'hierarchical' => true, // true = acts like categories false = acts like tags
        'label' => 'Pass Type', 
        'query_var' => true, 
        'rewrite' => true ,
        'show_admin_column' => true,
        'public' => true,
        'rewrite' => array( 'slug' => 'pass-type' ),
        '_builtin' => true
    ) );

    register_taxonomy( 
        'activity_type', 
        array('film', 'story'),
     array( 
        'hierarchical' => true, // true = acts like categories false = acts like tags
        'label' => 'Activity', 
        'query_var' => true, 
        'rewrite' => true ,
        'show_admin_column' => true,
        'public' => true,
        'rewrite' => array( 'slug' => 'activity-type' ),
        '_builtin' => true
    ) );

    register_taxonomy( 
        'faq_type', 
        array('faqs'),
     array( 
        'hierarchical' => true, // true = acts like categories false = acts like tags
        'label' => 'FAQ Type', 
        'query_var' => true, 
        'rewrite' => true ,
        'show_admin_column' => true,
        'public' => true,
        'rewrite' => array( 'slug' => 'faq-type' ),
        '_builtin' => true
    ) );


    register_taxonomy( 'festival', 'festival_activity',
     array( 
        'hierarchical' => true, // true = acts like categories false = acts like tags
        'label' => 'Festival Name', 
        'query_var' => true, 
        'rewrite' => true ,
        'show_admin_column' => true,
        'public' => true,
        'rewrite' => array( 'slug' => 'festival' ),
        '_builtin' => true
    ) );

    register_taxonomy( 'festival_day', 'festival_activity',
     array( 
        'hierarchical' => true, // true = acts like categories false = acts like tags
        'label' => 'Festival Day', 
        'query_var' => true, 
        'rewrite' => true ,
        'show_admin_column' => true,
        'public' => true,
        'rewrite' => array( 'slug' => 'festival-day' ),
        '_builtin' => true
    ) );
    
} // End build taxonomies

// Add the custom columns to the position post type:
// add_filter( 'manage_posts_columns', 'set_custom_cpt_columns' );
// function set_custom_cpt_columns($columns) {
//     global $wp_query;
//     $query = isset($wp_query->query) ? $wp_query->query : '';
//     $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
    
//     if($post_type=='teams') {
//         unset( $columns['taxonomy-team-groups'] );
//         unset( $columns['title'] );
//         unset( $columns['date'] );
//         $columns['title'] = __( 'Name', 'bellaworks' );
//         $columns['photo'] = __( 'Photo', 'bellaworks' );
//         $columns['taxonomy-team-groups'] = __( 'Group', 'bellaworks' );
//         $columns['date'] = __( 'Date', 'bellaworks' );
//     }
    
//     return $columns;
// }

// Add the data to the custom columns for the book post type:
// add_action( 'manage_posts_custom_column' , 'custom_post_column', 10, 2 );
// function custom_post_column( $column, $post_id ) {
//     global $wp_query;
//     $query = isset($wp_query->query) ? $wp_query->query : '';
//     $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
//     if($post_type=='teams') {
//         switch ( $column ) {
//             case 'jobtitle' :
//                 $jobtitle = get_field("jobtitle",$post_id);
//                 echo ($jobtitle) ? $jobtitle : '';
//                 break;

//             case 'photo' :
//                 $img = get_field('image',$post_id);
//                 $img_src = ($img) ? $img['sizes']['medium'] : '';
//                 $the_photo = '<span class="tmphoto" style="display:inline-block;width:50px;height:50px;background:#e2e1e1;text-align:center;border:1px solid #CCC;overflow:hidden;">';
//                 if($img_src) {
//                    $the_photo .= '<span style="display:block;width:100%;height:100%;background:url('.$img_src.') top center no-repeat;background-size:cover;transform:scale(1.2)"></span>';
//                 } else {
//                     $the_photo .= '<i class="dashicons dashicons-businessperson" style="font-size:25px;position:relative;top:13px;left: -3px;opacity:0.3;"></i>';
//                 }
//                 $the_photo .= '</span>';
//                 echo $the_photo;
//                 break;
//         }
//     }
    
// }
