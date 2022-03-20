<?php
/**
 * Plugin Name: Blackfire WP Testing plugin
 * Plugin URI: https://blackfire.io
 * Description: Blackfire Wordpress testing plugin. Helps identifying metrics
 * Author: Jérôme Vieilledent, Nemanja Cimbaljevic
 * License: MIT
 */

class Blackfire_Markers
{
    /**
     * Quick init method.
     */
    public static function init(): void
    {
        if (false === method_exists(\BlackfireProbe::class, 'addMarker')) {
            return;
        }

        $blackfire_markers = new static();

        foreach ($blackfire_markers->get_markable_hooks() as $hook_name => $hook_label) {
            add_action($hook_name,
                function () use ($hook_label) {
                    \BlackfireProbe::addMarker($hook_label);
                }
            );
        }
    }

    /**
     * Action hook names to attach makers to.
     *
     * Hooks from wp-settings.php
     *
     * 'mu_plugin_loaded',
     * 'network_plugin_loaded',
     * 'muplugins_loaded',
     * 'plugin_loaded',
     * 'plugins_loaded',
     * 'sanitize_comment_cookies',
     * 'setup_theme',
     * 'after_setup_theme',
     * 'init',
     * 'wp_loaded',
     */
    public function get_markable_hooks(): iterable
    {
        yield 'muplugins_loaded' => __('Must-use and network-activated plugins have loaded.');
        yield 'plugins_loaded' => __('Activated plugins have loaded.');
        yield 'setup_theme' => __('Before the theme is loaded.');
        yield 'after_setup_theme' => __('After the theme is loaded.');
        yield 'init' => __('WP finished loading but before any headers are sent.');
        yield 'wp_loaded' => __('WP fully loaded.');
    }
}

Blackfire_Markers::init();
