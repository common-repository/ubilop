<?php

/**
  * Proporcionar una vista de área de administración para el plugin
  *
  * Este archivo se utiliza para marcar los aspectos de administración del plugin.
  *
  * @link http://ubilop.com
  * @since desde 0.0.1
  *
 * @package    ubilop-plugin-wp
 * @subpackage ubilop-plugin-wp/admin/parcials
  *
  * Este archivo debe consistir principalmente en HTML con un poco de PHP. 
 */



$sql = "SELECT * FROM " . UBILOP_TABLE_CONFIG;
$result = $this->db->get_results($sql);

$sql1 = "SELECT * FROM " . UBILOP_TABLE_SENDER . " WHERE estado = 1";
$result1 = $this->db->get_results($sql1);
$dir = UBILOP_PLUGIN_DIR_URL;

 
         foreach ($result1 as $k => $v) { 
        $idRemi = sanitize_text_field($v->id); 
        $nombre = sanitize_text_field($v->nombre);
        $direccion = sanitize_text_field($v->direccion);
        $poblacion = sanitize_text_field($v->poblacion);
        $codPostal = sanitize_text_field($v->cod_postal);
        $pais = sanitize_text_field($v->pais);
        $telefono = sanitize_text_field($v->telefono);
        $email = sanitize_text_field($v->email);
        $contacto = sanitize_text_field($v->contacto);
        $observaciones = sanitize_text_field($v->observaciones);
        $servicio = sanitize_text_field($v->servicio);
        $estado = sanitize_text_field($v->estado);
     } 

$sql2 = "SELECT * FROM " . UBILOP_TABLE_CRON;
$result2 = $this->db->get_results($sql2);

        foreach ($result2 as $k => $v) { 
        $idCron = sanitize_text_field($v->id);
        $documentado = sanitize_text_field($v->documentado);
        $transmitido = sanitize_text_field($v->transmitido); 
        $procesado = sanitize_text_field($v->procesado);
        $transito = sanitize_text_field($v->transito);
        $reparto = sanitize_text_field($v->reparto);
        $entregado = sanitize_text_field($v->entregado);
        $cancelado = sanitize_text_field($v->cancelado);
        $incidencia = sanitize_text_field($v->incidencia);
        $hora = sanitize_text_field($v->hora);
    } 

?>
<style>
    #footer-thankyou {display:none;}
    #footer-upgrade {display:none;}

    @media (min-width: 700px) {
    .centrador{padding: 0 10rem;}
    .wth-caja {width:70%}
    }
    @media (max-width: 700px) {
    .wth-caja {width:90%}
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-s12">
            <h5><?php esc_html_e(get_admin_page_title()); ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <a class="add-fact-table btn-floating pulse">
                <i class="material-icons">add</i>
            </a>
            <span> Establecer Configuración de conexión con el FACT</span>

            

            
        </div>
        <div class="right-align">

        <a class="view_tuto waves-effect waves-light btn"><i class="material-icons right">ondemand_video</i>Tutorial</a>
        
        </div>
    </div>
    <div class="add-container"><br><br>
        <div class="row">
            <table class="responsive-table bordered">
                <thead>
                    <tr>
                        <th>Código Cliente</th>
                        <th>Clave Cliente</th>
                        <th>Web Service</th>
                        <th>Seguimiento</th>
                    </tr>
                    <?php

                    if (!$result) {
                        echo "
                            <tr id='' idRegistro=''>
                                <td id='' colspan='3' codigo=''>
                                    <h6>Haga Click en el Botón + para establecer su conexión al FACT, solicite sus credenciales contactando al departamento de soporte en <a href='https://ubilop.com' target='_blank'>Ubilop.com</a> </h6>
                                </td>
                            </tr>                
                            ";
                    }
                    ?>

                </thead>

                <tbody>

                
                    <?php

                    foreach ($result as $k => $v) {

                        $id = $v->id;
                        $codigo = $v->codigo_cliente;
                        $clave = $v->clave;
                        $ws = $v->url_ws;
                        $iris = $v->url_iris;

                        if ($id) {

                            echo "
                            <tr id='idR' idRegistro='$id'>
                                <td id='cod' codigo='$codigo'>$codigo</td>
                                <td id='cla' clave='$clave'>$clave</td>
                                <td id='wse' webService='$ws'>$ws</td>
                                <td id='iri' iris='$iris'>$iris</td>
                            </tr>
                            ";
                        }
                    }

                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="row">

            <table border="1" style=" border-collapse: collapse;">
                <?php

                
                //requerimos la libreria nusoap para manejo de webservice con php
                require_once UBILOP_PLUGIN_DIR_PATH . 'admin/lib/nusoap.php';


                //instanciando un nuevo objeto cliente para consumir el webservice
                $client = new nusoap_client($ws, 'wsdl');

                //llamando al método y pasándole el array con los parámetros
                $resultado = $client->call('ServidorInformacion');

                ?>
                <div class="listado-pendientes">

                    <table border="1" class="responsive-table bordered">
                        <thead>
                            <tr>
                             
                                <th>Estado</th>
                                <th>Agencia </th>
                                <th>Login</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rst = $resultado['ServidorInformacionResult'];
                        if ($rst) {
                            $result1 = $rst['Value'];
                            //se imprime la respuesta consultada al metodo en Lista


                            echo "<td width=''>";
                            echo $result1['ServidorEstado'];
                            echo "</td>";

                            echo "<td width=''>";
                            echo $result1['AgenciaNombre'];
                            echo "</td>";

                            $param = array(
								'_Usuario' => UBILOP_COD_CONFIG,
								'_Clave' => UBILOP_CLAVE_CONFIG
							);

							$resultado1 = $client->call('LoginTest', $param);

							if($resultado1){
								$rst1 = $resultado1['LoginTestResult'];
							}else{
								$rst1 = '';
							}

                            if($rst1['Ok'] == 'true' || $rst1['Ok'] == true){

                                echo "<td width=''> <i class='material-icons prefix ' style='color:#8bc34a'>done</i></td></tr> </br></br> ";

                            }else{

                                echo "<td width='' style='color:red'> X </td></tr> </br></br> ";

                            }

                            

                        } else {

                            echo "<tr ><td colspan='4' width=''>";
                            echo "Servidor no encontrado, establezca o verifique la url del WebService, puede solicitar sus credenciales contactando al departamento de soporte en <a href='http://ubilop.com' target='_blank'>Ubilop.com</a> ";
                            echo "</td></tr>";
                        }

                        ?>
                        <tbody>
                        </table>
                </div>
    </div>
    <br><br>
    
    <div class="row z-depth-3 wth-caja" >
        <ul id="tabs-swipe-demo" class="tabs" style="overflow:hidden;" >
            <li class="tab col s4"><a style="color:#848484" class="active" href="#test-swipe-1">Remitente</a></li>
            <li class="tab col s4" ><a style="color:#848484" href="#test-swipe-3">Parámetros de Configuración</a></li>
            <li class="tab col s4"><a style="color:#848484"  href="#test-swipe-2">Funciones Cron</a></li>
        </ul>
        
        <div class="z-depth-1">
            <div id="test-swipe-1" class="col s12 white">
                <div class="row">
                <div class="divider"></div>
                    <div class="section header">
                        <div class="col s12 m6 l4" >
                            <label style="margin-left:0" for="sltRemitente">Remitente</label>
                            <select data-sender="" id="sltRemitente"  value="<?php esc_html_e($servicio,'ubilop-plugin-wp') ?>" class="wc-enhanced-select browser-default tooltipped sltRemitente" data-position="top" data-tooltip="Tipo de servicio de transporte solicitado">
                                <option value="<?php esc_html_e($idRemi,'ubilop-plugin-wp') ?>" selected=""><?php $nombre != "" ?  esc_html_e(ucfirst($nombre), 'ubilop-plugin-wp') : esc_html_e('Nombre Remitente', 'ubilop-plugin-wp') ?></option>
                            </select>                                      
                        </div> 

                        <div class="col s12 m6 l4 center-align">
                                <a class="btn-large tooltipped newSender" style="background-color: #DFDFDF; color:gray;" data-position="top" data-tooltip="Especifique los datos del remitente con los 
                                que desea trasmitir sus ordenes al FACT(En caso de no registrar ninguno el sistema tomará los datos de la tienda como remitente por 
                                defecto)">Nuevo Remitente</a> 
                                
                                <!-- <?php if($estado == 0) {echo '<div class="switch right-align"><span class="lever"></span>Estado : Activo<i class="material-icons prefix " style="color:#8bc34a">done</i></label></div>';}else{
                                    echo '<div class="switch right-align"><label >Estado :  &nbsp OFF<input type="checkbox" checked="checked" id="chkEstado" class="estadoSender"><span class="lever"></span>ON</label></div>';
                                } ?> -->                        
                        </div>

                        <div class="col s12 m6 l4">
                        <?php if($estado == 1) {
                            echo '<label style="margin-left:0" for="sltEstado">Remitente Predeterminado</label><select disabled data-estado="" id="sltEstado"  value="1" class="wc-enhanced-select browser-default tooltipped sltEstado" data-position="top" data-tooltip="Remitente Predeterminado"><option value="1" selected="">Si</option><option value="0">No</option></select>';}
                        else{
                            echo '<label style="margin-left:0" for="sltEstado">Remitente Predeterminado</label><select data-estado="" id="sltEstado"  value="0" class="wc-enhanced-select browser-default tooltipped sltEstado" data-position="top" data-tooltip="Remitente Predeterminado"><option value="1" >Si</option><option value="0" selected="">No</option></select>';
                        } ?>
                        </div>
                    </div>

                    <br><div class="divider"></div><br><br>
                    <div class="section body">
                        <input id='idRemi' value="<?php esc_html_e($idRemi,'ubilop-plugin-wp') ?>" type='hidden'>
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="nombre" type="text" value="<?php esc_html_e($nombre, 'ubilop-plugin-wp') ?>" remitente="<?php esc_html_e($idRemi,'ubilop-plugin-wp') ?>" class="validate">
                            <label for="nombre">Nombre*</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">person_pin_circle</i>
                            <input id="direccion" type="text" value="<?php esc_html_e($direccion,'ubilop-plugin-wp') ?>" class="validate">
                            <label for="direccion">Dirección</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">location_city</i>
                            <input id="poblacion" type="text" value="<?php esc_html_e($poblacion,'ubilop-plugin-wp') ?>" class="validate">
                            <label for="poblacion">Población*</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">location_on</i>
                            <input id="codPostal" type="text" value="<?php esc_html_e($codPostal,'ubilop-plugin-wp') ?>" class="validate">
                            <label for="codPostal">Código Postal*</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">public</i>
                            <input id="pais" type="text" min="3" max="3" value="<?php esc_html_e($pais,'ubilop-plugin-wp') ?>" class="validate txtPais">
                            <label for="pais">País(ISO3 ejem: ESP)</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">phone</i>
                            <input id="telefono" type="text" value="<?php esc_html_e($telefono,'ubilop-plugin-wp') ?>" class="validate">
                            <label for="telefono">Teléfono*</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">email</i>
                            <input id="email" type="text" value="<?php esc_html_e($email,'ubilop-plugin-wp') ?>" class="validate">
                            <label for="email">Email</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <i class="material-icons prefix">person_add</i>
                            <input id="contacto" type="text" value="<?php esc_html_e($contacto,'ubilop-plugin-wp') ?>" class="validate">
                            <label for="contacto">Contacto</label>
                        </div>

                        
                        <div class="input-field col s12 right-align">
                        <button id="btnRemitente" class="btn waves-effect waves-light remitenteg" type="button" name="remitente"><img class="hide imgSpinner" style="margin: -2px 4px;" src="<?php echo UBILOP_PLUGIN_DIR_URL ?>admin/img/wpspin_light.gif"  alt="">Guardar
                            <i class="material-icons right">send</i>
                        </button>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div id="test-swipe-2" class="col s12  white">
            <div class="divider"></div>
                <div id="cron" cron="<?php esc_html_e($idCron,'ubilop-plugin-wp') ?>" class="row centrador" >
                        <div class="section center-align">
                            <a class="btn-large tooltipped" style="background-color: #DFDFDF; color:gray;" data-position="top" data-tooltip="Ejecute de manera programada la actualización automática de los estados de pedidos en Woocommerce, a partir del último estado producido en el 
                      FACT">Tareas CRON</a>
                      <p class="range-field tooltipped" data-position="bottom" data-tooltip="Especifiqué cada cuantas horas desea ejecutar la función automática de actualización de estados">
                        <label for="tiempo">Establezca el tiempo para actualizar los estados:</label>
                        <input type="range" value="<?php esc_html_e($hora,'ubilop-plugin-wp') ?>" id="tiempo" min="1" max="10" />
                     </p>
                          </div><div class="divider"></div><br>
                    <div class="col s12 m6">                   
                    <i class="material-icons prefix">cloud_done</i>
                    <label style="margin-left:0">ESTADO DOCUMENTADO</label>                   
                        <select id="documentado" class="wc-enhanced-select browser-default">
                            <option value="<?php esc_html_e($documentado,'ubilop-plugin-wp') ?>"  selected><?php $documentado != "" ?  esc_html_e(ucfirst($documentado), 'ubilop-plugin-wp') : esc_html_e('Seleccionar equivalencia', 'ubilop-plugin-wp') ?></option>
                                <?php
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
                                    $estadito = substr($status, 3);
									echo '<option value="' . esc_attr( $estadito ) . '" ' . selected( $status, false ) . '>' . esc_html( $status_name ) . '</option>';
								}
                                ?>
                                <option value=""  >Ninguno</option>
                        </select>
                        <br>
                    </div>
                    <div class="col s12 m6">                   
                    <i class="material-icons prefix">history</i>
                    <label style="margin-left:0">ESTADO TRANSMITIDO</label>                   
                        <select id="transmitido" class="wc-enhanced-select browser-default">
                            <option value="<?php esc_html_e($transmitido,'ubilop-plugin-wp') ?>"  selected><?php $transmitido != "" ?  esc_html_e(ucfirst($transmitido), 'ubilop-plugin-wp') : esc_html_e('Seleccionar equivalencia', 'ubilop-plugin-wp') ?></option>
                                <?php
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
                                    $estadito = substr($status, 3);
									echo '<option value="' . esc_attr( $estadito ) . '" ' . selected( $status, false ) . '>' . esc_html( $status_name ) . '</option>';
								}
                                ?>
                                <option value=""  >Ninguno</option>
                        </select>
                        <br>
                    </div>
                    <div class="col s12 m6">                   
                    <i class="material-icons prefix">shop</i>
                    <label style="margin-left:0">ESTADO PROCESADO</label>                   
                        <select id="procesado" class="wc-enhanced-select browser-default">
                            <option value="<?php esc_html_e($procesado,'ubilop-plugin-wp') ?>"  selected><?php $procesado != "" ?  esc_html_e(ucfirst($procesado), 'ubilop-plugin-wp') : esc_html_e('Seleccionar equivalencia', 'ubilop-plugin-wp') ?></option>
                                <?php
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
                                    $estadito = substr($status, 3);
									echo '<option value="' . esc_attr( $estadito ) . '" ' . selected( $status, false ) . '>' . esc_html( $status_name ) . '</option>';
								}
                                ?>
                                <option value=""  >Ninguno</option>
                        </select>
                        <br>
                    </div>
                    <div class="col s12 m6">
                    <i class="material-icons prefix">share</i>
                    <label style="margin-left:0">ESTADO EN TRANSITO</label>                   
                        <select id="transito" class="wc-enhanced-select browser-default">
                            <option value="<?php esc_html_e($transito,'ubilop-plugin-wp') ?>"  selected><?php $transito != "" ?  esc_html_e(ucfirst($transito), 'ubilop-plugin-wp') : esc_html_e('Seleccionar equivalencia', 'ubilop-plugin-wp') ?></option>
                                <?php
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
                                    $estadito = substr($status, 3);
									echo '<option value="' . esc_attr( $estadito ) . '" ' . selected( $status, false ) . '>' . esc_html( $status_name ) . '</option>';
								}
                                ?>
                                <option value=""  >Ninguno</option>
                        </select>
                    <br>
                    </div>
                    <div class="col s12 m6">
                    <i class="material-icons prefix">local_shipping</i>
                    <label style="margin-left:0">ESTADO EN REPARTO</label>                   
                        <select id="reparto" class="wc-enhanced-select browser-default">
                            <option value="<?php esc_html_e($reparto,'ubilop-plugin-wp') ?>"  selected><?php $reparto != "" ?  esc_html_e(ucfirst($reparto), 'ubilop-plugin-wp') : esc_html_e('Seleccionar equivalencia', 'ubilop-plugin-wp') ?></option>
                                <?php
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
                                    $estadito = substr($status, 3);
									echo '<option value="' . esc_attr( $estadito ) . '" ' . selected( $status, false ) . '>' . esc_html( $status_name ) . '</option>';
								}
                                ?>
                                <option value=""  >Ninguno</option>
                        </select>
                    <br>
                    </div>
                    <div class="col s12 m6">
                    <i class="material-icons prefix">sentiment_very_satisfied</i>
                    <label style="margin-left:0">ESTADO ENTREGADO</label>                   
                        <select id="entregado" class="wc-enhanced-select browser-default">
                         <option value="<?php esc_html_e($entregado,'ubilop-plugin-wp') ?>" selected><?php $entregado != "" ?  esc_html_e(ucfirst($entregado), 'ubilop-plugin-wp') : esc_html_e('Seleccionar equivalencia', 'ubilop-plugin-wp') ?></option>
                            <?php
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
                                    $estadito = substr($status, 3);
									echo '<option value="' . esc_attr( $estadito ) . '" ' . selected( $status, false ) . '>' . esc_html( $status_name ) . '</option>';
								}
                                ?>
                                <option value=""  >Ninguno</option>
                            </select>
                        <br>           
                    </div>
                    <div class="col s12 m6">
                    <i class="material-icons prefix">cancel</i>
                    <label style="margin-left:0">ESTADO CANCELADO</label>                   
							<select id="cancelado" class="wc-enhanced-select browser-default">
                                <option value="<?php esc_html_e($cancelado,'ubilop-plugin-wp') ?>" selected><?php $cancelado != "" ?  esc_html_e(ucfirst($cancelado), 'ubilop-plugin-wp') : esc_html_e('Seleccionar equivalencia', 'ubilop-plugin-wp') ?></option>
                                <?php
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
                                    $estadito = substr($status, 3);
									echo '<option value="' . esc_attr( $estadito ) . '" ' . selected( $status, false ) . '>' . esc_html( $status_name ) . '</option>';
								}
                                ?>
                                <option value=""  >Ninguno</option>
							</select>
						<br>
                    </div>
                    <div class="col s12 m6">
                    <i class="material-icons prefix">error</i>
                    <label style="margin-left:0">ESTADO INCIDENCIA</label>                   
							<select id="incidencia" class="wc-enhanced-select browser-default">
                                <option value="<?php esc_html_e($incidencia,'ubilop-plugin-wp') ?>" selected><?php $incidencia != "" ?  esc_html_e(ucfirst($incidencia), 'ubilop-plugin-wp') : esc_html_e('Seleccionar equivalencia', 'ubilop-plugin-wp') ?></option>
                                <?php
								$statuses = wc_get_order_statuses();
								foreach ( $statuses as $status => $status_name ) {
                                    $estadito = substr($status, 3);
									echo '<option value="' . esc_attr( $estadito ) . '" ' . selected( $status, false ) . '>' . esc_html( $status_name ) . '</option>';
								}
                                ?>
                                <option value=""  >Ninguno</option>
							</select>
						<br>
                    </div>
                    <div class="input-field col s12 right-align">
                    <button id="btnCron" class="btn waves-effect waves-light" type="button" name="cron"><img class="hide imgSpinner" style="margin: -2px 4px;" src="<?php echo UBILOP_PLUGIN_DIR_URL ?>admin/img/wpspin_light.gif"  alt="">Guardar
                        <i class="material-icons right">send</i>
                    </button>
                    </div>
                 </div>
            </div>
            <div id="test-swipe-3" class="col s12 white">
            <div class="row">
                <div class="divider"></div>
                    <div id="parametros" cron="<?php esc_html_e($idRemi,'ubilop-plugin-wp') ?>" class="row centrador">
                        <div class="section center-align">
                            <a class="btn-large tooltipped" style="background-color: #DFDFDF; color:gray;" data-position="top" data-tooltip="Ejecute de manera programada la actualización automática de los estados de pedidos en Woocommerce, a partir del último estado producido en el 
                                FACT">Parámetros</a>
                         </div>
                         <div class="divider"></div><br>
                                <div class="col s12 l6" >
                                   <!-- <input id="servicio" type="text" value="<?php esc_html_e($servicio,'ubilop-plugin-wp') ?>" class="validate"> -->
                                    <label style="margin-left:0" for="servicio">Servicio Predeterminado</label>
                                    <select data-service="" id="servicio"  value="<?php esc_html_e($servicio,'ubilop-plugin-wp') ?>" class="wc-enhanced-select browser-default tooltipped servicio" data-position="top" data-tooltip="Tipo de servicio de transporte solicitado">
                                        <option value="<?php esc_html_e($servicio,'ubilop-plugin-wp') ?>" selected=""><?php $servicio != "" ?  esc_html_e(ucfirst($servicio), 'ubilop-plugin-wp') : esc_html_e('Servicio', 'ubilop-plugin-wp') ?></option>
                                    </select>
                                    <input type="text"  name="servicio1" class="servicio1" style="display:none" value="<?php esc_html_e($servicio,'ubilop-plugin-wp') ?>"/>
													
                                        <p><label><input chk-servicio="" type="checkbox"  id="chkServicio" class="filled-in chkServicio" /><span>&nbsp Ingresar Manualmente </span></label>                                    
                                       
                                </div>                    
                                <div class="col s12 l6">
                                <label style="margin-left:0">Observaciones Predeterminadas</label>              
                                    <select id="observaciones" class="wc-enhanced-select browser-default tooltipped" data-position="top" data-tooltip="Establecer dato por defecto de la orden para grabar en el campo Observaciones">
                                        <option value="<?php esc_html_e($observaciones,'ubilop-plugin-wp') ?>"  selected><?php $observaciones != "" ?  esc_html_e(ucfirst($observaciones), 'ubilop-plugin-wp') : esc_html_e('Observaciones', 'ubilop-plugin-wp') ?></option>
                                        <option value="name"  >Productos-Nombre Orden</option>
                                        <option value="sku"  >SKU Productos</option>
                                        <option value=""  >Ninguno</option>
                                    </select>
                                </div>
                                <div class="input-field col s12 right-align">
                                    <button id="btnParametros" class="btn waves-effect waves-light remitenteg" type="button" name="parametros"><img class="hide imgSpinner" style="margin: -2px 4px;" src="<?php echo UBILOP_PLUGIN_DIR_URL ?>admin/img/wpspin_light.gif"  alt="">Guardar
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>              
                     </div>
             </div>
        </div>
</div>
<!-- Modal Structure -->
<div id="add_fact_table" class="modal">
    <div class="modal-content">
        <h5>Datos de Configuración</h5>
        <div class="right-align">
           <a  param-config="" href="#">Solicitar Credenciales de Conexión</a> 
            <!-- <a  href="https://www.ubilop.com/contacto.html" target="_blank">Solicitar Credenciales de Conexión</a> -->
        </div>
        <!-- preloader -->
        <div class="preload">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>

        <form action="" method="post" form-fact>
            <div class="row">
                <div class="input-field col s6">
                    <input type="text" id="codigo" class="validate">
                    <label for="codigo">Codigo Cliente</label>
                </div>
                <div class="input-field col s6">
                    <input type="text" id="clave" class="validate">
                    <label for="clave">Clave Cliente</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" id="urlWS" class="validate">
                    <label for="urlWs">Url WebService</label>
                </div>
                <div class="input-field col s12">
                    <input type="text" id="urlIris" class="validate">
                    <label for="urlIris">Url Seguimiento</label>
                </div>

            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button id="crearFactConfig" class="btn waves-effect waves-light" type="button" name="action"><img class="hide imgSpinner" style="margin: -2px 4px;" src="<?php echo UBILOP_PLUGIN_DIR_URL ?>admin/img/wpspin_light.gif"  alt="">Guardar
            <i class="material-icons right">send</i>
        </button>
    </div>
</div>


<div id="view_tutorial" class="modal">
    <div class="modal-content">
        <h5>Video Explicativo</h5>

        <center>
            <div id="">
                <iframe width="560" height="315" src="https://www.youtube.com/embed/sHvzMmhcdk4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></br>
            </div>

        </center>
    </div>
    <div class="modal-footer">

    </div>
</div>