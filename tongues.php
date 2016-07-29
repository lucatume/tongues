<?php
/**
 * Plugin Name: Tongues
 * Plugin URI: http://theAverageDev.com
 * Description: Yet another WordPress language plugin
 * Version: 1.0
 * Author: theAverageDev
 * Author URI: http://theAverageDev.com
 * License: GPL 2.0
 */

include 'vendor/autoload.php';

add_action('plugins_loaded', function () {
    include 'src/bootstrap.php';
});
