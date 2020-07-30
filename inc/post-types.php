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



/* ##########################################################
 * Add new taxonomy, make it hierarchical (like categories)
 * Custom Taxonomies
*/
add_action( 'init', 'build_taxonomies', 0 );
 
function build_taxonomies() {
// custom tax
    register_taxonomy( 
        'event-location', 
        array('music'),
        array( 
            'hierarchical' => true, // true = acts like categories false = acts like tags
            'label' => 'Location', 
            'query_var' => true, 
            'rewrite' => true ,
            'show_admin_column' => true,
            'public' => true,
            'rewrite' => array( 'slug' => 'event-location' ),
            '_builtin' => true
        ) 
    );

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
        ) 
    );

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
        )
    );

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
        )
    );


    register_taxonomy( 
        'festival', 'festival_activity',
        array( 
            'hierarchical' => true, // true = acts like categories false = acts like tags
            'label' => 'Festival Name', 
            'query_var' => true, 
            'rewrite' => true ,
            'show_admin_column' => true,
            'public' => true,
            'rewrite' => array( 'slug' => 'festival' ),
            '_builtin' => true
        )
    );

    register_taxonomy( 
        'festival_day', 'festival_activity',
        array( 
            'hierarchical' => true, // true = acts like categories false = acts like tags
            'label' => 'Festival Day', 
            'query_var' => true, 
            'rewrite' => true ,
            'show_admin_column' => true,
            'public' => true,
            'rewrite' => array( 'slug' => 'festival-day' ),
            '_builtin' => true
        )
    );

    register_taxonomy( 
        'edition', 
        array('story'),
        array( 
            'hierarchical' => true, // true = acts like categories false = acts like tags
            'label' => 'Edition', 
            'query_var' => true, 
            'rewrite' => true ,
            'show_admin_column' => true,
            'public' => true,
            'rewrite' => array( 'slug' => 'edition' ),
            '_builtin' => true
        ) 
    );
    
} // End build taxonomies



// Add the custom columns to the position post type:
add_filter( 'manage_posts_columns', 'set_custom_cpt_columns' );
function set_custom_cpt_columns($columns) {
    global $wp_query;
    $query = isset($wp_query->query) ? $wp_query->query : '';
    $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
    if($post_type=='music') {
        unset($columns['taxonomy-event-location']);
        unset($columns['expirationdate']);
        unset($columns['date']);
        $columns['title'] = __( 'Name', 'bellaworks' );
        $columns['show_on_homepage'] = __( 'Show on<br>Homepage', 'bellaworks' );
        $columns['featimage'] = __( 'Image', 'bellaworks' );
        $columns['taxonomy-event-location'] = __( 'Location', 'bellaworks' );
        $columns['expirationdate'] = __( 'Expires', 'bellaworks' );
        $columns['date'] = __( 'Date', 'bellaworks' );
    }

    if($post_type=='story') {
        unset($columns['taxonomy-activity_type']);
        unset($columns['expirationdate']);
        unset($columns['date']);
        $columns['title'] = __( 'Name', 'bellaworks' );
        $columns['show_on_homepage'] = __( 'Show on<br>Homepage', 'bellaworks' );
        $columns['taxonomy-activity_type'] = __( 'Activity', 'bellaworks' );
        $columns['expirationdate'] = __( 'Expires', 'bellaworks' );
        $columns['date'] = __( 'Date', 'bellaworks' );
    }
    
    return $columns;
}

//Add the data to the custom columns for the book post type:
add_action( 'manage_posts_custom_column' , 'custom_post_column', 10, 2 );
function custom_post_column( $column, $post_id ) {
    global $wp_query;
    $query = isset($wp_query->query) ? $wp_query->query : '';
    $post_type = ( isset($query['post_type']) ) ? $query['post_type'] : '';
    
    if($post_type=='music') {
        switch ( $column ) {

            case 'show_on_homepage' :
                $show = get_field('show_on_homepage',$post_id);
                if($show=='yes') {
                    echo '<span style="display:inline-block;width:50px;text-align:center;"><i class="dashicons dashicons-star-filled" style="color:#f1b429;font-size:25px;"></i></span>';
                } 
                break;

            case 'featimage' :
                $img = get_field('thumbnail_image',$post_id);
                $img_src = ($img) ? $img['sizes']['medium'] : '';
                $the_photo = '<span class="tmphoto" style="display:inline-block;width:50px;height:50px;background:#e2e1e1;text-align:center;border:1px solid #CCC;overflow:hidden;">';
                if($img_src) {
                   $the_photo .= '<span style="display:block;width:100%;height:100%;background:url('.$img_src.') top center no-repeat;background-size:cover;transform:scale(1.2)"></span>';
                } else {
                    $the_photo .= '<i class="dashicons dashicons-format-image" style="font-size:25px;position:relative;top:13px;left: -3px;opacity:0.3;"></i>';
                }
                $the_photo .= '</span>';
                echo $the_photo;
                break;
        }
    }

    if($post_type=='story') {
        switch ( $column ) {

            case 'show_on_homepage' :
                $show = get_field('show_on_homepage',$post_id);
                if($show=='yes') {
                    echo '<span style="display:inline-block;width:50px;text-align:center;"><i class="dashicons dashicons-star-filled" style="color:#f1b429;font-size:25px;"></i></span>';
                } 
                break;

        }
    }
    
}
