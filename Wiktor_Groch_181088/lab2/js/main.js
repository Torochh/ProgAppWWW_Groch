//--------------MOTYW CIEMNY------------------
const themebutton = document.getElementById('darktheme');

function setTheme(theme){
  document.documentElement.setAttribute("data-theme",theme);
  localStorage.setItem("saved-theme",theme);
}

function przelacz(){
  const acctheme = document.documentElement.getAttribute("data-theme");
  if(acctheme != 'dark'){
    setTheme('dark');
  }else{
    setTheme('');
  } 
}
function LoadSaved(){
  setTheme(localStorage.getItem("saved-theme"));
}
themebutton.addEventListener("click",przelacz);
LoadSaved();

//------------------ZEGAR-----------------------
function zegar(){
  const time = new Date();
  const opcje = {
      hour: '2-digit',
      minute: '2-digit',
      second: '2-digit',
      hour12: false
    };
    const date = new Date();
    const opcje2 = {
      year: 'numeric',
      month: 'long',
      day: 'numeric'
    };
  const formater2 = new Intl.DateTimeFormat("pl-PL",opcje2);
  const dateF = formater2.format(date);
  document.getElementById("data").textContent = dateF;
  const formater = new Intl.DateTimeFormat("pl-PL",opcje);
  const timeF = formater.format(time);  
  document.getElementById("zegar").textContent = timeF;
}

//--------------------STOP------------------
let flaga = false;
const StopZ = document.getElementById('stop');
function stopZegar(){
  if (flaga != true){
    IdI = clearInterval(IdI);
    flaga = true;
  }
}
StopZ.addEventListener("click",stopZegar);

//----------------------START-----------------------
const StartZ = document.getElementById('start');
function startZegar(){
  if( flaga != false){
    IdI = setInterval(zegar,1000);
    flaga = false;
  }
}
StartZ.addEventListener("click",startZegar);
zegar();
let IdI = setInterval(zegar,1000);


//--------------------SZUKANIE------------------
const szukanie = document.getElementById("szukaj");
const produkty = document.querySelectorAll(".katalog .card");
const licznikW = document.getElementById('results-count');
const NieLicznik = document.getElementById('no-results-msg');

function szukanieF(){
  const query = szukanie.value.trim().toLowerCase();
  let licznik = 0;

  produkty.forEach(card => {
    const nazwa = card.textContent.toLowerCase();

    if (nazwa.includes(query)) {
      card.hidden = false;
      licznik ++;
    }else{
      card.hidden = true;
    }
  });
  licznikW.textContent = `Liczba wynikow: ${licznik}`;

  if (licznik === 0){
    NieLicznik.hidden = false;
  }else{
    NieLicznik.hidden = true;
  }
}
szukanie.addEventListener('input',szukanieF);



