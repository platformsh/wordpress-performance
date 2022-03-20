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

        foreach ($blackfire_markers->get_markable_hooks() as $hook_name) {
            add_action($hook_name,
                function () use ($hook_name) {
                    \BlackfireProbe::addMarker("wordpress.$hook_name");
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
     *
     * Additional hooks used:
     * parse_request
     * parse_query
     * pre_get_posts
     * posts_clauses
     * posts_selection
     * wp
     * template_redirect
     */
    public function get_markable_hooks(): iterable
    {
        yield 'muplugins_loaded';
        yield 'plugins_loaded';
        yield 'setup_theme';
        yield 'after_setup_theme';
        yield 'init';
        yield 'wp_loaded';
        yield 'parse_request';
        yield 'parse_query';
        yield 'posts_clauses';
        yield 'posts_selection';
        yield 'wp';
        yield 'template_redirect';
    }
}

Blackfire_Markers::init();
