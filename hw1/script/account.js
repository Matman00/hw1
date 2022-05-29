let caricato=0;
function view_account_settings(event){
  const box=document.querySelector("#account_settings_box");
  box.classList.remove("hidden");
  box.classList.add("account_settings_box");
  const box_hidden=document.querySelector("#riepilogo");
  box_hidden.classList.remove("riepilogo");
  box_hidden.classList.add("hidden");
  window.scroll({
  top: 0,
  left: 0,
  behavior: 'smooth'
});
}
let n_item=[];
function save_num_item(json){

  n_item=json;
  fetch("http://localhost/hw1/get_ordini.php?email="+email).then(onResponse).then(onJsonOrdini);

}
function view_riepilogo(event){
  const box=document.querySelector("#riepilogo");
  box.classList.remove("hidden");
  box.classList.add("riepilogo");
  const box_hidden=document.querySelector("#account_settings_box");
  box_hidden.classList.remove("account_settings_box");
  box_hidden.classList.add("hidden");
  window.scroll({
    top: 0,
    left: 0,
    behavior: 'smooth'
  });
  fetch("http://localhost/hw1/get_num_item_ordine.php?email="+email).then(onResponse).then(save_num_item);

}

function onJsonIndirizzi(json){
  const box=document.getElementById("address");
  if(json.length>0){
      for(let j of json){
      const div=document.createElement("div");
      div.classList.add("inner_box_address");
      box.appendChild(div);

      let p=document.createElement("p");
      p.textContent=j.via;
      div.appendChild(p);

      p=document.createElement("p");
      p.textContent=j.citta+", "+j.cap+", "+j.paese;
      div.appendChild(p);

      p=document.createElement("p");
      p.textContent=j.telefono;
      div.appendChild(p);
    }
  }
}
function onJsonOrdini(json){
if(caricato){
  const verifica=document.querySelectorAll(".box_ordini");
  for(let v of verifica){
    v.remove();
  }
}

  const riepilogo=document.getElementById("riepilogo");
  if(json.length>0){
    for(let n of n_item){

      for(let i=0;i<json.length;i++){

        let check=1;
        let indice=i;

        if(n.id===json[i].id){
          const box_ordini=document.createElement("div");
          box_ordini.classList.add("box_ordini");
          riepilogo.appendChild(box_ordini);
          caricato=1;
          if(check){
            const frist=document.createElement("div");
            frist.classList.add("frist");
            box_ordini.appendChild(frist);

            let img=document.createElement("img");
            img.src=json[i].pic;
            frist.appendChild(img);

            check=0;
            i=i+n.numero; //prima immagine del ordine successivo

          }
          const info_box=document.createElement("div");
          info_box.classList.add("info_ordini_box");
          box_ordini.appendChild(info_box);

          const box_info_scrittura=document.createElement("div");
          box_info_scrittura.classList.add("box_info_scrittura");
          info_box.appendChild(box_info_scrittura);
          //nuemro ordine
          let div=document.createElement("div");
          box_info_scrittura.appendChild(div);

          let p=document.createElement("p");
          p.textContent="Numero Ordine";
          div.appendChild(p);

          let h2=document.createElement("h2");
          h2.textContent=n.id;
          div.appendChild(h2);

          //totale
          div=document.createElement("div");
          box_info_scrittura.appendChild(div);

          p=document.createElement("p");
          p.textContent="Totale";
          div.appendChild(p);

          h2=document.createElement("h2");
          h2.textContent=json[indice].totale;
          div.appendChild(h2);
          console.log("numero "+n.numero+"   indice  "+indice);
          if(n.numero>1){

            const more_orders=document.createElement("div");
            more_orders.classList.add("more_orders");
            info_box.appendChild(more_orders);

            p=document.createElement("p");
            p.textContent="Altri Prodotti...";
            more_orders.appendChild(p);

            const imgs=document.createElement("div");
            imgs.classList.add("imgs");
            more_orders.appendChild(imgs);
            let prodotto=0;
            for(let a=indice+1;a<json.length;a++){

              if(prodotto!==n.numero-1 && prodotto<4){
                let img=document.createElement("img");
                img.src=json[a].pic;
                imgs.appendChild(img);
                prodotto++;
              }
              if(n.numero>4 && prodotto===3){
                let img=document.createElement("img");
                img.src="./css&img/img/altro.png";
                imgs.appendChild(img);
              }
            }
          }
        }
      }
    }
  }
}

function onJsonEmail(json){
  console.log(json);
  document.getElementById("nome").textContent=json.nome;
  document.getElementById("cognome").textContent=json.cognome;
  document.getElementById("telefono").textContent=json.telefono;
  document.getElementById("email").textContent=json.email;
}

function onResponse(response) {
  return response.json();
}
function off_modale(event) {

  const key = event.key;
  if (key === "Escape") {
    const article = document.querySelector("#modale");
    article.classList.remove("modale");
    article.classList.add("hidden");
    document.body.classList.remove("no-scroll");
  }
}

function modale() {
  const article = document.querySelector("#modale");
  article.classList.remove("hidden");
  article.classList.add("modale");
  document.body.classList.add("no-scroll");
  window.addEventListener('keydown', off_modale);
  const event={
    key:"Escape",
  };


}

  const add_address = document.querySelector("#add_address");
  add_address.addEventListener('click', modale);
  console.log(add_address);


const account_settings=document.querySelector("#account_settings");
account_settings.addEventListener('click',view_account_settings);
const riepilogo_ordini=document.querySelector("#ordini");
riepilogo_ordini.addEventListener('click', view_riepilogo);


const email=document.getElementById("email_get").textContent;
console.log(email);

fetch("http://localhost/hw1/get_indirizzi.php?email="+email).then(onResponse).then(onJsonIndirizzi);
fetch("http://localhost/hw1/get_utenti.php?q="+email).then(onResponse).then(onJsonEmail);
