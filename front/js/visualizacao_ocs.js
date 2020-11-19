const controller = "UsuarioOrdemCompraController"
const downloadDocumentoController = "DownloadDocumentoController"

$(document).ready(function(){

inicio();

function inicio(){
    grid_principal()
}

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
        formData.append('method', 'filterForUser');
        formData.append('term', term);
    }else{
        formData.append('method', 'readForUser');
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
                    <td>${dados[linha].numero}</td>
                    <td>${dados[linha].nome}</td>
                    <td>
                        <a id="download" data-iddocumento="${dados[linha].id_documento}" href="${base}/src/docs/${dados[linha].id_oc}/${dados[linha].path}" target="_blank">
                            <img src="./icons/ext/${dados[linha].extensao}.png">
                        </a>
                    </td>
                    <td>
                    <svg id="infoDownload" data-iddocumento="${dados[linha].id_documento}" class="bi bi-info-circle" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
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

function addDownload(id_documento){
    
    formData = new FormData();
    formData.append('class', downloadDocumentoController);
    formData.append('method', 'add');
    formData.append('id_documento', id_documento);
    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then()
    .catch(console.error);
}

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

$(document).on("click","#download",function(){
    id_documento = $(this).attr("data-iddocumento");
    addDownload(id_documento);
})

$(document).on("click","#infoDownload",function(){
    id_documento = $(this).attr("data-iddocumento");
    $('#modal_info').modal('show')
    getInfo(id_documento);
})
})
