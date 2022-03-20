<?php
/**
 * Plugin Name: Blackfire WP Testing plugin
 * Plugin URI: https://blackfire.io
 * Description: Blackfire Wordpress testing plugin. Helps identifying metrics
 * Author: Jérôme Vieilledent, Nemanja Cimbaljevic
 * License: MIT
 */

use BlackfireProbe;

class Blackfire_Markers
{
    /**
     * Quick init method.
     */
    public static function init(): void
    {
        if (false === method_exists(BlackfireProbe::class, 'addMarker')) {
            return;
        }

        $blackfire_markers = new static();

        foreach ($blackfire_markers->get_hooks() as $hook_name) {
            add_action($hook_name,
                function () use ($blackfire_markers, $hook_name) {
                    $blackfire_markers->create_marker($hook_name);
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
    public function get_hooks(): array
    {
        return array(
            'muplugins_loaded',
            'plugins_loaded',
            'setup_theme',
            'after_setup_theme',
            'init',
            'wp_loaded',
        );
    }

    /**
     * Put labels on all markers.
     *
     * @param  string  $hook_name
     *
     * @return string
     */
    public function get_marker_label(string $hook_name): string
    {
        $labels = array(
            'muplugins_loaded'  => __('All must-use and network-activated plugins have loaded.'),
            'plugins_loaded'    => __('Activated plugins have loaded.'),
            'setup_theme'       => __('Before the theme is loaded.'),
            'after_setup_theme' => __('After the theme is loaded.'),
            'init'              => __('WordPress has finished loading but before any headers are sent.'),
            'wp_loaded'         => __('WP, all plugins, and the theme are fully loaded and instantiated.'),
        );

        return sprintf('[%s] %s', $hook_name, $labels[$hook_name] ?? '');
    }

    public function create_marker(string $hook_name): void
    {
        BlackfireProbe::addMarker($this->get_marker_label($hook_name));
    }
}

Blackfire_Markers::init();
