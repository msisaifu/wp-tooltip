<?php

/*
 * Plugin Name: Wp Tooltip
 * Version: 1.0.0
 * Plugin URI:
 * Description:  this is minimum structure for a new plugin development, just copy this plugin and change your self and add more thing as yu need.
 * Author: Nurul Amin
 * Author URI: http://nurulamin.me
 * Requires at least: 4.0
 * Tested up to:
 * License: GPL2
 * Text Domain: yourtextdomain [find this text and replace with your text]
 * Domain Path: /lang/
 *
 */


if (!function_exists('add_action')){
    echo "Something wrong";
    exit();
}

class WpTooltip{
    public $version             = '1.0.0';
    public $text_domain         = 'yourtextdomain';  // Must chnage this text

    public function __construct()
    {
        add_action('init',array($this,'wp_register_post_type'));
        add_action('wp_enqueue_scripts',array($this,'enqueue'));
        add_shortcode( 'wp-tooltip', array( $this, 'tooltip'));
    }


    public function activate(){
       $this->wp_register_post_type();

       flush_rewrite_rules();
    }

    public function deactivate(){
        flush_rewrite_rules();
    }
    public function uninstall(){

    }
    function wp_register_post_type() {
        $name = "Wp Tooltip" ;  //Change as your NEED
        $labels        = array(
            'name'               => __( $name , 'post type general name', $this->text_domain ),
            'singular_name'      => __( $name, 'post type singular name', $this->text_domain ),
            'add_new'            => __( 'Add New', $name, $this->text_domain ),
            'add_new_item'       => __( 'Add New '.$name, $this->text_domain ),
            'edit_item'          => __( 'Edit '.$name, $this->text_domain ),
            'new_item'           => __( 'New ' .$name, $this->text_domain ),
            'view_item'          => __( 'View '. $name, $this->text_domain ),
            'search_items'       => __( 'Search ' .$name, $this->text_domain ),
            'not_found'          => __( 'Nothing found', $this->text_domain ),
            'not_found_in_trash' => __( 'Nothing found in Trash', $this->text_domain ),
            'parent_item_colon'  => __( $name, $this->text_domain ),
        );
        $post_type_agr = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'capability_type' => 'post',
            'menu_position' => false,
            'show_in_menu'  => true,
            'supports'      => array( 'title', 'editor', 'thumbnail' ),
            'hierarchical'  => false,
            'rewrite'       => false,
            'query_var'     => false,
            'show_in_nav_menus' => false,
        );
        register_post_type( 'wp_tooltip', $post_type_agr );
    }
    function enqueue(){
//        wp_enqueue_style( 'bootstrap_css', 'http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
        wp_enqueue_style( 'bootstrap_css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' );
        wp_deregister_script( 'jquery' );
        wp_enqueue_script( 'jquery' ,'https://code.jquery.com/jquery-3.2.1.slim.min.js');

        wp_enqueue_script('jquery-p-js',"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js");
        wp_enqueue_script('jquery_ui',"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js");

//        wp_enqueue_script('jquery',"https://code.jquery.com/jquery-1.12.4.js");
//        wp_enqueue_script('jquery_ui',"https://code.jquery.com/ui/1.12.1/jquery-ui.js",'','',false);
        add_action('wp_footer', array($this,'tootipScript'));
    }
    function tootipScript(){
       echo "
            <script>
                  $(function () {
                     $('[data-toggle=\"tooltip\"]').tooltip({
//                     animation:true,
//                     delay: { 'show': 500, 'hide': 100 },
                     placement:'left',
                     track: true
//                      position: { my: 'left+15', at: 'right' }
                     })
                  })
            </script>
       ";
    }
    function tooltip($atts){
        $a = shortcode_atts( array(
            'content' => '',
            'key' => '',
        ), $atts );
        extract($a);
        $data="<span data-toggle='tooltip' title='$content'> $key </span>";
        return $data;
    }
}

if (class_exists('WpTooltip')){
    $wpTooltip=new WpTooltip();
}

//activat
register_activation_hook(__FILE__,array($wpTooltip,'activate'));

//deactivat
register_deactivation_hook(__FILE__,array($wpTooltip,'deactivate'));