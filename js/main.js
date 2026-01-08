/* main.js - includes existing small mobile menu code + TTS helper */

/* existing code you had */
jQuery(document).ready(function($){
	//open-close submenu on mobile
	$('.cd-main-nav').on('click', function(event){
		if($(event.target).is('.cd-main-nav')) $(this).children('ul').toggleClass('is-visible');
	});
});

/* ------------------------
   TTS helper (Web Speech API)
   Put this at end of main.js
   ------------------------ */
(function(){
  if (!('speechSynthesis' in window)) {
    console.warn('TTS: speechSynthesis not supported');
    return;
  }

  window.TTS = {
    _utt: null,
    speak: function(text, opts){
      if (!text) return;
      try { window.speechSynthesis.cancel(); } catch(e){}
      var u = new SpeechSynthesisUtterance(String(text));
      u.lang = (opts && opts.lang) ? opts.lang : 'en-US';
      u.rate = (opts && opts.rate) ? parseFloat(opts.rate) : 1;
      u.pitch = (opts && opts.pitch) ? parseFloat(opts.pitch) : 1;
      u.volume = (opts && opts.volume) ? parseFloat(opts.volume) : 1;
      window.TTS._utt = u;
      window.speechSynthesis.speak(u);
    },
    stop: function(){ try { window.speechSynthesis.cancel(); } catch(e){} },
    isSpeaking: function(){ return window.speechSynthesis.speaking; }
  };

  // Attach click handler for any element with [data-tts-play]
  document.addEventListener('click', function(e){
    var btn = e.target.closest ? e.target.closest('[data-tts-play]') : (e.target.getAttribute && e.target.getAttribute('data-tts-play') ? e.target : null);
    if (!btn) return;
    var targetSelector = btn.getAttribute('data-tts-target');
    var text = '';
    if (targetSelector) {
      var el = document.querySelector(targetSelector);
      if (el) text = el.getAttribute('data-tts') || el.innerText || el.textContent;
    } else {
      text = btn.getAttribute('data-tts') || btn.innerText || btn.title || '';
    }
    if (!text) return;
    if (window.TTS.isSpeaking()) {
      window.TTS.stop();
      btn.innerText = '🔊';
    } else {
      window.TTS.speak(text);
      btn.innerText = '⏸️';
      // restore icon after finished
      var check = setInterval(function(){
        if (!window.TTS.isSpeaking()) {
          btn.innerText = '🔊';
          clearInterval(check);
        }
      }, 200);
    }
  });

  // Populate voices (if you want a selector in future)
  function getVoicesSafe(){
    var v = speechSynthesis.getVoices();
    if (v.length === 0){
      // some browsers populate onvoiceschanged
      speechSynthesis.onvoiceschanged = function(){ /* no-op */ };
    }
    return speechSynthesis.getVoices();
  }
})();
