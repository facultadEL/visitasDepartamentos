<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!--link rel="stylesheet" href="css/registroPasante.css"-->
	<title>Registro de Visitas</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap-responsive.css">
	<link rel="stylesheet" href="bootstrap/css/estilos.css">
	<script src="bootstrap/js/jquery-1.11.3.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script defer>
		var tieneDatos = false;

		var cantAlumnosAgregados = 0;
		var sep = '/--/';
		var sepTotal = '/-/-/';
		var dniAId = '#dniAlumno';
		var apellidoAId = '#apellidoAlumno';
		var nombreAId = '#nombreAlumno';
		var fechaAId = '#fechaAlumno';
		var mailAId = '#mailAlumno';
		var hiddenAId = '#idHiddenAlumno';
		var stringAlumnosPasar = "";

		var idVisita,nombreVisita, catedra, profesorCatedra, profesorVisita, movilidad,
		fecha, nombreEmpresa, areaEmpresa,nombreContacto,apellidoContacto,
		cargoContacto,mailContacto,telefonoEmpresa,motivoVisita;
		
		function sacarColor(me)
		{
	    	// $(me).css('border-color','initial');
	    	// $(me).css('outline','1px');
	    	loadScreen();
	    	$(me).css('box-shadow','0px 0px 10px 1px #ccc');
		}

		function setDatosVisita(datos)
		{
			tieneDatos = true;
			var vDatos = datos.split(sep);
			idVisita = vDatos[0];
			nombreVisita = vDatos[1];
			catedra = vDatos[2];
			profesorCatedra = vDatos[3];
			profesorVisita = vDatos[4];
			movilidad = vDatos[5];
			fecha = vDatos[6];
			nombreEmpresa = vDatos[7];
			areaEmpresa = vDatos[8];
			nombreContacto = vDatos[9];
			apellidoContacto = vDatos[10];
			cargoContacto = vDatos[11];
			mailContacto = vDatos[12];
			telefonoEmpresa = vDatos[13];
			motivoVisita = vDatos[14];
		}

		function setAlumnoXVisita(datos)
		{
			cantAlumnosAgregados++;
			alumnosAgregados.push(datos);

		}

		var alumnoDictionary = [];
		var alumnosAgregados = []

		function setAlumno(alumnoToSet)
		{
			alumnoDictionary.push(alumnoToSet);
		}


		function checkAlumno()
		{
			var encontro = 0;
			dniNuevoAlumno = $(dniAId).val();
			for(var i = 0; i < alumnoDictionary.length; i++)
			{
				var vDatosAlumno = alumnoDictionary[i].split(sep);
				if(dniNuevoAlumno == vDatosAlumno[0])
				{
					$(apellidoAId).val(vDatosAlumno[1]);
					$(nombreAId).val(vDatosAlumno[2]);
					$(fechaAId).val(vDatosAlumno[3]);
					$(mailAId).val(vDatosAlumno[4]);
					$(hiddenAId).val(vDatosAlumno[5]);
					encontro = 1;
				}
			}
			if(encontro == 0)
			{
				$(apellidoAId).val("");
				$(nombreAId).val("");
				$(fechaAId).val("");
				$(mailAId).val("");
				$(hiddenAId).val("");
			}
		}

		function toCapitalLetter(originalString)
		{
			originalString = originalString.toLowerCase();
			returnString = originalString[0].toUpperCase()+originalString.substr(1);
			return returnString;
		}

		function controlAlumnos()
		{
			dniActual = $(dniAId).val();
			for(var i = 0; i < alumnosAgregados.length; i++)
			{
				vDatosAlumnoAgregado = alumnosAgregados[i].split(sep);
				if(dniActual == vDatosAlumnoAgregado[0])
				{
					$('#alerta1').attr('hidden',false);
					return false;
				}
			}
			return true;
		}

		function addAlumno()
		{
			if(!controlAlumnos()) return false;
			if(!controlVacio(dniAId)) return false;
			if(!controlVacio(apellidoAId)) return false;
			if(!controlVacio(nombreAId)) return false;
			if(!controlVacio(fechaAId)) return false;
			if(!controlVacio(mailAId)) return false;
			//if(!controlMail(mailAId)) return false;
			cantAlumnosAgregados++;
			//stringAlumnosPasar += $(dniAId).val()+sep+$(apellidoAId).val()+sep+$(nombreAId).val()+sep+$(fechaAId).val()+sep+$(mailAId).val()+sep+$(hiddenAId)+sepTotal;
			stringToPush = $(dniAId).val()+sep+toCapitalLetter($(apellidoAId).val())+sep+toCapitalLetter($(nombreAId).val())+sep+$(fechaAId).val()+sep+$(mailAId).val()+sep+$(hiddenAId).val();
			alumnosAgregados.push(stringToPush);

			actualizarTabla();
			limpiarPantalla();

		}

		function volver()
		{
			window.location.href = 'escritorioVisitas.php';
		}

		function limpiarPantalla()
		{
			$(dniAId).val('');
			$(apellidoAId).val('');
			$(nombreAId).val('');
			$(fechaAId).val('');
			$(mailAId).val('');
			$(hiddenAId).val('-1');
		}

		function actualizarTabla()
		{
			stringToAdd = '';
			$('#cuerpoTabla').html('');

			for(var i = 0; i < alumnosAgregados.length; i++)
			{
				var vAlumno = alumnosAgregados[i].split(sep);
				stringToAdd += '<tr><td>'+vAlumno[0]+'</td><td>'+vAlumno[1]+'</td><td>'+vAlumno[2]+'</td><td>'+vAlumno[3]+'</td><td>'+vAlumno[4]+'</td><td><input type="button" class="btn btn-danger" value="X" onclick="borrarAlumno('+"'"+i+"'"+')"</td></tr>';
			}
			$('#cuerpoTabla').html(stringToAdd);
		}

		function borrarAlumno(index)
		{
			//Funcion que borra
			alumnosAgregados.splice(index,1);
			cantAlumnosAgregados--;
			actualizarTabla();
		}

		function controlVacio(nombreSelector)
		{
			if($.trim($(nombreSelector).val()) == '')
	    	{
	        	// $(nombreSelector).css('border-color','red');
	        	// $(nombreSelector).css('outline','0px');
	        	$('#alertaDatos').attr('hidden',false);
	        	$(nombreSelector).css('box-shadow','0px 0px 10px 5px #f24d4d');

		        $(nombreSelector).focus();
	    	    return false;
	    	}
	    	return true;
		}

		function controlMail(nombreSelector)
		{
			if($(nombreSelector).val().indexOf('@') == -1)
			{
				$(nombreSelector).css('box-shadow','0px 0px 10px 5px #f24d4d');

		        $(nombreSelector).focus();
				return false;
			}
			return true;
		}

		function controlSubmit()
		{
			//Llamar a control vacio con las variables obligatorias
			if(!controlVacio('#nombreVisita')) return false;
			if(!controlVacio('#fechaVisita')) return false;
			if(!controlVacio('#catedra')) return false;
			if(!controlVacio('#profesorCatedra')) return false;
			if(!controlVacio('#movilidad')) return false;
			if(!controlVacio('#motivo')) return false;
			if(!controlVacio('#nombreEmpresa')) return false;
			if(!controlVacio('#areaEmpresa')) return false;
			if(!controlVacio('#caracteristicaEmpresa')) return false;
			if(!controlVacio('#telefonoEmpresa')) return false;
			if(!controlVacio('#nombreContacto')) return false;
			if(!controlVacio('#apellidoContacto')) return false;
			if(!controlVacio('#cargoContacto')) return false;

			if(cantAlumnosAgregados < 1)
			{
				$('#alertaAlumnos').attr('hidden',false);
				return false;
			}
			else
			{
				datosAlumnosEnviar=""
				for(var i = 0; i < alumnosAgregados.length; i++)
				{
					datosAlumnosEnviar += alumnosAgregados[i];
					if(i < (alumnosAgregados.length - 1))
					{
						datosAlumnosEnviar += sepTotal;
					}
				}
				$('#datosAlumnos').val(datosAlumnosEnviar);
			}

			return true;
		}

		$(document).ready(function(){
			if(tieneDatos)
			{
				$('#idVisitaHidden').val(idVisita);
				$('#nombreVisita').val(nombreVisita);
				$('#fechaVisita').val(fecha);
				$('#catedra').val(catedra);
				$('#profesorCatedra').val(profesorCatedra);
				$('#profesorVisita').val(profesorVisita);
				$('#movilidad').val(movilidad);
				$('#motivo').val(motivoVisita);
				$('#nombreEmpresa').val(nombreEmpresa);
				$('#areaEmpresa').val(areaEmpresa);
				vTelefonoEmpresa = telefonoEmpresa.split('-');
				$('#caracteristicaEmpresa').val(vTelefonoEmpresa[0]);
				$('#telefonoEmpresa').val(vTelefonoEmpresa[1]);
				$('#nombreContacto').val(nombreContacto);
				$('#apellidoContacto').val(apellidoContacto);
				$('#cargoContacto').val(cargoContacto);
				$('#mailContacto').val(mailContacto);

				actualizarTabla();
			}
		});


		function loadScreen(){
		  $('#alerta1').attr('hidden', true);
		  $('#alertaDatos').attr('hidden', true);
		  $('#alertaAlumnos').attr('hidden', true);
		}
	</script>
</head>
<body onload="loadScreen()">
<?php

include_once "conexion.php";
include_once "scripts/libreria.php";

$idVisita = (empty($_REQUEST['idVisita'])) ? 0 : $_REQUEST['idVisita'];

$sep = '/--/';

if($idVisita != 0)
{
	$condicion = "id=$idVisita LIMIT 1;";
	$sqlVisita = traerSqlCondicion('*','visita',$condicion);
	$rowVisita = pg_fetch_array($sqlVisita);
	$datosVisita = $rowVisita['id'].$sep;
	$datosVisita .= $rowVisita['nombre'].$sep;
	$datosVisita .= $rowVisita['catedra'].$sep;
	$datosVisita .= $rowVisita['profesor_catedra'].$sep;
	$datosVisita .= $rowVisita['profesor_visita'].$sep;
	$datosVisita .= $rowVisita['movilidad'].$sep;
	$datosVisita .= $rowVisita['fecha'].$sep;
	$datosVisita .= $rowVisita['nombre_empresa'].$sep;
	$datosVisita .= $rowVisita['area_empresa'].$sep;
	$datosVisita .= $rowVisita['nombre_contacto'].$sep;
	$datosVisita .= $rowVisita['apellido_contacto'].$sep;
	$datosVisita .= $rowVisita['cargo_contacto'].$sep;
	$datosVisita .= $rowVisita['mail_contacto'].$sep;
	$datosVisita .= $rowVisita['telefono_empresa'].$sep;
	$datosVisita .= $rowVisita['motivo_visita'];

	echo "<script>setDatosVisita('".$datosVisita."')</script>";

	$condicion = "visita_fk=".$rowVisita['id'];
	$sqlAlumnoXVisita = traerSqlCondicion('alumno.*','alumnoxvisita INNER JOIN alumno ON(alumno.id = alumnoxvisita.alumno_fk)',$condicion);
	while($rowAlumnoXVisita = pg_fetch_array($sqlAlumnoXVisita))
	{
		$datosAlumno = $rowAlumnoXVisita['dni'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['apellido'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['nombre'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['fecha_nac'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['mail'].$sep;
		$datosAlumno .= $rowAlumnoXVisita['id'];
		
		echo "<script>setAlumnoXVisita('".$datosAlumno."')</script>";
	}

}

$cantAlumnos = contarRegistro('id','alumno',null);
if($cantAlumnos > 0)
{
	$sqlAlumnos = traerSql('*','alumno');
	while($rowAlumnos = pg_fetch_array($sqlAlumnos))
	{
		$dataAlumno = $rowAlumnos['dni'].$sep.$rowAlumnos['apellido'].$sep.$rowAlumnos['nombre'].$sep.$rowAlumnos['fecha_nac'].$sep.$rowAlumnos['mail'].$sep.$rowAlumnos['id'];
		echo "<script>setAlumno('".$dataAlumno."')</script>";
	}
}

?>
<div class="container">
		<div class="margen_sup"></div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Registrar Nueva Visita</h3>
			</div>

			<div class="panel-body panel_body">
				<form name="f1" id="form2" action="guardarVisita.php" onsubmit="return controlSubmit();" method="post" class="form-horizontal col-xs-12 col-sm-12 col-md-12 col-lg-12 formNuevaVisita">
					<div class="row">
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
							<div class="alert alert-danger text-center" id="alerta1">
								<strong>Atenci&oacute;n:</strong> El alumno ya est&aacute; agregado.
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
							<div class="alert alert-danger text-center" id="alertaDatos">
								<strong>Atenci&oacute;n:</strong> Faltan agregar datos.
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xs-offset-2 col-sm-offset-2 col-md-offset-2 col-lg-offset-2">
							<div class="alert alert-danger text-center" id="alertaAlumnos">
								<strong>Atenci&oacute;n:</strong> Se debe agregar por lo menos un alumno.
							</div>
						</div>
					</div>

					<div class="row">
						<legend class="text-left"><h4 class="text-left">Datos de la visita</h4></legend>
					</div>

					<input type="hidden" name="idVisitaHidden" id="idVisitaHidden" value="0"/>
					<input type="hidden" name="datosAlumnos" id="datosAlumnos" value="" />

					<div class="row">
						<div class="form-group">
							<label for="nombreVisita" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Nombre:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="nombreVisita" type="text" id="nombreVisita" onkeydown="sacarColor(this)" required /></div>
							
							<label for="fechaVisita" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Fecha:</label>
							<div class="col-xs-10 col-sm-4 col-md-3 col-lg-3"><input class="form-control" name="fechaVisita" type="date" id="fechaVisita" onkeydown="sacarColor(this)" required /></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="catedra" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">C&aacute;tedra:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="catedra" type="text" id="catedra" onkeydown="sacarColor(this)" required /></div>
							
							<label for="profesorCatedra" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Profesor C&aacute;tedra:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="profesorCatedra" type="text" id="profesorCatedra" onkeydown="sacarColor(this)" required /></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="profesorVisita" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Profesor Visita:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="profesorVisita" type="text" id="profesorVisita" onkeydown="sacarColor(this)"  /></div>
							
							<label for="movilidad" class="control-label col-xs-4 col-sm-2 col-md-2 col-lg-2">Medio de Movilidad:</label>
							<div class="col-xs-8 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="movilidad" type="text" id="movilidad" onkeydown="sacarColor(this)" required /></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="motivo" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Motivo:</label>
							<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
								<textarea class="form-control" name="motivo" rows="3" id="motivo" onkeydown="sacarColor(this)"></textarea>
							</div>
						</div>
					</div>
					<!-- <label for="nombreVisita">Nombre: </label>
					<input type="text" name="nombreVisita" id="nombreVisita" onkeydown="sacarColor(this)"/>
					<label for="fechaVisita">Fecha: </label>
					<input type="date" name="fechaVisita" id="fechaVisita" onkeydown="sacarColor(this)"/> 
					<label for="catedra">C&aacute;tedra:</label>
					<input type="text" name="catedra" id="catedra" onkeydown="sacarColor(this)"/>
					<label for="profesorCatedra">Profesor a cargo de la c&aacute;tedra:</label>
					<input type="text" name="profesorCatedra" id="profesorCatedra" onkeydown="sacarColor(this)"/>
					<label for="profesorVisita">Profesor a cargo de la visita:</label>
					<input type="text" name="profesorVisita" id="profesorVisita" />
					<label for="movilidad">Medio de movilidad:</label>
					<input type="text" name="movilidad" id="movilidad" onkeydown="sacarColor(this)"/>
					<label for="motivo">Motivo de la visita:</label>
					<textarea name="motivo" id="motivo" onkeydown="sacarColor(this)"></textarea>-->
					
					<div class="row">
						<legend class="text-left"><h4 class="text-left">Datos de la Empresa</h4></legend>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="nombreEmpresa" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Raz&oacute;n Social:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="nombreEmpresa" type="text" id="nombreEmpresa" onkeydown="sacarColor(this)" required /></div>
							
							<label for="areaEmpresa" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">&Aacute;rea:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="areaEmpresa" type="text" id="areaEmpresa" onkeydown="sacarColor(this)" required /></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="caracteristicaEmpresa" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">T&eacute;lefono:</label>
							<div class="col-xs-3 col-sm-2 col-md-2 col-lg-1"><input class="form-control" name="caracteristicaEmpresa" type="text" pattern="[1-9]{2,4}" placeholder="Sin 0" maxlength="5" id="caracteristicaEmpresa" onkeydown="sacarColor(this)" required /></div>
							<div class="col-xs-7 col-sm-3 col-md-3 col-lg-3"><input class="form-control" name="telefonoEmpresa" type="text" pattern="[0-9]{6,8}" placeholder="Sin 15" id="telefonoEmpresa" onkeydown="sacarColor(this)" required /></div>
						</div>
					</div>
			<!-- <fieldset>
				<legend>Datos de la Empresa</legend>
					<label for="nombreEmpresa">Nombre de la empresa:</label>
					<input type="text" name="nombreEmpresa" id="nombreEmpresa" onkeydown="sacarColor(this)"/>
					<label for="areaEmpresa">&Aacute;rea de la empresa:</label>
					<input type="text" name="areaEmpresa" id="areaEmpresa" onkeydown="sacarColor(this)"/>
					<label for="caracteristicaEmpresa">T&eacute;lefono:</label>
					<input type="text" name="caracteristicaEmpresa" id="caracteristicaEmpresa" onkeydown="sacarColor(this)"/>
					<input type="text" name="telefonoEmpresa" id="telefonoEmpresa" onkeydown="sacarColor(this)"/>
			</fieldset> -->

					<div class="row">
						<legend class="text-left"><h4 class="text-left">Datos del Contacto</h4></legend>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="nombreContacto" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Nombre:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="nombreContacto" type="text" id="nombreContacto" onkeydown="sacarColor(this)" /></div>
							
							<label for="apellidoContacto" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Apellido:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="apellidoContacto" type="text" id="apellidoContacto" onkeydown="sacarColor(this)" /></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="cargoContacto" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Cargo:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="cargoContacto" type="text" id="cargoContacto" onkeydown="sacarColor(this)" /></div>
							
							<label for="mailContacto" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Mail:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="mailContacto" type="mail" id="mailContacto" onkeydown="sacarColor(this)" /></div>
						</div>
					</div>
			<!-- <fieldset>
				<legend>Datos del Contacto</legend>
					<label for="nombreContacto">Nombre:</label>
					<input type="text" name="nombreContacto" id="nombreContacto" onkeydown="sacarColor(this)"/>
					<label for="apellidoContacto">Apellido:</label>
					<input type="text" name="apellidoContacto" id="apellidoContacto" onkeydown="sacarColor(this)"/>
					<label for="cargoContacto">Cargo que ocupa:</label>
					<input type="text" name="cargoContacto" id="cargoContacto" onkeydown="sacarColor(this)"/>
					<label for="mailContacto">Mail:</label>
					<input type="mail" name="mailContacto" id="mailContacto" />
			</fieldset> -->

					<div class="row">
						<legend class="text-left"><h4 class="text-left">Alumnos</h4></legend>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="dniAlumno" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">DNI:</label>
							<div class="col-xs-10 col-sm-4 col-md-2 col-lg-2"><input class="form-control" name="dniAlumno" pattern="([0-9]{1}|[0-9]{2})[0-9]{3}[0-9]{3}" maxlength="10" title="Solo n&uacute;meros" type="text" id="dniAlumno" onblur="checkAlumno()" onkeydown="sacarColor(this)"  /></div>
							<input type="hidden" name="idHiddenAlumno" id="idHiddenAlumno" value="-1"/>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="nombreAlumno" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Nombre:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="nombreAlumno" type="text" id="nombreAlumno" onkeydown="sacarColor(this)" /></div>

							<label for="apellidoAlumno" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2">Apellido:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="apellidoAlumno" type="text" id="apellidoAlumno" onkeydown="sacarColor(this)" /></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<label for="fechaAlumno" class="control-label col-xs-4 col-sm-2 col-md-2 col-lg-2">Fecha de Nacimiento:</label>
							<div class="col-xs-8 col-sm-4 col-md-3 col-lg-3"><input class="form-control" name="fechaAlumno" type="date" id="fechaAlumno" onkeydown="sacarColor(this)" /></div>

							<label for="mailAlumno" class="control-label col-xs-2 col-sm-2 col-md-2 col-lg-2 col-md-offset-1 col-lg-offset-1">Mail:</label>
							<div class="col-xs-10 col-sm-4 col-md-4 col-lg-4"><input class="form-control" name="mailAlumno" type="mail" id="mailAlumno" onkeydown="sacarColor(this)" /></div>
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<p>
								<center><button type="button" id="agregarAlumno" onclick="addAlumno();" class="btn btn-primary btn-sm" title="Agregar alumno">Agregar</button></center>
							</p>
						</div>
					</div>

					<table id="tablaTotalAlumnos" class="table table-striped table-condensed">
						<thead>
							<tr>
								<th>DNI</th>
								<th>Apellido</th>
								<th>Nombre</th>
								<th>Fecha Nacimiento</th>
								<th>Mail</th>
							</tr>
						</thead>
						<tbody id="cuerpoTabla">
							
						</tbody>
					</table>
			<!-- <fieldset>
				<legend>Alumnos</legend>
					<label for="dniAlumno">DNI: </label>
					<input type="text" name="dniAlumno" id="dniAlumno" onblur="checkAlumno()"/>
					<input type="hidden" name="idHiddenAlumno" id="idHiddenAlumno" value="-1"/>
					<label for="nombreAlumno">Nombre:</label>
					<input type="text" name="nombreAlumno" id="nombreAlumno" />
					<label for="apellidoAlumno">Apellido:</label>
					<input type="text" name="apellidoAlumno" id="apellidoAlumno" />
					<label for="fechaAlumno">Fecha de Nacimiento:</label>
					<input type="date" name="fechaAlumno" id="fechaAlumno" />
					<label for="mailAlumno">Mail:</label>
					<input type="mail" name="mailAlumno" id="mailAlumno" />
					<input type="button" id="agregarAlumno" name="agregarAlumno" value="Agregar" onclick="addAlumno();"/>
					<table id="tablaTotalAlumnos">
						<thead>
							<td>
								DNI
							</td>
							<td>
								Apellido
							</td>
							<td>
								Nombre
							</td>
							<td>
								Fecha Nacimiento
							</td>
							<td>
								Mail
							</td>
							<td>
							</td>
						</thead>
						<tbody id="cuerpoTabla">
							
						</tbody>
					</table> 
			</fieldset>-->
					<?php include_once "cerrar_conexion.php"; ?>
					<div class="row">
						<div class="form-group">
							<p>
								<center>
									<button type="button" id="agregarAlumno" onclick="volver();" class="btn btn-default submit" title="Salir">Volver</button>
									<button type="submit" id="agregarAlumno" class="btn btn-default submit" title="Guardar">Guardar</button>
								</center>
							</p>
						</div>
					</div>
				</form>
			</div>
		</div>

</body>
</html>