const controller = "DocumentoController"
const OCController = "OCController"

$(document).ready(function(){

inicio();

function inicio(){
    grid_principal();
    limpar_campos()
    carregar_ocs();
    $('#modal_principal').modal('hide')
    document.querySelector('.enviandoArquivos').style.display = 'none';
}

function carregar_campos(){

    inputFile = document.querySelector('input[type="file"]')

    formData = new FormData();
    let id = document.querySelector("#id").value;
    let id_ordem_compra = document.querySelector("#id_ordem_compra").value;
    let notificar = document.querySelector("#notificar").checked;
   
    for(f in inputFile.files){
        formData.append('file'+f, inputFile.files[f]);
    }
    formData.append('id_ordem_compra', id_ordem_compra);
    formData.append('notificar', notificar);
    formData.append('id', id);

    return formData;
}

function limpar_campos(){

    let file = document.querySelector("#file").value = "";
    let id = document.querySelector("#id").value = "";
    let id_ordem_compra = document.querySelector("#id_ordem_compra").value = "";

}

function preencher_form(data){

    let id = data.id;
    let id_ordem_compra = data.id_ordem_compra;
    
    
    $('#modal_principal').modal('show')
    document.querySelector("#id").value = id
    document.querySelector("#id_ordem_compra").value = id_ordem_compra
    
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
                    <td>${dados[linha].nome}</td>
                    <td>${dados[linha].numero}</td>
                    <td>
                        <a href="${base}/src/docs/${dados[linha].id_oc}/${dados[linha].path}" target="_blank">
                            <img src="./icons/ext/${dados[linha].extensao}.png">
                        </a>
                    </td>
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
    document.querySelector('.enviandoArquivos').style.display = 'block';

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
                base_erro(data.MSN.errorInfo[1],data.MSN.errorInfo[2])
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
})
