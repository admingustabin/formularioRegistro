function incluirUsuario() {
    $("body").on("submit", "#formDefault", function(event){
        event.preventDefault();
        if($("#formDefault").valid()){
            // barra
            $.ajax({
                type: "POST",
                url: "backend/registrarseAPI.php?option=incluirUsuario",
                dataType: "json",
                data: $(this).serialize(),
                sucess: function(respuesta){
                    // ocultar barra
                    if (respuesta.error == 1) {
                        //mensaje
                        alert("El email es invalido");
                        //El email ya existe
                    }
                    if (respuesta.error == 2) {
                        //mensaje
                        alert("El password es invalido");
                        //El password es invalido
                    }
                    if (respuesta.error == 3) {
                        //mensaje
                        alert("Ya existe el email");
                        //El password es invalido
                    }
                    if (respuesta.exito == 1) {
                        //mensaje
                        alert("La cuenta fue creada");
                        //La cuenta fue creada
                        //Limpiar el formulario
                        document.querySelector("#email").value="";
                        document.querySelector("#password").value="";

                        //Esperar 4 segundos 
                        setTimeout(function() {
                            //Redirigir a gracias.php
                            window.location.href="gracias.php";
                        }, 4000);
                        //fin de la espera de los 4 segundos
                    }
                }
            })
        }
    })
}