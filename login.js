$('#formLogin').submit(function(e){
    e.preventDefault();
    
    var usuario = $.trim($("#username").val());    
    var password =$.trim($("#password").val());    
    if(usuario.length == "" || password == ""){
       Swal.fire({
           type:'warning',
           title:'Ingrese usuario y/o password',
           icon: 'warning'
       });
       return false; 
     }else{        
         $.ajax({
            url:"bd/login.php",
            type:"POST",
            datatype: "json",
            data: {usuario:usuario, password:password}, 
            success:function(data){   
                console.log(data);              
                if(data == 'null'){
                    Swal.fire({
                        type:'error',
                        title:'Usuario y/o password incorrectos',
                        icon: 'error'
                    });
                    $("#username").val('');
                    $("#password").val('');                    
                }else{
                    window.location.href = "dashmenu/panel_content.php";              
                }
            }    
         });
     }
 });