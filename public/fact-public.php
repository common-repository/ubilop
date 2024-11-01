<?php

/**
 * La funcionalidad específica de administración del plugin.
 *
 * @link       http://ubilop.com
 * @since      0.0.1
 *
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/public/parcials
 */

/**

 *
 * @since      0.0.1
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/includes/admin
 * @author     Ubilop <info@ubilop.com>
 * 
 * @property string $plugin_name
 * @property string $version
 */
class UBILOP_Public {
    
    /**
	 * El identificador único de éste plugin
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $plugin_name  El nombre o identificador único de éste plugin
	 */
    private $plugin_name;
    
    /**
	 * Versión actual del plugin
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $version  La versión actual del plugin
	 */
    private $version;
    
    /**
	 * Objeto wpdb
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      object    $db @global $wpdb
	 */
    private $db;
    
    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct( $plugin_name, $version ) {
        
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        
        global $wpdb;
        $this->db = $wpdb;
        
    }
    
    /**
	 * Registra los archivos de hojas de estilos del área de administración
	 *
	 * @since    0.0.1
     * @access   public
	 */
    public function enqueue_styles() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */
		wp_enqueue_style( $this->plugin_name, UBILOP_PLUGIN_DIR_URL . 'public/css/fact-public.css', array(), $this->version, 'all' );
        
    }
    
    /**
	 * Registra los archivos Javascript del área de administración
	 *
	 * @since    0.0.1
     * @access   public
	 */
    public function enqueue_scripts() {
        
        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en BC_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El BC_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
		 */
        wp_enqueue_script( $this->plugin_name, UBILOP_PLUGIN_DIR_URL . 'public/js/fact-public.js', array( 'jquery' ), $this->version, true );
        
    }
    
    
    
}









