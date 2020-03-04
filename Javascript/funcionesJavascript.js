$(document).ready(function() {

	//para cargar un select de Marcas de los equipos
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarMarcas.php'
	})
	.done(function(Marcas) {
		$('#Marca').html(Marcas);
	})
	.fail(function() {
		//aca para en caso de falla
	})

	//para cargar un select de Tipos de los equipos
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarTipos.php'
	})
	.done(function(Tipos) {
		$('#Tipo').html(Tipos);
	})
	.fail(function() {
		//aca para en caso de falla
	})

	//para cargar un select de Pisos de los equipos
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarPiso.php'
	})
	.done(function(Pisos) {
		$('#Piso').html(Pisos)
	})
	.fail(function() {
		//aca para en caso de falla
	})

	$.ajax({
		type: 'POST',
		url: '../Controller/cargarGrupo.php'
	})
	.done(function(Grupo) {
		$('#Grupo').html(Grupo);
	})
	.fail(function() {
		//aca en caso de falla
	})

	$.ajax({
		type: 'POST',
		url: '../Controller/cargarSO.php'
	})
	.done(function(SO) {
		$('#SO').html(SO);
	})
	.fail(function() {
		//aca en caso de falla
	})

	//para cargar la consulta del equipo elegido
	var idEquipo= $('#idEquipo').val();
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarConsulta.php',
		data: {'idEquipo': idEquipo}
	})
	.done(function(Consulta) {
		$('.datosConsulta').html(Consulta);
	})
	.fail(function() {
		//aca para en caso de falla
	})

	//para cargar el historico del equipo
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarHistorico.php',
		data: {'idEquipo': idEquipo}
	})
	.done(function(Historico) {
		$('.historicoTabla').html(Historico);
	})
	.fail(function() {
		//aca para en caso de falla
	})

	$('#EquipoID').val(idEquipo);

	//para cargar el select de las sedes en actualizar equipo
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarSede.php',
		data: {'idEquipo': idEquipo}
	})
	.done(function(Sede) {
		$('#SedeActualizar').html(Sede);
	})
	.fail(function() {
		//aca en caso de falla
	})

	//para cargar el select de los pisos en actualizar equipo
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarPiso.php',
		data: {'idEquipo': idEquipo}
	})
	.done(function(Piso) {
		$('#PisoActualizar').html(Piso);
	})
	.fail(function() {
		//aca en caso de falla
	})

	//para cargar el select de los departamentos en actualizar equipo
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarDepartamento.php',
		data: {'idEquipo': idEquipo}
	})
	.done(function(Departamento) {
		$('#DepartamentoActualizar').html(Departamento);
	})
	.fail(function() {
		//aca en caso de falla
	})

	//para cargar el select de los usuarios en actualizar equipo
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarAdministrativo.php',
		data: {'idEquipo': idEquipo}
	})
	.done(function(Administrativo) {
		$('#AdministrativoActualizar').html(Administrativo);
	})
	.fail(function() {
		//aca en caso de falla
	})

	$.ajax({
		type: 'POST',
		url: '../Controller/cargarGrupo.php',
		data: {'idEquipo': idEquipo}
	})
	.done(function(Grupo) {
		$('#GrupoActualizar').html(Grupo);
	})
	.fail(function() {
		//aca en caso de falla
	})

	$.ajax({
		type: 'POST',
		url: '../Controller/cargarSO.php',
		data: {'idEquipo': idEquipo}
	})
	.done(function(SO) {
		$('#SOActualizar').html(SO);
	})
	.fail(function() {
		//aca en caso de falla
	})

	var busqueda= $('#busqueda').val();
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarInventario.php',
		data: {'busqueda': busqueda}
	})
	.done(function(Inventario) {
		$('.Consulta-Multiple').html(Inventario);
	})
	.fail(function() {
		//aca en caso de falla
	})

	//para cargar los datos de la tabla de Incidencias
	$.ajax({
		type: 'POST',
		url: '../Controller/cargarIncidencias.php'
	})
	.done(function(Incidencias) {
		$('#IncidenciasTabla').html(Incidencias)
	})
	.fail(function() {
		//aca para en caso de falla
	})

	//para cargar siguiente parte de formulario en caso de que sea un cpu
	$('#Tipo').change(function() {
		var idTipo= $('#Tipo').val();

		if (idTipo=='') {
			$('#Input-Tipo').empty();
			$('#Input-Tipo').append('<input class="form-control" type="text" name="Tipo" placeholder="Tipo">');
			$('#Grupo').attr("disabled", "disabled");
			$('#SO').attr("disabled", "disabled");
			$('#Nombre_Equipo').attr("disabled", "disabled");
			$('#MAC').attr("disabled", "disabled");
			$('#IP').attr("disabled", "disabled");
			$('#Red').attr("disabled", "disabled");
			$('#Voz').attr("disabled", "disabled");

		} else if(idTipo=='CASE O CPU') {
			$('#Input-Tipo').empty();
			$('#Grupo').removeAttr("disabled");
			$('#SO').removeAttr("disabled");
			$('#Nombre_Equipo').removeAttr("disabled");
			$('#MAC').removeAttr("disabled");
			$('#IP').removeAttr("disabled");
			$('#Red').removeAttr("disabled");
			$('#Voz').removeAttr("disabled");

		} else {
			$('#Input-Tipo').empty();
			$('#Grupo').attr("disabled", "disabled");
			$('#SO').attr("disabled", "disabled");
			$('#Nombre_Equipo').attr("disabled", "disabled");
			$('#MAC').attr("disabled", "disabled");
			$('#IP').attr("disabled", "disabled");
			$('#Red').attr("disabled", "disabled");
			$('#Voz').attr("disabled", "disabled");
		}
	})

	//para cargar un select de Modelos segun Marca de los equipos
	$('#Marca').change(function() {
		var id= $('#Marca').val();
		if (id=='') {
			$('#Input-Marca').empty();
			$('#Input-Marca').append('<input class="form-control" type="text" name="Marca" placeholder="Marca">');
			
			$.ajax({
				type: 'POST',
				url: '../Controller/cargarModelos.php',
				data: {'idMarca': id}
			})
			.done(function(Modelos) {
				$('#Modelo').html(Modelos);
			})
			.fail(function(){
				//aca para en caso de falla
			})
		} else {
			$.ajax({
				type: 'POST',
				url: '../Controller/cargarModelos.php',
				data: {'idMarca': id}
			})
			.done(function(Modelos) {
				$('#Modelo').html(Modelos);
			})
			.fail(function(){
				//aca para en caso de falla
			})

			$('#Input-Marca').empty();
		}
	})

	//
	$('#Modelo').change(function() {
		var id= $('#Modelo').val();
		if (id=='') {
			$('#Input-Modelo').empty();
			$('#Input-Modelo').append('<input class="form-control" type="text" name="Modelo" placeholder="Modelo">');
		} else {
			$('#Input-Modelo').empty();
		}
	})

	$('#Status').change(function() {
		var id= $('#Status').val();
		if (id=='') {
			$('#Input-Status').empty();
			$('#Input-Status').append('<input class="form-control" type="text" name="Status" placeholder="Status">');
		} else {
			$('#Input-Status').empty();
		}
	})

	$('#Sede').change(function() {
		var id= $('#Sede').val();
		if (id=='') {
			$('#Input-Sede').empty();
			$('#Input-Sede').append('<input class="form-control" type="text" name="Sede" placeholder="Sede">');
		} else {
			$('#Input-Sede').empty();
		}
	})

	//para cargar un select de Departamentos segun Piso de los equipos
	$('#Piso').change(function() {
		var id= $('#Piso').val();
		if (id=='') {
			$('#Input-Piso').empty();
			$('#Input-Piso').append('<input class="form-control" type="text" name="Piso" placeholder="Piso">');

			$.ajax({
				type: 'POST',
				url: '../Controller/cargarDepartamento.php',
				data: {'idPiso': id}
			})
			.done(function(Departamentos) {
				$('#Departamento').html(Departamentos);
			})
			.fail(function(){
				//aca para en caso de falla
			})
		} else {
			$.ajax({
				type: 'POST',
				url: '../Controller/cargarDepartamento.php',
				data: {'idPiso': id}
			})
			.done(function(Departamentos) {
				$('#Departamento').html(Departamentos);
			})
			.fail(function(){
				//aca para en caso de falla
			})

			$('#Input-Piso').empty();
		}
	})

	//para cargar un select de Usuarios segun Departamento de los equipos
	$('#Departamento').change(function() {
		var id= $('#Departamento').val();
		if (id=='') {
			$('#Input-Departamento').empty();
			$('#Input-Departamento').append('<input class="form-control" type="text" name="Departamento" placeholder="Departamento">');

			$.ajax({
				type: 'POST',
				url: '../Controller/cargarAdministrativo.php',
				data: {'idDepartamento': id}
			})
			.done(function(Administrativos) {
				$('#Administrativo').html(Administrativos);
			})
			.fail(function(){
				//aca para en caso de falla
			})
		} else {
			$.ajax({
				type: 'POST',
				url: '../Controller/cargarAdministrativo.php',
				data: {'idDepartamento': id}
			})
			.done(function(Administrativos) {
				$('#Administrativo').html(Administrativos);
			})
			.fail(function(){
				//aca para en caso de falla
			})

			$('#Input-Departamento').empty();
		}
	})

	$('#Administrativo').change(function() {
		var id= $('#Administrativo').val();
		if (id== '') {
			$('#Input-Administrativo').empty();
			$('#Input-Administrativo').append('<input class="form-control" type="text" name="Administrativo" placeholder="Usuario">');
		} else {
			$('#Input-Administrativo').empty();
		}
	})

	$('#Fallas').change(function() {
		var id= $('#Fallas').val();
		if (id=='') {
			$('#Input-Fallas').empty();
			$('#Input-Fallas').append('<input class="form-control" type="text" name="Fallas" placeholder="Falla">');
		} else {
			$('#Input-Fallas').empty();
		}
	})

	//aca tambien debo hacer la de tipo

	//para cargar la consulta del equipo individual
	$('#idEquipo').change(function() {
		var id= $('#idEquipo').val();
		id= Number(id);
		var numEquipos= $('#numEquipos').val();
		numEquipos= Number(numEquipos);
		if (id <= 0) {
			$('#idEquipo').val(1);
			id=1;
		} else if(id > numEquipos) {
			$('#idEquipo').val(numEquipos);
			id=numEquipos;
		} else {
			$('#idEquipo').val(id);
		}

		$.ajax({
			type: 'POST',
			url: '../Controller/cargarConsulta.php',
			data: {'idEquipo': id}
		})
		.done(function(Consulta) {
			$('.datosConsulta').html(Consulta);
		})
		.fail(function(){
			//aca para en caso de falla
		})

		$.ajax({
			type: 'POST',
			url: '../Controller/cargarHistorico.php',
			data: {'idEquipo': id}
		})
		.done(function(Historico) {
			$('.historicoTabla').html(Historico);
		})
		.fail(function(){
			//aca para en caso de falla
		})

		$('#EquipoID').val(id);
	})

	//para cargar los datos del equipo asi como el historico cuando presione el boton Anterior
	$('#Anterior').click(function () {
		var id= $('#idEquipo').val();
		id--
		if (id <= 0) {
			$('#idEquipo').val(1);
			id=1;
		} else {
			$('#idEquipo').val(id);
		}

		$.ajax({
			type: 'POST',
			url: '../Controller/cargarConsulta.php',
			data: {'idEquipo': id}
		})
		.done(function(Consulta) {
			$('.datosConsulta').html(Consulta);
		})
		.fail(function(){
			//aca para en caso de falla
		})

		$.ajax({
			type: 'POST',
			url: '../Controller/cargarHistorico.php',
			data: {'idEquipo': id}
		})
		.done(function(Historico) {
			$('.historicoTabla').html(Historico);
		})
		.fail(function(){
			//aca para en caso de falla
		})

		$('#EquipoID').val(id);
	})

	//para cargar los datos del equipo asi como el historico cuando presione el boton Siguiente
	$('#Siguiente').click(function () {
		var id= $('#idEquipo').val();
		var numEquipos= $('#numEquipos').val();
		id++;
		if (id > numEquipos) {
			$('#idEquipo').val(numEquipos);
			id= numEquipos;
		} else {
			$('#idEquipo').val(id);
		}
		
		$.ajax({
			type: 'POST',
			url: '../Controller/cargarConsulta.php',
			data: {'idEquipo': id}
		})
		.done(function(Consulta) {
			$('.datosConsulta').html(Consulta);
		})
		.fail(function(){
			//aca para en caso de falla
		})
		
		$.ajax({
			type: 'POST',
			url: '../Controller/cargarHistorico.php',
			data: {'idEquipo': id}
		})
		.done(function(Historico) {
			$('.historicoTabla').html(Historico);
		})
		.fail(function(){
			//aca para en caso de falla
		})

		$('#EquipoID').val(id);
	})

	$('#SedeActualizar').change(function() {
		var id= $('#SedeActualizar').val();

		if (id== '') {
			$('#Input-Sede').empty();
			$('#Input-Sede').append('<input class="form-control" type="text" name="Sede" placeholder="Sede">');
		} else {
			$('#Input-Sede').empty();
		}
	})

	$('#PisoActualizar').change(function() {
		var idPiso= $('#PisoActualizar').val();

		if (idPiso== '') {
			$('#Input-Piso').empty();
			$('#Input-Piso').append('<input class="form-control" type="text" name="Piso" placeholder="Piso">');

			$.ajax({
				type: 'POST',
				url: '../Controller/cargarDepartamento.php',
				data: {'idPiso': idPiso}
			})
			.done(function(Departamento) {
				$('#DepartamentoActualizar').html(Departamento);
			})
			.fail(function() {
				//aca en caso de falla
			})
		} else {

			$.ajax({
				type: 'POST',
				url: '../Controller/cargarDepartamento.php',
				data: {'idPiso': idPiso}
			})
			.done(function(Departamento) {
				$('#DepartamentoActualizar').html(Departamento);
			})
			.fail(function() {
				//aca en caso de falla
			})

			$('#Input-Piso').empty();
		}
	})

	$('#DepartamentoActualizar').change(function() {
		var idDepartamento= $('#DepartamentoActualizar').val();

		if (idDepartamento== '') {
			$('#Input-Departamento').empty();
			$('#Input-Departamento').append('<input class="form-control" type="text" name="Departamento" placeholder="Departamento">');

			$.ajax({
				type: 'POST',
				url: '../Controller/cargarAdministrativo.php',
				data: {'idDepartamento': idDepartamento}
			})
			.done(function(Administrativo) {
				$('#AdministrativoActualizar').html(Administrativo);
			})
			.fail(function() {
				//aca en caso de falla
			})
		} else {
			$.ajax({
				type: 'POST',
				url: '../Controller/cargarAdministrativo.php',
				data: {'idDepartamento': idDepartamento}
			})
			.done(function(Administrativo) {
				$('#AdministrativoActualizar').html(Administrativo);
			})
			.fail(function() {
				//aca en caso de falla
			})

			$('#Input-Departamento').empty();
		}
	})

	$('#AdministrativoActualizar').change(function() {
		var id= $('#AdministrativoActualizar').val();

		if (id== '') {
			$('#Input-Administrativo').empty();
			$('#Input-Administrativo').append('<input class="form-control" type="text" name="Administrativo" placeholder="Usuario">');
		} else {
			$('#Input-Administrativo').empty();
		}
	})

	$('#GrupoActualizar').change(function() {
		var id= $('#GrupoActualizar').val();

		if (id== '') {
			$('#Input-Grupo').empty();
			$('#Input-Grupo').append('<input class="form-control" type="text" name="Grupo" placeholder="Grupo">');
		} else {
			$('#Input-Grupo').empty();
		}
	})

	$('#SOActualizar').change(function() {
		var id= $('#SOActualizar').val();

		if (id=='') {
			$('#Input-SO').empty();
			$('#Input-SO').append('<input class="form-control" type="text" name="SO" placeholder="Sistema Operativo">');
		} else {
			$('#Input-SO').empty();
		}
	})
	
	$('#Grupo').change(function() {
		var id= $('#Grupo').val();

		if (id=='') {
			$('#Input-Grupo').empty();
			$('#Input-Grupo').append('<input class="form-control" type="text" name="Grupo" placeholder="Grupo">');
		} else {
			$('#Input-Grupo').empty();
		}
	})

	$('#SO').change(function() {
		var id= $('#SO').val();

		if (id=='') {
			$('#Input-SO').empty();
			$('#Input-SO').append('<input class="form-control" type="text" name="SO" placeholder="Sistema Operativo">');
		} else {
			$('#Input-SO').empty();
		}
	})

	$('#busqueda').change(function() {
		var busqueda= $('#busqueda').val();
		$.ajax({
			type: 'POST',
			url: '../Controller/cargarInventario.php',
			data: {'busqueda': busqueda}
		})
		.done(function(Inventario) {
			$('.Consulta-Multiple').html(Inventario);
		})
		.fail(function() {
			//aca en caso de falla
		})
		$('#Busqueda-PDF').val(busqueda);
		$('#Busqueda-Excel').val(busqueda);
	})

	$('#Boton-Busqueda').click(function() {
		var busqueda= $('#busqueda').val();
		$.ajax({
			type: 'POST',
			url: '../Controller/cargarInventario.php',
			data: {'busqueda': busqueda}
		})
		.done(function(Inventario) {
			$('.Consulta-Multiple').html(Inventario);
		})
		.fail(function() {
			//aca en caso de falla
		})
		$('#Busqueda-PDF').val(busqueda);
	})

	$('.Select-Rol').change(function() {
		var rol= $('.Select-Rol').val();
		$('.permisologia').empty();
		if (rol==1) {
			$('.permisologia').append('<div>Permisos</div>');
			$('.permisologia').append('<div><ul><li>Consultas de Inventario</li><li>Reportar Fallas o Mantenimiento</li><li>Administrar Usuarios</li><li>Actualizar Equipos</li><li>Descargar Reportes de Inventario</li><li>Consultar Log del Sistema</li><li>Acceso Total al Sistema</li></ul></div>');
		} else if(rol==2) {
			$('.permisologia').append('<div>Permisos</div>');
			$('.permisologia').append('<div><ul><li>Consultas de Inventario</li><li>Reportar Fallas o Mantenimiento</li><li>Actualizar Equipos</li><li>Descargar Reportes de Inventario</li></ul></div>');
		} else {
			$('.permisologia').append('<div>Permisos</div>');
			$('.permisologia').append('<div><ul><li>Consultas de Inventario</li><li>Descargar Reportes de Inventario</li></ul></div>');
		}
	})

	$('.custom-file-input').on('change', function(event) {
	    var inputFile = event.currentTarget;
	    $(inputFile).parent()
	        .find('.custom-file-label')
	        .html(inputFile.files[0].name);
	})

	$('#busqueda').tooltip()

	$('#idEquipo').tooltip()
})