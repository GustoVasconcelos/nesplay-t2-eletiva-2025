if (typeof anime !== "undefined") {
    console.log("anime.js carregado com sucesso!");
} else {
    console.error("anime.js não foi carregado corretamente.");
}
window.onload = function () {
    anime({
        targets: '#myDiv',
        translateX: 250,
        loop: true,
        easing: 'easeInOutQuad',
        duration: 2000,
        direction: 'alternate'
    });
};