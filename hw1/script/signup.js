function signup_form(){
  const form_hidden=document.querySelector("#login_form");
  form_hidden.classList.remove("login_form");
  form_hidden.classList.add("hidden");
  document.getElementById("login").style.color='#ababab';
  document.getElementById("signup").style.color='#fff';
  const form_view=document.querySelector("#signup_form");
  form_view.classList.remove("hidden");
  form_view.classList.add("signup_form");
  document.querySelector("#hr_signup").classList.remove("hidden");
  document.querySelector("#hr_login").classList.add("hidden");
}

function check_form(){
  console.log(formStatusSignup);
  if(Object.keys(formStatusSignup).length !== 7 || Object.values(formStatusSignup).includes(false) ){
    document.getElementById("signup_btn").setAttribute('disabled', '');
  }
  else document.getElementById("signup_btn").removeAttribute('disabled');
}

function enable(){
  document.getElementById("signup_btn").removeAttribute('disabled');
}

function add_error(name){
  const error_text=document.getElementById("signup_error_text");
  error_text.classList.remove("hidden");
  error_text.textContent="";
  error_text.textContent="inserisci "+name;
}
function remove_error(){
  const error_text=document.getElementById("signup_error_text");
  error_text.classList.add("hidden");
}



function check_email_json(json){
  const email=document.getElementById("email_signup");
  if(json===null){
    email.classList.remove("error");
    remove_error();
    check_form();
  }
  else{
    const error_text=document.getElementById("signup_error_text");
    error_text.classList.remove("hidden");
    error_text.textContent="";
    error_text.textContent="Sei già registrato";
    email.classList.add("error");
    formStatusSignup[email.name]= false;
    check_form();
  }
}

function onResponse(response) {
  if(!response.ok) return null;
  return response.json();
}

function check_email_signup(e){
  const email=document.getElementById("email_signup");



  if(email.value.length===0){
    formStatusSignup[e.currentTarget.name]=false;
    add_error(email.name);
    email.classList.add("error");
    check_form();
  }
  else{
    if(!/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(e.currentTarget.value)){

      const error_text=document.getElementById("signup_error_text");

      e.currentTarget.classList.add("error");
      error_text.classList.remove("hidden");
      error_text.textContent="";
      error_text.textContent="email non valida";
      formStatusSignup[e.currentTarget.name]= false;
      check_form();
    }
    else{
      remove_error();
      formStatusSignup[e.currentTarget.name]=true;
      check_form();
      email.classList.remove("error");
      fetch("http://localhost/hw1/get_utenti.php?q="+e.currentTarget.value).then(onResponse).then(check_email_json);
    }
  }


}
function check_nome_cognome(event){

  if(event.currentTarget.value.length>0){
    formStatusSignup[event.currentTarget.name]=true;
    event.currentTarget.classList.remove("error");
    remove_error();
    check_form();
  }
  else{
    formStatusSignup[event.currentTarget.name]=false;
    event.currentTarget.classList.add("error");
    add_error(event.currentTarget.name);
    check_form();
  }
}
function check_password(event){
  if(event.currentTarget.value.length>0 ){
    if(/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%*?]{8,}$/.test(event.currentTarget.value)){
      formStatusSignup[event.currentTarget.name]=true;
      event.currentTarget.classList.remove("error");
      remove_error();
      check_form();
    }
    else{
      const error_text=document.getElementById("signup_error_text");
      event.currentTarget.classList.add("error");
      error_text.classList.remove("hidden");
      error_text.textContent="";
      error_text.textContent="password non valida";
      formStatusSignup[event.currentTarget.name]= false;
      check_form();
    }

  }
  else{
    formStatusSignup[event.currentTarget.name]=false;
    event.currentTarget.classList.add("error");
    add_error(event.currentTarget.name);
    check_form();
  }

}
function verify_password(event){
  const error_text=document.getElementById("signup_error_text");
  if(event.currentTarget.value.length>0){
    const pass=document.getElementById("password_signup");
    console.log(pass.value);
    if(event.currentTarget.value===pass.value){
      formStatusSignup[event.currentTarget.name]=true;
      event.currentTarget.classList.remove("error");
      remove_error();
      check_form();
    }
    else{
      error_text.classList.remove("hidden");
      error_text.textContent="";
      error_text.textContent="Le password non coincidono";
      event.currentTarget.classList.add("error");
      formStatusSignup[event.currentTarget.name]=false;
      check_form();
    }
  }
  else{
    add_error(event.currentTarget.name);
    event.currentTarget.classList.add("error");
    formStatusSignup[event.currentTarget.name]=false;
    check_form();
  }
}

function check_telefono(event){
  const error_text=document.getElementById("signup_error_text");
  
  if(event.currentTarget.value.length>9){
    if(/^[0-9]{10,}$/.test(event.currentTarget.value)){
      formStatusSignup[event.currentTarget.name]=true;
      event.currentTarget.classList.remove("error");
      remove_error();
      check_form();
    }
    else{
      error_text.classList.remove("hidden");
      error_text.textContent="";
      error_text.textContent="Non è un numero di telefono";
      event.currentTarget.classList.add("error");
      formStatusSignup[event.currentTarget.name]=false;
      check_form();
    }
    }
    else{
    add_error(event.currentTarget.name);
    event.currentTarget.classList.add("error");
    formStatusSignup[event.currentTarget.name]=false;
    check_form();
  }
}

const signup_text=document.querySelector("#signup");
signup_text.addEventListener("click", signup_form);

const formStatusSignup={'upload' : true};

const vsignup_form=document.forms['signup_form'];
vsignup_form.addEventListener('submit', check_form);


document.getElementById("nome_signup").addEventListener("blur",check_nome_cognome);
document.getElementById("cognome_signup").addEventListener("blur",check_nome_cognome);
document.getElementById("email_signup").addEventListener("blur",check_email_signup);
document.getElementById("password_signup").addEventListener("blur",check_password);
document.getElementById("verify_password").addEventListener("blur",verify_password);
document.getElementById("telefono_signup").addEventListener("blur",check_telefono);


document.getElementById("nome_signup").addEventListener("focus",enable);
document.getElementById("cognome_signup").addEventListener("focus",enable);
document.getElementById("email_signup").addEventListener("focus",enable);
document.getElementById("password_signup").addEventListener("focus",enable);
document.getElementById("verify_password").addEventListener("focus",enable);
document.getElementById("password_signup").addEventListener("focus",enable);
document.getElementById("telefono_signup").addEventListener("focus",enable);
