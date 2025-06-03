/*
    ———————————————————————————————————————————————————————————————
    |Projeto NESPlay                                              |
    |Animações: Anime.js v3.2.1                                   |
    |Usando Anime.js para:                                        |
    |   – animação de spans no logotipo                           |
    |   – movimento aleatório dos blocos de fundo                 |
    ———————————————————————————————————————————————————————————————
*/

window.onload = function () {
    // Animação dos blocos do background
    const background = document.querySelector(".background");
    const COLORS = ["grey", "red", "black"];
    const BLOCK_SIZE = 60;
    const MAX_SCALE = 5;
    const TOTAL_BLOCKS = 25;

    function getMaxCoords() {
        return {
            maxX: background.clientWidth - BLOCK_SIZE * MAX_SCALE,
            maxY: background.clientHeight - BLOCK_SIZE * MAX_SCALE
        };
    }

    function randomPosition(max) {
        return anime.random(0, max) + "px";
    }

    function animateBlock(block) {
        const { maxX, maxY } = getMaxCoords();
        anime({
            targets: block,
            left: randomPosition(maxX),
            top: randomPosition(maxY),
            scale: anime.random(1, MAX_SCALE),
            duration: anime.random(3000, 6000),
            easing: 'linear',
            complete: () => animateBlock(block)
        });
    }

    for (let i = 0; i < TOTAL_BLOCKS; i++) {
        const block = document.createElement("div");
        block.classList.add("block");
        block.style.backgroundColor = COLORS[anime.random(0, COLORS.length - 1)];
        const { maxX, maxY } = getMaxCoords();
        block.style.left = randomPosition(maxX);
        block.style.top = randomPosition(maxY);
        background.appendChild(block);
        animateBlock(block);
    }
    // FIM--Animação dos blocos do background--FIM

    // Animação do logotipo
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
    // FIM--Animação do logotipo--FIM

    // Função para mudar o texto do arquivo (se existir input e div)
    const fileNameDiv = document.getElementById('romFileName');
    const input = document.getElementById('romFile');

    if (input && fileNameDiv) {
        input.addEventListener('change', () => {
            const name = input.files.length
                ? input.files[0].name
                : 'Nenhum arquivo escolhido';
            fileNameDiv.textContent = name;
        });
    }
    // FIM--Função para mudar o texto do arquivo--FIM

    // Listener para mostrar/ocultar input de novo nome ao selecionar categoria
    const select = document.getElementById('selectCategoriaRenomear');
    const inputNovoNome = document.getElementById('novoNomeCategoria');

    if (select && inputNovoNome) {
        select.addEventListener('change', function () {
            if (select.value && select.value !== "Escolher...") {
                inputNovoNome.classList.remove('d-none');
            } else {
                inputNovoNome.classList.add('d-none');
            }
        });
    }
    // FIM--Listener para mostrar/ocultar input de novo nome ao selecionar categoria--FIM

    // Funções para gerenciar os usuários
    function editarUsuario(id) {
        document.querySelector(`#user-${id} .user-view`).classList.add('d-none');
        document.getElementById(`form-${id}`).classList.remove('d-none');
    }
    window.editarUsuario = editarUsuario;

    function cancelarEdicao(id) {
        document.getElementById(`form-${id}`).classList.add('d-none');
        document.querySelector(`#user-${id} .user-view`).classList.remove('d-none');
    }
    window.cancelarEdicao = cancelarEdicao;
    // FIM--Funções para gerenciar os usuários--FIM
};