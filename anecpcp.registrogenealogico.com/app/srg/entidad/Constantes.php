<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Constantes
 *
 * @author Balvis
 */

class Constantes{
    
     /// FIN CONSTANTES DE rutas
    
     const K_RUTA_IMAGEN_OPCION="images/img/";
    
    const K_SESSION_LOGOUT="La sesión ha finalizado";
    const K_SESSION_LOGIN="La sesión está activa";
    const K_ID_EMPRESA_DEFAULT = "001";
    const K_SESSION_EMPRESA="CodigoEmpresa";
    const K_SESSION_USUARIO="Usuario";
    const K_SESSION_USUARIO_LOGIN="Login";
    const K_SESSION_NOMBRE_COMPLETO="NombresCompletos";
    const K_SESSION_CORREO_USUARIO="Correo";
    const K_SESSION_ROL_USUARIO="Rol";
    const K_SESSION_CODIGO_USUARIO="UsuarioCodigo";
    const K_SESSION_CARGO_USUARIO="UsuarioCargo";
    const K_SESSION_CODIGO_LOCAL="CodigoLocal";
    const K_SESSION_CODIGO_TURNO_ACTUAL="CodigoTurnoSel";
    const K_SESSION_NOMBRE_TURNO="NombreTurno";
    
    const K_SESSION_EMPRESA_DIRECCION="EmpresaDir";    
    const K_SESSION_EMPRESA_LOGO="EmpresaLogo";    
    const K_SESSION_EMPRESA_TELEFONO="EmpresaTelf";    
    const K_SESSION_EMPRESA_NOMBRE="EmpresaNom";  
    const K_SESSION_EMPRESA_RAZON="EmpresaRazon"; 
    const K_SESSION_PRODUCTO_SEL="ProductosSel";  
    const K_SESSION_PERFILES="__Perfiles";  
    const K_SESSION_PERFIL_SEL="perfilSel";  
    
    const K_SESSION_PROD_COMPRA_SEL="ProductosCompraSel";  
    const K_SESSION_PROD_VENTA_SEL="ProductosVentaSel";  
    const K_SESSION_DSCTO_VENTA_VAL="_DsctoVenta"; 
    
    /// CONSTANTES DE MENSAJES DE MANTENIMIENTOS
    const K_MENSAJE_INSERT_OK="Se registr&oacute; Correctamente";
    const K_MENSAJE_INSERT_NOOK="No se pudo grabar el registro ";
    const K_MENSAJE_INSERT_NOOK_DP = "Existe Duplicidad";

    const K_MENSAJE_SELECT_OK = "Consulta exitosa";
    const K_MENSAJE_SELECT_NOOK = "Consulta no exitosa";

    const K_MENSAJE_INSCRIPCION_EXITO = "Se ha registrado un nuevo ejemplar en el registro genealógico con el código: ";
   
    const K_MENSAJE_VALIDACION_INS = "No se puede agregar o editar una imagen ya que la inscripción del ejemplar se encuentra aprobada";
    const k_MENSAJE_VALIDADOR_NAC = "La solicitud de nacimiento ya ha sido aprobada";
    const K_MENSAJE_UPDATE_NOOK="No se pudo actualizar el registro";
    const K_MENSAJE_UPDATE_OK="Se actualiz&oacute; Correctamente";
    const K_MENSAJE_UPDATE_NOOK_DP = "Existe Duplicidad";
    
    const K_MENSAJE_DELETE_NOOK="No se pudo eliminar el registro.";
    const K_MENSAJE_DELETE_OK="Se elimin&oacute; Correctamente";
    const K_MENSAJE_DELETE_NOOK_REF="No se pudo eliminar el registro.Existen referencias del código en otra tabla";
    const K_MENSAJE_NOOK_CRIADOR="Solo puede tener un criadero";
    const K_MENSAJE_COOPROPIEDAD_VALIDATE="Sólo se puede agregar un copropietario. Si desea crear una nueva copropiedad, vuelva agregar los propietarios";
    const K_MENSAJE_COOPROPIEDAD_VALIDATE_ERROR="No se pudo registrar la propiedad o coopropiedad.";

    const K_MENSAJE_PREF_NOMBRE_DUPLICATE="Ya existe el prefijo y nombre del ejemplar.";
    const K_MENSAJE_NOMBRE_SUPER_CAMP="El nombre del ejemplar que desea utilizar ya está asignado a un Campeón de Campeones, verificar otro nombre.";
    /// FIN CONSTANTES DE MANTENIMIENTOS
    
     const K_RESULTADO_OK=1;
     const K_RESULTADO_NOOK=0;
     
     
     const K_ERROR_APLICACION=1;
     const K_ERROR_SESION_TIMEOUT=2;
     const K_ERROR_USUARIO=2;
     
     const K_ESTADO_ACTIVO="A";
     const K_ESTADO_INACTIVO="I";
     
     const K_CANTIDAD_DECIMAL=2;

     /*codigo del tipo de transferencia por embrion*/
     const K_TRANSFER_EMBRION=5;
     const K_FECHA_VALIDATE_TE=20180228;
     
     const K_URL_REDIRECT='http://localhost:81/teon/srg/ecu/anecpcp.registrogenealogico.com/app/srg/';
 
     const K_SEPARADOR_RESENIA = ', ';
     const K_MENSAJE_DELETE_NOOK_TIENE_NAC = "NO SE PUEDE ELIMINAR EL SERVICIO.  EL SERVICIO YA SE ENCUENTRA ASOCIADO A UNA SOLICITUD DE NACIMIENTO.";
    
}

class ConstantesTablas{
    
    const K_TODOS="0";
    const K_TIPO_PRODUCTO="1";
    const K_IMPUESTO="2";
    const k_TIPO_VENTA="5";
    const K_TIPO_MOTIVO="6";
    const K_UNIDAD_MEDIDA="7";
    const K_TIPO_DOCUMENTO_VENTA="8";
    const K_TIPO_CLIENTE="9";    
    const K_PARAM_VENTA="10";    
}

class ConstantesTipoDocParam{
    

    const K_PROPIO="1";
    const K_GENERICO="2";
    const K_COMERCIAL="3";
}
class ConstantesTipoCompVentaParam{
    const K_TICKET="1";
    const K_BOLETA="2";
    const K_FACTURA="3";
}
class ConstantesImpuestoParam{
    const K_IGV="1";
}
class ConstantesParamVenta{
    const K_FACTURA="1";
    const K_TICKET="2";
}
class ConstantesCatpcha{
    const K_CLAVE_SITIO='6LcsW1QnAAAAAKqGcFVLrUHq7gPrB9C5LLnDFfuf';
    const K_CLAVE_SECRETA='6LcsW1QnAAAAADLdAD7_9HPWU2Eo000fLKVLYntM';
    const K_URL_GOOGLE_VERIFY="https://www.google.com/recaptcha/api/siteverify";
    const K_PUNTUACION=0.7;
 }
class ConstantesPathWeb{
    
 /*RUTA PARA CARGA DE IMG TRANSFERENCIA DEL SRG*/
const K_PATH_TRANS_IMG='/home/h7b2lwjt47m6/public_html/app/srg_documentos/imgtrans/';
const K_PATHWEB_TRANS_IMG='http://localhost:81/teon/srg/ecu/anecpcp.registrogenealogico.com/app/srg_documentos/imgtrans/';

/*RUTA PARA CARGA DE IMG Y PDF DE INSCRIPCIONES*/
const K_PATH_INS_IMG='/home/h7b2lwjt47m6/public_html/app/srg_documentos/imgins/';
const K_PATHWEB_INS_IMG='http://localhost:81/teon/srg/ecu/anecpcp.registrogenealogico.com/app/srg_documentos/imgins/';

const K_PATH_INS_PDF='/home/h7b2lwjt47m6/public_html/app/srg_documentos/pdfins/';
const K_PATHWEB_INS_PDF='http://localhost:81/teon/srg/ecu/anecpcp.registrogenealogico.com/app/srg_documentos/pdfins/';

/*RUTA PARA CARGA DE IMG Y PDF DE NACIMIENTO*/
const K_PATH_NAC_IMG='/home/h7b2lwjt47m6/public_html/app/srg_documentos/imgnac/';
const K_PATHWEB_NAC_IMG='http://localhost:81/teon/srg/ecu/anecpcp.registrogenealogico.com/app/srg_documentos/imgnac/';

const K_PATH_NAC_PDF='/home/h7b2lwjt47m6/public_html/app/srg_documentos/pdfnac/';
const K_PATHWEB_NAC_PDF='http://localhost:81/teon/srg/ecu/anecpcp.registrogenealogico.com/app/srg_documentos/pdfnac/';


   
}
 /**RUTA PARA CARGA DE PDF DE MONTA */
define('K_PATH_MONTA_PDF','/home/h7b2lwjt47m6/public_html/app/srg_documentos/pdfmonta');
define('K_PATHWEB_MONTA_PDF','http://localhost:81/teon/srg/ecu/anecpcp.registrogenealogico.com/app/srg_documentos/pdfmonta/');