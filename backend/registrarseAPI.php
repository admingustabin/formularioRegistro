<?php
require_once('../tools/mypathdb.php'); // conexion a la BD
require_once('../tools/sed.php'); // encriptar/desencriptar

// limpiar inyeccion de sql
//session_start();
$option = $_GET['option'];

if ($option == "incluirUsuario") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $validaemail = preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email);
    $validaPassword = preg_match("#.*^(?=.{8,20})(?=.*[a-z]).*$#", $password);
    
    if ($validaemail == 0) {
        $data = array('error'=>'1');
        die(json_encode($data));
    }
    
    if ($validaPassword == 0) {
        $data = array('error'=>'2');
        die(json_encode($data));
    }
    
    $password = SED::encryption($password);

    $sql = "INSERT INTO `usuarios` (`id`, `email`, `password`, `status`) VALUES (NULL, '$email', '$password', '0')";
    try {
        $conn->query($sql);
        $data = array('exito'=>'1'); 

        $destino = "gustabin@yahoo.com";
        $asunto = "Usuario registrado en el sistema";
        $cuerpo = "<h2>Hola, un nuevo usuario se ha registrado en el carrito!</h2>
        Hemos recibido la siguiente información:
        <br><br>
        <b>Usuario: </b> $email<br> 
        <br><br><br>
        El equipo de carrito de compras.<br>
        <img src=https://www.gustabin.com/img/logoEmpresa.png height=50px width=50px />
        <a href=https://www.facebook.com/gustabin2.0>
        <img src=https://www.gustabin.com/img/logoFacebook.jpg alt=Logo Facebook height=50px width=50px></a>
        <h5>Desarrollado por Gustabin<br>
        Copyright © 2022. Todos los derechos reservados. Version 1.0.0 <br></h5>
        ";
        $yourWebsite = "gustabin.com";
        $yourEmail = "info@gustabin.com";
        $cabeceras = "From: $yourWebsite <$yourEmail>\n" . "Reply-To: cuentas@gustabin.com" . "\n" . "Content-type: text/html";
        mail($destino, $asunto, $cuerpo, $cabeceras);


        $destino = $email;
        $asunto = "Activar cuenta en carrito de compras";
        $cuerpo = "<h2>Apreciado cliente, </h2>  <br>
            Hemos recibido su solicitud para crear un usuario. <br><br>            
            <b>Su usuario es:</b> $email<br>            
                Por favor lea los <a href=https://www.gustabin.com/site/terminos/terminos.php>terminos y condiciones</a> 
                y si esta de acuerdo haga click en el siguiente enlace para 
                <a href=http://localhost/plantilla/backend/registrarseAPI.php?option=activarUsuario&usuario=$email&clave=$password>activar su cuenta.
            </a>
            <br><br>

            Gracias por confiar en nosotros.
            <br>
            El equipo de carrito de compras.<br>
            <img src=https://www.gustabin.com/img/logoEmpresa.png height=50px width=50px />
            <a href=https://www.facebook.com/gustabin2.0>
            <img src=https://www.gustabin.com/img/logoFacebook.jpg alt=Logo Facebook height=50px width=50px></a>
            <h5>Desarrollado por Gustabin<br>
            Copyright © 2022. Todos los derechos reservados. Version 1.0.0 <br></h5>
            ";
        $yourWebsite = "gustabin.com";
        $yourEmail = "info@gustabin.com";
        $cabeceras = "From: $yourWebsite <$yourEmail>\n" . "Reply-To: cuentas@gustabin.com" . "\n" . "Content-type: text/html";
        mail($destino, $asunto, $cuerpo, $cabeceras);

        mysqli_close($conn);        
        die(json_encode($data));
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            // Duplicate email
            $data = array('error'=>'3');
            die(json_encode($data));
        }
    }    
}


if ($option == 'activarUsuario') {
    $email = $_GET['usuario'];
    $password = $_GET['clave'];

    $sql = "UPDATE usuarios SET status ='1' WHERE email='$email' AND password='$password'";

    mysqli_query($conn, $sql);
    mysqli_close($conn);
    header("location:../gracias.html");
}