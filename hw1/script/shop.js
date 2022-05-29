var elementi_caricati=0;
var errore=0;
let check_session=0;

function carrello_add(event){

  console.log(document.getElementById("email").textContent);
  if(document.getElementById("email").textContent===""){
    window.alert("Effettua il login");
    return;
  }
  else
  {

    const quantita=document.querySelectorAll("#quantita");
    for(let i=0;i<quantita.length;i++){
      console.log("q "+ quantita[i].name+ "event "+ event.currentTarget.name + "value q "+quantita[i].value);
      if(quantita[i].name===event.currentTarget.name && quantita[i].value>0){
        console.log("1");
        fetch("http://localhost/hw1/insert_carrello.php?quantita="+quantita[i].value+"&sku="+event.currentTarget.name+"&email="+document.getElementById("email").textContent);
        quantita[i].value=0;
      }
      quantita[i].value=0;
    }
  }
}

function onJsonViewProduct(json){
  console.log(json);
  if (elementi_caricati===1) {

    const verifica=document.querySelectorAll(".box_product");

    for(let v of verifica){

      v.remove();
    }
  }
  if(json.length===0 && errore===0){
    errore=1;
    const section=document.querySelector("section");
    const error=document.createElement("h1");
    error.id="error";
    error.textContent="Purtoppo non abbiamo trovato nessun risultato...";
    section.appendChild(error);
  }
  if(json.length>0){
    for(var i=0;i < json.length;i++ ){
      if(errore===1) document.getElementById("error").remove();
      errore=0;
      const section=document.querySelector("section");


      const box_product=document.createElement("div");
      box_product.classList.add("box_product");
      section.appendChild(box_product);

      const frist=document.createElement("div");
      frist.classList.add("frist");
      box_product.appendChild(frist);

      const img=document.createElement("img");
      img.src=json[i].pic;
      frist.appendChild(img);

      const info_ordini_box=document.createElement("div");
      info_ordini_box.classList.add("info_ordini_box");
      box_product.appendChild(info_ordini_box);

      const box_info_scrittura=document.createElement("div");
      box_info_scrittura.classList.add("box_info_scrittura");
      info_ordini_box.appendChild(box_info_scrittura);

      var div=document.createElement("div");
      box_info_scrittura.appendChild(div);

      var h2=document.createElement("h2");
      h2.textContent=json[i].titolo;
      div.appendChild(h2);

      div= document.createElement("div");
      box_info_scrittura.appendChild(div);

      var p=document.createElement("p");
      p.textContent="DESCRIZIONE";
      div.appendChild(p);
      h2=document.createElement("h2");
      h2.textContent=json[i].descrizione;
      div.appendChild(h2);

      div= document.createElement("div");
      box_info_scrittura.appendChild(div);

      p=document.createElement("p");
      p.textContent="SKU";
      div.appendChild(p);
      h2=document.createElement("h2");
      h2.textContent=json[i].sku;
      div.appendChild(h2);

      div= document.createElement("div");
      box_info_scrittura.appendChild(div);

      p=document.createElement("p");
      p.textContent="PREZZO";
      div.appendChild(p);
      h2=document.createElement("h2");
      if(json[i].attivo==1){
        const sconto=json[i].prezzo*(json[i].percentuale/100);
        h2.textContent=json[i].prezzo - sconto + "€";
        div.appendChild(h2);
      }
      else{
        h2.textContent=json[i].prezzo + "€";
        div.appendChild(h2);
      }


      const carrello=document.createElement("div");
      carrello.classList.add("carrello");
      box_info_scrittura.appendChild(carrello);

      const quantita=document.createElement("div");
      quantita.classList.add("quantita");
      carrello.appendChild(quantita);

      var label=document.createElement("label");
      label.textContent="QUANTITA";
      quantita.appendChild(label);

      const input=document.createElement("input");
      input.type="number";
      input.value="0";
      input.min="0";
      input.max=json[i].quantita;
      input.id="quantita"
      input.name=json[i].sku;
      quantita.appendChild(input);

      const button=document.createElement("button");
      button.name=json[i].sku;
      button.id="add_carrello";
      button.textContent="Aggiugni al Carrello";
      carrello.appendChild(button);

    }
 elementi_caricati=1;
  const add_carrello=document.querySelectorAll("#add_carrello");
  for(var i=0;i<add_carrello.length;i++){
    add_carrello[i].addEventListener("click", carrello_add);
  }
}

}

function session_Json(json){

  if(json.length===0){

    fetch("http://localhost/hw1/insert_shopping_session.php?email="+document.getElementById("email").textContent);
  }
}

function onResponce(responce){
  return responce.json();
}

function search_bar(e){
  const element=e.currentTarget.value;
  
  if(element.length>0){
    fetch("http://localhost/hw1/search_bar.php?element="+element).then(onResponce).then(onJsonViewProduct);
  }
  else{
    fetch("http://localhost/hw1/get_product.php").then(onResponce).then(onJsonViewProduct);
  }
}


if(document.getElementById("email").textContent.length!==0){
  fetch("http://localhost/hw1/get_session.php?email="+document.getElementById("email").textContent).then(onResponce).then(session_Json);
}
fetch("http://localhost/hw1/get_product.php").then(onResponce).then(onJsonViewProduct);


const button_search_bar=document.getElementById("search_bar");
button_search_bar.addEventListener("keyup", search_bar);
