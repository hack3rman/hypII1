function selecție_meniu(sursă,titlu){
  let element = document.getElementById("titlu_h1");
  element.innerHTML = titlu;
  schimb_conținutul(sursă);
}

function schimb_conținutul(sursă, element_selectat){
  let i;
  document.getElementById("ramă").src = 'copiuțe/' + sursă + '.html';
  let elemente = document.querySelectorAll("#submeniu>p");
  for ( i = 0; i < elemente.length; i++  ) {
    elemente[i].style.backgroundColor = "#ffffff";
  }
  element_selectat.style.backgroundColor = "#10706010";

}

