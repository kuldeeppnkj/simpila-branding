<?php
/*
Plugin Name: Simplia Branding
Description: Replace WordPress branding with Simplia and remove update notifications.
Version: 1.0
Author: Pankaj Kuldeep
*/

class SimpliaBrandingPlugin {
    public function __construct() {
        // Hook into the admin menu to change the branding
        add_action('admin_menu', array($this, 'replace_wordpress_branding'));
        
        // Hook into the admin to remove update notifications
        add_action('admin_init', array($this, 'remove_updates_and_notifications'));
        add_filter('admin_footer_text', array($this, 'replace_admin_footer_text'));
    }

    // Function to replace WordPress branding with "Simplia"
    public function replace_wordpress_branding() {
        global $menu;
        $menu[2][0] = 'Simplia'; // Change the name in the menu
        remove_action('admin_footer', 'update_footer'); // Remove "Thank you" text in the footer
    }

    // Function to remove updates and notifications
    public function remove_updates_and_notifications() {
        if (!current_user_can('update_plugins')) {
            remove_action('admin_notices', 'update_nag', 3);
            remove_action('admin_init', 'wp_version_check');
            remove_action('admin_init', 'wp_update_plugins');
            remove_action('admin_init', 'wp_update_themes');
            
        }
        // Hide WordPress branding in the admin area
        add_filter('update_footer', '__return_empty_string');
    }

    // Function to replace the admin footer text
    public function replace_admin_footer_text($text) {
        return "Powered by Simplia";
    }
}

// Instantiate the SimpliaBrandingPlugin class
$simplia_branding_plugin = new SimpliaBrandingPlugin();
