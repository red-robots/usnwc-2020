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

function extract_emails_from($string){
  preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
  return $matches[0];
}

function email_obfuscator($string) {
    $output = '';
    if($string) {
        $emails_matched = ($string) ? extract_emails_from($string) : '';
        if($emails_matched) {
            foreach($emails_matched as $em) {
                $encrypted = antispambot($em,1);
                $replace = 'mailto:'.$em;
                $new_mailto = 'mailto:'.$encrypted;
                $string = str_replace($replace, $new_mailto, $string);
                $rep2 = $em.'</a>';
                $new2 = antispambot($em).'</a>';
                $string = str_replace($rep2, $new2, $string);
            }
        }
        $output = apply_filters('the_content',$string);
    }
    return $output;
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


function get_event_date_range($start,$end) {
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
                    $month = date('M',strtotime($start));
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
                $event_date = date('M d, Y', strtotime($start));
            }
            
        } 

    }
    return $event_date;
}

add_action('admin_head', 'my_custom_admin_css');
function my_custom_admin_css() { ?>
<style type="text/css">
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
#acf-group_5f1912cfb5ecf [data-layout="menu_group"] > .acf-fc-layout-handle {
    color: transparent;
    background: #f1f2f3;
}
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
</style>
<?php }

add_action('admin_footer', 'my_custom_admin_js');
function my_custom_admin_js() { ?>
<script type="text/javascript">
jQuery(document).ready(function($){
    if( $("#acf-group_5f1912cfb5ecf").length > 0 ) {
        $('[data-layout="menu_group"]').each(function(){
            var parent = $(this).find('[data-name="parent_menu_name"] .acf-input-wrap input').val();
            var parentMenu = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '(Blank)';
            var parentMenu_child = ( parent.replace(/\s+/g,'').trim() ) ? parent.replace(/\s+/g,' ').trim() : '';
            $(this).attr("data-parenttext",parentMenu);
            $(this).find('[data-layout="child_menu_data"]').attr("data-parenttext","- "+parentMenu_child);
        });
    }
});
</script>
<?php
}


function be_acf_options_page() {
    if ( ! function_exists( 'acf_add_options_page' ) )
        return;

    acf_add_options_page( array( 
        'title'      => 'Menu Options',
        'capability' => 'manage_options',
    ) );
}
add_action( 'init', 'be_acf_options_page' );

function get_vimeo_data($vimeoId) {
    if (empty($vimeoId)) return '';
    $json_url = 'http://vimeo.com/api/v2/video/'.$vimeoId.'.json?callback=showThumb';
    $json_data = @file_get_contents($json_url);
    if($json_data) {
        $json_parts = str_replace("/**/showThumb(","",$json_data);
        $json_parts = str_replace("}])","}]",$json_parts);
        $data = json_decode($json_parts);
        return ($data) ? $data[0] : '';
    }
}
/*  
* Return value from get_vimeo_data($vimeoId)
*
Array
(
      [0] => stdClass Object
        (
            [id] => 207171170
            [title] => U.S. National Whitewater Center
            [description] => ""
            [url] => https://vimeo.com/207171170
            [upload_date] => 2017-03-06 14:44:40
            [thumbnail_small] => http://i.vimeocdn.com/video/624990951_100x75.jpg
            [thumbnail_medium] => http://i.vimeocdn.com/video/624990951_200x150.jpg
            [thumbnail_large] => http://i.vimeocdn.com/video/624990951_640.jpg
            [user_id] => 6206160
            [user_name] => U.S. National Whitewater Center
            [user_url] => https://vimeo.com/usnwc
            [user_portrait_small] => http://i.vimeocdn.com/portrait/33550254_30x30
            [user_portrait_medium] => http://i.vimeocdn.com/portrait/33550254_75x75
            [user_portrait_large] => http://i.vimeocdn.com/portrait/33550254_100x100
            [user_portrait_huge] => http://i.vimeocdn.com/portrait/33550254_300x300
            [stats_number_of_likes] => 4
            [stats_number_of_plays] => 123145
            [stats_number_of_comments] => 0
            [duration] => 185
            [width] => 1920
            [height] => 816
            [tags] => USNWC, U.S. National, Whitewater, Center, Raft, Kayak, Climb, Zipline, Mountain Bike, Run, Trails, Music, Beer
            [embed_privacy] => anywhere
      )

)
*/


