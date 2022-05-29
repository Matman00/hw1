//webform
const form = document.getElementById('form');
const result = document.getElementById('result');

//script webform
form.addEventListener('submit', function(e) {
  const formData = new FormData(form);
  e.preventDefault();
  var object = {};
  formData.forEach((value, key) => {
    object[key] = value
  });
  var json = JSON.stringify(object);
  result.innerHTML = "Please wait..."

  fetch('https://api.web3forms.com/submit', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: json
    })
    .then(async (response) => {
      let json = await response.json();
      if (response.status == 200) {
        result.innerHTML = json.message;
      } else {
        console.log(response);
        result.innerHTML = json.message;
      }
    })
    .catch(error => {
      console.log(error);
      result.innerHTML = "Something went wrong!";
    })
    .then(function() {
      form.reset();

      setTimeout(() => {
        result.style.display = "none";

      }, 3000);

    });
});

function off_modale(event) {

  const key = event.key;
  if (key === "Escape") {
    const article = document.querySelector("#modale");
    article.classList.remove("modale");
    article.classList.add("hidden");
    document.body.classList.remove("no-scroll");
  }
}
//html
function close_menu(event) {
  const key = event.key;
  if (key === "Escape") {
    const container_menu = document.querySelector("#container_menu");
    container_menu.classList.remove("modale");
    container_menu.classList.add("hidden");
  }
}
//fine html
function modale() {
  const article = document.querySelector("#modale");
  article.classList.remove("hidden");
  article.classList.add("modale");
  document.body.classList.add("no-scroll");
  window.addEventListener('keydown', off_modale);
  const event={
    key:"Escape",
  };
  close_menu(event);

}

//script insta
function onResponse(response) {
  return response.json();
}

function onJsonMedia(json) {
  console.log(json);
  const container = document.querySelector('.feed');
  const len = 3;
  if (json.length < 3) {
    len = json.length;
  }
  for (let i = 0; i < len; i++) {
    if (json[i].media_type !== 'VIDEO') {

      const div = document.createElement('div');
      const img = document.createElement('img');
      img.src = json[i].media_url;
      div.appendChild(img);
      container.appendChild(div);
    }
  }
}




fetch("http://localhost/hw1/api_instagram.php").then(onResponse).then(onJsonMedia);
// webform
const collab_prev = document.querySelector("#collab_prev1");
collab_prev.addEventListener('click', modale);
//html

function open_menu() {
  const container_menu = document.querySelector("#container_menu");
  container_menu.classList.remove("hidden");
  container_menu.classList.add("modale");
  document.body.classList.add("no-scroll");
  window.addEventListener('keydown', close_menu);
  const collab_prev1 = document.querySelector("#collab_prev");
  collab_prev1.addEventListener('click', modale);
}
const menu = document.querySelector(".option");
menu.addEventListener('click', open_menu);
