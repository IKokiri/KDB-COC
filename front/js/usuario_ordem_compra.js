const controller = "UsuarioOrdemCompraController"
const UsuarioController = "UsuarioController"
const OCController = "OCController"

$(document).ready(function(){

inicio();

function inicio(){
    grid_principal();
    limpar_campos()
    carregar_ocs();
    carregar_usuarios()
    $('#modal_principal').modal('hide')
}

function carregar_campos(){

    formData = new FormData();
    let id_usuario = document.querySelector("#id_usuario").value;
    let id_ordem_compra = document.querySelector("#id_ordem_compra").value;
    let idusuario = document.querySelector("#idusuario").value;
    let idordemcompra = document.querySelector("#idordemcompra").value;

    formData.append('id_usuario', id_usuario);
    formData.append('id_ordem_compra', id_ordem_compra);
    formData.append('idusuario', idusuario);
    formData.append('idordemcompra', idordemcompra);

    return formData;
}

function limpar_campos(){

    document.querySelector("#id_usuario").value = "";
    document.querySelector("#id_ordem_compra").value = "";
    document.querySelector("#idusuario").value = "";
    document.querySelector("#idordemcompra").value = "";

}

function preencher_form(data){

    let id_usuario = data.id_usuario;
    let id_ordem_compra = data.id_ordem_compra;
    
    $('#modal_principal').modal('show')
    document.querySelector("#id_usuario").value = id_usuario
    document.querySelector("#id_ordem_compra").value = id_ordem_compra
    document.querySelector("#idusuario").value = id_usuario
    document.querySelector("#idordemcompra").value = id_ordem_compra
    
}

$(document).on('click','#abrir_modal',function(){
    $('#modal_principal').modal('show')
})

$('#modal_principal').on('hidden.bs.modal', function () {

})

$(document).on('click','#salvar',function(){
    formData = carregar_campos()
    id_usuario = formData.get("idusuario");
    id_ordem_compra = formData.get("idordemcompra");

    if(id_usuario && id_ordem_compra){
        update(formData)
        
    }else{
        criar(formData)
    }

})

$(document).on('click','#remover',function(){
    
    idusuario = $(this).attr("data-idusuario");
    idordemcompra = $(this).attr("data-idordemcompra");
    
    var res = confirm("Deseja remover o registro?");
    if (res == true) {
        remover(idusuario,idordemcompra);
    } else {
    
    }
    
    
})


$(document).on('click','#edit',function(){

    $('#modal_principal').modal('show')
    
    idusuario = $(this).attr("data-idusuario");
    idordemcompra = $(this).attr("data-idordemcompra");
    edit(idusuario,idordemcompra);
    
})


$(document).on("keyup","#buscar",function(){
    term = document.querySelector("#buscar").value;
    buscar(term)
})

function buscar(term){
    grid_principal(term);
}

function grid_principal(term = "",ini = 0,fim = 10){

    formData = new FormData();

    formData.append('class', controller);
    if(term){
        formData.append('method', 'filter');
        formData.append('term', term);
    }else{
        formData.append('method', 'readLimit');
    }
    
    formData.append('pagini', ini);    
    formData.append('pagfim', fim);

    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }         
        grid = ""
        dados = data.result_array
        for(linha in dados){
            grid += 
            `
                <tr>
                    <td>${dados[linha].email}</td>
                    <td>${dados[linha].numero}</td>
                    <td data-idusuario="${dados[linha].id_usuario}" data-idordemcompra="${dados[linha].id_ordem_compra}" id="edit"><img src="./icons/001-pencil.png"  alt=""></td>
                    <td data-idusuario="${dados[linha].id_usuario}" data-idordemcompra="${dados[linha].id_ordem_compra}" id="remover"><img src="./icons/002-delete.png"  alt=""></td>
                </tr>
            `
        }
        document.querySelector(".grid").innerHTML = grid

        pagination(ini,fim);
    })
    .catch(console.error);
}
function pagination(ini,fim = 10){

    ini = parseInt(ini);
    fim = parseInt(fim);
   
    pag = ` <li class="page-item anterior" data-ini=${ini-10}  data-fim=${fim}><a class="page-link" href="javascript:void(0)"><<</a></li>
    <li class="page-item"><a class="page-link" href="javascript:void(0)">${ini+1} a ${ini+10}</a></li>
    <li class="page-item proximo"  data-ini=${ini+10}  data-fim=${fim}><a class="page-link" href="javascript:void(0)">>></a></li>`
    document.querySelector(".pagination").innerHTML = pag
   
}

$(document).on('click','.anterior',function(){
  
    ini = $(this).attr("data-ini");
    fim = $(this).attr("data-fim");
    ini = parseInt(ini);
    fim = parseInt(fim);
    if(ini < 0){
        return;
    }
    grid_principal("",ini,fim)
})

$(document).on('click','.proximo',function(){
    ini = $(this).attr("data-ini");
    fim = $(this).attr("data-fim");
    ini = parseInt(ini);
    fim = parseInt(fim);
    grid_principal("",ini,fim)
})


// CRIAR
function criar(formData){
    

    formData = carregar_campos();
    formData.append('class', controller);
    formData.append('method', 'create');
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }         
            inicio()
        })
        .catch(console.error);
}

function remover(idusuario,idordemcompra){
    
    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'delete');
    formData.append('idusuario', idusuario);
    formData.append('idordemcompra', idordemcompra);
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }      
            inicio()
        })
        .catch(console.error);
}

function edit(idusuario,idordemcompra){

    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'getId');
    formData.append('idusuario', idusuario);
    formData.append('idordemcompra', idordemcompra);
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }         
            $linha = data.result_array[0];
            preencher_form($linha);

        })
        .catch(console.error);
}

function update(formData){

    formData.append('class', controller);
    formData.append('method', 'update');
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }      
            inicio()
        })
        .catch(console.error);
}

function carregar_ocs(){

    formData = new FormData();
    formData.append('class', OCController);
    formData.append('method', 'read');

    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }         
        options = ""
        dados = data.result_array
        for(linha in dados){
            options += `
            <option value="${dados[linha].id}">
            ${dados[linha].numero}
            </option>
            `
        }
        document.querySelector("#id_ordem_compra").innerHTML = options
    })
    .catch(console.error);
}
function carregar_usuarios(){

    formData = new FormData();
    formData.append('class', UsuarioController);
    formData.append('method', 'read');

    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {  
            if(data.MSN){
                base_erro(data.MSN.errorInfo[1])
            }         
        options = ""
        dados = data.result_array
        for(linha in dados){
            options += `
            <option value="${dados[linha].id}">
            ${dados[linha].email}
            </option>
            `
        }
        document.querySelector("#id_usuario").innerHTML = options
    })
    .catch(console.error);
}
})
