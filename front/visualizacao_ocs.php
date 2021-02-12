<?php
  require_once "./nav.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<body>

<!-- Modal -->
<div class="modal fade" id="modal_documento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <div class="form-group col-md-6">
                
                <label for="inputEmail4">Notificar:</label>
                <div class="pessoas_notificar">
                </div>
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


<!-- Modal -->
<div class="modal fade" id="mdl_aprovacoes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Aprovações</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body aprovadores">
           
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Usuario</th>
                <th scope="col">Aprovação</th>
              </tr>
            </thead>
            <tbody class="grid_aprovacao">

            </tbody>
          </table>  

        </div>
        <div class="modal-footer footer_aprovacao">
          <button type="button" class="btn_aprovar btn btn-danger">Não Aprovar</button>
          <button type="button" id="salvar" class="btn_aprovar btn btn-primary">Aprovar</button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal -->


<div class="modal fade" id="modal_obs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Observação OC</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
         
        <form>
            <div class="form-row">
              <div class="form-group col-md-12">
                <label for="inputEmail4">Observação:</label>
                <textarea readonly class="form-control observacao" cols="30" rows="10"></textarea>
              </div>
            </div>
            <input type="hidden" id="id">
          </form>
         </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="button" id="salvar" class="btn btn-primary">Salvar</button>
        </div>
      </div>
    </div>
  </div>
 <br>
  <table class="table table-bordered  table-hover col-10 offset-1">
        <thead>
          <tr>
            <th scope="col">Documento</th>
            <th scope="col">Download</th>
            <th colspan='2' scope="col">Info</th>
          </tr>
        </thead>
        <tbody class="grid">
        </tbody>
    </table> 
    <div class="offset-1">
      <nav aria-label="Page navigation example">
      <ul class="pagination">
      </ul>
      </nav>
  </div>
    <?php
      require_once "./footer.php";
    ?>
    <script src="./js/visualizacao_ocs.js"></script>
</body>
</html>