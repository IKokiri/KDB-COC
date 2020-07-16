<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
</head>
<style> 
body{
    background-color:#ddd;
    padding-top:5%;
}
</style>
<body class="text-center">

<div class="form-signin col-md-2 offset-5">
      <img class="mb-4" src="icons/k.png" alt="" width="72" height="72">
      <label for="inputEmail" class="sr-only">Email</label>
      <input type="email" id="email" class="form-control" placeholder="Email" required="" autofocus="">
      <label for="inputPassword" class="sr-only">Senha</label>
      <input type="password" id="senha" class="form-control" placeholder="Senha" required="">
      <div class="checkbox mb-3">
      </div>
      <button class="btn btn-lg btn-primary btn-block" id="entrar">Entrar</button>
    </div>
<?php
      include "footer.php"
    ?>
<script src="./js/login.js"></script>
</body>
</html>