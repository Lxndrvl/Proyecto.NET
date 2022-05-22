<?php 
session_start(); 

if (isset($_SESSION['acceso'])){
  if ($_SESSION['acceso'] == true){
    header('Location:views/');
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <h4>Acceso al sistema</h4>
        <form action="">
          <div class="form-group">
            <label for="">Escribe tu nombre de usuario:</label>
            <input type="text" class="form-control" id="nomuser">
          </div>
          <div class="form-group">
            <label for="">Escribe tu contraseña:</label>
            <input type="password" class="form-control" id="claveuser">
          </div>
          <button id="acceder" class="btn btn-success" type="button">Ingresar</button>
        </form>
      </div>
    </div>
    <div class="col-md-4"></div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      
      function signin(){
        if ($("#nomuser").val() != "" && $("#claveuser").val() != ""){
          $.ajax({
            url: 'controllers/usuario.controller.php',
            type: 'GET',
            data: {
              op          : 'login',
              username    : $("#nomuser").val(),
              contraseña  : $("#claveuser").val()
            },
            success: function (result){
              if ($.trim(result) == ""){
                //Ingresa al dashboard
                window.location.href = 'views/'
              } else {
                alert(result);
              }
            }
          });
        }
      }

      $("#claveuser").keypress(function (event){
        if (event.keyCode == 13){
          signin();
        }
      });

      $("#acceder").click(signin);

    });
  </script>

</body>
</html>