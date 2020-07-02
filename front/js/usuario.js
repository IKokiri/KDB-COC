const controller = "UsuarioController"

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


function grid_principal(){

    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'read');

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
                    <td>${dados[linha].permissao}</td>
                    <td data-id="${dados[linha].id}" id="edit"><img src="./icons/001-pencil.png"  alt=""></td>
                    <td data-id="${dados[linha].id}" id="remover"><img src="./icons/002-delete.png"  alt=""></td>
                </tr>
            `
        }
        document.querySelector(".grid").innerHTML = grid
    })
    .catch(console.error);
}

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
            inicio()
        })
        .catch(console.error);
}


})
