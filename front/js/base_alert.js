function base_erro(erro, obs=""){
    err = ""
    if(erro == 1062){
        
        err = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Atenção!</strong> #001 - O registro já existe.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
          </button>
        </div>`;
    }

    if(erro == 1451){
        
      err = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
      <strong>Atenção!</strong> #002 - O registro está sendo usado em outro módulo. É necessário desfazer todos os vinculos com este registro. 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>`; 
  }


  if(erro == "authInvalido"){
        
    err = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atenção!</strong> #003 - Usuário ou senha não existe. 
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              </button>
            </div>`;
}

if(erro == "ArqGrande"){
        
    err = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>Atenção!</strong> #004- Arquivo Grande.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
    </div>`;
}
if(erro == "arqDup"){
        
  err = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Atenção!</strong> #005- Arquivo já existe. (${obs})
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
  </div>`;
}
    document.querySelector("#base_alert").innerHTML = err;
}