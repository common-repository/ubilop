<?php
/**
 * Registrar todas las acciones y filtros para el complemento
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
 * @property array $actions
 * @property array $filters
 */

class FACT_Cron {

    

    public function intervalos( $intervalos ){

        global $wpdb;
        $this->db = $wpdb;

            $sql1 = "SELECT * FROM " . UBILOP_TABLE_CRON;
            $res = $this->db->get_row($sql1);

            if(is_null($res->hora)){
                $horas = 1000;
            }else{
                
                $horas = $res->hora;
            }
            
            $minutos = $horas * 60 ;
            $segundos = $minutos * 60;

            //add_filter( 'cron_schedules', 'example_add_cron_interval' );
            
            $intervalos['establecido'] = array(
            'interval' => $segundos,
            'display'  => esc_html__( 'Cada '.$segundos.' segundos' ), );
            
            
            return $intervalos;

            

    }

    public function inicializador(){

            if (! wp_next_scheduled ( 'fact_init_cron' )) {
                wp_schedule_event( time()+10, 'establecido', 'fact_init_cron' );
            
        }
        
    }

    public function actualizadorEstados(){
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

    }

}

