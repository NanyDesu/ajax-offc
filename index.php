<?php
include 'connect.php';
$select = "SELECT * FROM USUARIO";
$result = mysqli_query($connect, $select);
$users = array();

while ($row = mysqli_fetch_array($result)) {
  $id = $row['ID_USUARIO'];
  $nome = $row['NOME'];
  $email = $row['EMAIL'];
  array_push($users, array("nome" => $nome, "id" => $id, "email" => $email));
}
?>
+
<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Form User</title>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous">
  </script>
  <link rel="stylesheet" href="style.css" type="text/css" />
</head>

<body>
  <a href="#janela1" rel="modal">Novo Usuario</a>
 
  <div id="table">
    <table border="1px" cellpadding="5px" cellspacing="0">
      <tr>
       
        <th>Id</th> 
        <th>Nome</th> 
        <th>Email</th>
        <th></th>
      </tr>
      <?php foreach ($users as $key => $value) : ?>
        <tr id="user-list-<?= $value["id"] ?>">
          <td><?= $value["id"] ?></td>
          <td><?= $value["nome"] ?></td>
          <td><?= $value["email"] ?></td>
          <td>
            <button onclick="deleteUserById(<?= $value["id"] ?>)">deletar</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </table>

 

    <div class="window" id="janela1">
      <a href="#" class="fechar">X</a>
      <h4>Cadastro de usuario</h4>
      <form id="cadUsuario" action="" method="post">
        <label>Nome:</label><input type="text" name="nome" id="nome" />
        <label>Email:</label><input type="text" name="email" id="email" />
        <label>Senha:</label> <input type="text" name="senha" id="senha" />
        <br /><br />
        <input type="button" value="Salvar" id="salvar" />
      </form>
    </div>
    <div id="mascara"></div>
  </div>
</body>

</html>

<script type="text/javascript" language="javascript">
  $(document).ready(function() {

    $('#salvar').click(function() {

      var dados = $('#cadUsuario').serialize();

      $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'save.php',
        async: true,
        data: dados,
        success: function(response) {
          location.reload();
        }
      });

      return false;
    });



    $("a[rel=modal]").click(function(ev) {
      ev.preventDefault();

      var id = $(this).attr("href");

      var alturaTela = $(document).height();
      var larguraTela = $(window).width();

     
      $('#mascara').css({
        'width': larguraTela,
        'height': alturaTela
      });
      $('#mascara').fadeIn(1000);
      $('#mascara').fadeTo("slow", 0.8);

      var left = ($(window).width() / 2) - ($(id).width() / 2);
      var top = ($(window).height() / 2) - ($(id).height() / 2);

      $(id).css({
        'top': top,
        'left': left
      });
      $(id).show();
    });

    $("#mascara").click(function() {
      $(this).hide();
      $(".window").hide();
    });

    $('.fechar').click(function(ev) {
      ev.preventDefault();
      $("#mascara").hide();
      $(".window").hide();
    });

  });

  function deleteUserById(id) {
    console.log("entrou");
    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: 'delete.php',
      async: true,
      data: {
        id: id
      },
      success: function(response) {
        document.getElementById(`user-list-${id}`).remove();
      }
    });
  }
</script>