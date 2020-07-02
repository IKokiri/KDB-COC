const controller = "LoginController"

$(document).ready(function(){
    
    deslogar();

$(document).on('click','#entrar',function(){
    getLogin();
})

function deslogar(){
    formData = new FormData();
    formData.append('class', controller);
    formData.append('method', 'deslogar');
    
    fetch(base_request,{
        method:'post',
        body: formData
    })
    .then(response => response.json())
    .then(data => {        
        
    })
    .catch(console.error);
}

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
        if(data.count==1)   
            window.location.href = `${base_front}/visualizacao_ocs.php`; 
    })
    .catch(console.error);
}

})
