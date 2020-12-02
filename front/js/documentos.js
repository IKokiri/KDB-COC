const controller = "DocumentoController"
const OCController = "OCController"
const downloadDocumentoController = "DownloadDocumentoController"

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
    ocnome = document.querySelector("#id_ordem_compra").selectedOptions[0].text
   
    formData = carregar_campos()
    id = formData.get("id");
    files = document.querySelector("#file").files.length;
    if(files < 1){
        alert("É necessário anexar pelo menos um arquivo à OC.")
        return;
    }
    if(id){
        update(formData)
    }else{

        var r = confirm(`Deseja alterar a OC: ${ocnome}`);
        if (r == true) {
            criar(formData)
        }
        
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
        numeroOC = 0;
        for(linha in dados){
            if(numeroOC != dados[linha].numero){
                grid += `<tr data-idoc="${dados[linha].id_oc}" id="observacao_oc" class='table-primary'>
                    <td  colspan='1'><B>OC: ${dados[linha].numero}</B>
                    </td>
                    <td colspan='3'>
                        <B>
                            PARA VER AS OBSERVAÇÕES REFERENTE À OC ${dados[linha].numero}, CLIQUE AQUI.
                        </B>
                </td>
                </tr>`
            }
            numeroOC = dados[linha].numero
            
            if(dados[linha].nome == null){
                continue
            }
            grid += 
            `
                <tr>
                    <td>${dados[linha].nome}</td>
                    <td>
                    <a href="${base}/src/docs/${dados[linha].id_oc}/${dados[linha].path}" target="_blank">
                        <img src="./icons/ext/${dados[linha].extensao}.png">
                    </a>
                </td>
                <td data-id="${dados[linha].id}" id="remover"><img src="./icons/002-delete.png"  alt=""></td>
                    <td>
                    <svg id="infoDownload" data-iddocumento="${dados[linha].id}" class="bi bi-info-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M8.93 6.588l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588z"/>
                    <circle cx="8" cy="4.5" r="1"/>
                    </svg>
                    </td>
                </tr>
            `
        
        }
        document.querySelector(".grid").innerHTML = grid
        pagination(ini,fim);
    })
    .catch(console.error);
}
function ggrid_principal(term = "",ini = 0,fim = 10){

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

$(document).on("click","#infoDownload",function(){
    id_documento = $(this).attr("data-iddocumento");
    $('#modal_info').modal('show')
    getInfo(id_documento);
})

function getInfo(id_documento){
    
    formData = new FormData();
    formData.append('class', downloadDocumentoController);
    formData.append('method', 'getInfo');
    formData.append('id_documento', id_documento);
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
                <td>${dados[linha].data_download}</td>
            </tr>
            `
        }
        document.querySelector(".grid_info").innerHTML = grid
    })
    .catch(console.error);
}


$(document).on('click','#observacao_oc',function(){

    idoc = $(this).attr("data-idoc");
    setObsOC(idoc)
    $('#modal_obs').modal('show')

})
function setObsOC(id){

    formData = new FormData();
    formData.append('class', OCController);
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
            linha = data.result_array[0];
            
            document.querySelector(".observacao").innerHTML = linha.observacao

        })
        .catch(console.error);
}
})
