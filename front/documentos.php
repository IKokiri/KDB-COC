
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
  include "nav.php"
?>
    <title>Documentos</title>
</head>
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
            <th scope="col">Documento</th>
            <th scope="col">Download</th>            
            <th scope="col">Remover</th>
            <th scope="col">Info</th>
          </tr>
        </thead>
        <tbody class="grid">
        </tbody>
    </table> 
  <!-- <table class="table table-bordered  table-hover col-10 offset-1">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">OC</th>
            <th scope="col">Download</th>
            <th scope="col">Remover</th>
          </tr>
        </thead>
        <tbody class="grid">
        </tbody>
      </table> -->
  <div class="offset-1">
      <nav aria-label="Page navigation example">
      <ul class="pagination">
      </ul>
      </nav>
  </div>

<!-- Modal -->
<div class="modal fade" id="modal_principal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Documento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- FORM -->
          <form>
            <div class="form-row">

              <div class="form-group col-md-6">
                <label for="inputEmail4">OC</label>
                <select class="form-control" id="id_ordem_compra">

                </select>
              </div>        
            </div>
            <div class="form-group">
              <label for="exampleFormControlFile1"></label>
              <input type="file" class="form-control-file" name="file[]" id="file" multiple="multiple">
            </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="notificar">
            <label class="form-check-label" for="exampleCheck1">Notificar usuários</label>
          </div>
            <input type="hidden" id="id">
          </form>
          <!-- FORM -->
        </div>
        <div class="modal-footer">
        <div class="enviandoArquivos">
          <button class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Enviando Arquivos
          </button>
        </div>        
        <div class="botoesPadrao">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            <button type="button" id="salvar" class="btn btn-primary">Salvar</button>
        </div>
          
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
<div class="modal fade" id="modal_info" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Documento</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Data Download</th>
              </tr>
            </thead>
            <tbody class="grid_info">
            </tbody>
          </table>  

 

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" id="salvar" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->
  <?php
      include "footer.php"
    ?>
    <script src="./js/base_alert.js"></script>
    <script src="./js/documentos.js"></script>
</body>
</html>