<?php
/**
 * Plugin Name: Quatriceps
 * Plugin URI: http://wp.tetragy.com/quatriceps
 * Description: Mathematics problem generator
 * Version: 1.1.3
 * Author: pmagunia
 * Author URI: https://tetragy.com
 * License: GPLv2 or Later
 */

/*  Copyright 2014  Tetragy Limited

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

# settings menu link
add_action('admin_menu', 'quatriceps_admin_add_page');
function quatriceps_admin_add_page() {
  add_options_page('Settings', 'Quatriceps', 'manage_options', 'Quatriceps', 'quatriceps_plugin_settings_page');
}

# plugin page settings link
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'quatriceps_plugin_settings_link' );
function quatriceps_plugin_settings_link($links) { 
  $settings_link = '<a href="options-general.php?page=Quatriceps">Settings</a>'; 
  array_unshift($links, $settings_link); 
  return $links; 
}

function quatriceps_plugin_settings_page()
{ ?>
  <div class="wrap">
    <div class="wp-quatriceps-admin">
      <h2>Quatriceps Settings</h2>
      <?php
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        echo (!is_plugin_active('simple-mathjax/simple-mathjax.php') ? '<h3 style="color:red;">Required Wordpress plugin Simple-MathJax not found.</h3>' : '');
      ?>
      <p>Settings related to the Quatriceps plugin can be modified here and will have a global effect on all Quatriceps shortcode.</p>
      <div>
        <form action="options.php" method="post">
          <?php settings_fields('quatriceps_plugin_settings'); ?>
          <?php do_settings_sections('quatriceps'); ?>
          <br/>
          <div class-"wp-quatriceps-submit">
          <input name="Submit" type="submit" value="<?php esc_attr_e('Save'); ?>" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <?php }

add_action('admin_init', 'quatriceps_plugin_admin_init');

function quatriceps_plugin_admin_init() {
  register_setting( 'quatriceps_plugin_settings', 'quatriceps_router', 'quatriceps_settings_router_validate');
  add_settings_section('quatriceps_options', 'Quatriceps', 'quatriceps_section_text', 'quatriceps');
  add_settings_section('quatriceps_helper_options', 'Quickstart', 'quatriceps_helper_text', 'quatriceps');
  add_settings_field('quatriceps_router', 'Quatriceps Router', 'quatriceps_setting_router', 'quatriceps', 'quatriceps_options');
}

function quatriceps_section_text() {
  echo '<p>Visit https://github.com/pmagunia/tserver to create your own Maxima backend server with custom operations.</p>';
}

function quatriceps_helper_text() {
  echo '<p>Once configured, use WordPress Shortcode syntax when editing a post to add Quatriceps widgets: <strong>[quatriceps com="addition"]</strong>.</p><p>Visit Tetragy\'s <a href="https://math.tetragy.com/quatriceps/doc">Quatriceps documentation</a> for a complete list of commands available.</p>';
}

function quatriceps_setting_router() {
  $router = get_option('quatriceps_router', 'https://route.tetragy.com');
  echo "<input id='quatriceps_router' name='quatriceps_router' size='30' type='text' value='$router' />";
}

function quatriceps_settings_router_validate($router) {
  if(strlen($router) > 255) {
    $router = 'https://route.tetragy.com';
  }
  return $router;
}

# Print form with Shortcode API
function quatriceps_func( $atts ) {
  extract( shortcode_atts( array(
    'com' => 'prime',
  ), $atts ) );

	$dialog = '<div class="quatriceps-dialog"><div class="quatriceps-waiting-container"><div class="quatriceps-waiting">Computing...</div></div><div class="quatriceps-output-container"><div class="quatriceps-output"></div></div></div>';

  # if users wants to override packaged file
  if(is_file(__DIR__ . '/html/override/' . $com . '.html')) {
    $markup = file_get_contents(__DIR__ . '/html/override/' . $com . '.html');
  } else {
     $markup = file_get_contents(__DIR__ . '/html/' . $com . '.html');
  }
  $markup = '<div class="quatriceps-cp">' . $markup . '</div>';
  return '<div class="quatriceps" id="quatriceps-' . $com .'">' . $markup . $dialog . $recap . '</div>';
}

add_shortcode('quatriceps', 'quatriceps_func');

add_action('init', 'quatriceps_script_enqueuer');

function quatriceps_script_enqueuer() {
  # check if admin wants to override default CSS and JS files
  $override_css = $override_js = '/html/override';
  $override_css_path = plugin_dir_path( __FILE__ ) . '/html/override/caascade.css';
  $override_js_path = plugin_dir_path( __FILE__ ) . '/html/override/caascade.js';
  if(!is_file($override_css_path))
  {
    $override_css = '';
  }
  if(!is_file($override_js_path))
  {
     $override_js = '';
  }
  wp_register_script("quatriceps_script", WP_PLUGIN_URL . '/quatriceps' . $override_js . '/quatriceps.js', array('jquery'), '1.1.3', true);
  wp_register_style("quatriceps_css", WP_PLUGIN_URL . '/quatriceps' . $override_css . '/quatriceps.css', array(), '1.1.3', 'all');
  wp_localize_script('quatriceps_script', 'quatricepsAjax', array('ajaxurl' => admin_url('admin-ajax.php')));        

  wp_enqueue_script('mathjax_script');
  wp_enqueue_script('quatriceps_script');
  wp_enqueue_style('quatriceps_css');
}

add_action("wp_ajax_quatriceps_compute", "prefix_ajax_quatriceps_compute");
add_action("wp_ajax_nopriv_quatriceps_compute", "prefix_ajax_quatriceps_compute");

function prefix_ajax_quatriceps_compute() {

  $fields['cmd'] = $_REQUEST['cmd'];
  $fields['pdf'] = urlencode($_REQUEST['pdf']);
  $fields['arg0'] = urlencode($_REQUEST['arg0']);
  $fields['arg1'] = urlencode($_REQUEST['arg1']);
  $fields['arg2'] = urlencode($_REQUEST['arg2']);
  $fields['arg3'] = urlencode($_REQUEST['arg3']);
  $fields_string = '';
  foreach($fields as $key => $value)
  {
    $fields_string .= $key . '=' . $value . '&';
  }
  $fields_string = rtrim($fields_string, '&');
  echo $_REQUEST['callback'] . '(' . file_get_contents(get_option('quatriceps_router', 'https://route.tetragy.com') . '/index.php?' . $fields_string) . ')';
  die();
}

