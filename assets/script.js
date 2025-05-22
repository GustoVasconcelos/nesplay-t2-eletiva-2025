if (typeof anime !== "undefined") {
    console.log("anime.js carregado com sucesso!");
} else {
    console.error("anime.js não foi carregado corretamente.");
}

window.onload = function () {
    // Animação do #myDiv
    anime({
        targets: '#myDiv',
        translateX: 250,
        loop: true,
        easing: 'easeInOutQuad',
        duration: 2000,
        direction: 'alternate'
    });

    // Animação dos <span>
    anime({
        targets: 'span',
        translateY: [
          { value: '-2.75rem', easing: 'easeOutExpo', duration: 600 },
          { value: '0rem', easing: 'easeOutBounce', duration: 800, delay: 100 }
        ],
        rotate: ['-1turn', '0turn'],
        delay: (_, i) => i * 50,
        easing: 'easeInOutCirc',
        loopDelay: 1000,
        loop: true
      });
};
