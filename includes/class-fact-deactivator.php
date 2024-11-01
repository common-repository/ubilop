<?php

/**
 * Se activa en la activación del plugin
 *
 * @link       http://ubilop.com
 * @since      0.0.1
 *
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/includes
 */

/**
 * Ésta clase define todo lo necesario durante la activación del plugin
 *
 * @since      0.0.1
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/includes
 * @author     Ubilop <alexis@ubilop.com>
 */

class FACT_Deactivator {

	/**
	 * Método estático
	 *
	 * Método que se ejecuta al desactivar el plugin
	 *
	 * @since 0.0.1
     * @access public static
	 */
	public static function deactivate() {
        
		flush_rewrite_rules(); // LIMPIADOR DE ENLACES PERMANENTES
		wp_clear_scheduled_hook( 'fact_init_cron' );
        
	}

}