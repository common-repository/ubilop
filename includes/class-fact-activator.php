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
class FACT_Activator
{

    /**
     * Método estático que se ejecuta al activar el plugin
     *
     * Creación de la tabla {$wpdb->prefix}fact_data
     * para guardar toda la información necesaria
     *
     * @since 0.0.1
     * @access public static
     */
    public static function activate()
    {

        global $wpdb;

        //query para crear la tabla en db de wordpress con los detalles de configuración de conexión-fact
        $sql = "CREATE TABLE IF NOT EXISTS " . UBILOP_TABLE_CONFIG . " (
            id int(9) NOT NULL AUTO_INCREMENT,
            codigo_cliente varchar(20) NOT NULL,
            clave varchar(20) NOT NULL,
            url_ws varchar(200) NOT NULL,
            url_iris varchar(200),
            estado bool,
            PRIMARY KEY (id)
    );
    ";
        $wpdb->query($sql);
        
       // $sql= "ALTER TABLE ". UBILOP_TABLE_CONFIG ." ADD url_iris varchar(200);";
        //$wpdb->query($sql);
        

        //query para crear la tabla en db de wordpress con los registros transmitidos al fact
        $sql1 = "CREATE TABLE IF NOT EXISTS " . UBILOP_TABLE_DATA . " (
                id int(9) NOT NULL AUTO_INCREMENT,
                id_orden int(9) NOT NULL,
                fecha DATE,
                albaran varchar(50) NOT NULL,
                cliente varchar(50) NOT NULL,
                estado text NOT NULL,
                seguimiento varchar(200),
                ruta varchar(250) NOT NULL,
                devuelto bool,
                PRIMARY KEY (id)
        );
        ";
        $wpdb->query($sql1);

       // $sql1= "ALTER TABLE ". UBILOP_TABLE_DATA ." ADD devuelto bool NOT NULL;";
       // $wpdb->query($sql1);

       // $sql1 = "ALTER TABLE ". UBILOP_TABLE_DATA ." CHANGE recogida albaran VARCHAR(50) NOT NULL;";
        //$wpdb->query($sql1);
        
        //query para crear la tabla en db de wordpress con los remitentes predeterminados
        $sql2 = "CREATE TABLE IF NOT EXISTS " . UBILOP_TABLE_SENDER . " (
            id int(9) NOT NULL AUTO_INCREMENT,
            nombre varchar(100) NOT NULL,
            direccion varchar(120),
            poblacion varchar(100) NOT NULL,
            cod_postal varchar(100),
            pais varchar(50),
            telefono varchar(100) NOT NULL,
            email varchar(100),
            contacto varchar(100),
            observaciones varchar(250),
            servicio varchar(50),
            estado bool NOT NULL,
            PRIMARY KEY (id)
    );
    ";
     $wpdb->query($sql2);
    // $sql2= "ALTER TABLE ". UBILOP_TABLE_SENDER ." ADD estado bool NOT NULL;";
     //$wpdb->query($sql2);

      //query para crear la tabla en db de wordpress con las equivalencias de estados y el tiempo de actualización
      $sql3 = "CREATE TABLE IF NOT EXISTS " . UBILOP_TABLE_CRON . " (
        id int(9) NOT NULL AUTO_INCREMENT,
        documentado varchar(50),
        transmitido varchar(50),
        procesado varchar(50),
        transito varchar(50),
        reparto varchar(50),
        entregado varchar(50),
        cancelado varchar(50),
        incidencia varchar(50),
        hora varchar(10) NOT NULL,
        PRIMARY KEY (id)
);
";
 $wpdb->query($sql3);

 //$sql3= "ALTER TABLE ". UBILOP_TABLE_CRON ." ADD (incidencia varchar(50) );";
// $wpdb->query($sql3);

//query para crear la tabla en db de wordpress con los registros transmitidos al fact
$sql4 = "CREATE TABLE IF NOT EXISTS " . UBILOP_TABLE_RETURN . " (
    id int(9) NOT NULL AUTO_INCREMENT,
    id_orden int(9) NOT NULL,
    fecha DATE,
    recogida varchar(20) NOT NULL,
    cliente varchar(20) NOT NULL,
    estado text NOT NULL,
    seguimiento varchar(200),
    ruta varchar(250) NOT NULL,
    PRIMARY KEY (id)
);
";
$wpdb->query($sql4);

// $sql1= "ALTER TABLE ". UBILOP_TABLE_DATA ." ADD seguimiento varchar(200);";
//$wpdb->query($sql1);

        

    }
}
