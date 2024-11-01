<?php

/**
 * Se activa cuando el plugin va a ser desinstalado
 *
 * @link       http://ubilop.com
 * @since      0.0.1
 *
 * @package    ubilop-plugin-wp
 */

/*

 * Agregar todo el código necesario
 * para eliminar ( como las bases de datos, limpiar caché,
 * limpiar enlaces permanentes, etc. ) en la desinstalación
 * del plugin
 */

 if(!defined('WP_UNINSTALL_PLUGIN')){
     die(); // corta el proceso restante de este codigo o exit()
 }

global $wpdb;
$sql = "DROP TABLE IF EXISTS {$wpdb->prefix}fact_data";
$wpdb->query( $sql );

$sql1 = "DROP TABLE IF EXISTS {$wpdb->prefix}fact_config";
$wpdb->query( $sql1 );

$sql2 = "DROP TABLE IF EXISTS {$wpdb->prefix}fact_sender";
$wpdb->query( $sql2 );

$sql3 = "DROP TABLE IF EXISTS {$wpdb->prefix}fact_cron";
$wpdb->query( $sql3 );

$sql4 = "DROP TABLE IF EXISTS {$wpdb->prefix}fact_return";
$wpdb->query( $sql4 );