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
    
        div = Math.ceil(data.count/4)
        
        grid = ""
        ckbUsers=""
        dados = data.result_array
        i=0;
        for(linha in dados){
            ckbUsers += 
            `  
            <div class='col-3'>
                <div class="form-group form-check">
                <input type="checkbox" data-checked="id${dados[linha].id}" class="checkGroupUser form-check-input" id="${dados[linha].id}">
                <label class="form-check-label" for="${dados[linha].id}">${dados[linha].email}</label>
                </div>
            </div>
            ` 
            
            i++

            if(i==4){
                grid += "<div class='row'>"+ckbUsers+"</div>"
                ckbUsers = ""
                i=0;
            }
        }
        
        grid += "<div class='row'>"+ckbUsers+"</div>"
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
                    <td>${dados[linha].numero}</td>
                    <td data-id="${dados[linha].id}" id="addGroup"><img src="./icons/addgroup.png"  alt=""></td>
                    <td data-id="${dados[linha].id}" id="edit"><img src="./icons/001-pencil.png"  alt=""></td>
                    <td data-id="${dados[linha].id}" id="remover"><img src="./icons/002-delete.png"  alt=""></td>
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