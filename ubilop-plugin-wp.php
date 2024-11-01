<?php
// Metadata del plugins -->
/**
 * Plugin Name:       FACTUBILOP
 * Plugin URI:        https://ubilop.com/
 * Description:       Complemento de Ubilop para transmitir las ordenes de Wordpress-WC al software de facturación FACT.
 * Version:           3.1.1
 * Requires at least: 4.9.8
 * Requires PHP:      5.5
 * Author:            Ubilop
 * Author URI:        https://ubilop.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ubilop-plugin-wp
 * Domain Path:       /languages
 */

 

 //limitar el acceso directo a este archivo
 defined('ABSPATH') or die('No Script kiddies please');

if (!defined('WPINC')) {
    die;
}
/**
 * Definimos las constantes y variables globales
 */
global $wpdb;
global $wsvc;



define('UBILOP_REALPATH_BASENAME_PLUGIN', dirname(plugin_basename(__FILE__)) . '/');
define('UBILOP_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
define('UBILOP_PLUGIN_DIR_URL', plugin_dir_url(__FILE__));
define('UBILOP_TABLE_DATA', "{$wpdb->prefix}fact_data");
define('UBILOP_TABLE_RETURN', "{$wpdb->prefix}fact_return");
define('UBILOP_TABLE_CONFIG', "{$wpdb->prefix}fact_config");
define('UBILOP_TABLE_SENDER', "{$wpdb->prefix}fact_sender");
define('UBILOP_TABLE_CRON', "{$wpdb->prefix}fact_cron");

$sql = "SELECT * FROM " . UBILOP_TABLE_CONFIG . " WHERE estado = 1";
$result = $wpdb->get_row($sql);
if($result){
    define('UBILOP_WS_CONFIG', "{$result->url_ws}");
    define('UBILOP_COD_CONFIG', "{$result->codigo_cliente}");
    define('UBILOP_CLAVE_CONFIG', "{$result->clave}");
    define('UBILOP_IRIS_CONFIG', "{$result->url_iris}");
}else{
    define('UBILOP_WS_CONFIG', "");
}



/**
 * Código que se ejecuta en la activación del plugin
 */
if (!function_exists('activate_fact_wp')) {

    function activate_fact_wp()
    {
        require_once UBILOP_PLUGIN_DIR_PATH . 'includes/class-fact-activator.php';
        FACT_Activator::activate();
    }
}
register_activation_hook(__FILE__, 'activate_fact_wp'); // gancho de wp para activar el Plugin

/**
 * Código que se ejecuta en la desactivación del plugin
 */
if (!function_exists('deactivate_fact_wp')) {
    function deactivate_fact_wp()
    {
        require_once UBILOP_PLUGIN_DIR_PATH . 'includes/class-fact-deactivator.php';
        FACT_Deactivator::deactivate();
    }
}
register_deactivation_hook(__FILE__, 'deactivate_fact_wp'); // gancho de wp para desactivar el Plugin

/**
 * Código que se ejecuta en la master-page del plugin
 */
require_once UBILOP_PLUGIN_DIR_PATH . 'includes/class-fact-master.php';
if (!function_exists('run_fact_master')) {
    function run_fact_master()
    {
        $new_master = new FACT_Master;
        $new_master->run();
    }
}
run_fact_master(); 


