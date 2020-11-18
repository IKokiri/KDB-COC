const controller = "OCController";
const userController = "UsuarioController";
const userOC = "UsuarioOrdemCompraController";

$(document).ready(function(){

inicio();

function inicio(){
    grid_principal();
    limpar_campos()
    $('.modal').modal('hide')
}

function gridUsers(term = ""){

    formData = new FormData();

    formData.append('class', userController);
    if(term){
        formData.append('method', 'filter');
        formData.append('term', term);
    }else{
        formData.append('method', 'read');
    }

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
            <div class="form-group form-check">
            <input type="checkbox" data-checked="id${dados[linha].id}" class="checkGroupUser form-check-input" id="${dados[linha].id}">
            <label class="form-check-label" for="${dados[linha].id}">${dados[linha].email}</label>
            </div>
            `
        }
        
        checkUsers();
        document.querySelector(".groupUsers").innerHTML = grid
    })
    .catch(console.error);
}

function carregar_campos(){
    formData = new FormData();
    let numero = document.querySelector("#numero").value;
    let id = document.querySelector("#id").value;

    formData.append('numero', numero);
    formData.append('id', id);

    return formData;
}

function checkUsers(){
    
    formData = carregar_campos()
    formData.append('class', userOC);
    formData.append('method', 'getUsersOC');    
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {  
            inputs = data.result_array;
            for(input in inputs){
                document.querySelector(`[data-checked=id${inputs[input].id_usuario}]`).checked = true
            }

        })
        .catch(console.error);
}


function limpar_campos(){

    let numero = document.querySelector("#numero").value = "";
    let id = document.querySelector("#id").value = "";

}

function preencher_form(data){

    let numero = data.numero;
    let id = data.id;
    
    $('#modal_principal').modal('show')
    document.querySelector("#numero").value = numero
    document.querySelector("#id").value = id
    
}

$(document).on('click','#abrir_modal',function(){
    $('#modal_principal').modal('show')
})
$(document).on('click','#addGroup',function(){
    id = $(this).attr("data-id");
    document.querySelector("#id").value = id;

    $('#modal_addgroup').modal('show')
    gridUsers()

})
$(document).on('click','#salvarGrupo',function(){
    
    arrUsers = [];
    inputs = document.querySelectorAll(".checkGroupUser")
    for(input in inputs){
        if(inputs[input].checked){
            arrUsers.push(inputs[input].id)
        }
    }
    adicionarUsuarios(arrUsers)
})

function adicionarUsuarios(arrUsers){

    
    formData = carregar_campos()
    
    formData.append('class', userOC);
    formData.append('method', 'addUsers');    
    formData.append('users', arrUsers);
    
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

function grid_principal(term = ""){

    formData = new FormData();

    formData.append('class', controller);
    if(term){
        formData.append('method', 'filter');
        formData.append('term', term);
    }else{
        formData.append('method', 'read');
    }

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
                    <td>${dados[linha].numero}</td>
                    <td data-id="${dados[linha].id}" id="addGroup"><img src="./icons/addgroup.png"  alt=""></td>
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