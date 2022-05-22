<?php 
    session_start(); 
    
    if ($_SESSION['acceso'] == false){
        //Acceso al Dashboard
        header('location:../');
    }
/*    
    if (isset($_SESSION['acceso'])){
    }
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#" data-target="#modal-change-pw" data-toggle="modal">Cambiar contraseña</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
              Opciones
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="#">Action</a>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="../controllers/usuario.controller.php?op=logout">Cerrar Sesión</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled">User: <?= $_SESSION['nombre_completo']; ?></a>
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
      </div>
    </nav>

    <div id="modal-change-pw" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="my-modal-title">Actualizar contraseña</h5>
            <button class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="" id="form-update-pw">
              <div class="form-group">
                <label for="">Ingrese su antigua contraseña</label>
                <input type="password" id="clave1" class="form-control form-control-sm">
              </div>
              <div class="form-group">
                <label for="">Ingrese su nueva contraseña</label>
                <input type="password" id="clave2" class="form-control form-control-sm">
              </div>
              <div class="form-group">
                <label for="">Confirme su nueva contraseña</label>
                <input type="password" id="clave3" class="form-control form-control-sm">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button class="btn btn-success btn-sm" type="button" id="update-pw">Actualizar</button>
            <button class="btn btn-secondary btn-sm" type="button" id="cancel-update" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script>

    <script>
      //Cambiar clave - Vaciar modal
      $(document).ready(function (){
        //Limpiar modal
        function resetUI(){
          $("#form-update-pw")[0].reset();
        }
        function changepw(){
          const clave1 = $("#clave1").val();
          const clave2 = $("#clave2").val();
          const clave3 = $("#clave3").val();
          //Campos vacios
          if(clave1 == "" || clave2 == "" || clave3 == ""){
            alert("Debe ingresar los datos para continuar");
          }
          //Contraseñas no coinciden
          else{
            if(clave2 != clave3){
              alert("Su nueva contraseña no coincide");
            }
            else{
              $.ajax({
                url: '../controllers/usuario.controller.php',
                type: 'GET',
                data: {
                  op: 'changepassword',
                  clave1 : clave1,
                  clave2 : clave2
                },
                success: function(result){
                  //trim = quitar espacios
                  if($.trim(result) == ""){
                    alert("Se actualizo la contraseña");
                    resetUI();
                    $("#modal-change-pw").modal("hide");
                  }
                  else{
                    alert(result);
                    $("#clave1").focus();
                  }
                }
              });
            }
          }
        }
        $("#update-pw").click(changepw);
        $("#cancel-update").click(resetUI);
      });
    </script>
</body>
</html>