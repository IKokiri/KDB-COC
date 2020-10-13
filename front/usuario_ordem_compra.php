
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
  include "nav.php"
?>
    <title>Usuário OC</title>
</head>
<body>
    
    <button id="abrir_modal">
        +
    </button>

    <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">Usuário</th>
            <th scope="col">Ordem Compra</th>
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
          <h5 class="modal-title" id="exampleModalLabel">Usuário X Ordem de Compra</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- FORM -->
          <form>
            <div class="form-row">

              <div class="form-group col-md-6">
                <label for="inputEmail4">Ocrdem Compra</label>
                <select class="form-control" id="id_ordem_compra">

                </select>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail4">Usuário</label>
                <select class="form-control" id="id_usuario">

                </select>
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

    
  <?php
      include "footer.php"
    ?>
    <script src="./js/usuario_ordem_compra.js"></script>
</body>
</html>