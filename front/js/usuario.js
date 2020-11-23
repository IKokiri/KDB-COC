const controller = "UsuarioController"
var permissao = ["Padrão","Administrador"];
$(document).ready(function(){

inicio();

function inicio(){
    grid_principal();
    limpar_campos()
    $('#modal_principal').modal('hide')
}

function carregar_campos(){

    inputFile = document.querySelector('input[type="file"]')

    formData = new FormData();
    let email = document.querySelector("#email").value;
    let senha = document.querySelector("#senha").value;
    let permissao = document.querySelector("#permissao").value;
    let id = document.querySelector("#id").value;

    formData.append('email', email);
    formData.append('senha', senha);
    formData.append('permissao', permissao);
    formData.append('id', id);

    return formData;
}

function limpar_campos(){

    let email = document.querySelector("#email").value = "";
    let senha = document.querySelector("#senha").value = "";
    let permissao = document.querySelector("#permissao").value = 0;
    let id = document.querySelector("#id").value = "";

}

function preencher_form(data){

    let email = data.email;
    let senha = data.senha;
    let permissao = data.permissao;
    let id = data.id;
    
    
    $('#modal_principal').modal('show')
    document.querySelector("#email").value = email
    document.querySelector("#senha").value = senha
    document.querySelector("#permissao").value = permissao
    document.querySelector("#id").value = id
    
}

$(document).on('click','#abrir_modal',function(){
    $('#modal_principal').modal('show')
})

$('#modal_principal').on('hidden.bs.modal', function () {
    document.querySelector("#id").value = ""
  })

$(document).on('click','#salvar',function(){
    formData = carregar_campos()
    id = formData.get("id");

    if(id){
        update(formData)
    }else{
        criar(formData)
    }

})

$(document).on('click','#remover',function(){
    
    id = $(this).attr("data-id");
    
    var res = confirm("Deseja remover o registro?");
    if (res == true) {
        remover(id);
    } else {
    
    }
    
})

$(document).on('click','#edit',function(){

    $('#modal_principal').modal('show')
    id = $(this).attr("data-id");
    edit(id);
    
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
        grid = ""
        dados = data.result_array
        for(linha in dados){
            grid += 
            `
                <tr>
                    <td>${dados[linha].email}</td>
                    <td>${permissao[dados[linha].permissao]}</td>
                    <td data-id="${dados[linha].id}" id="edit"><img src="./icons/001-pencil.png"  alt=""></td>
                    <td data-id="${dados[linha].id}" id="remover"><img src="./icons/002-delete.png"  alt=""></td>
                </tr>
            `
        }
        document.querySelector(".grid").innerHTML = grid
       
        pagination(ini,fim,data.count);
    })
    .catch(console.error);
}
function pagination(ini,fim = 10,count){
    
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

function remover(id){
    
    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'delete');
    formData.append('id', id);
    
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

function edit(id){

    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'getId');
    formData.append('id', id);
    
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



})
