<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <?php
      include "header.php"
    ?>
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="javascript:void(0)">COC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto menus"> 
          </ul>
        </div>

        <div class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" id="buscar" type="search" placeholder="Buscar" aria-label="Search">
        </div>

        <div class="pull-right">
          <span id="usuario_ativo"></span>
        </div>

 
      </nav>
      <script src="./js/nav.js"></script>
</body>
</html>