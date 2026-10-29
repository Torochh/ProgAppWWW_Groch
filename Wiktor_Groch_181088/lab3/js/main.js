//--------------MOTYW CIEMNY------------------
const themebutton = document.getElementById('darktheme');

function setTheme(theme){
  document.documentElement.setAttribute("data-theme",theme);
  localStorage.setItem("saved-theme",theme);

  if (theme === 'dark') {
    themebutton.setAttribute("aria-pressed", "true");
  } else {
    themebutton.setAttribute("aria-pressed", "false");
  }
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

//----------------------START-----------------------
const StartZ = document.getElementById('start');
function startZegar(){
  if( flaga != false){
    IdI = setInterval(zegar,1000);
    flaga = false;
  }
}

// Zabezpieczenie
let IdI;
if (StopZ && StartZ) {
  StopZ.addEventListener("click",stopZegar);
  StartZ.addEventListener("click",startZegar);
  zegar();
  IdI = setInterval(zegar,1000);
}


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

// Zabezpieczenie
if (szukanie) {
  szukanie.addEventListener('input',szukanieF);
}


//--------------------KALKULATOR CENY------------------
const lista_produkty = [
  { id: "klasyczna kaczka", nazwa: "Zolta kaczka", cenaGrosze: 10000 },
  { id: "kaczka koszykarz", nazwa: "Kaczka koszykarz", cenaGrosze: 15000 },
  { id: "kaczka z Naruto", nazwa: "Kaczka z Naruto", cenaGrosze: 20000 }
];

function kalkulatorCeny(cenaGrosze, ilosc){
  return cenaGrosze * ilosc;
}
const fortmatCeny = new Intl.NumberFormat("pl-PL",{
  style: "currency",
  currency: "PLN"
});

const formKontakt = document.getElementById('formularz-kontakt');
const selectProdukt = document.getElementById('lista');
const inputIlosc = document.getElementById('ilosc');
const inputWiadomosc = document.getElementById('wiadomosc');
const podgladCeny = document.getElementById('podglad-ceny');
const bladWiadomosc = document.getElementById('blad-wiadomosc');

const sekcjaPodsumowania = document.getElementById('podsumowanie-sekcja');
const podsumowanieProdukt = document.getElementById('podsumowanie-produkt');
const podsumowanieIlosc = document.getElementById('podsumowanie-ilosc');
const podsumowanieWartosc = document.getElementById('podsumowanie-wartosc');
const podsumowanieWiadomosc = document.getElementById('podsumowanie-wiadomosc');

if (formKontakt) {
  function PoprawnaIlosc() {
    if (inputIlosc.value.trim() === '') return null;
    const wartosc = Number(inputIlosc.value);
    if (Number.isInteger(wartosc) && wartosc >= 1 && wartosc <= 5) {
      return wartosc;
    }
    return null;
  }

  function usunPodsumowanie() {
    if (sekcjaPodsumowania) {
      sekcjaPodsumowania.hidden = true;
    }
  }

  function AktualizujCene() {
    usunPodsumowanie();

    const wybranyID = selectProdukt.value;
    const wybranyProdukt = lista_produkty.find(p => p.id === wybranyID);
    const ilosc = PoprawnaIlosc();
    
    if (!wybranyProdukt || ilosc === null) {
      podgladCeny.textContent = 'Wybierz produkt i poprawną ilość (całkowita 1–5), aby zobaczyć wycenę.';
      return null;
    }

    const sumaGrosze = kalkulatorCeny(wybranyProdukt.cenaGrosze, ilosc);
    const sumaPLN = fortmatCeny.format(sumaGrosze / 100);
    podgladCeny.textContent = `Cena: ${sumaPLN}`;
    
    return { wybranyProdukt, ilosc, sumaPLN };
  }

  selectProdukt.addEventListener('change', AktualizujCene);
  inputIlosc.addEventListener('input', AktualizujCene);

  inputWiadomosc.addEventListener('input', () => {
    usunPodsumowanie();
    if (inputWiadomosc.value.trim().length >= 10) {
      bladWiadomosc.textContent = '';
      bladWiadomosc.hidden = true;
    }
  });

  formKontakt.addEventListener('submit', (e) => {
    e.preventDefault();

    const wynik = AktualizujCene();
    const tekstWiadomosci = inputWiadomosc.value.trim();

    if (tekstWiadomosci.length < 10) {
      usunPodsumowanie();
      bladWiadomosc.textContent = 'Wiadomość po usunięciu spacji musi mieć minimum 10 znaków.';
      bladWiadomosc.hidden = false;
      inputWiadomosc.focus();
      return;
    }

    bladWiadomosc.textContent = '';
    bladWiadomosc.hidden = true;

    if (wynik) {
      podsumowanieProdukt.textContent = wynik.wybranyProdukt.nazwa;
      podsumowanieIlosc.textContent = wynik.ilosc;
      podsumowanieWartosc.textContent = wynik.sumaPLN;
      podsumowanieWiadomosc.textContent = tekstWiadomosci;
      sekcjaPodsumowania.hidden = false;
    }
  });
}