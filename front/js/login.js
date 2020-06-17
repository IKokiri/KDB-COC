const base_request = "http://localhost:8000"
const controller = "LoginController"

$(document).ready(function(){

$(document).on('click','#entrar',function(){
    getLogin();
})

function getLogin(formData){

    email = document.querySelector("#email").value;
    senha = document.querySelector("#senha").value;

    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'getLogin');
    formData.append('email', email);
    formData.append('senha', senha);
    
    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {        
        window.location.href = "http://localhost:8000/front/visualizacao_ocs.php"; 
    })
    .catch(console.error);
}

})
