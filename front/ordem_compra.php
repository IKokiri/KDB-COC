
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    
    <?php
      include "header.php"
    ?>
    <title>OCs</title>
</head>
<?php
  include "nav.php"
?>
<body>
    
<div class="text-center">
    <button class="btn btn-primary m-1" id="abrir_modal">
        +
    </button> 
  </div>
  <div class="col-10 offset-1" id="base_alert"></div>
  
  <table class="table table-bordered  table-hover col-10 offset-1">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">+ Usuarios</th>
            <th scope="col">Alterar</th>
            <th scope="col">Remover</th>
          </tr>
        </thead>
        <tbody class="grid">
        </tbody>
      </table>

<!-- Modal -->
<div class="modal fade" id="modal_principal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- FORM -->
          <form>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Número da OC:</label>
                <input type="number" class="form-control" id="numero">
              </div>
            </div>
            <input type="hidden" id="id">
          </form>
          <!-- FORM -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" id="salvar" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>

  

  <div class="modal" id="modal_addgroup" tabindex="-1">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Usuários</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="groupUsers modal-body">


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="button" id="salvarGrupo" class="btn btn-primary">Salvar</button>
      </div>
    </div>
  </div>
</div>
    
  <?php
      include "footer.php"
    ?>
    <script src="./js/base_alert.js"></script>
    <script src="./js/ordem_compra.js"></script>
</body>
</html>