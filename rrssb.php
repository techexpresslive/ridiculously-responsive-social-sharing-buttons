<?php
/*
Plugin Name: Ridiculously Responsive Social Sharing Buttons
Plugin URI: https://wordpress.org/plugins/ridiculously-responsive-social-sharing-buttons/
Description: Ridiculously Responsive Social Sharing Buttons adapted from https://github.com/kni-labs/rrssb.
Version: 1.0
Author: Alan Reed
Author URI: http://www.alanreed.org
Date: 2 June 2014

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* CSS and JS */

function rrssb_js()
{
	// Use latest jqeury file.
	wp_deregister_script('jquery');
	wp_enqueue_script('jquery', 'http://code.jquery.com/jquery-latest.min.js ', array(), false, true);
	
	// Use RRSSB's jquery file.
	// wp_register_script('rrssb-jqeury', plugins_url('/js/vendor/jquery-1.9.1.min.js', __FILE__ ) );
	// wp_enqueue_script('rrssb-jqeury');
	// TODO: allow users to choose which jquery file they use. (or none - maybe their theme or or another plugin handles it.)
    
    wp_register_script('rrssb-modern-min-script', plugins_url('/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', __FILE__ ) );
    wp_enqueue_script('rrssb-modern-min-script');
	
    wp_register_script('rrssb-min-script', plugins_url('/js/rrssb.min.js', __FILE__ ) );
    wp_enqueue_script('rrssb-min-script');
}
add_action('wp_enqueue_scripts', 'rrssb_js' );

function rrssb_css()
{
    wp_register_style('norm_stylesheet', plugins_url('css/normalize.min.css', __FILE__));
    wp_enqueue_style('norm_stylesheet');
	
    wp_register_style('rrssb_stylesheet', plugins_url('css/rrssb.css', __FILE__));
    wp_enqueue_style('rrssb_stylesheet');
}
add_action('wp_enqueue_scripts', 'rrssb_css' );

/* On Activation/ Decativation */
/*
public function rrssb_activate() {
	update_option($this->option_name, $this->data);
}

public function rrssb_deactivate() {
	delete_option($this->option_name);
}

// Listen for the activate event
register_activation_hook(__FILE__, array($this, 'rrssb_activate'));

// Deactivation plugin
register_deactivation_hook(__FILE__, array($this, 'rrssb_deactivate'));
*/
/* Admin Panel */
/*
	// Name of the array
	$option_name = 'tz-todo';

	// Default values
	$data = array(
		'url_todo' => 'todo',
		'title_todo' => 'Todo List'
	);

	add_action('admin_init', array($this, 'admin_init'));
	add_action('admin_menu', array($this, 'add_page'));

    // White list our options using the Settings API
    function admin_init() {
        register_setting('todo_list_options', $this->option_name, array($this, 'validate'));
    }

    // Add entry in the settings menu
    function add_page() {
        add_options_page('RRSSB Options', 'RRSSB Options', 'manage_options', 'todo_list_options', array($this, 'options_do_page'));
    }

    // Print the menu page itself
    function options_do_page() {
        $options = get_option($option_name);
        ?>
        <div class="wrap">
            <h2>Todo List Options</h2>
            <form method="post" action="options.php">
                <?php settings_fields('todo_list_options'); ?>
                <table class="form-table">
                    <tr valign="top"><th scope="row">App URL:</th>
                        <td><input type="text" name="<?php echo $this->option_name?>[url_todo]" value="<?php echo $options['url_todo']; ?>" /></td>
                    </tr>
                    <tr valign="top"><th scope="row">Title:</th>
                        <td><input type="text" name="<?php echo $this->option_name?>[title_todo]" value="<?php echo $options['title_todo']; ?>" /></td>
                    </tr>
                </table>
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
                </p>
            </form>
        </div>
        <?php
    }

    function validate($input) {

        $valid = array();
        $valid['url_todo'] = sanitize_text_field($input['url_todo']);
        $valid['title_todo'] = sanitize_text_field($input['title_todo']);

        if (strlen($valid['url_todo']) == 0) {
            add_settings_error(
                    'todo_url', 					// setting title
                    'todourl_texterror',			// error ID
                    'Please enter a valid URL',		// error message
                    'error'							// type of message
            );
			
			# Set it to the default value
			$valid['url_todo'] = $this->data['url_todo'];
        }
        if (strlen($valid['title_todo']) == 0) {
            add_settings_error(
                    'todo_title',
                    'todotitle_texterror',
                    'Please enter a title',
                    'error'
            );
			
			$valid['title_todo'] = $this->data['title_todo'];
        }
		
        return $valid;
    }
	*/
	
/* End Admin Panel */

/* Add shortcode */

function rrssb_show_buttons_shortcode()
{
	return rrssb_show_buttons();
}
add_shortcode('rrssb', 'rrssb_show_buttons_shortcode');

/* Show content */

function rrssb_show_buttons($content = "")
/// Append buttons to $content.
{
	$content .= '
		<style>
			.no-margin li {margin: 0!important;}
		</style>
		<div class="share-container clearfix">
			<span class="label"><-- Put a label here. !--></span>
		<!-- buttons start here -->
		<ul class="rrssb-buttons clearfix no-margin">';

	/*
	 * Edit below to reorder the buttons.
	 * NOTE: Lines prefixed with `//` are ignored - Use this to add or remove buttons.
	 *
	 **/

	$content .= rrssb_email_btn();
	$content .= rrssb_facebook_btn();
	$content .= rrssb_linkedin_btn();
	$content .= rrssb_twitter_btn();
	$content .= rrssb_reddit_btn();
	$content .= rrssb_google_btn();
	$content .= rrssb_pocket_btn();
	// $content .= rrssb_github_btn();
	// $content .= rrssb_instagram_btn();
	// $content .= rrssb_pinterest_btn();
	// $content .= rrssb_tumblr_btn();
	// $content .= rrssb_youtube_btn();
	
	/*
	 * Stop editing here.
	 *
	 **/
	
	$content .= '
		</ul>
		<!-- buttons end here -->
		</div>';
    
	return $content;
}

function rrssb_show_buttons_on_single($content)
{
    if ( is_single() ) {
		$content = rrssb_show_buttons($content);
	}
	return $content;
}
add_filter('the_content', 'rrssb_show_buttons_on_single');

/* Functions for each different kind of button */

function rrssb_email_btn()
{
	$icon = file_get_contents('icons/mail.svg',true);
    $content = '<li class="email">
		<a href="mailto:?subject='.urlencode( get_the_title() ) .'&body=' .urlencode( get_permalink() ). '" class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">email</span></a></li>';
    return $content;
}
function rrssb_facebook_btn()
{
	$icon = file_get_contents('icons/facebook.svg',true);
    $content = '<li class="facebook">
		<a href="https://www.facebook.com/sharer/sharer.php?u=' .urlencode( get_permalink() ) . ' " class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">facebook</span></a></li>';
    return $content;
}
function rrssb_linkedin_btn()
{
	$icon = file_get_contents('icons/linkedin.svg',true);
    $content = '<li class="linkedin">
		<a href="http://www.linkedin.com/shareArticle?mini=true&url=' .  urlencode( get_permalink() ) . '&title=' . urlencode( get_the_title() ) . '" class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">linkedin</span></a></li>';
    return $content;
}
function rrssb_twitter_btn()
{
	$icon = file_get_contents('icons/twitter.svg',true);
	// TODO: Allow user to choose between get_permalink() and wp_get_shortlink()
    $content = '<li class="twitter">
		<a href="http://twitter.com/home?status=' . urlencode( get_the_title() )  . ' - ' . urlencode( wp_get_shortlink() ). '" class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">twitter</span></a></li>';
    return $content;
}
function rrssb_reddit_btn()
{
	$icon = file_get_contents('icons/reddit.svg',true);
    $content = '<li class="reddit">
		<a href="http://www.reddit.com/submit?url=' . urlencode( get_permalink() ) . '" class="popup">
		<span class="icon">
		' .$icon. '
		</span>
		<span class="text">reddit</span></a></li>';
    return $content;
}
function rrssb_google_btn()
{
	$icon = file_get_contents('icons/google_plus.svg',true);
    $content = '<li class="googleplus">
		<a href="https://plus.google.com/share?url=' . urlencode( get_the_title() ) . ' - ' . urlencode( get_permalink() ) .'" class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">google+</span></a></li>';
    return $content;
}
function rrssb_pocket_btn()
{
	$icon = file_get_contents('icons/pocket.svg',true);
	$content = '<li class="pocket">
		<a href="https://getpocket.com/save?url=' . urlencode( get_permalink() ) . '" class="popup">
		<span class="icon">
		' . $icon . '
		<span class="text">pocket</span></a></li>';
	return $content;
}
function rrssb_github_btn()
{
	$icon = file_get_contents('icons/github.svg',true);
    $content = '<li class="github">
		<a href="https://github.com/###" class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">github</span></a></li>';
    return $content;
}
function rrssb_instagram_btn()
{
	$icon = file_get_contents('icons/instagram.svg',true);
    $content = '<li class="instagram">
		<a href="https://instagram.com/###" class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">instagram</span></a></li>';
    return $content;
}
function rrssb_pinterest_btn()
{
	$icon = file_get_contents('icons/pinterest.svg',true);
    $content = '<li class="pinterest">
		<a href="https://pinterest.com/###" class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">pinterest</span></a></li>';
    return $content;
}
function rrssb_tumblr_btn()
{
	$icon = file_get_contents('icons/tumblr.svg',true);
    $content = '<li class="tumblr">
		<a href="https://tumblr.com/### class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">tumblr</span></a></li>';
    return $content;
}
function rrssb_youtube_btn()
{
	$icon = file_get_contents('icons/youtube.svg',true);
    $content = '<li class="youtube">
		<a href="https://youtube.com/###" class="popup">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">youtube</span></a></li>';
    return $content;
}

/* End buttons */

/* END FILE */
?>