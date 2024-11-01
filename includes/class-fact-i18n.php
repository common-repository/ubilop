<?php

/**
 * Define la funcionalidad de internacionalización
 *
 * Carga y define los archivos de internacionalización de este plugin para que esté listo para su traducción.
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
class FACT_i18n {
    
    /**
	 * Carga el dominio de texto (textdomain) del plugin para la traducción.
	 *
     * @since    0.0.1
     * @access public static
	 */    
    public function load_plugin_textdomain() {
        
        load_plugin_textdomain(
            'factcode-textdomain',
            false,
            UBILOP_PLUGIN_DIR_PATH . 'languages'
        );
        
    }
    
}