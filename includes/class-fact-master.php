<?php

/**
 * El archivo que define la clase del nucleo principal del plugin
 *
 * Una definición de clase que incluye atributos y funciones que se 
 * utilizan tanto del lado del público como del área de administración.
 * 
 * @link       http://ubilop.com
 * @since      0.0.1
 *
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/includes
 */

/**
 * También mantiene el identificador único de este complemento,
 * así como la versión actual del plugin.
 *
 * @since      0.0.1
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/includes
 * @author     Ubilop <alexis@ubilop.com>
 * 
 * @property object $cargador
 * @property string $plugin_name
 * @property string $version
 */
class FACT_Master
{

    /**
     * El cargador que es responsable de mantener y registrar
     * todos los ganchos (hooks) que alimentan el plugin.
     *
     * @since    0.0.1
     * @access   protected
     * @var      FACT_Cargador    $cargador  Mantiene y registra todos los ganchos ( Hooks ) del plugin
     */
    protected $cargador;

    /**
     * El identificador único de éste plugin
     *
     * @since    0.0.1
     * @access   protected
     * @var      string    $plugin_name  El nombre o identificador único de éste plugin
     */
    protected $plugin_name;

    /**
     * Versión actual del plugin
     *
     * @since    0.0.1
     * @access   protected
     * @var      string    $version  La versión actual del plugin
     */
    protected $version;

    /**
     *
     * @since    0.0.1
     * @access   protected
     * @var      FACT_Cron   
     */
    protected $fact_cron;

    

    /**
     * Constructor
     * 
     * Defina la funcionalidad principal del plugin.
     *
     * Establece el nombre y la versión del plugin que se puede utilizar en todo el plugin.
     * Cargar las dependencias, carga de instancias, definir la configuración regional (idioma)
     * Establecer los ganchos para el área de administración y
     * el lado público del sitio.
     *
     * @since    0.0.1
     */
    public function __construct()
    {
        

        $this->plugin_name = 'ubilop-plugin-wp';
        $this->version = '0.0.3';

        $this->fact_cargar_dependencias();
        $this->fact_cargar_instancias();
        $this->set_idiomas();
        $this->fact_definir_admin_hooks();
        $this->fact_definir_public_hooks();
    }

    /**
	 * Defina la configuración regional de este plugin para la internacionalización.
     *
     * Utiliza la clase FACT_i18n para establecer el dominio y registrar el gancho
     * con WordPress.
	 *
	 * @since    0.0.1
	 * @access   private
	 */
    private function set_idiomas() {
        
        $fact_i18n = new FACT_i18n();
        $this->cargador->add_action( 'plugins_loaded', $fact_i18n, 'load_plugin_textdomain' );        
        
    }

    /**
     * Cargue las dependencias necesarias para este plugin.
     *
     * Incluya los siguientes archivos que componen el plugin:
     *
     * - FACT_Cargador. Itera los ganchos del plugin.
     * - FACT_i18n. Define la funcionalidad de la internacionalización
     * - FACT_Admin. Define todos los ganchos del área de administración.
     * - FACT_Public. Define todos los ganchos del del cliente/público.
     *
     * @since    0.0.1
     * @access   private
     */
    private function fact_cargar_dependencias()
    {

        /**
         * La clase responsable de iterar las acciones y filtros del núcleo del plugin.
         */
        require_once UBILOP_PLUGIN_DIR_PATH . 'includes/class-fact-cargador.php';

        /**
         * La clase responsable de definir la funcionalidad de la
         * internacionalización del plugin
         */
         require_once UBILOP_PLUGIN_DIR_PATH . 'includes/class-fact-i18n.php';        

        /**
         * La clase responsable de definir todas las acciones en el
         * área de administración
         */
        require_once UBILOP_PLUGIN_DIR_PATH . 'admin/class-fact-admin.php';

        /**
         * La clase responsable de crear los menús en nuestro panel de administración
         * área de administración
         */

        require_once UBILOP_PLUGIN_DIR_PATH . 'includes/class-fact-menu.php';

        /**
         * La clase responsable de crear las tareas programadas en nuestro panel de administración
         * área de administración
         */

        require_once UBILOP_PLUGIN_DIR_PATH . 'includes/class-fact-cron.php';


    }



    /**
     * Cargar todas las instancias necesarias para el uso de los 
     * archivos de las clases agregadas
     *
     * @since    0.0.1
     * @access   private
     */
    private function fact_cargar_instancias()
    {

        // Cree una instancia del cargador que se utilizará para registrar los ganchos con WordPress.
        $this->cargador     = new FACT_cargador;
        $this->fact_admin   = new FACT_Admin($this->get_plugin_name(), $this->get_version());
        $this->cron          = new FACT_Cron;
    }

    /**
     * Registrar todos los ganchos relacionados con la funcionalidad del área de administración
     * Del plugin.
     *
     * @since    0.0.1
     * @access   private
     */
    private function fact_definir_admin_hooks()
    {
        
        //gancho para encolar los estilos css
        $this->cargador->add_action('admin_enqueue_scripts', $this->fact_admin, 'enqueue_styles');
        //gancho para encolar los scripts js
        $this->cargador->add_action('admin_enqueue_scripts', $this->fact_admin, 'enqueue_scripts');
        //Menus
        $this->cargador->add_action('admin_menu', $this->fact_admin, 'add_menu' );
        //config $this->fact_config->add_action('admin_init', $this->new_admin, 'fact_admin_init');
        
        //gancho para agregar una columna del fact en el listado de ordenes de woocomerce
        $this->cargador->add_filter( 'manage_edit-shop_order_columns', $this->fact_admin, 'add_fact_order_columns');
        //gancho para agregar el boton del fact en el listado de ordenes de woocomerce
        $this->cargador->add_action( 'manage_shop_order_posts_custom_column', $this->fact_admin, 'render_fact_column');

        //gancho para guardar y actualizar la configuración de conexión al fact 
        $this->cargador->add_action('wp_ajax_fact_data', $this->fact_admin, 'ajax_crud_fact' );
        
        //gancho para transmitir una orden al fact
        $this->cargador->add_action('wp_ajax_fact_send', $this->fact_admin, 'ajax_send_fact' );

        //gancho para visualizar un envío del fact
        $this->cargador->add_action('wp_ajax_fact_view', $this->fact_admin, 'ajax_order_fact' );

        //gancho para visualizar una recogida del fact
        $this->cargador->add_action('wp_ajax_fact_view_return', $this->fact_admin, 'ajax_recogida_fact' );

        //gancho para visualizar los estados de un envío del fact
        $this->cargador->add_action('wp_ajax_fact_list', $this->fact_admin, 'ajax_list_fact' );

        //gancho para visualizar la etiqueta Pdf de un envío del fact
        $this->cargador->add_action('wp_ajax_fact_label', $this->fact_admin, 'ajax_label_fact' );

        //gancho para visualizar el manifiesto de un envío del fact
        $this->cargador->add_action('wp_ajax_fact_manifest', $this->fact_admin, 'ajax_manifest_fact' );

        //gancho para imprimir las etiquetas en masivo
        $this->cargador->add_action('wp_ajax_fact_masive', $this->fact_admin, 'ajax_masive_fact' );

        //gancho para traer los servicios autorizados del cliente
        $this->cargador->add_action('wp_ajax_fact_service', $this->fact_admin, 'ajax_service_fact' );

        //gancho para traer los diferentes remitentes registrados 
        $this->cargador->add_action('wp_ajax_fact_senders', $this->fact_admin, 'ajax_senders_fact' );

        //filtro para tareas programas cron
        $this->cargador->add_filter('cron_schedules', $this->cron, 'intervalos' );

        //ganchos eventos cron
        $this->cargador->add_action('init', $this->cron, 'inicializador' );
        $this->cargador->add_action('fact_init_cron', $this->cron, 'actualizadorEstados' );
        
        //$this->cargador->add_action('wp_ajax_fact_estado', $this->fact_admin, 'ajax_estado_fact' );

        $this->cargador->add_action('wp_ajax_fact_state', $this->fact_admin, 'ajax_estado_fact' );

        //gancho para guardar los datos de un remitente
        $this->cargador->add_action('wp_ajax_fact_sender', $this->fact_admin, 'ajax_sender_fact' );

        //gancho para guardar los datos cron
        $this->cargador->add_action('wp_ajax_fact_cron', $this->fact_admin, 'ajax_cron_fact' );

        //gancho para generar una recogida de una orden transmitida al fact
        $this->cargador->add_action('wp_ajax_fact_return', $this->fact_admin, 'ajax_return_fact' );

        //gancho para realizar una solicitud de credenciales de acceso
       $this->cargador->add_action('wp_ajax_fact_email', $this->fact_admin, 'ajax_email_fact' );


    }
    

    /**
     * Registrar todos los ganchos relacionados con la funcionalidad del área de administración
     * Del plugin.
     *
     * @since    0.0.1
     * @access   private
     */
    private function fact_definir_public_hooks()
    {

    }

    /**
     * Ejecuta el cargador para ejecutar todos los ganchos con WordPress.
     *
     * @since    0.0.1
     * @access   public
     */
    public function run()
    {
        $this->cargador->run();
    }

    /**
     * El nombre del plugin utilizado para identificarlo de forma exclusiva en el contexto de
     * WordPress y para definir la funcionalidad de internacionalización.
     *
     * @since     0.0.1
     * @access    public
     * @return    string    El nombre del plugin.
     */
    public function get_plugin_name()
    {
        return $this->plugin_name;
    }

    /**
     * La referencia a la clase que itera los ganchos con el plugin.
     *
     * @since     0.0.1
     * @access    public
     * @return    FACT_Cargador    Itera los ganchos del plugin.
     */
    public function get_cargador()
    {
        return $this->cargador;
    }

    /**
     * Retorna el número de la versión del plugin
     *
     * @since     0.0.1
     * @access    public
     * @return    string    El número de la versión del plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
    

}

