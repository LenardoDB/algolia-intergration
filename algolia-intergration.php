<?php

use LenardoDB\AlgoliaIntergration\Functions;

/**
 * Plugin Name: Algolia Intergration
 * Author: Lenardo de Bruine
 * Author URI: https://github.com/LenardoDB
 * Description: Add Algolia Integration.
 * Tested up to: 5.7.2
 * Version: 1.0.0
 * 
 * @package Algolia_Intergration
 */

if (!defined('ABSPATH')) {
    die;
}

require_once __DIR__ . '/vendor/autoload.php';

new Functions();
