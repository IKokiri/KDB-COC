const controller = "UsuarioOrdemCompraController"
const downloadDocumentoController = "DownloadDocumentoController"
const OCcontroler = "OCController"

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

function setObsOC(id){

    formData = new FormData();
    formData.append('class', OCcontroler);
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
        numeroOC = 0;
        for(linha in dados){
            if(numeroOC != dados[linha].numero){
                grid += `<tr data-idoc="${dados[linha].id_oc}"  class='table-primary'>
                    <td  colspan='1'><B>OC: ${dados[linha].numero}</B>
                    <td colspan='1' data-idoc="${dados[linha].id_oc}" id="observacao_oc">
                        <B>
                            PARA VER AS OBSERVAÇÕES REFERENTE À OC ${dados[linha].numero}, CLIQUE AQUI.
                        </B>
                </td>
                </td>
                <td id="abrir_modal_documento">
                    <img src="./icons/add.png">
                </td>
                <td data-idoc="${dados[linha].id_oc}" class='text-center mdl_aprovacoes'>
                    <img src="./icons/handshake.png">
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
                        <a id="download" data-iddocumento="${dados[linha].id_documento}" href="${base}/src/docs/${dados[linha].id_oc}/${dados[linha].path}" target="_blank">
                            <img src="./icons/ext/${dados[linha].extensao}.png">
                        </a>
                    </td>
                    <td colspan='2'>
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


function grid_aprovadores(idoc){

    formData = new FormData();

    formData.append('class', controller);
    formData.append('id_oc', idoc);
    formData.append('method', 'getOCUsers');
    
    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => { 

        dados = data.result_array;

        grid_emails = "";
        footer = "";
        
        for(i in dados){
            
            footer = `<button data-idoc="${idoc}" type="button" class="btn_desaprovar btn btn-danger">Não Aprovar</button>
                      <button data-idoc="${idoc}" type="button" id="salvar" class="btn_aprovar btn btn-primary">Aprovar</button>`
            
            grid_emails += `<tr>
                                <td>
                                ${dados[i].email}
                                </td>
                                <td>
                                ${(dados[i].aprovado==1)?"<img src='./icons/agree.png'>":"<img src='./icons/desagree.png'>"}
                                </td>
                            </tr>`;
        }

        document.querySelector(".grid_aprovacao").innerHTML = grid_emails
        document.querySelector(".footer_aprovacao").innerHTML = footer
        
        

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

$(document).on('click','.btn_aprovar',function(){
  
    idoc = $(this).attr("data-idoc");
    aprovar(idoc,1);

})

$(document).on('click','.btn_desaprovar',function(){
  
    idoc = $(this).attr("data-idoc");
    aprovar(idoc,0);

})

function aprovar(idoc,apr){

    formData = new FormData();

    formData.append('class', controller);
    formData.append('method', 'aprovar');
    formData.append('aprovado', apr);
    formData.append('id_ordem_compra', idoc);
 
    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        grid_aprovadores(idoc)
    })
    .catch(console.error);
}


$(document).on('click','#observacao_oc',function(){

    idoc = $(this).attr("data-idoc");
    setObsOC(idoc)
    $('#modal_obs').modal('show')

})


$(document).on('click','.mdl_aprovacoes',function(){

    idoc = $(this).attr("data-idoc");
    

    $('#mdl_aprovacoes').modal('show')

    
    grid_aprovadores(idoc)

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

$(document).on('click','#abrir_modal_documento',function(){
    $('#modal_documento').modal('show')
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
