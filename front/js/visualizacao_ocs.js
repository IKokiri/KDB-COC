const base_request = "http://localhost:8000"
const controller = "UsuarioOrdemCompraController"

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
                        <a href="${base_request}/src/docs/${dados[linha].path}" target="_blank">
                            <img src="./icons/ext/cad.png">
                        </a>
                    </td>
                </tr>
            `
        }
        document.querySelector(".grid").innerHTML = grid
    })
    .catch(console.error);
}


})
