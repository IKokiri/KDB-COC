<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">COC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                OCs
              </a>
              <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="ordem_compra.php">OCs</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="documentos.php">Documentos</a>
              </div>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Usuários
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="usuario.php">Usuários</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="usuario_ordem_compra.php">Usuários x OCs</a>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="visualizacao_ocs.php">Minhas OCs</a>
              </li>
              <li class="nav-item">
                <a class="nav-link text-danger" href="/coc/front/">Sair</a>
              </li>
          </ul>
        </div>

        <div class="pull-right">
          <span id="usuario_ativo"></span>
        </div>
      </nav>
</body>
</html>