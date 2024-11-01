=== Sendingbay módulo E-commerce ===
Contributors: Ubilop
Donate link: https://sendingbay.com/
Tags: fact, sendingbay, ubilop, mensajería, transporte, courier, envíos, correos, dynamics Express, shipping
Requires at least: 4.9.8
Tested up to: 6.4.2
Stable tag: 3.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Complemento de Ubilop para transmitir las ordenes de Wordpress-WC al software de facturación FACT

== Description ==

El complemento Sendingbay para Wordpress-Woocommerce, ofrece la funcionalidad a nuestros usuarios de poder transmitir sus órdenes gestionadas por Woocommerce al FACT(Software Integral Multi-plataforma) para control de tráfico y gestión de tareas ejercidas por Empresas de Mensajería, Paquetería y Transporte Urgente. El complemento es gratuito y solo necesitará las credenciales de configuración que le proporcionará la Agencia que lo representa(+ detalles en ubilop.com).
<iframe width="560" height="315" src="https://www.youtube.com/embed/02PJlPj_Zcs" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

== Installation ==

- Instalar el Complemento de Ubilop para WordPress-Woocommerce.


- Una vez instalado el complemento de Ubilop para Wordpress, se procede a la activación del mismo haciendo click en activar plugin.


- Una vez activado el Plugin selecciona la opción de menú Fact Datos para realizar la configuración de conexión, indique en el formulario su usuario, clave y el url del WebService proporcionado por la agencia padre y hace click en Guardar(Estos datos son editables).


- Una vez establecida la configuración de conexión se puede dirigir al Ítem de menú Woocommerce / Pedidos donde se muestra el listado de sus órdenes, cada una con su respectivo botón de Transmitir al Fact y en el caso de haber transmitido se muestra el botón de Imprimir etiqueta.

== Changelog ==

= 3.0.8 =

*  Compatibilidad PHP 8.

= 3.0.7 =

*  Modificación PhpMailer.

= 3.0.6 =

*  Cambios imagen de marca.


= 3.0.5 =

*  Actualización en el proceso de Login.

= 3.0.4 =

*  Actualización en el proceso de Transmitir envío a plataforma.

= 3.0.3 =

*  Optimización en el proceso de Transmitir envío a plataforma.

= 3.0.2 =

*  Optimización en la función de filtrar busqueda de envíos transmitidos por rango de fechas(Firefox).

= 3.0.1 =

*  Determinar el valor correcto para enviar en el campo Observaciones.

= 3.0.0 =

*  Verificación LoginTest, Performance Transmisión Masiva.

= 2.6.9 =

*  Update en generar etiquetas de forma masiva.

= 2.5.9 =

*  Se agrego un control para ingresar del forma alternativa el tipo de Servicio.

= 2.4.9 =

*  Version original de JQUERY para Wordpress.

= 2.3.9 =

*  Corrección en el proceso para encolar la librería JQUERY.

= 2.2.9 =

*  Se modifico el proceso para encolar la librería JQUERY.


= 2.1.9 =

*  Se agregó un botón en la sección de configuración del módulo que muestra un video tutorial del proceso de instalación, configuración y gestión del Plugin.


= 2.1.8 =

*  Mejora en la funcionalidad de transmisión masiva para imprimir las etiquetas de esos envíos de forma automática.
*  Corrección de la sentencia Alter Table campo estado.

= 2.1.7 =

*  Implementación de transmisión masiva de ordenes seleccionadas al FACT.

= 2.1.6 =

*  Validación/Corrección peso Productos Variables. 

= 2.1.5 =

*  Calcular el peso total de los Productos Variables que componen un pedido. 

= 2.1.4 =

*  Implementación para registrar multiples direcciones de remitentes.
*  En el listado de ordenes transmitidas se agrego un enlace que redirecciona al perfil de edición de la orden.

= 2.1.3 =

*  Actualización de metodos(Manifiesto e Impresión masiva).
*  Implementación de servicios autorizados por cliente.

= 2.1.2 =

*  Incluir el monto del envío al total en tipo contra-rembolso.
*  Se agrego un botón para ejecutar la actualización de estados de forma manual.

= 2.0.2 =

*  Cambios en la tabla fact_data(rename albaran y add devuelto)

= 2.0.1 =

*  Update(2.0.0)

= 2.0.0 =

*  Transmición al FACT sin recargar la página de pedidos WC.
*  Corrección de la función get_weight().

= 1.0.9 =

*  Calcular el peso total de los productos que componen un pedido.

= 1.0.8 =

*  Implementación de la logística inversa.

= 1.0.7 =

* Update Optimización jerarquizada del actualizador de estados.

= 1.0.6 =

* Update Actualizador de estados CRON.

= 1.0.5 =

* Actualizador de estados en automático.

= 1.0.4 =

* Actualización funciones CRON.

= 1.0.3 =

* Correción Portes Debido.

= 1.0.2 =

* Actualización parámetro Rembolso.

= 1.0.1 =

* Actualización del botón de impresión en el listado de ordenes de Woocommerce".

= 1.0.0 =

* Actualización para que los botones de Imprimir Manifiesto y Etiquetas abran en nueva ventana.

= 0.0.9 =

* Se agrego en la sección de parámetros de configuración la entrada para establecer el Servicio predeterminada.
* Se agrego la funcionalidad de actualizar el estado de la orden al que se establece en las opciones CRON(Documentado).
* Se agrego la funcionalidad de tomar los datos de facturación del destinatario cuando los de envío están vacios.

= 0.0.8 =
* Se agrego en la sección de parámetros de configuración el desplegable para elegir Observaciones predeterminadas.
* Se restableció todo el diseño de área de listado de ordenes woocommerce con sus estilos por defecto tanto en la tabla como en la ventana modal.

= 0.0.7 =
* Comando sql Alter para actualizar los campos de las tablas que no existan.

= 0.0.6 =
* Las listas desplegables para vincular los estados del FACT cargan todos los estados de woocommerce y personalizados.
* Se ajusto el estilo css en la caja de busqueda de las ordenes de woocommerce.

= 0.0.5 =
* Se agrego una entrada de URL Seguimiento-Iris en el formulario de configuración.
* Se agrego en campo CodigoSeguimiento en el listado de ordenes transmitidas al FACT.

= 0.0.4 =
* Integración de funcionalidad para registrar remitente predeterminado.
* Tareas programadas CRON para la actualización de estados automática.
 
= 0.0.3 =
* Se agrego una entrada para filtrar transmisiones por numero de orden o albarán.
* Se agrego el enlace web de Ubilop en la sección de configuración.
* Se actualizo la última versión de jquery

= 0.0.2 =
* Cambios en el archivo fact-orders-display.php
* Actualización del leeme.
 
= 0.0.1 =
* Versión inicial del complemento.
 

== Upgrade Notice ==

= 3.0.8 =
Actualización versión 3.0.8

= 3.0.7 =
Actualización versión 3.0.7

= 3.0.6 =
Actualización versión 3.0.6

= 3.0.5 =
Actualización versión 3.0.5

= 3.0.4 =
Actualización versión 3.0.4

= 3.0.3 =
Actualización versión 3.0.3

= 3.0.2 =
Actualización versión 3.0.2

= 3.0.1 =
Actualización versión 3.0.1

= 3.0.0 =
Actualización nueva versión 3.0.0

= 2.6.9 =
Actualización nueva versión 2.6.9

= 2.5.9 =
Actualización nueva versión 2.5.9

= 2.4.9 =
Actualización nueva versión 2.4.9

= 2.3.9 =
Actualización nueva versión 2.3.9

= 2.2.9 =
Actualización nueva versión 2.2.9

= 2.1.9 =
Actualización nueva versión 2.1.9

= 2.1.8 =
Actualización nueva versión 2.1.8

= 2.1.7 =
Actualización nueva versión 2.1.7

= 2.1.6 =
Actualización nueva versión 2.1.6

= 2.1.5 =
Actualización nueva versión 2.1.5

= 2.1.4 =
Actualización nueva versión 2.1.4

= 2.1.3 =
Actualización nueva versión 2.1.3

= 2.1.2 =
Actualización nueva versión 2.1.2

= 2.0.2 =
Actualización nueva versión 2.0.2

= 2.0.1 =
Actualización nueva versión 2.0.1

= 2.0.0 =
Actualización nueva versión 2.0.0

= 1.0.9 =
Actualización nueva versión 1.0.9

= 1.0.8 =
Actualización nueva versión 1.0.8

= 1.0.7 =
Actualización nueva versión 1.0.7

= 1.0.6 =
Actualización nueva versión 1.0.6

= 1.0.5 =
Actualización nueva versión 1.0.5

= 1.0.4 =
Actualización nueva versión 1.0.4

= 1.0.3 =
Actualización nueva versión 1.0.3

= 1.0.2 =
Actualización nueva versión 1.0.2

= 1.0.1 =
Actualización nueva versión 1.0.1

= 1.0.0 =
Actualización nueva versión 1.0.0

= 0.0.9 =
Actualización nueva versión 0.0.9

= 0.0.8 =
Actualización nueva versión 0.0.8

= 0.0.7 =
Actualización nueva versión 0.0.7

= 0.0.6 =
Actualización nueva versión 0.0.6

= 0.0.5 =
Actualización nueva versión 0.0.5

= 0.0.4 =
Actualización nueva versión 0.0.4

= 0.0.3 =
Actualización nueva versión 0.0.3
 
= 0.0.2 =
Actualización logo del FACT en el listado de ordenes transmitidas.
 
= 0.0.1 =
Versión inicial del complemento.