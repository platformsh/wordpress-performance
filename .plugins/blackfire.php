<?php
/**
 * Plugin Name: Blackfire WP Testing plugin
 * Plugin URI: https://blackfire.io
 * Description: Blackfire Wordpress testing plugin. Helps identifying metrics
 * Author: Jérôme Vieilledent
 * License: MIT
 */

namespace Blackfire\Bridge\WordPress;

function set_transaction_name($transactionName)
{
    if (!method_exists(\BlackfireProbe::class, 'setTransactionName')) {
        return;
    }

    \BlackfireProbe::setTransactionName($transactionName);
}

function add_marker($markerName = '')
{
    if (!method_exists(\BlackfireProbe::class, 'addMarker')) {
        return;
    }

    \BlackfireProbe::addMarker($markerName);
}
