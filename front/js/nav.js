$(document).ready(function(){
    formData = new FormData();
    formData.append('class', "Gosth");
    formData.append('method', "gosth");

    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {    
  
        menus = "";
        grupoTelas = data.telas
        usuario_ativo = data.emailLogado
        
        for(t in grupoTelas){

            telas = grupoTelas[t];
            
            for(tela in telas){
                if(telas[tela].caminho == ""){
                    continue
                }
                
                menus += `<li class="nav-item">
                <a class="nav-link" href="${telas[tela].caminho}">${telas[tela].nome}
                </a>
              </li>`
            }
        }
        menus += `<li class="nav-item">
                    <a class="nav-link text-danger" href="${base_front}">Sair</a>
                </li> `
      document.querySelector(".menus").innerHTML = menus
      document.querySelector("#usuario_ativo").innerHTML = usuario_ativo
      

    })
    .catch(console.error);

})
