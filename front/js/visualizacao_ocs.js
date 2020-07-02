const controller = "UsuarioOrdemCompraController"
const downloadDocumentoController = "DownloadDocumentoController"

$(document).ready(function(){

inicio();

function inicio(){
    grid_principal()
}

function grid_principal(){

    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'readForUser');

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
                        <a id="download" data-iddocumento="${dados[linha].id_documento}" href="${base}/src/docs/${dados[linha].path}" target="_blank">
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
        document.querySelector("#usuario_ativo").innerHTML = data.user
    })
    .catch(console.error);
}

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