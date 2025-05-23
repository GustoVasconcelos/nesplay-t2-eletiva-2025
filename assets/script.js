if (typeof anime !== "undefined") {
    console.log("anime.js carregado com sucesso!");
} else {
    console.error("anime.js não foi carregado corretamente.");
}

window.onload = function () {
    // Animação dos <span>
    anime({
        targets: 'span',
        translateY: [
            { value: '-1.27rem', easing: 'easeOutExpo', duration: 600 },
            { value: '0rem', easing: 'easeOutBounce', duration: 800, delay: 100 }
        ],
        rotate: ['-1turn', '0turn'],
        delay: (_, i) => i * 50,
        easing: 'easeInOutCirc',
        loopDelay: 1000,
        loop: true
    });
    //Fim--Animação dos <span>--Fim
};
