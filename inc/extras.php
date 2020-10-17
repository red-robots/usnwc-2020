<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');

function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}


function get_social_links() {
    $social_types = social_icons();
    $social = array();
    foreach($social_types as $k=>$icon) {
        if( $value = get_field($k,'option') ) {
            $social[$k] = array('link'=>$value,'icon'=>$icon);
        }
    }
    return $social;
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fab fa-facebook-square',
        'twitter'   => 'fab fa-twitter-square',
        'linkedin'  => 'fab fa-linkedin',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'vimeo'  => 'fab fa-vimeo',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}


function GetDays($sStartDate, $sEndDate){  
    // Firstly, format the provided dates.  
    // This function works best with YYYY-MM-DD  
    // but other date formats will work thanks  
    // to strtotime().  
    $sStartDate = gmdate("Y-m-d", strtotime($sStartDate));  
    $sEndDate = gmdate("Y-m-d", strtotime($sEndDate));  

    // Start the variable off with the start date  
    $aDays[] = $sStartDate;  

    // Set a 'temp' variable, sCurrentDate, with  
    // the start date - before beginning the loop  
    $sCurrentDate = $sStartDate;  

    // While the current date is less than the end date  
    while($sCurrentDate < $sEndDate){  
        // Add a day to the current date  
        $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  

        // Add this new day to the aDays array  
        $aDays[] = $sCurrentDate;  
    }  

    // Once the loop has finished, return the  
    // array of days.  
    return $aDays;  
}  


function get_event_date_range($start,$end,$fullMonth=false) {
    $event_date = '';
    $date_range = array($start,$end);
    if($date_range && array_filter($date_range) ) {
        $dates = array_filter( array_unique($date_range) );
        $count = count($dates);
        if($count>1) {
            $s_day =  date('d',strtotime($start));
            $e_day =  date('d',strtotime($end));
            
            /* If the same year */
            if( date("Y",strtotime($start)) == date("Y",strtotime($end)) ) {
                $year = date('Y',strtotime($start));

                if( date("m",strtotime($start)) == date("m",strtotime($end)) ) {
                    if($fullMonth) {
                        $month = date('F',strtotime($start));
                    } else {
                        $month = date('M',strtotime($start));
                    }
                    $event_date = $month . ' ' . $s_day . '-' . $e_day . ', ' . $year;
                }
                if( date("m",strtotime($start)) != date("m",strtotime($end)) ) {
                    $event_date_start = date('M',strtotime($start)) . ' ' . $s_day;
                    $event_date_end = date('M',strtotime($end)) . ' ' . $e_day;
                    $event_date = $event_date_start . ' - ' . $event_date_end . ', ' . $year;
                }

            } else {

                $year_start = date('Y',strtotime($start));
                $year_end = date('Y',strtotime($end));
                $event_date_start = date('M',strtotime($start)) . ' ' . $s_day . ', ' . $year_start;
                $event_date_end = date('M',strtotime($end)) . ' ' . $e_day . ', ' . $year_end;
                $event_date = $event_date_start . ' - ' . $event_date_end;

            }

        } else {

            if($start) {
                if($fullMonth) {
                    $event_date = date('F d, Y', strtotime($start));
                } else {
                    $event_date = date('M d, Y', strtotime($start));
                }
                
            }
            
        } 

    }
    return $event_date;
}

add_action('admin_head', 'my_custom_admin_css');
function my_custom_admin_css() { ?>
<style type="text/css">
div.acf-field[data-name="is_event_completed"] h2.hndle,
div.acf-field[data-name="is_event_completed"] div.acf-label,
div.acf-field[data-name="is_event_completed"] div.acf-input,
body.post-type-acf-field-group #expirationdatediv.postbox  {
    display: none!important;
}
div.acf-field-repeater[data-name="today"] table tr.acf-row td {
    border-bottom: 6px solid #d6d6d6;
}
#acf-group_5f1912cfb5ecf .parent-menu-text {
    display: inline-block;
    font-weight: bold;
    margin-left: 5px;
}
#acf-group_5f1912cfb5ecf [data-layout="child_menu_data"] .parent-menu-text {
    display: none;
}
.acf-flexible-content div[data-layout="race_type"] {
    margin-top: 10px!important;
}
div[data-layout="race_type"] > .acf-fc-layout-handle,
#acf-group_5f1912cfb5ecf [data-layout="menu_group"] > .acf-fc-layout-handle {
    color: transparent;
    background: #f1f2f3;
}
div[data-layout="race_type"] > .acf-fc-layout-handle {
    color: transparent!important;
}
div[data-layout="race_type"] > .acf-fc-layout-handle .acf-fc-layout-order {
    color: #000!important;
    background: #FFF!important;
}
div[data-layout="race_type"]:before,
#acf-group_5f1912cfb5ecf [data-layout="menu_group"]:before {
    content:attr(data-parenttext);
    display: block;
    position: absolute;
    top: 9px;
    left: 42px;
    font-size: 14px;
    font-weight: bold;
    z-index: 15;
}
#acf-group_5f1912cfb5ecf [data-layout="child_menu_data"]:before {
    content: attr(data-parenttext);
    display: block;
    position: absolute;
    top: 11px;
    left: 117px;
    font-size: 11px;
    font-weight: bold;
    z-index: 15;
    color: #61a963;
}
#acf-group_5f1912cfb5ecf .acf-flexible-content .layout {
    margin-top: 10px;
}
div.acf-field #expirationdatediv .inside td {
    padding: 2px 5px;
    vertical-align: top;
}
#acf-group_5f460b222fe52 div.acf-fc-layout-handle {
    font-size: 0px;
    color: transparent;
    position: relative;
}
#acf-group_5f460b222fe52 div.acf-fc-layout-handle .customTabName {
    font-size: 15px;
    color: #444!important;
    position: absolute;
    left: 40px;
    top: 17px;
    z-index: 5;
}
body.wp-admin.post-type-activity_schedule #poststuff #titlewrap {
    position: relative;
}
body.wp-admin.post-type-activity_schedule #poststuff #titlewrap input:focus {
    outline: 0;
    box-shadow: none;
}
body.wp-admin.post-type-activity_schedule #poststuff #titlewrap {
    display: none;
}
#poststuff #titlewrap span.cover {
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0;
    left: 0;
    z-index: 20;
    background: #f1f1f1;
    opacity: 0.7;
}
<?php 
$has_expiration_post_types = array('festival','music'); 
foreach($has_expiration_post_types as $pt) { ?>
    body.post-type-<?php echo $pt?> div.acf-field[data-name="is_event_completed"] h2.hndle,
    body.post-type-<?php echo $pt?> div.acf-field[data-name="is_event_completed"] .acf-input,
    body.post-type-<?php echo $pt?> div.acf-field[data-name="is_event_completed"] .acf-label label {
        display: none;
    }
<?php } ?>

</style>
<?php }


/*===== START ADMIN CUSTOM SCRIPTS ======*/
add_action('admin_footer', 'my_custom_admin_js');
function my_custom_admin_js() { ?>
<script type="text/javascript">
jQuery(document).ready(function($){

    /* ACF Flexible Content for Menu Options */
    if( $("#acf-group_5f1912cfb5ecf").length > 0 ) {
        $('[data-layout="menu_group"]').each(function(){
            var parent = $(this).find('[data-name="parent_menu_name"] .acf-input-wrap input').val();
            var parentMenu = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '(Blank)';
            var parentMenu_child = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '';
            $(this).attr("data-parenttext",parentMenu);
            $(this).find('[data-layout="child_menu_data"]').attr("data-parenttext","- "+parentMenu_child);
        });
    }

    if( $('[data-layout="race_type').length > 0 ) {
        $('[data-layout="race_type').each(function(e){
            var tab = $(this).find('[data-name="name"] .acf-input-wrap input').val();
            var tabName = ( tab.replace(/\s+/g,'').trim() ) ? tab.replace(/\s+/g,' ').trim() : '(Untitle)';
            $(this).attr("data-parenttext",tabName);
        });
    }


    if( ($('body.post-php div.acf-field[data-name="is_event_completed"]').length > 0) && ($("#expirationdatediv").length > 0) ) {
        $("#expirationdatediv").appendTo('div.acf-field[data-name="is_event_completed"]');
        //var acfLabel = $('body.post-php div.acf-field[data-name="is_event_completed"] .acf-label label').text();
        var acfLabel = 'Enable post expiration if event is completed';
        $('div.acf-field #expirationdatediv label[for="enable-expirationdate"]').html('<strong>'+acfLabel+'</strong>');
    }

    if( $("#acf-group_5f460b222fe52").length > 0 ) {
        $('[data-layout="activity"]').each(function(){
            var parent = $(this).find('[data-name="type"] .acf-input-wrap input').val();
            var tabTitle = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '(Untitled)';
            //var parentMenu_child = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '';
            //$(this).find(".acf-fc-layout-handle").attr("data-parenttext",parentMenu);
            $(this).find(".acf-fc-layout-handle").append('<span class="customTabName">'+tabTitle+'</span>');
        });
        $(document).on("keyup",'[data-layout="activity"] [data-name="type"] .acf-input-wrap input',function(){
            var str = $(this).val().replace(/\s+/g,' ').trim();
            var parent = $(this).parents('[data-layout="activity"]');
            parent.find(".customTabName").text(str);
        });
    }


    if( $("body.wp-admin.post-type-activity_schedule").length > 0 ) {
        //$('[data-name="eventDateSchedule"] input.hasDatepicker').focus();
        $("#titlewrap").append('<span class="cover"></span>');
        $("#titlewrap input").blur();
        $('[data-name="eventDateSchedule"]').focus();
        // $(document).on("keyup change blur",'[data-name="eventDateSchedule"] input.hasDatepicker',function(){
        //     var defaultVal = $("#titlewrap input").val();
        //     var str = $(this).val().replace(/\s+/g,' ').trim();
        //     $("#titlewrap input").val(str).addClass("focus-visible");
        //     $("#title-prompt-text").addClass("screen-reader-text");
        //     if(defaultVal) {
        //         $(".button.edit-slug").trigger("click");
        //         $("#new-post-slug").val("");
        //         $(".button.save").trigger("click");
        //     }
        // });
    }


});
</script>
<?php
}
/*===== END ADMIN CUSTOM SCRIPTS ======*/

/* ACF CUSTOM OPTIONS TABS */
function be_acf_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) ) return;
    
    $acf_option_tabs = array(
        array( 
            'title'      => 'Today Options',
            'capability' => 'manage_options',
        ),
        array( 
            'title'      => 'Menu Options',
            'capability' => 'manage_options',
        )
    );

    foreach($acf_option_tabs as $options) {
        acf_add_options_page($options);
    }

    // acf_add_options_page( 
    //     array( 
    //         'title'      => 'Menu Options',
    //         'capability' => 'manage_options',
    //     )
    // );
    // acf_add_options_page( 
    //     array( 
    //         'title'      => 'Today Options',
    //         'capability' => 'manage_options',
    //     )
    // );
}
add_action( 'init', 'be_acf_options_page' );

function get_vimeo_data($vimeoId) {
    if (empty($vimeoId)) return '';
    $obj = @unserialize(file_get_contents("https://vimeo.com/api/v2/video/".$vimeoId.".php"));
    return ($obj) ? $obj[0] : '';
    //$json_url = 'http://vimeo.com/api/v2/video/'.$vimeoId.'.json?callback=showThumb';
    // $json_data = @file_get_contents($json_url);
    // if($json_data) {
    //     $json_parts = str_replace("/**/showThumb(","",$json_data);
    //     $json_parts = str_replace("}])","}]",$json_parts);
    //     $data = json_decode($json_parts);
    //     return ($data) ? $data[0] : '';
    // }
}

/* Options page under Activity custom post type */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_sub_page(array(
//         'page_title'     => 'Activity Global Options',
//         'menu_title'    => 'Activity Global Options',
//         'parent_slug'    => 'edit.php?post_type=activity',
//     ));
// }


function get_pass_type_category($term_id) {
    $taxonomy = 'pass_type';
    $args = array(
        'posts_per_page'=> -1,
        'post_type'     => 'pass',
        'post_status'   => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => $term_id
            )
        )
        
    );
    $posts = get_posts($args);
    return ($posts) ? $posts : '';
}


function get_faqs_by_single_post($post_id) {
    global $wpdb;
    $faq_posts = array();
    $faq_post_types = array();

    $post_type = get_post_type($post_id);

    $query = "SELECT p.ID, m.meta_value as content_type FROM {$wpdb->posts} p, {$wpdb->postmeta} m
              WHERE m.post_id=p.ID AND p.post_type='faqs' AND p.post_status='publish' AND m.meta_key='content'";
    $result = $wpdb->get_results($query);
    if($result) {
        foreach($result as $row) {
            $faq_post_id = $row->ID;
            $type = $row->content_type; /* single or multiple */
            if($type) {
                $metaKey = $type . '_type'; /* This may result `single_type` or `multiple_type` */ 
                $meta = get_content_type_data($faq_post_id,$metaKey);
                if($type=='single') {
                    
                    if($meta) {
                        if( $metaPostIds = $meta->meta_value ) {
                            if( in_array($post_id, $metaPostIds) ) {
                                $faq_posts[] = $faq_post_id;
                            }
                        }
                    }
                } elseif($type=='multiple') {
                    /* get post type assigned */
                    if($post_type) {
                        if( $assigned_posttypes = $meta->meta_value ) {
                            if( in_array($post_type, $assigned_posttypes) ) {
                                $faq_posts[] = $faq_post_id;
                            }
                        }
                    }
                }
            }
        }
    }

    return $faq_posts;
}


function get_content_type_data($post_id,$metaKey) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->postmeta} m 
              WHERE m.post_id=".$post_id." AND m.meta_key='".$metaKey."'";
    $result = $wpdb->get_row($query);
    if($result) {
        $metaVal = ($result->meta_value) ? @unserialize($result->meta_value) : '';
        $result->meta_value = $metaVal;
    }
    return ($result) ? $result : '';
}

function get_faqs_by_assigned_page_id($postIds) {
    $faqs = array();
    if( empty($postIds) ) return '';
    foreach($postIds as $id) {
        $parent = get_the_title($id);
        $children = get_field("faqs",$id);
        if($children) {
            $item['ID'] = $id;
            $item['title'] = $parent;
            $item['faqs'] = $children;
            $faqs[] = $item;
        }
    }

    return $faqs;
}


function get_faq_listings($post_id) {
    $faqs = '';
    if( $faqsIds = get_faqs_by_single_post($post_id) ) {
        $faqs = get_faqs_by_assigned_page_id($faqsIds);
    }
    return $faqs;
}

function get_page_id_by_permalink($url) {
    global $wpdb;
    $siteURL = get_site_url();
    if( empty($url) ) return '';

    /* Check if internal or external link */
    $parse = parse_external_url($url);
    $basename = basename($url);
    if( $parse['class']=='internal-link' ) {
        $query = "SELECT p.ID, p.post_type FROM {$wpdb->posts} p 
                  WHERE p.post_name='".$basename."'";
        $result = $wpdb->get_row($query);
        return ($result) ? $result : '';
    } else {
        return '';
    }
}

function get_categories_by_page_id($post_id,$taxonomy,$related=null) {
    global $wpdb;
    $related_posts = array();
    $related_terms = ( isset($related['terms']) && $related['terms'] ) ? $related['terms'] : '';
    $related_taxonomy = ( isset($related['taxonomy']) && $related['taxonomy'] ) ? $related['taxonomy'] : '';
    
    $related_post_type = ( isset($related['post_type']) && $related['post_type'] ) ? $related['post_type'] : '';

    $query = "SELECT rel.object_id as post_id, tax.term_id, terms.name, terms.slug, tax.taxonomy FROM {$wpdb->terms} terms, {$wpdb->term_taxonomy} tax, {$wpdb->term_relationships} rel
              WHERE rel.term_taxonomy_id=tax.term_taxonomy_id AND tax.term_id=terms.term_id AND tax.taxonomy='".$taxonomy."' AND rel.object_id=".$post_id;

    $result = $wpdb->get_results($query);
    if($result) {
      foreach($result as $row) {
        $term_id = $row->term_id;
        $query2 = "SELECT p.*, terms.term_id, terms.name, terms.slug, tax.taxonomy FROM {$wpdb->posts} p, {$wpdb->terms} terms, {$wpdb->term_taxonomy} tax, {$wpdb->term_relationships} rel
                  WHERE p.ID=rel.object_id AND p.post_type='".$related_post_type."' AND p.post_status='publish' 
                  AND rel.term_taxonomy_id=tax.term_taxonomy_id AND tax.term_id=".$term_id." AND terms.term_id=tax.term_id GROUP BY p.ID ORDER BY p.post_date DESC";
        $related = $wpdb->get_results($query2);

        $limit = 2;
        if($related) {
          $i=1; foreach($related as $rel) {
            $post_terms = get_the_terms($rel,$related_taxonomy);
            if($post_terms) {
              foreach($post_terms as $p) {
                $p_term_slug = $p->slug;
                
                if( $related_terms && in_array($p_term_slug,$related_terms) ) {

                  $related_term_id = $p->related_terms;
                  
                  if($i<=$limit) {
                    $rel->related_terms = $p;
                    $related_posts[] = $rel; 
                  }

                  $i++;
                }

              }
            }
          }
        }

      }
    }

    return $related_posts;
}


function get_current_activity_schedule($postype) {
    global $wpdb;
    $dateNow = date('Y-m-d');
    ///$today = date('l, F jS, Y');
    //$today_slug = sanitize_title($today);
    $today_slug = sanitize_title($dateNow);
    $query = "SELECT * FROM {$wpdb->posts} p WHERE p.post_type='".$postype."' AND p.post_status='publish' AND p.post_name='".$today_slug."'";
    $result = $wpdb->get_row($query);
    return ($result) ? $result : '';
}

function update_post_status_if_expired() {
   global $wpdb;
   $dateNow = date('Y-m-d');
   $dateNowStr = strtotime( date('Ymd') );
   $query = "SELECT p.ID,p.post_title,p.post_type, date_format(str_to_date(m.meta_value, '%Y%m%d'),'%Y-%m-%d') AS start_date
           FROM {$wpdb->posts} p,{$wpdb->postmeta} m
           WHERE p.ID=m.post_id AND p.post_status='publish' 
           AND m.meta_key='start_date' AND (m.meta_value IS NOT NULL OR m.meta_value <> '') ORDER BY start_date ASC";
   $result = $wpdb->get_results($query); 
   $last_updated = get_last_post_status_updated();

   $exception = array('completed','canceled');
   $is_updated = array();

   if( empty($last_updated) || $last_updated!=$dateNow ) {

      if($result) {
         foreach($result as $row) {
            $post_id = $row->ID;
            $start_date = $row->start_date;
            $end_date = get_field("end_date",$post_id);
            $status = get_field('eventstatus',$post_id);
            $based_date = ($start_date) ? strtotime($start_date) : '';
            if($end_date) {
               $based_date = strtotime($end_date);
            }
            $row->eventstatus = $status;
            if($based_date) {
               if( !in_array($status,$exception) ) {
                  if($start<$dateNowStr) {
                     $updated = update_post_meta($post_id,'eventstatus','completed');
                     if($updated) {
                        $is_updated[] = $post_id;
                     }
                  }
               }
            }
         }
      }

   }   
   

   if($is_updated) {
      update_option('last_post_status_updated', $dateNow);
   }

   return $is_updated;
}

function get_last_post_status_updated() {
    global $wpdb;
    $query = "SELECT opt.option_value FROM {$wpdb->options} opt WHERE opt.option_name='last_post_status_updated'";
    $result = $wpdb->get_row($query); 
    $output = '';
    if($result) {
        $output = $result->option_value;
    } else {
        add_option('last_post_status_updated', NULL);
    }
    return $output;
}


function custom_query_posts($posttype,$perpage,$offset,$order='ASC') {
   global $wpdb;
   $dateToday = date('Y-m-d');
   $dateNow = strtotime($dateToday);

   /* Fist option */
   // $query = "SELECT p.*,date_format(str_to_date(m.meta_value, '%Y%m%d'),'%Y-%m-%d') AS start_date
   //         FROM {$wpdb->posts} p,{$wpdb->postmeta} m
   //         WHERE p.ID=m.post_id AND p.post_type='".$posttype."' AND p.post_status='publish'
   //         AND m.meta_key='start_date' AND (m.meta_value IS NOT NULL OR m.meta_value <> '') 
   //         AND DATE(m.meta_value) >= CURDATE()";


   $query1 = "SELECT p.*, m.meta_value AS eventstatus
          FROM {$wpdb->posts} p,{$wpdb->postmeta} m
          WHERE p.ID=m.post_id AND p.post_type='".$posttype."' AND p.post_status='publish'
          AND m.meta_key='eventstatus' AND m.meta_value='active'";

   $query2 = "SELECT p.*, m.meta_value AS eventstatus
          FROM {$wpdb->posts} p,{$wpdb->postmeta} m
          WHERE p.ID=m.post_id AND p.post_type='".$posttype."' AND p.post_status='publish'
          AND m.meta_key='eventstatus' AND m.meta_value<>'active'";


   $a_query = "SELECT q1.*,date_format(str_to_date(mm.meta_value, '%Y%m%d'),'%Y-%m-%d') AS start_date 
            FROM (".$query1.") q1, {$wpdb->postmeta} mm
            WHERE q1.ID=mm.post_id AND mm.meta_key='start_date' ORDER BY start_date {$order}";

   $b_query = "SELECT q2.*,date_format(str_to_date(mc.meta_value, '%Y%m%d'),'%Y-%m-%d') AS c_start_date 
            FROM (".$query2.") q2, {$wpdb->postmeta} mc
            WHERE q2.ID=mc.post_id AND mc.meta_key='start_date' ORDER BY c_start_date {$order}";


   $result1 = $wpdb->get_results($a_query);
   $result2 = $wpdb->get_results($b_query);
   $final = ($result1||$result2) ? array_merge($result1,$result2) : '';
   $total = ($final) ? count($final) : 0;
   $records = array();

   if($final) {
      $offset = $offset-1;
      if($offset<=0) {
         $offset = 0;
      }

      $start = $offset;
      $end = $perpage;
      if($offset>0) {
         $start = (($offset+1) * $perpage) - $perpage;
         $end = ($offset+1) * $perpage;
      }
      
      for($i=$start; $i<$end; $i++) {
         if( isset($final[$i]) ) {
            $data = $final[$i];
            $records[] = $data;
         }
      }
   }

   $output['total'] = $total;
   $output['records'] = $records;
   return $output;
}


function get_template_by_id($post_id,$template=null) {
    global $wpdb;
    if($template) {
        $result = $wpdb->get_row( "SELECT p.ID FROM {$wpdb->posts} p, {$wpdb->postmeta} m WHERE p.ID=m.post_id AND m.post_id=".$post_id." AND m.meta_key='_wp_page_template' AND m.meta_value='".$template."'" );
    } else {
        $result = $wpdb->get_row( "SELECT ID FROM $wpdb->posts WHERE ID=".$post_id );
    }
    
    return ($result) ? $result->ID : '';
}


/* Hide Default WP Richtext Editor */
add_action( 'load-page.php', 'hide_tinyeditor_wp' );
function hide_tinyeditor_wp() {
    if( !isset( $_GET['post'] ) )
        return;
    $pages = array();
    $post_id = $_GET['post'];
    $templates = array('page-food-beverage');
    if($templates) {
        foreach($templates as $filename) {
            $filename .= ".php";
            $id = get_template_by_id($post_id,$filename);
            if($id) {
                $pages[] = $id;
            }
        }
    }
    if( $pages && in_array($_GET['post'], $pages) ) {
        remove_post_type_support('page', 'editor');
    }
}


add_action('acf/save_post', 'my_custom_acf_save_post');
function my_custom_acf_save_post( $post_id ) {
    $post_type = get_post_type($post_id);
    if($post_type=='activity_schedule') {
        /* Update slug when event date is changed */
        $event_date = get_field("eventDateSchedule");
        if($event_date) {
            $post_title = date('l, F jS, Y',strtotime($event_date));
            $post_slug = sanitize_title($event_date);
            $my_post = array(
                'ID'            =>  $post_id,
                'post_title'    => $post_title,
                'post_name'     => $post_slug
            );
            wp_update_post( $my_post );
        }
    }
    // // Get newly saved values.
    // $values = get_fields( $post_id );

    // // Check the new value of a specific field.
    // $hero_image = get_field('hero_image', $post_id);
    // if( $hero_image ) {
    //     // Do something...
    // }
}




