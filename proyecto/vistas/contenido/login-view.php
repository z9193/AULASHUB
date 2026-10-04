<?php
$peticionAjax = false;
require_once "./config/configGen.php";
require_once "./config/main.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light">

<div class="container mt-5" style="max-width:400px;">
    <form id="formLogin">

        <div class="text-center mb-4">
            <i class="fas fa-user-shield fa-3x text-primary"></i>
            <h4 class="mt-2 fw-bold"><?php echo COMPANY; ?></h4>
        </div>

        <div class="card shadow-sm p-4">
            <h5 class="mb-3 text-center">Iniciar sesión</h5>

            <div class="form-floating mb-3">
                <input type="text" name="numero_empleado" class="form-control" id="floatingInput" placeholder="Número de empleado" required>
                <label for="floatingInput">Número de empleado</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" name="clave" class="form-control" id="floatingPassword" placeholder="Contraseña" required>
                <label for="floatingPassword">Contraseña</label>
            </div>

            <button class="btn btn-primary w-100 py-2" type="submit">
                <i class="fas fa-sign-in-alt"></i> &nbsp; Ingresar
            </button>

            <div id="respuesta" class="mt-3"></div>
        </div>

    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$("#formLogin").submit(function(e){
    e.preventDefault();

    $.ajax({
        url:  "<?php echo SERVERURL; ?>Ajax/loginAjax.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(resp){
            try {
                var r = typeof resp === "string" ? JSON.parse(resp) : resp;

                if(r.Alerta === "redirigir"){
                    window.location.href = r.URL;

                } else if(r.Alerta === "simple"){
                    Swal.fire({
                        title: r.Titulo,
                        text:  r.Texto,
                        icon:  r.Tipo
                    });

                } else {
                    // Respuesta inesperada
                    $("#respuesta").html('<div class="alert alert-danger">Respuesta inesperada del servidor.</div>');
                }
            } catch(err){
                $("#respuesta").html('<div class="alert alert-danger">Error al procesar la respuesta.</div>');
            }
        },
        error: function(){
            $("#respuesta").html('<div class="alert alert-danger">No se pudo conectar con el servidor.</div>');
        }
    });
});
</script>

</body>
</html>