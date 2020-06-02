const base_request = "http://localhost:8000"
$(document).ready(function(){
    inicio();

function inicio(){
    grid();
}

$(document).on('click','#abrir_modal',function(){
    $('#modal_principal').modal('show')
})

function grid(){

    var formData = new FormData();
    formData.append('class', 'OCController');
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
                    <td>${dados[linha].numero}</td>
                    <td><img src="./icons/001-pencil.png" alt=""></td>
                    <td><img src="./icons/002-delete.png" alt=""></td>
                </tr>
            `
        }
        document.querySelector(".grid").innerHTML = grid
    })
    .catch(console.error);
}

// CRIAR
function criar(){

    var formData = new FormData();
    formData.append('class', 'Calsse');
    formData.append('method', 'metodo');
    formData.append('nome', 'luiz');
    
        fetch(base_request,{
            method:'post',
            body: formData
        })
        .then(response => response.json())
        .then(data => {        
            console.log(data)
        })
        .catch(console.error);
}



// fetch(base_request, {
//   method: 'post',
//   body: formData
// })
// .then(response => response.json())
// .catch(error => console.error('Error:', error))
// .then(response => console.log('Success:', JSON.stringify(response)))
    
})