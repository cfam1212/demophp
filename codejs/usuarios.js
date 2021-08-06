$(document).ready(function(){
    var _fecha, _fechacaduca, _caduca, _cambiar, _id, _opcion, _data, _estado, _fila, _loginold, _passold, _imagen, _row,
    _username, _lastname, _login, _password, _perfil, _userid, _usuario, _continuar, _button;

    $("#modalNewUser").draggable({
        handle: ".modal-header"
    });     

    $("#btnNuevo").click(function(){
        $("#frmUserNew").trigger("reset");
        // $("#divcheck").hide();
        $("#header").css("background-color","#5D6D7E");
        $("#header").css("color","white");
        $(".modal-title").text("Nuevo Usuario");  
        $("#modalNewUser").modal("show");
        $("#chkEstado").prop("checked", true);
        $("#chkEstado").prop("disabled", true);
        _id=0;
        _opcion=0;
        _estado='Activo';

        preview = document.getElementById('image-preview'),
        image = document.createElement('img');
        image.setAttribute("class","img-fluid px-3 px-sm-4 mt-3 mb-4");
        image.setAttribute("style", "width: 10rem;");
        image.src = '../images/sin-user.png';
        preview.innerHTML = '';
        preview.append(image);        

        $("#chkCaduca").prop("checked", false);
        $("#lblCaduca").text("NO"); 
        $("#txtFechacaduca").prop('disabled','disabled');
        $("#txtFechacaduca").val(_fechacaduca);
        $("#chkCambiar").prop("checked", false);
    });

    _fecha = new Date();
    _fechacaduca = moment(_fecha).format("YYYY/MM/DD");

    $(document).on("click","#chkCaduca",function(){
        if($("#chkCaduca").is(":checked")){
            $("#lblCaduca").text("SI");
            $("#txtFechacaduca").prop('disabled','');
            _caduca = 'SI';
        }else{
            $("#lblCaduca").text("NO");
            $("#txtFechacaduca").prop('disabled','disabled');
            _caduca = 'NO';
        }
    });

    $('#txtFechacaduca').datepicker(
    {
        inline: true,
        dateFormat: "yy/mm/dd",
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        numberOfMonths: 1,
        showButtonPanel: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "-100:+5"
    });

    $(document).on("click","#chkCambiar",function(){
        if($("#chkCambiar").is(":checked")){
            $("#lblCambiar").text("SI");
            _cambiar = 'SI';
        }else{
            $("#lblCambiar").text("NO");
            _caduca = 'SI';
        }
    });    

    document.getElementById("txtImagen").onchange = function(e) {
        let reader = new FileReader();
        reader.readAsDataURL(e.target.files[0]);
        reader.onload = function(){
            let preview = document.getElementById('image-preview'),
                    image = document.createElement('img');
            image.setAttribute("class","img-fluid px-3 px-sm-4 mt-3 mb-4");
            image.setAttribute("style", "width: 10rem;");
        
            image.src = reader.result;
        
            preview.innerHTML = '';
            preview.append(image);
        };
    }
    
    $(document).on("click","#btnEditar",function(){        
        _fila = $(this).closest("tr");
        _data = $('#tabledata').dataTable().fnGetData(_fila);
        _id = _data[0];
        _loginold = _data[2];
        _estado = _data[4];
        _opcion = 1;
        $.ajax({
            url: "../bd/consultadatos.php",
            type: "POST",
            dataType: "json",
            data: {tipo:23, auxv1:"", auxv2:"", auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:_id, auxi2:0, auxi3:0, auxi4:0, auxi5:0, auxi6:0, 
            opcion:0},
            success: function(data){
                _passold = data[0].Pass;
                _caduca = data[0].Caduca;
                _cambiar = data[0].Cambiar;

                $("#txtFechacaduca").val(data[0].FechaCaduca);
                $("#txtUsername").val(data[0].Nombres);
                $("#txtLastname").val(data[0].Apellidos);
                $("#txtLogin").val(data[0].Login);
                $("#txtPassword").val(data[0].Pass);
                $("#cboPerfil").val(data[0].CodigoPerf);

                if(_caduca == 'SI'){
                    $("#chkcaduca").prop("checked", true);
                    $("#lblcaduca").text("SI"); 
                    $("#fechacaduca").prop('disabled','');                    
                }

                if(_cambiar == 'SI'){
                    $("#chkCambiar").prop("checked", true);
                    $("#lblCambiar").text('SI');
                }

                _imagen = data[0].Imagen == '' ? '../images/sin-user.png' : '../images/' + data[0].Imagen;
                preview = document.getElementById('image-preview'),
                image = document.createElement('img');
                image.setAttribute("class","img-fluid px-3 px-sm-4 mt-3 mb-4");
                image.setAttribute("style", "width: 10rem;");
                image.src = _imagen;
                preview.innerHTML = '';
                preview.append(image);
            },
            error: function (error) {
                console.log(error);
            }                  
        });

        $("#frmUserNew").trigger("reset");
        $("#divcheck").show();
        $("#header").css("background-color","#5D6D7E");
        $("#header").css("color","white");
        $(".modal-title").text("Editar Usuario");
        $("#modalNewUser").modal("show");
        
        $("#login").val(_loginold);

        if(_estado == "Activo"){
            $("#chkEstado").prop("checked", true);
            $("#lblEstado").text("Activo");            
        }else{
            $("#chkEstado").prop("checked", false);
            $("#lblEstado").text("Inactivo");
        }
    });

    $(document).on("click","#chkEstado",function(){
        if($("#chkEstado").is(":checked")){
            $("#lblEstado").text("Activo");
            _estado = 'Activo';
        }else{
            $("#lblEstado").text("Inactivo");
            _estado = 'Inactivo';
        }
    });    
    
    $(document).on("click","#btnEliminar",function(e){   
        _fila = $(this);  
        _row = $(this).closest('tr');     
        _data = $('#tabledata').dataTable().fnGetData(_row);
        _id = _data[0];
        _username = _row.find('td:eq(0)').text();
        Swal.fire({
            title: 'Está Seguro de Borrar '+ _username ,
            text: 'El registro será eliminado..',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Eliminar',
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve) {
                    $.ajax({
                        url: "../bd/consultadatos.php",
                        type: "POST",
                        dataType: "json",
                        data: {tipo:22, auxv1:"", auxv2:"", auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:_id, auxi2:0, auxi3:0, auxi4:0, auxi5:0, 
                        auxi6:0, opcion:2},
                        success: function(data){
                            Swal.close();
                            TableData.row(_fila.parents('tr')).remove().draw();
                            alertify.error('Registro Eliminado..!');
                        },
                        error: function (error) {
                            console.log(error);
                        }                  
                    });
                });
            }            
        });
    });

    $('#btnSave').click(function(e){
        e.preventDefault();
        _username = $.trim($("#txtUsername").val());
        _lastname = $.trim($("#txtLastname").val());
        _login = $.trim($("#txtLogin").val());
        _password = $.trim($("#txtPassword").val());
        _fechacaduca = $.trim($("#txtFechacaduca").val());
        _perfil = $('#cboPerfil').val();
        _imagen = document.getElementById("txtImagen");

        if(_opcion == 1){
            if(_passold != _password){
                _opcion = 2;
            }
        }

        if(_username == '')
        {
            alertify.notify('Ingrese Nombre del Usuario..!', 'warning', 2, function () { console.log('dismissed'); });
            return;
        }

        if(_lastname == '')
        {
            alertify.notify('Ingrese Apellido del Usuario..!', 'warning', 2, function () { console.log('dismissed'); });
            return;
        }
        
        if(_login == '')
        {
            alertify.notify('Ingrese Login..!', 'warning', 2, function () { console.log('dismissed'); });
            return;    
        }
        
        if(_password == '')
        {
            alertify.notify('Ingrese Password..!', 'warning', 2, function () { console.log('dismissed'); });
            return;    
        }
               
        if(_perfil == '0')
        {
            alertify.notify('Seleccione Perfil..!', 'warning', 2, function () { console.log('dismissed'); });
            return;    
        }

        if(_loginold != _login){
            $.ajax({
                url: "../bd/consultadatos.php",
                type: "POST",
                dataType: "json",
                data: {tipo:20, auxv1:"", auxv2:_login, auxv3:"", auxv4:"", auxv5:"", auxv6:"", auxi1:0, auxi2:0, auxi3:0, auxi4:0, auxi5:0, 
                auxi6:0, opcion:0},
                success: function(data){                    
                    if(data[0].contar == "0"){                         
                        _continuar = true;
                    }else{                      
                        _continuar = false;
                    }   
                    FunGrabar(_continuar);
                },
                error: function (error){
                    console.log(error);
                }
            });
        }else{
            FunGrabar(true);
        }        
    });
    
    function FunGrabar(response){
        if(!response){
            alertify.notify('Login ya Existe Registrado..!', 'warning', 2, function () { console.log('dismissed'); });
        }else{
            _file = _imagen.files[0];
            form_data = new FormData();            
            form_data.append('perfil', _perfil);
            form_data.append('username', _username);
            form_data.append('lastname', _lastname);
            form_data.append('login', _login);
            form_data.append('password', _password);
            form_data.append('estado', _estado);
            form_data.append('caduca', _caduca);
            form_data.append('fechacaduca', _fechacaduca);
            form_data.append('cambiar', _cambiar);
            form_data.append('imagen', _file);
            form_data.append('opcion', _opcion);
            form_data.append('id', _id);
            $.ajax({
                url: "../bd/usuariocrud.php",
                type: "POST",                
                data: form_data,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(datos){                    
                    _userid = datos[0].UserId;
                    _usuario = datos[0].Usuario;
                    _login = datos[0].Namelogin;
                    _perfil = datos[0].Perfil;
                    _estado = datos[0].Estado;
                    _button = '<div class="text-center"><button id="btnEditar" class="btn btn-outline-info btn-sm ml-3">'+
                                '<i class="fas fa-file"></i></button><button class="btn btn-outline-danger btn-sm ml-3"'+
                                'id="btnEliminar"><i class="fas fa-trash"></i></button></div>'
                    if(_opcion == 0){
                        TableData.row.add([_userid, _usuario, _login, _perfil, _estado, _button]).draw();
                        alertify.notify('Grabado Correctamente..!', 'success', 2, function () { console.log('dismissed'); });
                    }
                    else{
                        TableData.row(_fila).data([_userid, _usuario, _login, _perfil, _estado, _button]).draw();
                        alertify.notify('Actualizado Correctamente..!', 'success', 2, function () { console.log('dismissed'); });
                    }                     
                    $("#modalNewUser").modal("hide");
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
    }    

});