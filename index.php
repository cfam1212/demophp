<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Ingreso Al Sistema</title>
        <link rel="icon" type="image/png" href="images/logo.png" >
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="vendors/sweetalert2/css/sweetalert2.min.css"> 
        
    </head>
    <body>

        <div id="wrapper">
            <div class="user-icon"></div>
            <div class="pass-icon"></div>

            <form name="login-form" id="formLogin" class="login-form" action="" method="post">
                <div class="header">
                    <h1>Login</h1>
                    <span>Ingrese sus credenciales para acceder al DashBoard.</span>
                </div>
                
                <div class="content">
                    <input name="username" id="username" type="text" class="input username" placeholder="Usuario" />
                    <input name="password" id="password" type="password" class="input password" placeholder="Password" />
                </div>
                
                <div class="footer">
                    <input type="submit" name="submit" value="Ingresar" class="button" />
                </div>
            </form>
        </div>
        <div class="gradient"></div>
    </body>
</html>

<script type="text/javascript" src="vendors/jquery/js/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $(".username").focus(function() {
            $(".user-icon").css("left","-48px");
        });
        $(".username").blur(function() {
            $(".user-icon").css("left","0px");
        });
        
        $(".password").focus(function() {
            $(".pass-icon").css("left","-48px");
        });
        $(".password").blur(function() {
            $(".pass-icon").css("left","0px");
        });
    });
</script>

<script src="login.js"></script>
<script src="vendors/sweetalert2/js/sweetalert2.all.min.js"></script>