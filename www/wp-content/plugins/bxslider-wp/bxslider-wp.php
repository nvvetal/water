<?php
/*
Plugin Name: BxSlider WP
Plugin URI: http://www.codefleet.net/bxslider-wp/
Description: Provides an easy to use interface for BxSlider that blends seamlessly with your WordPress workflow.
Version: 1.4.1
Author: Nico Amarilla
Author URI: http://www.codefleet.net/
License:

  Copyright 2013 (kosinix@codefleet.net)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

// Hook the plugin
add_action('plugins_loaded', 'bxslider_plugin_init');
function bxslider_plugin_init() {
    
    $version = '1.4.1'; // Must match the version in the header of the plugin file
    $path = realpath(plugin_dir_path(__FILE__)) . DIRECTORY_SEPARATOR ; // Path to plugin folder with trailing dir sep
    $url = plugin_dir_url(__FILE__); // URL to plugin folder
    $textdomain = 'bxslider'; // Language textdomain
    $debug = true; // Debug mode
    $view_folder = $path.'views'.DIRECTORY_SEPARATOR;
    
    // Include common classes
    if( !class_exists('Codefleet_Common_View') ){
        require_once($path.'vendor/Codefleet_Common_View.php');
    }
    
    // Include this plugin's classes
    if( !class_exists('Codefleet_BxSlider_Admin') ){
        require_once($path.'vendor/Codefleet_BxSlider_Admin.php');
    }
    if( !class_exists('Codefleet_BxSlider_Data') ){
        require_once($path.'vendor/Codefleet_BxSlider_Data.php');
    }
    if( !class_exists('Codefleet_BxSlider_Main') ){
        require_once($path.'vendor/Codefleet_BxSlider_Main.php');
    }

    // Load language files
    load_plugin_textdomain( $textdomain, false, basename(dirname(__FILE__)).'/lang' );
    
    $codefleet_common_view = new Codefleet_Common_View();
    $codefleet_bxslider_data = new Codefleet_BxSlider_Data();
    
    $codefleet_bxslider_main = Codefleet_BxSlider_Main::get_instance();
    $codefleet_bxslider_main->init($version, $path, $url, $debug, $textdomain, $codefleet_common_view, $codefleet_bxslider_data);
    
    $codefleet_bxslider_admin = Codefleet_BxSlider_Admin::get_instance();
    $codefleet_bxslider_admin->init($version, $path, $url, $debug, $textdomain, $codefleet_common_view, $view_folder, $codefleet_bxslider_data);
    
    // Prevent conflicts in global space
    if(!function_exists('bxslider_options')) {
        /**
         * Function that adds data attributes to the slider to be used by the initialization script
         *
         * @param int $slider_id - Slider custom post ID
         */
        function bxslider_options($slider_id){
            
            $codefleet_bxslider_data = new Codefleet_BxSlider_Data();
            
            $options = $codefleet_bxslider_data->get_options( $slider_id );
            $out = ' ';
            foreach($options as $name=>$option){
                $out .= 'data-bxslider-'.str_replace('_', '-', $name).'="'.$option.'"';
            }
            $out.=' ';
            echo $out;
        }
    }
    
    if(!function_exists('bxslider')) {
        /**
        * BxSlider
        *
        * Displays the slider on template files.
        *
        * @param string $slider_slug The slug of the slider.
        */
        function bxslider( $slider_slug ){
            $codefleet_bxslider_data = new Codefleet_BxSlider_Data();
            $slider_view = new Codefleet_Common_View(realpath(plugin_dir_path(__FILE__)). DIRECTORY_SEPARATOR .'views'. DIRECTORY_SEPARATOR . 'slider.php');
            if(isset($codefleet_bxslider_data)){
                echo $codefleet_bxslider_data->get_slider_render($slider_slug, $slider_view);
            }
        }
    }
}