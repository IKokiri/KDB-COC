<?php
  require_once "./nav.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<body>


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
<div class="modal fade" id="modal_obs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Observação OC</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body observacao">
         

 

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
            <th scope="col">OC</th>
            <th scope="col">Documento</th>
            <th scope="col">Obs</th>
            <th scope="col">Download</th>
            <th scope="col">Info</th>
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