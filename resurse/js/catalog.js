function înregistrează_poziție(){
  console.log(window.scrollY);
  sessionStorage.setItem("locație_verticală", window.scrollY);
}

function încarcă_poziție(){
  addEventListener("DOMContentLoaded", (event) => {
    let locație_veritcală = sessionStorage.getItem("locație_verticală", window.scrollY);
    if (locație_veritcală != 0) {
      window.scrollTo(0, locație_veritcală);
      sessionStorage.removeItem("locație_verticală");
    }
  });
}

function actualizare_elev_activ_note(){
  addEventListener("DOMContentLoaded", (event) => {
    let search = new URLSearchParams(document.location.search);
    let rezultat = search.get('id');
    if (rezultat) {
      let opțiuni = document.getElementById('selecție_select');
      for (i = 0; i < opțiuni.options.length; i++){
        if(opțiuni.options[i].value == rezultat){
          document.querySelector('#selecție_select').value = rezultat;
        }
      }
    }
  });
}

actualizare_elev_activ_note();