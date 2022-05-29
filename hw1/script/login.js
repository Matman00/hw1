function login_form(){
  const form_hidden=document.querySelector("#signup_form");
  form_hidden.classList.remove("signup_form");
  form_hidden.classList.add("hidden");
  document.getElementById("login").style.color='#fff';
  document.getElementById("signup").style.color='#ababab';
  const form_view=document.querySelector("#login_form");
  form_view.classList.remove("hidden");
  form_view.classList.add("login_form");
  document.querySelector("#hr_signup").classList.add("hidden");
  document.querySelector("#hr_login").classList.remove("hidden");
}

function prov(){
  
  if(Object.keys(formStatus).length !== 3 || Object.values(formStatus).includes(false) ){
    document.getElementById("login_btn").setAttribute('disabled', '');
  }
  else document.getElementById("login_btn").removeAttribute('disabled', '');
}

function check_email_jsonn(json){

  if(json===null){

    const error_text=document.getElementById("login_error_text");
    error_text.classList.remove("hidden");
    error_text.textContent="";
    error_text.textContent="Non sei registrato";
    document.getElementById("username_login").classList.add("error");
    formStatus.email= false;
    prov();
  }
  else{
    //document.getElementById("login_btn").removeAttribute('disabled');
    document.getElementById("username_login").classList.remove("error");
    const error_text=document.getElementById("login_error_text");
    error_text.classList.add("hidden");
    error_text.textContent="";

  }
}




function check_email() {
    const email=document.getElementById("username_login");


    const error_text=document.getElementById("login_error_text");
    if(email.value.length===0){
      formStatus.email=false;
      error_text.classList.remove("hidden");
      error_text.textContent="";
      error_text.textContent="inserisci email";
      email.classList.add("error");
      prov();
    }
    else{
      if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email.value)){

        email.classList.add("error");
        error_text.classList.remove("hidden");
        error_text.textContent="";
        error_text.textContent="email non valida";
        formStatus.email= false;
        prov();
      }
      else{
        error_text.textContent="";
        error_text.classList.add("hidden");
        formStatus.email=true;
        prov();
        email.classList.remove("error");
        fetch("http://localhost/hw1/get_utenti.php?q="+email.value).then(onResponse).then(check_email_jsonn);
      }
    }


}



function check_pass(event){
  const error_text=document.getElementById("login_error_text");
  if(event.currentTarget.value.length===0){
    formStatus.password=false;
    event.currentTarget.classList.add("error");
    error_text.classList.remove("hidden");
    error_text.textContent="";
    error_text.textContent="inserisci password";
    prov();
  }
  else{

    event.currentTarget.classList.remove("error");
    error_text.classList.add("hidden");
    error_text.textContent="";
    formStatus.password=true;
    prov();
  }
}



var cta = document.querySelector(".cta");
var check = 0;

cta.addEventListener('click', function(e){
    var text = e.target.nextElementSibling;
    var loginText = e.target.parentElement;
    text.classList.toggle('show-hide');
    loginText.classList.toggle('expand');
    if(check == 0)
    {
        cta.innerHTML = "<i class=\"fas fa-chevron-up\"></i>";
        check++;
    }
    else
    {
        cta.innerHTML = "<i class=\"fas fa-chevron-down\"></i>";
        check = 0;
        login_form();
    }

})


 const login_btn=document.querySelector("#login");
 login_btn.addEventListener("click", login_form);

const formStatus={'upload' : true};

function enable(){
  document.getElementById("login_btn").removeAttribute('disabled');
}

if(document.getElementById("username_login").value.length>0){
  formStatus.email=true;
}else{
  formStatus.email=false;
}
document.getElementById("username_login").addEventListener("blur",check_email);
document.getElementById("password_login").addEventListener("blur",check_pass);
document.getElementById("username_login").addEventListener("focus",enable);
document.getElementById("password_login").addEventListener("focus",enable);
const vlogin_form=document.forms['login_form'];
vlogin_form.addEventListener('submit', prov);
