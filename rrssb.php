<?php
/*
Plugin Name: Ridiculously Responsive Social Sharing Buttons
Plugin URI: https://wordpress.org/plugins/ridiculously-responsive-social-sharing-buttons/
Description: Ridiculously Responsive Social Sharing Buttons adapted from https://github.com/kni-labs/rrssb.
Version: 2.0
Author: Alan Reed
Author URI: http://www.alanreed.org
Date: 4 June 2014

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

include( 'rrssb_admin.php' );

/* On Activation & Decativation */

function activate_rrssb() {	
	add_option('show_email'		, 1);
	add_option('show_facebook'	, 1);
	add_option('show_linkedin'	, 1);
	add_option('show_twitter'	, 1);
	add_option('show_reddit'	, 1);
	add_option('show_google'	, 1);
	add_option('show_pocket'	, 1);
	add_option('show_github'	, 0);
	add_option('show_instagram'	, 0);
	add_option('show_pinterest'	, 0);
	add_option('show_tumblr'	, 0);
	add_option('show_youtube'	, 0);
	
	add_option('github_link'	, "");
	add_option('instagram_link'	, "");
	add_option('pinterest_link', "");
	add_option('tumblr_link'	, "");
	add_option('youtube_link'	, "");
	
	add_option('give_rrssb_credit'	, 1);
	add_option('show_buttons_under_post', 1);
	add_option('use_rrssb_jquery'	, 1);
	add_option('help_improve_rrssb'	, 1);
	add_option('rrssb_css' , ".no-margin li {margin: 0!important;}");
	add_option('rrssb_css_classes' , "no-margin");
}

function deactive_rrssb() {  
  	delete_option('show_email');
	delete_option('show_facebook');
	delete_option('show_linkedin');
	delete_option('show_twitter');
	delete_option('show_reddit');
	delete_option('show_google');
	delete_option('show_pocket');
	delete_option('show_github');
	delete_option('show_instagram');
	delete_option('show_pinterest');
	delete_option('show_tumblr');
	delete_option('show_youtube');
	
	delete_option('github_link');
	delete_option('instagram_link');
	delete_option('pinterest_link');
	delete_option('tumblr_link');
	delete_option('youtube_link');
	
	delete_option('give_rrssb_credit');
	delete_option('show_buttons_under_post');
	delete_option('use_rrssb_jquery');
	delete_option('help_improve_rrssb');
	delete_option('rrssb_css');
	delete_option('rrssb_css_classes');
}

register_activation_hook(__FILE__, 'activate_rrssb');
register_deactivation_hook(__FILE__, 'deactive_rrssb');

/* CSS and JS */

function rrssb_js()
{
	// Use latest jqeury file.
	if ( 1 == get_option('use_rrssb_jquery') ) 
	{
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', 'http://code.jquery.com/jquery-latest.min.js ', array(), false, true);
	}
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
			' . get_option('rrssb_css') . '
		</style>
		<div class="share-container clearfix">
			<span class="label"><!-- Put an optional label here. --></span>
		<!-- buttons start here -->
		<ul class="rrssb-buttons clearfix ' . get_option('rrssb_css_classes') . '">';

	if ( 1 == get_option('show_email') ) 
		$content .= rrssb_email_btn();
	if ( 1 == get_option('show_facebook') ) 
		$content .= rrssb_facebook_btn();
	if ( 1 == get_option('show_linkedin') ) 
		$content .= rrssb_linkedin_btn();
	if ( 1 == get_option('show_twitter') ) 
		$content .= rrssb_twitter_btn();
	if ( 1 == get_option('show_reddit') ) 
		$content .= rrssb_reddit_btn();
	if ( 1 == get_option('show_google') ) 
		$content .= rrssb_google_btn();
	if ( 1 == get_option('show_pocket') ) 
		$content .= rrssb_pocket_btn();
	if ( 1 == get_option('show_github') ) 
		$content .= rrssb_github_btn();
	if ( 1 == get_option('show_instagram') ) 
		$content .= rrssb_instagram_btn();
	if ( 1 == get_option('show_pinterest') ) 
		$content .= rrssb_pinterest_btn();
	if ( 1 == get_option('show_tumblr') ) 
		$content .= rrssb_tumblr_btn();
	if ( 1 == get_option('show_youtube') ) 
		$content .= rrssb_youtube_btn();
	
	$content .= '</ul>';
	
	if ( 1 == get_option('give_rrssb_credit') )
		$content .= '
		<label><small>Buttons by 
		<a href="https://wordpress.org/plugins/ridiculously-responsive-social-sharing-buttons/">RRSSB</a>
		</small></label>';
		
	$content .= '
		<!-- buttons end here -->
		</div>';
    
	return $content;
}

function rrssb_show_buttons_on_single($content)
{
    if ( is_single() && ( 1 == get_option('show_buttons_under_post') )  ) {
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
		<a href="https://facebook.com/sharer/sharer.php?u=' .urlencode( get_permalink() ) . ' " class="popup">
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
		<a href="https://linkedin.com/shareArticle?mini=true&url=' .  urlencode( get_permalink() . '&title=' . get_the_title() ) . '" class="popup">
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
		<a href="https://twitter.com/home?status=' . urlencode( get_the_title() . ' - ' . get_permalink() ). '" class="popup">
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
		<a href="http://reddit.com/submit?url=' . urlencode( get_permalink() ) . '" class="popup">
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
		<a href="https://plus.google.com/share?url=' . urlencode( get_the_title() . ' - ' . get_permalink() ) .'" class="popup">
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
		<a href="https://github.com/' . get_option('github_link') . '" target="_blank">
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
		<a href="http://instagram.com/' . get_option('instagram_link') . '" target="_blank">
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
		<a href="http://pinterest.com/' . get_option('pinterest_link') . '" target="_blank">
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
		<a href="http://tumblr.com/' . get_option('tumblr_link') . '" target="_blank">
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
		<a href="http://youtube.com/' . get_option('youtube_link') . '" target="_blank">
		<span class="icon">
		' . $icon . '
		</span>
		<span class="text">youtube</span></a></li>';
    return $content;
}

/* End buttons */

/* END FILE */
?>