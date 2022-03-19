<?php
// conexion a la BD
// encriptar/desencriptar
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

    //$password = encriptar

    //ejecutar un SQL
    $sql = "INSERT INTO usuarios (id, email, password, status) VALUES (NULL, '$email', '$password', 0)";

    if (mysqli_query($conn, $sql)) {
        $data = array('exito'=>'1');
        //enviar un email

        mysqli_close($conn);
        die(json_encode($data));
    } else {
        $data = array('error'=>'3')
        die(json_encode($data));
    }
}



