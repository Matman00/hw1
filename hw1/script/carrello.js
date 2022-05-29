function svuota_carrello(){
  fetch("http://localhost/hw1/delete_carrello.php?email="+document.getElementById("email").textContent);
  window.location.reload()
}

function insert_articoli(){
  const element=document.querySelectorAll("#quantita");
  for( let e of element){
    console.log("nome "+e.name+"    ");
    fetch("http://localhost/hw1/insert_articoli_ordini.php?prod="+e.name).then(svuota_carrello);
  }
}

function carica_ordine(){
  fetch("http://localhost/hw1/insert_dettagli_ordine.php?email="+document.getElementById("email").textContent).then(insert_articoli);

}

function remove_element(event){
  fetch("http://localhost/hw1/delete_item_carrello.php?email="+document.getElementById("email").textContent+"&sku="+event.currentTarget.name);
  window.location.reload()
}

function view_carrrello_json(json){
  console.log(json);
  for(var i=0;i < json.length;i++ ){

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
    h2.textContent=json[i].nome;
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
    input.value=json[i].quantita;
    input.id="quantita"
    input.setAttribute('disabled','');
    input.name=json[i].sku;
    quantita.appendChild(input);

    const button=document.createElement("button");
    button.name=json[i].sku;
    button.type="button";
    button.id="remove_element";
    button.textContent="rimuovi dal carrello";
    carrello.appendChild(button);
    button.addEventListener("click",remove_element);
  }
  if(json.length>0){
    const section=document.querySelector("section");
    const totale=document.createElement("div");
    totale.classList.add("totale");
    section.appendChild(totale);

    const div=document.createElement("div");
    totale.appendChild(div);

    const p=document.createElement("p");
    p.textContent="Totale Carrello"
    div.appendChild(p);


    const h2=document.createElement("h2");
    h2.textContent=json[0].totale+"€";
    div.appendChild(h2);

    const button=document.createElement("button");
    button.type="button";
    button.id="ok_ordine";
    button.textContent="Procedi all'ordine";
    totale.appendChild(button);
    button.addEventListener('click', carica_ordine);


  }
  else{
    const section=document.querySelector("section");
    const h1=document.createElement("h1");
    h1.textContent="Il tuo carrello è vuoto...";
    section.appendChild(h1);
  }
}


function onResponce(responce){
  return responce.json();
}


fetch("http://localhost/hw1/get_carrello.php?q="+document.getElementById("email").textContent).then(onResponce).then(view_carrrello_json);
