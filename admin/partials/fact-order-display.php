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
$dir = UBILOP_PLUGIN_DIR_URL;

if (isset($_GET["fechaDesde"]) && isset($_GET["fechaHasta"])) {

    $fdesde =  sanitize_text_field( $_GET["fechaDesde"]);
    $fhasta =  sanitize_text_field( $_GET["fechaHasta"]);

    $sql = "SELECT * FROM " . UBILOP_TABLE_DATA . " WHERE ruta = '" . UBILOP_WS_CONFIG . "' AND fecha BETWEEN " . "'" . $fdesde . "'" . " AND " . "'" . $fhasta . "'" . " ORDER BY albaran DESC";
    $result = $this->db->get_results($sql);

} else {
    $fdesde = date("Y-m-d");
    $fhasta = date("Y-m-d");
    $sql = "SELECT * FROM " . UBILOP_TABLE_DATA . " WHERE ruta = '" . UBILOP_WS_CONFIG . "' AND fecha BETWEEN " . "'" . $fdesde . "'" . " AND " . "'" . $fdesde . "'" . " ORDER BY albaran DESC";
    $result = $this->db->get_results($sql);
}

?>

<div class="container">
    <div class="row">
        <div class="col s12">
            <h5><?php esc_html_e(get_admin_page_title()); ?></h5>
        </div>
        <div class='text-right'>
                    <span href='#' data-update-state-send='' class='btn btn-default update-state-send' title='Ejecutar Actualizador de estados envios'>Ejecutar Actualizador de Estados</span>                    
        </div>                          
        </div>
        <div class="form-wrapper">  
            <div id="notifySend" class='' style="display: none;">
                   <div class="alert alert-success">
                    <strong><i class='tiny material-icons'>done_all</i>Estados Actualizados Correctamente.</strong> 
                </div>
            </div> 
    </div>
    <div class="row"><br>
        <form action="#" method="POST" id="frmFiltFecha">
            <div class="text-center">
                <div class="col s4">
                    <label for="fechaDesde">Fecha desde:</label>
                    <input type="date" value="<?php if (isset( $fdesde )) {
                                                    echo esc_html( $fdesde );
                                                } else {
                                                    echo esc_html( date("Y-m-d") );
                                                } ?>" name="fechaDesde" id="fechaDesde" required>

                </div>
                <div class="col s4">
                    <label for="fechaHasta">Fecha hasta:</label>
                    <input type="date" value="<?php if (isset( $fhasta )) {
                                                    echo esc_html( $fhasta );
                                                } else {
                                                    echo esc_html( date("Y-m-d") );
                                                } ?>" name="fechaHasta" id="fechaHasta" required>
                </div>
                <div class="col s12 m4">
                    <button type="submit" id="btnFiltrar" class="btn waves-effect waves-light"><img class="hide imgSpinner" style="margin: -2px 4px;" src="<?php echo UBILOP_PLUGIN_DIR_URL ?>admin/img/wpspin_light.gif" alt="">Filtrar Busqueda</button>
                </div>

            </div>
        </form>
    </div>
    <div class=""><br>
        <div class="right-align">
            <?php
    
            if ($result) {
                $albaDesde = end($result)->albaran;
                $albaHasta = reset($result)->albaran;
                echo "
                <span data-fact-id-manifest='$albaDesde' class='btn waves-effect waves-light manifest' data-position='top' data-tooltip='Manifiesto PDF'>
                    Manifiesto
                </span>
                <span alba-desde-masive='$albaDesde' alba-hasta-masive='$albaHasta' class='btn waves-effect waves-light masive' data-position='top' data-tooltip='Impresión Masiva PDF'>
                    Impresión Masiva PDF
                </span>               
                ";
            }
            ?>
            
        </div>
        <?php
         if ($result) {
          echo "
        <div class='row'>
            <div class='row'>
                <div class='input-field col s12'>
                <i class='material-icons prefix'>pageview</i>
                <input type='text' class='' id='buscar'>
                <label for='icon_prefix'>Filtrar listado por numero de orden o albarán </label>
                </div>
            </div>
        </div>
        ";
                    }
                    ?>
        <div class="row">
            <span class="center-left"><span class="center-left"> <img class="" src="<?php  esc_html_e($dir) ?>admin/img/sb-black.png" style="margin: -10px 9px;border-radius: 49%;" width="52px" />Listado de ordenes transmitidas al FACT</span>
            <br><br>
            <table class="responsive-table bordered">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Orden</th>
                        <th>Albaran</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Seguimiento</th>
                        <th>Detalles</th>
                        <th>Estados</th>
                        <th>Etiqueta</th>
                        <th>Devolución</th>
                    </tr>
                    <?php

                    if (!$result) {
                        echo "
                            <tr id='' idRegistro=''>
                                <td id='' colspan='3' codigo=''>
                                    <h5>Sin Registros</h5>
                                </td>
                            </tr>                
                            ";
                    }
                    ?>

                </thead>

                <tbody id="tblOrdenes">

                    <?php


                    foreach ($result as $k => $v) {

                        $id = $v->id;
                        $fecha_transmitido = date("d-m-Y", strtotime($v->fecha));
                        $orden = $v->id_orden;
                        $albaran = $v->albaran;
                        $cliente = $v->cliente;
                        $seguimiento = $v->seguimiento;
                        $estado = $v->estado;
                        $devuelto = $v->devuelto;

                        //requerimos la libreria nusoap para manejo de webservice con php
                        require_once UBILOP_PLUGIN_DIR_PATH . 'admin/lib/nusoap.php';

                        //instanciando un nuevo objeto cliente para consumir el webservice
                        $client = new nusoap_client(UBILOP_WS_CONFIG, 'wsdl');
                        //pasando los parámetros a un array
                        $param = array(
                            '_Usuario' => UBILOP_COD_CONFIG,
                            '_Clave' => UBILOP_CLAVE_CONFIG,
                            '_AlbaranNumero' => $albaran,
                            '_Referencia1' => "",
                            '_Referencia2' => ""
                        );
                        //$estado = '';
                        //llamando al método y pasándole el array con los parámetros
                        $resultado = $client->call('RecuperarEnvio', $param);
                        $result = $resultado['RecuperarEnvioResult'];

                        if (isset($result['Value'])) {

                            if($value['Estado'] != 'ENTREGADO' && $estado != 'DEVUELTO'){

                                $value = $result['Value'];
                                $estado = $value['Estado'];
                            }
                            
                        } 
                        


                        if ($id) {

                            if($devuelto == 0 && $estado == 'ENTREGADO'  ){
                                 $html = "<span data-fact-id-devolucion='$albaran'   class='btn btn-floating waves-effect waves-light tooltipped btnReturn' data-position='top' data-tooltip='Gestionar Logística Inversa para este Pedido'><a href='#' title='Devolución'><i class='tiny material-icons'>repeat</i></a></span>";
                            }else{

                                $html = "<span data-fact-id-devolucion='$albaran'   class='btn btn-floating waves-effect waves-light tooltipped btnReturn disabled' data-position='top' data-tooltip='Gestionar Logística Inversa para este Pedido'><a href='#' title='Devolución'><i class='tiny material-icons'>repeat</i></a></span>";
                            }

                            echo "
                            <tr id='idR' idRegistro='$id'>
                                <td id='fec' fecha='$fecha'>$fecha_transmitido</td>
                                <td id='ord' orden='$orden'><a href='../wp-admin/post.php?post=".$orden."&action=edit' target='_blank'>$orden</a></td>
                                <td id='rec' recogida ='$albaran '>$albaran </td>
                                <td id='cli' cliente ='$cliente '>$cliente</td>
                                <td id='est' estado ='$estado '>$estado</td>
                                <td id='seg' estado ='$seguimiento '><i class='material-icons'>link</i><a href ='". UBILOP_IRIS_CONFIG ."$seguimiento' target='_blank'> $seguimiento</a></td>
                                <td>
                                    <span data-fact-id-view='$albaran' class='btn btn-floating waves-effect waves-light tooltipped' data-position='top' data-tooltip='Detalles del Envío'>
                                    <a href='#' title='Visualizar Detalles del Envío'><i class='tiny material-icons'>visibility</i></a>
                                    </span>
                                </td>
                                <td>
                                    <span data-fact-id-list='$albaran' class='btn btn-floating waves-effect waves-light tooltipped' data-position='top' data-tooltip='Estados del Envío'>
                                    <a href='#' title='Visualizar Estados del Envío'><i class='tiny material-icons'>list</i></a>
                                    </span>
                                </td>
                                <td>
                                    <span data-fact-id-label='$albaran'  class='btn btn-floating waves-effect waves-light tooltipped label' data-position='top' data-tooltip='Imprimir Etiqueta PDF'>
                                        <a href='#' title='Imprimir Etiqueta PDF'><i class='tiny material-icons'>print</i></a>
                                    </span>
                                </td>
                               <td>
                                    $html
                                </td> 
                            </tr>
                            ";
                        }
                    }

                    ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal Order -->
<div id="view_fact_order" class="modal">
    <div class="modal-content modal-view-order">
        <h5>Datos del Envío</h5>
        <!-- preloader -->
        <div class="preload">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>
        <center>
            <table id="tblEnvio">
                <tr>
                    <td>

                    </td>
                </tr>
            </table>

        </center>
    </div>
    <div class="modal-footer">

    </div>
</div>

<!-- Modal Estados -->
<div id="view_fact_list" class="modal">
    <div class="modal-content modal-view-order">
        <h5>Historial Estados Envío</h5>
        <!-- preloader -->
        <div class="preload">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>
        <center>
            <table class="responsive-table bordered" id="tblEstados">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>DetalleEstado</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>

            </table>

        </center>
    </div>
    <div class="modal-footer">

    </div>
</div>

<!-- Modal Label PDF -->
<div id="view_fact_label" class="modal">
    <div class="modal-content modal-view-order">
        <h5>Etiqueta Envío Imprimir PDF</h5>
        <!-- preloader -->
        <div class="preload">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>
        <center>
            <div id="etiquetaPdf">
                <a href='' id='urlLabelPdf' target='_blank'>Imprimir Etiqueta PDF</a></br></br>
                <iframe width='100%' id='ifmLabelPdf' height='400' src=''> </iframe></br></br>

            </div>

        </center>
    </div>
    <div class="modal-footer">

    </div>
</div>

<!-- Modal ManifiestoPDF -->
<div id="view_fact_manifest" class="modal">
    <div class="modal-content modal-view-order">
        <h5>Manifiesto PDF</h5>
        <!-- preloader -->
        <div class="preload">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>
        <center>
            <div id="manifiestoPdf">
                <a href='' id='urlManifiestoPdf' target='_blank'>Imprimir Manifiesto PDF</a></br></br>
                <iframe width='100%' id='ifmManifiestoPdf' height='400' src=''> </iframe></br></br>
            </div>
        </center>
    </div>
    <div class="modal-footer">

    </div>
</div>

<!-- Modal Masivo PDF -->
<div id="view_fact_masive" class="modal">
    <div class="modal-content modal-view-order">
        <h5>Masivo EtiquetasPDF</h5>
        <!-- preloader -->
        <div class="preload">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>
        <center>
            <div id="masivePdf">
                <a href='' id='urlMasivePdf' target='_blank'>Imprimir Masivo Etiquetas PDF</a></br></br>
                <iframe width='100%' id='ifmMasivePdf' height='400' src=''> </iframe></br></br>

            </div>

        </center>
    </div>
    <div class="modal-footer">

    </div>
</div>