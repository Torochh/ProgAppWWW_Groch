
//----------------OGRANICZENIE ANIMACJI ----------------------
const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');

  // 2. Jeśli tak, wyłącz animacje w całym jQuery
  if (prefersReducedMotion.matches) {
    $.fx.off = true;
  }

  // 3. Nasłuchuj zmian w czasie rzeczywistym (gdy użytkownik zmieni opcję w systemie bez odświeżania)
  prefersReducedMotion.addEventListener('change', (e) => {
    $.fx.off = e.matches;
  });


//----------------------- GUZIK A1 ----------------------------
const but1 = document.getElementById("A1");
let isEx = false;
$(but1).on('click', function (){
	const $this = $(this);
	isEx = !isEx;

	$this.attr('aria-pressed', isEx);

	const targW = isEx ? 240 : 160;
	const targH = isEx ? 130: 90;

	$this.stop(true,false).animate({
		width: targW,
		height: targH
	}, 300);
});


//----------------------- GUZIK A2 ----------------------------

const but2 = document.getElementById("A2");
let isBi = false;
let isFo = false;

$(but2).on({
  mousedown: function() {
    $(this).trigger('focus');
  },

  mouseenter: function() {
    isBi = true;
    $(this).attr('aria-pressed', true).stop(true, false).animate({
      width: 220,
      height: 120
    }, 300);
  },

  mouseleave: function() {
    isBi = false;
    if (!isBi && !isFo) {
      $(this).attr('aria-pressed', false).stop(true, false).animate({
        width: 160,
        height: 90
      }, 300);
    }
  },

  focus: function() {
    isFo = true;
    $(this).attr('aria-pressed', true).stop(true, false).animate({
      width: 220,
      height: 120 
    }, 300);
  },

  blur: function() {
    isFo = false;
    if (!isBi && !isFo) {
      $(this).attr('aria-pressed', false).stop(true, false).animate({
        width: 160,
        height: 90
      }, 300);
    }
  }
});

//----------------------- GUZIK A3 ----------------------------

const but3 = document.getElementById("A3");
const base_w = 160;
const base_h = 90;
const step_w = 20;
const step_h = 10;
const max = 5;

let currstep = 0;

$(but3).on('click', function(){
	const $this = $(this);
	if ($this.is(":animated")) {
		return;
	}
	if (currstep >= max){
		return;
	}

	currstep++;

	const targetW = base_w + (currstep * step_w);
	const targetH = base_h + (currstep * step_h);

	$this.animate({
		width : targetW,
		height : targetH
	}, 300);
});

//----------------------- RESET ----------------------------

const reset = document.getElementById("reset");

let isClic = false;

$(reset).on('click', function(){

	currstep = 0;
	isEx = false;

	$("#A1,#A3").stop(true, false).animate({
      width: 160,
      height: 90
    }, 300);


});


//--------------------STATUS PHP------------------
const $statusButton = $('#status');
const $statusMsg = $('#status-msg');

if ($statusButton.length && $statusMsg.length) {
  $statusButton.on('click', function(e) {
    e.preventDefault();

    $statusButton.prop('disabled', true);
    $statusMsg.text('Sprawdzanie stanu serwera...');

    $.ajax({
      url: 'status.php',
      method: 'GET',
      dataType: 'text',
      timeout: 5000
    })
    .done(function(response) {
      $statusMsg.text(response);
    })
    .fail(function(jqXHR, textStatus) {
      if (textStatus === 'timeout') {
        $statusMsg.text('Blad: Przekroczono czas oczekiwania na odpowiedz serwera (5s).');
      } else {
        $statusMsg.text(`Blad polaczenia: ${jqXHR.status} (${jqXHR.statusText || 'Brak odpowiedzi'})`);
      }
    })
    .always(function() {
      $statusButton.prop('disabled', false);
    });
  });
}
