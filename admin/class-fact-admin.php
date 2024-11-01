<?php

/**
 * Se activa en la activación del plugin
 *
 * @link       http://ubilop.com
 * @since      0.0.1
 *
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/includes/admin
 */

/**
 * Ésta clase define todo lo necesario durante la activación del plugin
 *
 * @since      0.0.1
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/includes/admin
 * @author     Ubilop <alexis@ubilop.com>
 */

// traemos el url del Webservice activo

require_once('lib/nusoap.php'); // !Important

use lib\PHPMailer\PHPMailer\PHPMailer;
        use lib\PHPMailer\PHPMailer\Exception;






class FACT_Admin
{


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
     * Para crear un nuevo menú en la administración
     *
     * @since 0.0.1
     * @access   private
     * @var      object    $build_menupage  Instancia del objeto
     */
    private $build_menupage;

    /**
     * Objeto wpdb
     *
     * @since 0.0.1
     * @access private
     * @var object $db @global $wpdb
     */
    private $db;



    /**
     * @param string $plugin_name nombre o identificador único de éste plugin.
     * @param string $version La versión actual del plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->build_menupage = new FACT_Build_Menupage;

        global $wpdb;
        $this->db = $wpdb;
    }

    /**
     * Registra los archivos de hojas de estilos del área de administración
     *
     * @since    0.0.1
     * @access   public
     */
    public function enqueue_styles($hook)
    {

        // var_dump($hook);
        if ($hook == 'toplevel_page_fact_options' || $hook == 'fact-datos_page_fact_orders' || $hook == 'fact-datos_page_fact_returns') {
        } else {
            return;
        }

        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en NEW_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El NEW_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
         */
        wp_enqueue_style($this->plugin_name, UBILOP_PLUGIN_DIR_URL . 'admin/css/fact-admin.css?n=1', array(), $this->version, 'all');

        /**
         * Framework materialize
         * https://materializecss.com/
         */
        wp_enqueue_style('new_materialize_css', UBILOP_PLUGIN_DIR_URL . 'helpers/materialize/css/materialize.min.css', array(), $this->version, 'all');


        /**
         * Framework materialize icons
         * https://materializecss.com/icons.html
         */
        wp_enqueue_style('new_materialize_icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '0.100.1', 'all');

        /**
         * Framework sweetalert
         * https://
         */
        //wp_enqueue_style('new_sweetalert_css', UBILOP_PLUGIN_DIR_URL . 'helpers/sweetalert-master/dist/sweetalert.css', array(), $this->version, 'all');
    }

    /**
     * Registra los archivos Javascript del área de administración
     *
     * @since    0.0.1
     * @access   public
     */

    public function enqueue_scripts($hook)
    {

        if ($hook == 'toplevel_page_fact_options' || $hook == 'fact-datos_page_fact_orders' || $hook == 'fact-datos_page_fact_returns' || $hook == 'edit.php') {
        } else {
            return;
        }

        /**
         * Se elimina la versión de jquery por defecto y se registra la última
         */
       // wp_deregister_script( 'jquery' );
       // wp_register_script( 'jquery', "https://code.jquery.com/jquery-3.5.1.min.js", array(), '3.5.1' );

        /**
         * Una instancia de esta clase debe pasar a la función run()
         * definido en NEW_Cargador como todos los ganchos se definen
         * en esa clase particular.
         *
         * El NEW_Cargador creará la relación
         * entre los ganchos definidos y las funciones definidas en este
         * clase.
         */

        wp_enqueue_script($this->plugin_name, UBILOP_PLUGIN_DIR_URL . 'admin/js/fact-admin.js?n=1', ['jquery'], $this->version, true);

        /**
         * Framework materialize
         * https://materializecss.com/
         */
        wp_enqueue_script('new_materialize_js', UBILOP_PLUGIN_DIR_URL . 'helpers/materialize/js/materialize.min.js', array(), '0.100.1', true);


        /**
         * Librería sweetalert2
         * https://sweetalert2.github.io/
         */
        wp_enqueue_script('new_sweetalert2_js', UBILOP_PLUGIN_DIR_URL . 'helpers/sweetalert2/sweetalert2.min.js', ['jquery'], $this->version, true);





        /**
         * Lozalizando el archivo Javascript
         * principal del área de administración
         * para pasarle el objeto "factdata" con los parámetros:
         * 
         * @param factdata.url        Url del archivo admin-ajax.php
         * @param factdata.seguridad  Nonce de seguridad para el envío seguro de datos
         */
        wp_localize_script(
            $this->plugin_name,
            'factdata',
            [
                'url' => admin_url('admin-ajax.php'),
                'url1' => admin_url('admin.php'),
                'seguridad' => wp_create_nonce('factdata_seg')
            ]
        );
    }


    /**
     * Crear el item Fact en el Menu principal de Wordpress
     */

    public function add_menu()
    {

        $this->build_menupage->add_menu_page(
            __('Fact Datos', 'ubilop-plugin-wp'),
            __('Fact Datos', 'ubilop-plugin-wp'),
            'edit_theme_options',
            'fact_options',
            [$this, 'controlador_display_menu'],
            'dashicons-id-alt',
            22
        );

        $sql = "SELECT * FROM " . UBILOP_TABLE_CONFIG . " WHERE estado = 1";
        $result = $this->db->get_row($sql);

        if ($result) {

            $this->build_menupage->add_submenu_page(
                'fact_options',
                __('Envios', 'ubilop-plugin-wp'),
                __('Envios', 'ubilop-plugin-wp'),
                'edit_theme_options',
                'fact_orders',
                [$this, 'controlador_display_submenu']
            );

            $this->build_menupage->add_submenu_page(
                'fact_options',
                __('Devoluciones', 'ubilop-plugin-wp'),
                __('Devoluciones', 'ubilop-plugin-wp'),
                'edit_theme_options',
                'fact_returns',
                [$this, 'controlador_display_submenu1']
            );

            
        }



        $this->build_menupage->run();
    }


    public function controlador_display_menu()
    {
        require_once UBILOP_PLUGIN_DIR_PATH . 'admin/partials/fact-config-display.php';
    }

    public function controlador_display_submenu()
    {
        require_once UBILOP_PLUGIN_DIR_PATH . 'admin/partials/fact-order-display.php';

    }

    public function controlador_display_submenu1()
    {
        require_once UBILOP_PLUGIN_DIR_PATH . 'admin/partials/fact-return-display.php';
    }

    


    /**
     * Agregar pestaña del Fact en el listado de Ordenes de Woocomerce
     */
    function add_fact_order_columns($columns)
    {

        $columns['fact_action'] = __('Fact Acción', 'ubilop-plugin-wp');

        $columns['fact_label'] = __('Fact Etiqueta', 'ubilop-plugin-wp');

        return $columns;
    }

    /**
     * Imprimir el boton de Transmitir al Fact en el listado de Ordenes de Woocommerce
     */
    function render_fact_column($column)
    {

        if (UBILOP_WS_CONFIG) {

            global $post;
            $data = get_post_meta($post->ID);

           $sql = "SELECT * FROM " . UBILOP_TABLE_DATA . " WHERE id_orden = $post->ID AND ruta = '" . UBILOP_WS_CONFIG . "'";
            $result = $this->db->get_row($sql);

            $orden = wc_get_order($post->ID); // funcion de woocomerce para consultar una orden
            $estadoDB = $result->estado;
            $albaran = $result->albaran;
            $order_data = $orden->get_data();

            $sql = "SELECT * FROM " . UBILOP_TABLE_SENDER . " WHERE estado = 1";
            $res = $this->db->get_row($sql);
            $servicio = $res->servicio;
            $idRemitente = $res->id;
            $nombreRemi = $res->nombre;

            if ($column == 'fact_action') {

                if (!$result) {


                    $items = $orden->get_items();
                    $weight= 0;
                    $product_weight = 0;
                    if (is_array($items)) {

                        foreach ( $items as $item ) {
                            
                            
                            $product = wc_get_product( $item['product_id'] );
                            
                            if($product){
                                
                                $quantity = $item->get_quantity();

                                //Verificamos si es un producto variable o simple para calcular el peso total de la orden                                
                                if( $product->is_type( 'variable' ) ){
                                    
                                     
                                    $vatiation_ids = $product->get_children();
                                    
                                    foreach ( $vatiation_ids as $variation_id ) {                                        
                                        
                                        $variation = wc_get_product( $variation_id ); // Get the product variation object

                                        if(is_bool($variation->get_weight()) === false){
                                            $itemsName = $item->get_name();
                                            $variationName = $variation->get_name();
                                            //$id = $variation->get_id();
                                            if($itemsName == $variationName){

                                                if (is_numeric($variation->get_weight())) {
                                                    if(!empty($variation->get_weight()))
                                                    $weight += $variation->get_weight() * $quantity; // Get weight from variation;
                                                }
                                                                                               
                                                //print_r($weight);
                                            }
                                            
                                            
                                        }else{
                                            $weight = 1;
                                        } 
                                                                                                               
                                    }
                                    
                                }else{
                                     

                                    if(is_bool($product->get_weight()) === false){
                                        $product_weight = $product->get_weight();
                                    }else{
                                        $product_weight = 0;
                                    } 
                                    
                                    if (is_numeric($product_weight)) {
                                        if(!empty($product_weight))
                                        $weight += $product_weight * $quantity;
                                    }
                                }                        
                                

                            }
                            
                        }

                    }

                    // si el estado es diferente a pendiente de pago o la orden a sido cancelda no se muestra el botón de transmitir
                    if($orden->get_status() != 'failed' && $orden->get_status() != 'cancelled' && $orden->get_status() != 'pending') {
                    $html = '<button class="button btn-transmitir" remitente="'.$idRemitente.'" nombre = "'.$nombreRemi.'" peso="'.$weight.'" status="'.$orden->get_status().'" style="display:flex; padding:3px 5px" metodo-pago="' . $order_data['payment_method'] . '" data-order-id="' . $post->ID . '" servicio="'. $servicio .'"><img id="imgSpinner" class="imgSpinner" dir="' . UBILOP_PLUGIN_DIR_URL . '" style="margin: 3px 4px; display:none;" src="' . UBILOP_PLUGIN_DIR_URL . 'admin/img/loader2.gif" width="25px"  alt=""></i><span>' . __('Transmitir Orden', 'ubilop-plugin-wp') . '</span>'
                            . '</button>';
                        }
                } else {

                    if($estadoDB == "DOCUMENTADO"){                   
                        
                        //$orden->update_status('fact-transmitido');
                        
                    }      
                    

                    $html = '<button class="order-status status-processing tips" disabled style="" estado="' . $orden->get_status() . '" data-order-id="' . $post->ID . '"><span>' . __("Transmitido", 'ubilop-plugin-wp') . '</span>'
                        . '</button>';
                }
                echo $html;
            }

            //$client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            //pasando los parámetros a un array
            $param = array(
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG,
                '_AlbaranNumero' => $result->albaran,
                '_EtiquetaTermica' => true,
                '_CuadranteInicial' => 1

            );



            if ($column == 'fact_label') {
                if ($result) {

                    $fecha_actual = date("Y-m-d");
                    $fecha = $result->fecha;
                    if($fecha_actual == $fecha){

                        $html1 = '<button type="button" class="button btnLabel" albaran="' . $result->albaran . '" ><img class="hide" style="margin: -3px 4px; display:none;" src="' . UBILOP_PLUGIN_DIR_URL . 'admin/img/wpspin_light.gif"  alt=""><span>' . __('Imprimir Etiqueta', 'ubilop-plugin-wp') . '</span></button>';
                    }else{
                      //  $html1 = '<button type="button" alt="Etiqueta de día anterior no disponible" class="btn btn-success btnLabel" disabled albaran="' . $result->albaran . '" ><span>' . __('Etiqueta No Disponible', 'ubilop-plugin-wp') . '</span></button>';
                    }
                    

                } else {
                    $html1 = '';
                }
                echo $html1;
            }
        }
    }

     public function ajax_estado_fact($hook){


        global $wpdb;
        $this->db = $wpdb;

        $fecha_tope = date("Y-m-d");
        $fecha_inicial = date("Y-m-d", strtotime($fecha_tope . "- 12 days"));

            $sql = "SELECT * FROM " . UBILOP_TABLE_DATA . " WHERE ruta = '" . UBILOP_WS_CONFIG . "' AND fecha BETWEEN " . "'" . $fecha_inicial . "'" . " AND " . "'" . $fecha_tope . "'" . " ORDER BY albaran DESC";
            $result = $this->db->get_results($sql);
            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');
            $estado = '';
            $sql1 = "SELECT * FROM " . UBILOP_TABLE_CRON;
            $res = $this->db->get_row($sql1);

        foreach($result as $k => $v) {

                
            $estadoDB = $v->estado;
            $albaran = $v->albaran;
            $ordenDb = $v->id_orden;
            $order = wc_get_order($ordenDb); // funcion de woocomerce para consultar una orden
        
         //pasando los parámetros a un array
             $param = array(
            '_Usuario' => UBILOP_COD_CONFIG,
            '_Clave' => UBILOP_CLAVE_CONFIG,
            '_AlbaranNumero' => $albaran,
            '_Referencia1' => "",
            '_Referencia2' => ""
        );
        
                        //llamando al método y pasándole el array con los parámetros
                        $resultado = $client->call('RecuperarEnvio', $param);
                        $result1 = $resultado['RecuperarEnvioResult'];

                        if (isset($result1['Value'])) {

                            $value = $result1['Value'];
                            $estado = $value['Estado'];
                        }
                        if($estado != $estadoDB && $res != null && $estadoDB != 'DEVUELTO' ){
                            if($order->get_status() != "completed" && $order->get_status() != "cancelled" ){
                            switch ($estado) {
                                case "DOCUMENTADO":
                                    if($res->documentado != ""){
                                        $order->update_status($res->documentado);
                                    }else{
                                   
                                    }                                       
                                    break;
                                 case "TRANSMITIDO":
                                        if($res->transmitido != "" && $order->get_status() != $res->transmitido ){

                                                $order->update_status($res->transmitido);
                                                              
                                        }                                      
                                        break;
                                case "PROCESADO":
                                    if($res->procesado != "" && $order->get_status() != $res->procesado){
                                    
                                        $order->update_status($res->procesado);
                                        
                                    }                                      
                                    break;
                                case "EN_TRANSITO":
                                        if($res->transito != "" && $order->get_status() != $res->transito){
                                          
                                            $order->update_status($res->transito);
                                            
                                        }
                                        break;
                                case "EN_REPARTO":
                                    if($res->reparto != "" && $order->get_status() != $res->reparto){
                                   
                                        $order->update_status($res->reparto);
                                        
                                    } 
                                    break;
                                case "ENTREGADO":
                                    if($res->entregado != "" && $order->get_status() != $res->entregado){
                                       
                                        $order->update_status($res->entregado);
                                        
                                    } 
                                    break;
                                case "CANCELADO":
                                    if($res->cancelado != "" && $order->get_status() != $res->cancelado){
                                        $order->update_status($res->cancelado);
                                    }
                                    break;
                                case "INCIDENCIA":
                                        if($res->incidencia != "" && $order->get_status() != $res->incidencia){
                                            $order->update_status($res->incidencia);
                                        }
                                        break;
                            }

                            
                        }  
                        
                        $columns = [
                            'estado' => $estado,
                        ];
        
                        $where = [
                            'albaran' => $albaran,
                        ];                
                        //Función de Wordpress para actualizar un resgistro en DB
                        $actualizarEstado = $this->db->update(UBILOP_TABLE_DATA, $columns, $where);
                        wp_clear_scheduled_hook( 'fact_init_cron' );
                 } 

        }

        $json = json_encode([
            'result' => $result

        ]);
        echo $json;
        die();
         

    } 

   
    

    

    public function ajax_email_fact(){

        $tienda = get_option('blogname');
        $direccion = get_option('woocommerce_store_address') . ' ' . get_option('woocommerce_store_address_2');
        $poblacion = get_option('woocommerce_store_city');
        $codPostal = get_option('woocommerce_store_postcode');
        $email = get_option('admin_email');
        $telefono = get_option('woocommerce_store_phone');
        $url = get_option('siteurl');


            $json = json_encode([
                'success' => 'OK',
                'tienda' => $tienda,
                'direccion' => $direccion,
                'poblacion' => $poblacion,
                'email' => $email,
                'telefono' => $telefono
            ] );

        
    

        echo $json;
        wp_die();

        
    }

    /**
     * función para guardar y actualizar los daton de configuracón y conexión al Fact
     */
    public function ajax_crud_fact()
    {

       
        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);

            if ($tipo == 'add') {

                // se establce el insert-into con los campos de la tabla y sus respectivos valores
                $columns = [
                    'codigo_cliente' => $codigo_cliente,
                    'clave' => $clave,
                    'url_ws' => $url_ws,
                    'url_iris' => $iris,
                    'estado' => true,
                ];

                //Función de Wordpress para insertar un resgistro en DB
                $result = $this->db->insert(UBILOP_TABLE_CONFIG, $columns);

                $json = json_encode([
                    'result' => $result,
                    'codigo_cliente' => $codigo_cliente,
                    'clave' => $clave,
                    'url_ws' => $url_ws,
                    'insert_id' => $this->db->insert_id
                ]);
            }
            if ($tipo == 'update') {

                $columns = [
                    'codigo_cliente' => $codigo_cliente,
                    'clave' => $clave,
                    'url_ws' => $url_ws,
                    'url_iris' => $iris,
                    'estado' => true,
                ];

                $where = [
                    'id' => $id,
                ];

                //Función de Wordpress para actualizar un resgistro en DB
                $result = $this->db->update(UBILOP_TABLE_CONFIG, $columns, $where);

                $json = json_encode([
                    'result' => $result,
                    'codigo_cliente' => $codigo_cliente,
                    'clave' => $clave,
                    'url_ws' => $url_ws,
                    'insert_id' => $id
                ]);
            }

            echo $json;
            wp_die();
        }
    }

    /**
     * función para recuperar los datos de un envío mediante ws fact
     */
    public function ajax_order_fact()
    {

        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);


            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            //pasando los parámetros a un array
            $param = array(
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG,
                '_AlbaranNumero' => $albaran,
                '_Referencia1' => "",
                '_Referencia2' => ""
            );

            //llamando al método y pasándole el array con los parámetros
            $resultado = $client->call('RecuperarEnvio', $param);

            //si ocurre algún error al consumir el Web Service
            if ($client->fault) { // si
                $error = $client->getError();
                if ($error) { // Hubo algun error

                    echo 'Error:  ' . $client->faultstring;
                }

                die();
            }

            $result1 = $resultado['RecuperarEnvioResult'];

            $value = $result1['Value'];


            $keyValues = array();

            $i = 0;
            while ($i <= count($value)) {
                $llave = key($value);
                if ($llave != "EstadoDetalle") {
                    $keyValues[$i] = $llave . ":    " . $value[$llave] . "<br><hr>";
                    $i++;
                }

                next($value);
            }

            $json = json_encode([

                'llaves' => $keyValues
            ]);

            echo $json;
            wp_die();
        }
    }

    /**
     * función para recuperar los datos de un envío mediante ws fact
     */
    public function ajax_recogida_fact()
    {

        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);


            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            //pasando los parámetros a un array
            $param = array(
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG,
                '_RecogidaNumero' => $recogida,
                '_Referencia1' => "",
                '_Referencia2' => ""
            );

            //llamando al método y pasándole el array con los parámetros
            $resultado = $client->call('RecuperarRecogida', $param);

            //si ocurre algún error al consumir el Web Service
            if ($client->fault) { // si
                $error = $client->getError();
                if ($error) { // Hubo algun error

                    echo 'Error:  ' . $client->faultstring;
                }

                die();
            }

            $result1 = $resultado['RecuperarRecogidaResult'];

            $value = $result1['Value'];


            $keyValues = array();

            $i = 0;
            while ($i <= count($value)) {
                $llave = key($value);
                if ($llave != "EstadoDetalle") {
                    $keyValues[$i] = $llave . ":    " . $value[$llave] . "<br><hr>";
                    $i++;
                }

                next($value);
            }

            $json = json_encode([

                'llaves' => $keyValues
            ]);

            echo $json;
            wp_die();
        }
    }
    

    /**
     * función para recuperar los estados de un envío mediante ws fact
     */
    public function ajax_list_fact()
    {

        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);


            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            if($tipo != 'viewReturn'){

                //pasando los parámetros a un array
                $param = array(
                    '_Usuario' => UBILOP_COD_CONFIG,
                    '_Clave' => UBILOP_CLAVE_CONFIG,
                    '_AlbaranNumero' => $albaran
                );

                //llamando al método y pasándole el array con los parámetros
                $resultado = $client->call('HistorialEstadosEnvio', $param);

                //si ocurre algún error al consumir el Web Service
                if ($client->fault) { // si
                    $error = $client->getError();
                    if ($error) { // Hubo algun error

                        echo 'Error:  ' . $client->faultstring;
                    }

                    die();
                }

                $result = $resultado['HistorialEstadosEnvioResult'];

            }else{

                //pasando los parámetros a un array
                $param = array(
                    '_Usuario' => UBILOP_COD_CONFIG,
                    '_Clave' => UBILOP_CLAVE_CONFIG,
                    '_RecogidaNumero' => $recogida
                );

                //llamando al método y pasándole el array con los parámetros
                $resultado = $client->call('HistorialEstadosRecogida', $param);

                //si ocurre algún error al consumir el Web Service
                if ($client->fault) { // si
                    $error = $client->getError();
                    if ($error) { // Hubo algun error

                        echo 'Error:  ' . $client->faultstring;
                    }

                    die();
                }

                $result = $resultado['HistorialEstadosRecogidaResult'];

            }

            
            $keyValues = array();

            if (isset($result['Value']['EstadoInfoWSVO'])) {

                $value = $result['Value']['EstadoInfoWSVO'];

                if ($value[0] == null) {

                    $detalle = preg_replace('([^A-Za-z0-9])', ' ', $value['DetalleEstado']);

                    if ($value['DetalleEstado'] != "") {
                        $keyValues = "<tr><td>" . $value['FechaRegistro'] . "</td><td>" . $value['Estado'] . "</td><td>" . $detalle . "</td></tr>";
                    } else {
                        $keyValues = "<tr><td>" . $value['FechaRegistro'] . "</td><td>" . $value['Estado'] . "</td><td></td></tr>";
                    }
                } else {
                    for ($i = 0; $i < count($value); $i++) {

                        $detalle = preg_replace('([^A-Za-z0-9])', ' ', $value[$i]['DetalleEstado']);

                        if ($value[$i]['DetalleEstado'] != "") {
                            $keyValues[$i] = "<tr><td>" . $value[$i]['FechaRegistro'] . "</td><td>" . $value[$i]['Estado'] . "</td><td>" . $detalle . "</td></tr>";
                        } else {
                            $keyValues[$i] = "<tr><td>" . $value[$i]['FechaRegistro'] . "</td><td>" . $value[$i]['Estado'] . "</td><td></td></tr>";
                        }
                    }
                }
            } else {
                $keyValues = 'Sin estados';
            }


            $json = json_encode([

                'estados' => $keyValues
            ]);

            echo $json;
            wp_die();
        }
    }

    /**
     * función para recuperar la etiqueta PDF de un envío mediante ws fact
     */
    public function ajax_label_fact()
    {


        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);

            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');
            if($tipo != 'viewReturn'){

                //pasando los parámetros a un array
                $param = array(
                    '_Usuario' => UBILOP_COD_CONFIG,
                    '_Clave' => UBILOP_CLAVE_CONFIG,
                    '_AlbaranNumero' => $albaran,
                    '_EtiquetaTermica' => true,
                    '_CuadranteInicial' => 1

                );

                //llamando al método y pasándole el array con los parámetros
                $resultado = $client->call('EtiquetaEnvioImprimirPDF', $param);
                $result1 = $resultado['EtiquetaEnvioImprimirPDFResult'];

            }else{

                //pasando los parámetros a un array
                $param = array(
                    '_Usuario' => UBILOP_COD_CONFIG,
                    '_Clave' => UBILOP_CLAVE_CONFIG,
                    '_RecogidaNumero' => $recogida,
                    '_EtiquetaTermica' => true,
                    '_CuadranteInicial' => 1

                );

                //llamando al método y pasándole el array con los parámetros
                $resultado = $client->call('EtiquetaRecogidaImprimirPDF', $param);
                $result1 = $resultado['EtiquetaRecogidaImprimirPDFResult'];

            }
           

            //si ocurre algún error al consumir el Web Service
            if ($client->fault) { // si
                $error = $client->getError();
                if ($error) { // Hubo algun error

                    echo 'Error:  ' . $client->faultstring;
                }

                die();
            }

            
            $info = utf8_encode($result1['Info']);
            if ($result1['CodigoError'] == 0) {

                $json = json_encode([
                    'info' => $info,
                    'etiqueta' => $result1['Value']
                ]);
            } else {
                $json = json_encode([
                    'error' => $result1['CodigoError'],
                    'mensaje' => $info
                ]);
            }

            echo $json;
            wp_die();
        }
    }

    /**
     * función para recuperar las etiqueta PDF en masivo
     */
    public function ajax_masive_fact()
    {


        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);

            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            //pasando los parámetros a un array
            $param = array(
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG,
                '_AlbaranDesde' => $albaDesde,
                '_AlbaranHasta' => $albaHasta,
                '_fecha' => date("Y-m-d"),
                '_EtiquetaTermica' => true,
                '_cuadranteInicial' => 1

            );

            //llamando al método y pasándole el array con los parámetros
            $resultado = $client->call('EtiquetaEnvioImprimirMasivoPDF', $param);

            //si ocurre algún error al consumir el Web Service
            if ($client->fault) { // si
                $error = $client->getError();
                if ($error) { // Hubo algun error

                    echo 'Error:  ' . $client->faultstring;
                }

                die();
            }

            $result1 = $resultado['EtiquetaEnvioImprimirMasivoPDFResult'];

            $info = utf8_encode($result1['Info']);

            if ($result1['CodigoError'] == 0) {

                $json = json_encode([
                    'info' => $info,
                    'etiqueta' => $result1['Value']
                ]);
            } else {
                $json = json_encode([
                    //'info' => $result1['Info'],
                    'error' => $info
                ]);
            }

            echo $json;
            wp_die();
        }
    }


    /**
     * función para recuperar el manifiesto de un envío mediante ws fact
     */
    public function ajax_manifest_fact()
    {


        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);


            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            //pasando los parámetros a un array
            $param = array(
                
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG,
                '_ImpresionUsuario' => true

            );

            //llamando al método y pasándole el array con los parámetros
            $resultado = $client->call('ManifiestoEnviosPDF', $param);

            //si ocurre algún error al consumir el Web Service
            if ($client->fault) { // si
                $error = $client->getError();
                if ($error) { // Hubo algun error

                    echo 'Error:  ' . $client->faultstring;
                }

                die();
            }

            $result1 = $resultado['ManifiestoEnviosPDFResult'];
            $info = utf8_encode($result1['Info']);
            if ($result1['Ok'] == true) {

                $json = json_encode([
                    'etiqueta' => $result1['Value']
                ]);
            } else {
                $json = json_encode([
                    'mensaje' => $info
                ]);
            }

            echo $json;
            wp_die();
        }
    }

    /**
     * función para recuperar los servicios autorizados por cliente
     */
    public function ajax_service_fact()
    {


        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);


            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            //pasando los parámetros a un array
            $param = array(
                
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG
            );

            //llamando al método y pasándole el array con los parámetros
            $resultado = $client->call('ListaServiciosAutorizados', $param);

            //si ocurre algún error al consumir el Web Service
            if ($client->fault) { // si
                $error = $client->getError();
                if ($error) { // Hubo algun error

                    echo 'Error:  ' . $client->faultstring;
                }

                die();
            }

            $result1 = $resultado['ListaServiciosAutorizadosResult'];
            $info = utf8_encode($result1['Info']);
            if ($result1['Ok'] == true) {

                $json = json_encode([
                    'servicios' => $result1['Value']
                ]);
            } else {
                $json = json_encode([
                    'mensaje' => $info
                ]);
            }

            echo $json;
            wp_die();
        }
    }

    /**
     * función para recuperar los remitentes
     */
    public function ajax_senders_fact()
    {


        check_ajax_referer('factdata_seg', 'nonce');

        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);


            $sql = "SELECT * FROM " . UBILOP_TABLE_SENDER ;
            $result = $this->db->get_results($sql);


            if ($result) {

                $json = json_encode([
                    'remitentes' => $result
                ]);
            } else {
                $json = json_encode([
                    'mensaje' => $info
                ]);
            }

            echo $json;
            wp_die();
        }
    }

    /**
     * función que graba los datos del remitente predeteminado
     */
    public function ajax_sender_fact()
    {
        check_ajax_referer('factdata_seg', 'nonce');
        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);

            if ($tipo == 'add') {
            // definimos los campos de la tabla y los valores a insertar en DB
                    $columns = [
                        'nombre' => $nombre,
                        'direccion' => $direccion,
                        'poblacion' => $poblacion,
                        'cod_postal' => $codigo,
                        'pais' => $pais,
                        'telefono' => $telefono,
                        'email' => $email,
                        'contacto' => $contacto,
                        'observaciones' => $observaciones,
                        'servicio' => $servicio,
                        'estado' => $estado,
                    ];

                    if($estado == 1){
    
                        $table = UBILOP_TABLE_SENDER;

                        $sql = "UPDATE ". $table . " SET estado = 0 WHERE estado = 1" ;

                        $this->db->query($sql);
                    }

                    //Función de Wordpress para insertar un resgistro en DB
                    $result = $this->db->insert(UBILOP_TABLE_SENDER, $columns);


                    if ($result) {

                        $json = json_encode([
                            'result' => $result,
                            'observa' => $observaciones
                        ]);
                       
                        }
                    }elseif ($tipo == 'update') {

                        $columns = [
                        'nombre' => $nombre,
                        'direccion' => $direccion,
                        'poblacion' => $poblacion,
                        'cod_postal' => $codigo,
                        'pais' => $pais,
                        'telefono' => $telefono,
                        'email' => $email,
                        'contacto' => $contacto,
                        'observaciones' => $observaciones,
                        'servicio' => $servicio,
                        'estado' => $estado,
                        ];
        
                        $where = [
                            'id' => $remitente,
                        ];
                               

                        if($estado == 1){
    
                            $table = UBILOP_TABLE_SENDER;

                            $sql = "UPDATE ". $table . " SET estado = 0 WHERE estado = 1" ;
    
                            $this->db->query($sql);
                        }

                        //Función de Wordpress para actualizar un resgistro en DB
                        $result = $this->db->update(UBILOP_TABLE_SENDER, $columns, $where);
        
                        $json = json_encode([
                            'result' => $result,
                            'observa' => $observaciones
                        ]);
                    }
                    echo $json;
                    wp_die();

        }
    }

    /**
     * función que graba los parametros para la ejecución de la función programada cron para actualizar estados
     */
    public function ajax_cron_fact()
    {
        check_ajax_referer('factdata_seg', 'nonce');
        if (current_user_can('manage_options')) {

            extract($_POST, EXTR_OVERWRITE);

            if ($tipo == 'add') {
            // definimos los campos de la tabla y los valores a insertar en DB
                    $columns = [
                        'documentado' => $documentado,
                        'transmitido' => $transmitido,
                        'procesado' => $procesado,
                        'transito' => $transito,
                        'reparto' => $reparto,
                        'entregado' => $entregado,
                        'cancelado' => $cancelado,
                        'incidencia' => $incidencia,
                        'hora' => $hora,

                    ];

                    //Función de Wordpress para insertar un resgistro en DB
                    $result = $this->db->insert(UBILOP_TABLE_CRON, $columns);

                    if ($result) {

                        $json = json_encode([
                            'result' => $result
                        ]);
                       
                        }
                    }elseif ($tipo == 'update') {

                        $columns = [
                        'documentado' => $documentado,
                        'transmitido' => $transmitido,
                        'procesado' => $procesado,
                        'transito' => $transito,
                        'reparto' => $reparto,
                        'entregado' => $entregado,
                        'cancelado' => $cancelado,
                        'incidencia' => $incidencia,
                        'hora' => $hora,
                        ];
        
                        $where = [
                            'id' => $cron,
                        ];
        
                        //Función de Wordpress para actualizar un resgistro en DB
                        $result = $this->db->update(UBILOP_TABLE_CRON, $columns, $where);
        
                        $json = json_encode([
                            'result' => $result
                        ]);
                    }
                    wp_clear_scheduled_hook( 'fact_init_cron' );
                    echo $json;
                    wp_die();

        }
    }

    

    /**
     * función para grabar el envio en el Fact mediante webservice y de ser true guardar detalles en db
     */
    public function ajax_send_fact()
    {

        check_ajax_referer('factdata_seg', 'nonce');
        $id_orden = "";

        if (current_user_can('manage_options')) {

            

            extract($_POST, EXTR_OVERWRITE);

            

            if($idsender != ''){

                $sql = "SELECT * FROM " . UBILOP_TABLE_SENDER . " WHERE id = " . $idsender;
                $res = $this->db->get_row($sql);

            }else{

                $sql = "SELECT * FROM " . UBILOP_TABLE_SENDER . " WHERE estado = 1 ";
                $res = $this->db->get_row($sql);

            }

            $id_orden = $order;

            // Get an instance of the WC_Order object
            $ordep = new WC_Order( $id_orden );
            $orden = wc_get_order( $id_orden ); //$order_id
            $order_data = $orden->get_data(); // The Order data

            //intanciamos la clase de la libreria nusoap para grabar datos de la orden en el WS
            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            $albaran = "0";
            $dcode = "";

            if($servicio == ''){

                $acode = $res->servicio;

            }else{

                $acode = $servicio;
            }

            $fecha_actual = date("Y-m-d", strtotime("+ 1 hours"));
            $fecha = date("Y-m-d", strtotime($fecha_actual . "+ 1 days"));
            if($res){
                $nombreR = $res->nombre;
                $direccionR = $res->direccion;
                $poblacionR = $res->poblacion;
                $codPostalR = $res->cod_postal;
                $paisR = $res->pais;
                $telefonoR = $res->telefono;
                $emailR = $res->email;
                $contactoR = $res->contacto;
                $observaciones = $res->observaciones;

            }else{
                $nombreR = get_option('blogname');
                $direccionR = get_option('woocommerce_store_address') . ' ' . get_option('woocommerce_store_address_2');
                $poblacionR = get_option('woocommerce_store_city');
                $codPostalR = get_option('woocommerce_store_postcode');
                $emailR = get_option('admin_email');
                $paisR = '';
                $telefonoR = '';
                $contactoR = '';
            }
            
            if($pais == ""){$pais = 'ESP';}
            
            if ($order_data['shipping']['first_name'] != "" && $order_data['shipping']['postcode'] != "" && $pobalcionD = $order_data['shipping']['city'] != ""){

                $nombreD = $order_data['shipping']['first_name'] . ' ' . $order_data['shipping']['last_name'];
                $direccionD = $order_data['shipping']['address_1'] . ' ' . $order_data['shipping']['address_2'];
                $pobalcionD = $order_data['shipping']['city']; //$order_data['shipping']['state'];
                $codPostalD = $order_data['shipping']['postcode'];
                $paisD = $order_data['shipping']['country'];
            }else{
                $nombreD = $order_data['billing']['first_name'] . ' ' . $order_data['billing']['last_name'];
                $direccionD = $order_data['billing']['address_1'] . ' ' . $order_data['billing']['address_2'];
                $pobalcionD = $order_data['billing']['city']; //$order_data['shipping']['state'];
                $codPostalD = $order_data['billing']['postcode'];
                $paisD = $order_data['billing']['country'];
            }
            
            if ($paisD == 'ES') {
                $interD = false;
            } else {
                $interD = true;
            }
            $telefonoD = $order_data['billing']['phone'];

            $emailD = $order_data['billing']['email'];;
            $emailSend = false;

                if($emailD != "")
                    $emailSend = true;
 
            $order_payment_method = $order_data['payment_method'];
            $total = $order_data['total'];
            $envio = $order_data['shipping_total'];
            if ($seguro == "") {
                $valor = 0;
                $valorar = false;
            }else{
                $valor = $total - $envio;
                $valorar = true;
            }
            $rembolso = 0;
            $portesD = $portes;
            if ($order_payment_method == 'cod' && $portesD == 'false') {
                 $rembolso = $total - $envio;
            }else if($order_payment_method == 'cod' && $portesD == 'true'){
                 $rembolso = $total;
            }

            $debidos = false;
            $bult = $bultos;
            $alto = $alt;
            $ancho = $anch;
            $largo = $larg;
        

            if($pes != null){

                $peso = $pes;

            }else{

                    $items = $orden->get_items();
                    $weight= 0;
                    $product_weight = 0;
                    if (is_array($items)) {

                        foreach ( $items as $item ) {
                            
                            
                            $product = wc_get_product( $item['product_id'] );
                            
                            if($product){
                                
                                $quantity = $item->get_quantity();

                                //Verificamos si es un producto variable o simple para calcular el peso total de la orden                                
                                if( $product->is_type( 'variable' ) ){
                                    
                                     
                                    $vatiation_ids = $product->get_children();
                                    
                                    foreach ( $vatiation_ids as $variation_id ) {                                        
                                        
                                        $variation = wc_get_product( $variation_id ); // Get the product variation object

                                        if(is_bool($variation->get_weight()) === false){
                                            $itemsName = $item->get_name();
                                            $variationName = $variation->get_name();
                                            //$id = $variation->get_id();
                                            if($itemsName == $variationName){

                                                if (is_numeric($variation->get_weight())) {
                                                    if(!empty($variation->get_weight()))
                                                    $peso += $variation->get_weight() * $quantity; // Get weight from variation;
                                                }
                                                                                               
                                                //print_r($weight);
                                            }
                                            
                                            
                                        }else{
                                            $peso = 1;
                                        } 
                                                                                                               
                                    }
                                    
                                }else{
                                     

                                    if(is_bool($product->get_weight()) === false){
                                        $product_weight = $product->get_weight();
                                    }else{
                                        $product_weight = 0;
                                    } 
                                    
                                    if (is_numeric($product_weight)) {
                                        if(!empty($product_weight))
                                        $peso += $product_weight * $quantity;
                                    }
                                }                        
                                

                            }
                            
                        }

                    }

                

            }

            if($peso == 0){
                $peso = 1;
            }

            $observacion = "";

            $productos = $orden->get_items();

            $productName = '';
            $productSku = '';
            $productSku1 = '';

            if (is_array($productos)) {
                $productToolTip = '';
                foreach ($productos as $producto) {

                    $productName .= $producto['name'] . ',  ';
                    $product = new WC_Product($producto['product_id']);
                    // SKU
                    $SKU = $product->get_sku();
                    $productSku .= $SKU . ',  ';
                }
            } else {
                _e('Unable get the products', 'woocommerce');
            }

            if ($order_data['customer_note'] == ""){

            if ($observaciones != "") {

                if($observaciones == 'name'){
                    
                    $observacion = $productName;                   

                }else if ($observaciones == 'sku'){

                    $observacion = $productSku; 
                }
            }
        }else{

                $observacion = $order_data['customer_note'];
            
        }


        

        $sql1 = "SELECT * FROM " . UBILOP_TABLE_DATA . " WHERE id_orden = " . $id_orden . " AND ruta = ". UBILOP_WS_CONFIG;
        $res1 = $this->db->get_row($sql1);

        if(!$res1){



            //pasando los parámetros a un array
            $param = array(
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG,
                '_AlbaranNumero' => $albaran,
                '_DepartamentoCodigo' => $dcode,
                '_ArticuloCodigo' => $acode,
                '_Fecha' => $fecha_actual,
                '_Observaciones' => $observacion,
                '_Referencia1' => $id_orden,
                '_Referencia2' => "",
                '_RNombre' => $nombreR,
                '_RVia' => "",
                '_RDireccion' => $direccionR,
                '_RNumero' => "",
                '_RPiso' => "",
                '_RPoblacion' => $poblacionR,
                '_RCodigoPostal' => $codPostalR,
                '_RPais' => $paisR,
                '_RTelefono' => $telefonoR,
                '_REmail' => $emailR,
                '_RContacto' => $contactoR,
                '_RInternacional' => false,
                '_DNombre' => $nombreD,
                '_DVia' => "",
                '_DDireccion' => $direccionD,
                '_DNumero' => "",
                '_DPiso' => "",
                '_DPoblacion' => $pobalcionD,
                '_DCodigoPostal' => $codPostalD,
                '_DPais' => $paisD,
                '_DTelefono' => $telefonoD,
                '_DEmail' => $emailD,
                '_DContacto' => "",
                '_DIdentificacion' => "",
                '_DIdentificacionRequerida' => false,
                '_DInternacional' => $interD,
                '_Bultos' => $bult,
                '_Alto' => $alto,
                '_Ancho' => $ancho,
                '_Largo' => $largo,
                '_Peso' => $peso,
                '_PortesDebido' => $debidos,
                '_SabadoEntrega' => false,
                '_AcuseCon' => false,
                '_RetornoCon' => false,
                '_GestionOrigen' => false,
                '_GestionDestino' => false,
                '_EnvioControlCon' => false,
                '_EscaneoAlbaranClienteCon' => false,
                '_Reembolso' => $rembolso,
                '_Valor' => $valor, //seguro del producto-paquete
                '_ValorarEnvio' => $valorar,
                '_GenerarRecogida' => false,
                '_ForzarCanalizacionPorCP' => false,
                '_NotificacionesPorSMSOrigen' => false,
                '_NotificacionesPorSMSDestino' => false,
                '_NotificacionesPorEmailOrigen' => false,
                '_NotificacionesPorEmailDestino' => $emailSend,
                '_RetornoOpcional' =>  false,
                '_MensajeroPreasignado' =>  "",
                '_OrigenDatos' => "MOD_WOOCOMMERCE",
                '_Contenido' => ""
            );

            //llamando al método y pasándole el array con los parámetros
            $resultado = $client->call('GrabarEnvio8', $param);

            //si ocurre algún error al consumir el Web Service
            if ($client->fault) { // si
                $error = $client->getError();
                if ($error) { // Hubo algun error

                    echo 'Error:  ' . $client->faultstring;
                }

                die();
            }

            $result1 = $resultado['GrabarEnvio8Result'];

            while($result1 == true){

            if ($result1) {
                
                //se usa para quitar los caracteres especiales que devuelve el value Info del Ws y no lance error el ajax
                $info = utf8_encode($result1['Info']);
                if ($result1['Info'] == 'OK') {

                    // definimos los campos de la tabla y los valores a insertar en DB
                    $columns = [
                        'id_orden' => $id_orden,
                        'fecha' => $fecha_actual,
                        'albaran' => $result1['Value']['Albaran'],
                        'cliente' => UBILOP_COD_CONFIG,
                        'estado' => $result1['Value']['Estado'],
                        'seguimiento' => $result1['Value']['CodigoSeguimiento'],
                        'ruta' => UBILOP_WS_CONFIG,
                        'devuelto' => false
                    ];

                    //Función de Wordpress para insertar un resgistro en DB
                    $result3 = $this->db->insert(UBILOP_TABLE_DATA, $columns);

                    if ($result3) {

                       
                        $sqlc = "SELECT * FROM " . UBILOP_TABLE_CRON;
                        $resc = $this->db->get_row($sqlc);
                        if($resc->documentado != ""){

                            $orden->update_status($resc->documentado);
                        }


                        $json = json_encode([
                            'albaran' => $result1['Value']['Albaran'],
                            'idOrden' => $id_orden,
                            'result' => $order_data,
                            'fecha actual' => $fecha_actual,
                            'infoWs' => $info,
                            'fact' => true,
                            'param' => $param,
                            'insert_id_factdata' => $this->db->insert_id,
                            'metodo_tipo' =>  $order_payment_method,
                            'metodo_nombre' =>  $order_payment_method,
                            'productsku' => $productSku
                        ]);

                        //$estado = new WC_Order($id_orden);
                        
                        echo $json;
                        wp_die();
                    }
                } else {


                    $json = json_encode([
                        'infoWs' => $info,
                        'pais' => $paisD,
                        'result' => $order_data,
                        'fact' => false

                    ]);

                    echo $json;
                    wp_die();
                }
            } 
        }
        
        } 
        
            $json = json_encode([
                'infoWs' => '',
                'error' => '',
                'result' => ''

            ]);

            echo $json;
            wp_die();

        }
    }


    /**
     * función para generar una recogida en el Fact mediante una orden con solicitud de devolución
     */
    public function ajax_return_fact()
    {

        check_ajax_referer('factdata_seg', 'nonce');
        $id_orden = "";

        if (current_user_can('manage_options')) {

           // $sql = "SELECT * FROM " . UBILOP_TABLE_SENDER;
           // $res = $this->db->get_row($sql);

            extract($_POST, EXTR_OVERWRITE);

            $return = $albaran;

            //intanciamos la clase de la libreria nusoap para grabar datos de la orden en el WS
            $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');

            //llamando al método y pasándole el array con los parámetros
            //pasando los parámetros a un array
            $param = array(
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG,
                '_AlbaranNumero' => $return,
                '_Referencia1' => "",
                '_Referencia2' => ""
            );

            //llamando al método y pasándole el array con los parámetros
            $resultado = $client->call('RecuperarEnvio', $param);

            $result = $resultado['RecuperarEnvioResult'];

            $result1 = $result['Value']; 

            

            $recogida = "0";
            $fecha_actual = date("Y-m-d");
            $fecha = date("Y-m-d", strtotime($fecha_actual . "+ 1 days"));
            
            if($origen == "on"){

                $name = $nombre;
                $direction = $direccion;
                $population = $poblacion;
                $postalCode = $postal;
                $country = $pais;
                $phone = $telefono;
                
            }else{
               

                $name = $result1['RNombre'];
                $direction = $result1['RDireccion'];
                $population = $result1['RPoblacion'];
                $postalCode = $result1['RCodigoPostal'];
                $country = $result1['RPais'];
                $phone = $result1['RTelefono'];
            }

               
    


            //pasando los parámetros a un array
            $param=array(
                '_Usuario' => UBILOP_COD_CONFIG,
                '_Clave' => UBILOP_CLAVE_CONFIG, 
                '_RecogidaNumero' => $recogida, 
                '_DepartamentoCodigo' => '', 
                '_ArticuloCodigo' => $result1['ArticuloCodigo'], 
                '_VehiculoCodigo' => 2, //pasar parametro de configuración
                '_HoraMaxima' => '18:00', '_HoraMaxima2' => '', 
                '_HoraMinima' => '09:00', '_HoraMinima2' => '', 
                '_FechaRecogida' => $fecha, 
                '_ObservacionesRecogida' => 'Devolucion',
                '_ObservacionesEntrega' => 'Devolucion', 
                '_Referencia1' => $result1['Referencia1'], 
                '_Referencia2' => $result1['Albaran'],
                '_RNombre' => $result1['DNombre'], 
                '_RDireccion' => $result1['DDireccion'], 
                '_RPoblacion' => $result1['DPoblacion'], 
                '_RCodigoPostal' => $result1['DCodigoPostal'],
                '_RPais' => $result1['DPais'], 
                '_RTelefono' => $result1['DTelefono'], 
                '_REmail' => $result1['DEmail'], 
                '_RContacto' => $result1['DContacto'], 
                '_RInternacional' => $result1['DInternacional'], 
                '_DNombre' => $name, 
                '_DDireccion' => $direction, 
                '_DPoblacion' =>   $population, 
                '_DCodigoPostal' => $postalCode, 
                '_DPais' => $country,
                '_DTelefono' => $phone, 
                '_DEmail' => '', 
                '_DContacto' => '', 
                '_DIdentificacion' => '', 
                '_DIdentificacionRequerida' => false, 
                '_DInternacional' => $result1['RInternacional'], 
                '_Bultos' => $result1["Bultos"],
                '_Alto' => $result1["Alto"], 
                '_Ancho' => $result1["Ancho"], 
                '_Largo' => $result1["Largo"], 
                '_Peso' => $result1["Peso"],
                '_SabadoEntrega' => false, 
                '_RetornoCon' => false, 
                '_GestionOrigen' => false, 
                '_GestionDestino' => false, 
                '_EnvioControlCon' => false, 
                '_Reembolso' => 0, 
                '_ValorMercancia' => 0, 
                '_Anticipo' => 0, 
                '_DuaValor' => 0,
                '_ForzarCanalizacionPorCP' => true,
                '_NotificacionesPorSMSOrigen' => false,
                '_NotificacionesPorSMSDestino' => false,
                '_NotificacionesPorEmailOrigen' => false,
                '_NotificacionesPorEmailDestino' => false

            );

            //llamando al método y pasándole el array con los parámetros
            $resultado = $client->call('GrabarRecogida5', $param);
        
            //si ocurre algún error al consumir el Web Service
            if ($client->fault) { // si
                $error = $client->getError();
            if ($error) { // Hubo algun error

                    echo 'Error:  ' . $client->faultstring;
                }
                
                die();
            }
                
            $result2 = $resultado['GrabarRecogida5Result'];
            //se usa para quitar los caracteres especiales que devuelve el value Info del Ws y no lance error el ajax
            $info = utf8_encode($result2['Info']);

                    if ($result2) {                       
                        
                        if ($result2['Info'] == 'OK') {

                            $columns = [
                                'estado' => 'DEVUELTO',
                                'devuelto' => 1,
                            ];
            
                            $where = [
                                'albaran' => $return,
                            ]; 

                            $this->db->update(UBILOP_TABLE_DATA, $columns, $where);

                            // definimos los campos de la tabla y los valores a insertar en DB
                            $columns = [
                                'id_orden' => $result1['Referencia1'],
                                'fecha' => $fecha_actual,
                                'recogida' => $result2['Value']['Recogida'],
                                'cliente' => UBILOP_COD_CONFIG,
                                'estado' => $result2['Value']['Estado'],
                                'seguimiento' => $result2['Value']['CodigoSeguimiento'],
                                'ruta' => UBILOP_WS_CONFIG
                            ];                           

                            //Función de Wordpress para insertar un resgistro en DB
                            $result3 = $this->db->insert(UBILOP_TABLE_RETURN, $columns);

                            if ($result3) {

                            
                                /*$sqlc = "SELECT * FROM " . UBILOP_TABLE_CRON;
                                $resc = $this->db->get_row($sqlc);
                                if($resc->documentado != ""){

                                    $orden->update_status($resc->documentado);
                                } */


                                $json = json_encode([
                                    'recogida' => $result2['Value']['Recogida'],
                                    'infoWs' => $info,
                                    'fact' => true,
                                    'insert_id_factdata' => $this->db->insert_id
                                ]);

                                //$estado = new WC_Order($id_orden);
                                
                                echo $json;
                                wp_die();
                            }
                        } else {


                            $json = json_encode([
                                'infoWs' => $info

                            ]);

                            echo $json;
                            wp_die();
                }
            } else {

                $json = json_encode([
                    'infoWs' => $info

                ]);

                echo $json;
                wp_die();

            }          
        }
    }
    
}
