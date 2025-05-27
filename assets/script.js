if (typeof anime !== "undefined") {
    console.log("anime.js carregado com sucesso!");
} else {
    console.error("anime.js não foi carregado corretamente.");
}

window.onload = function () {
    //Animação do logotipo
    anime({
        targets: 'span',
        translateY: [
            { value: '-1.27rem', easing: 'easeOutExpo', duration: 600 },
            { value: '0rem', easing: 'easeOutBounce', duration: 800, delay: 200 }
        ],
        rotate: ['-1turn', '0turn'],
        delay: (_, i) => i * 50,
        easing: 'easeInOutCirc',
        loopDelay: 1000,
        loop: true
    });
    //FIM--Animação do logotipo--FIM

    //Animação dos blocos do background
    const background = document.querySelector(".background");
    const COLORS = ["grey", "red", "black"];
    const BLOCK_SIZE = 60;
    const MAX_SCALE = 5;
    for (let i = 0; i < 100; i++) {
        const block = document.createElement("div");
        block.classList.add("block");
        const color = COLORS[anime.random(0, COLORS.length - 1)];
        block.style.backgroundColor = color;
        background.appendChild(block);
    }
    const randomLeft = () => {
        const maxX = background.clientWidth - BLOCK_SIZE * MAX_SCALE;
        return anime.random(0, maxX) + "px";
    };
    const randomTop = () => {
        const maxY = background.clientHeight - BLOCK_SIZE * MAX_SCALE;
        return anime.random(0, maxY) + "px";
    };
    const animateBlocks = () => {
        anime({
            targets: ".block",
            left: randomLeft,
            top: randomTop,
            scale: () => anime.random(1, MAX_SCALE),
            easing: "linear",
            duration: 3000,
            delay: anime.stagger(10),
            complete: animateBlocks
        });
    };
    animateBlocks();
    //FIM--Animação dos blocos do background--FIM
};
