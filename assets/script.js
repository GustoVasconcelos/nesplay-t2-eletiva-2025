/*
    ———————————————————————————————————————————————————————————————
    |Projeto NESPlay                                              |
    |Animações: Anime.js v3.2.1                                   |
    |Usando Anime.js para:                                        |
    |   – animação de spans no logotipo                           |
    |   – movimento aleatório dos blocos de fundo                 |
    ———————————————————————————————————————————————————————————————
*/

// Função para alternar as animações
; (function () {
    const btn = document.getElementById('toggle-anim');
    const body = document.body;
    const LS_KEY = 'nesplay_no_anim';

    // Aplica estado salvo
    if (localStorage.getItem(LS_KEY) === 'true') {
        body.classList.add('no-anim');
        if (btn) btn.textContent = 'Ativar animações';
    }

    // Listener do botão
    btn?.addEventListener('click', () => {
        const off = body.classList.toggle('no-anim');
        btn.textContent = off ? 'Ativar animações' : 'Desativar animações';
        localStorage.setItem(LS_KEY, off);
        location.reload(); // Força recarregar para aplicar/remover animações corretamente
    });
})();
// FIM--Função para alternar as animações--FIM

// Estado global de volume/mute para persistir entre trocas de ROM
window.isMuted = false;
window.prevVolume = 50;

// Função global para aplicar estado de volume/mute
window.applyVolumeState = function () {
    const volSlider = document.getElementById('volume-slider');
    const volDisplay = document.getElementById('volume-display');
    const muteBtn = document.getElementById('mute-btn');
    if (!window.nesGainNode || !volSlider || !volDisplay || !muteBtn) return;

    if (window.isMuted) {
        nesGainNode.gain.value = 0;
        volSlider.value = 0;
        volDisplay.textContent = '0%';
        muteBtn.textContent = 'Volume: Desilenciar';
    } else {
        nesGainNode.gain.value = window.prevVolume / 100;
        volSlider.value = window.prevVolume;
        volDisplay.textContent = window.prevVolume + '%';
        muteBtn.textContent = 'Volume: Silenciar';
    }
};

window.onload = function () {
    const isAnimOff = document.body.classList.contains('no-anim');

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
        if (isAnimOff) return;
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

    if (!isAnimOff) {
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
    }
    // FIM--Animação dos blocos do background--FIM

    // Animação do logotipo
    if (!isAnimOff) {
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
    }
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
    // FIM--Função para mudar o texto do arquivo (se existir input e div)--FIM

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

    // Funções para gerenciar as roms
    function editarRom(id) {
        document.querySelector(`#rom-${id} .rom-view`).classList.add('d-none');
        document.getElementById(`form-${id}`).classList.remove('d-none');
    }
    window.editarRom = editarRom;

    function cancelarEdicaoRom(id) {
        document.getElementById(`form-${id}`).classList.add('d-none');
        document.querySelector(`#rom-${id} .rom-view`).classList.remove('d-none');
    }
    window.cancelarEdicaoRom = cancelarEdicaoRom;
    // FIM--Funções para gerenciar as roms--FIM

    // Funções para gerenciar o volume e o slider do volume
    const volSlider = document.getElementById('volume-slider');
    const volDisplay = document.getElementById('volume-display');
    const muteBtn = document.getElementById('mute-btn');

    // Aplica estado na primeira carga
    document.documentElement.style.setProperty('--vol-percent', window.prevVolume + '%');
    applyVolumeState();

    // Slider de volume
    volSlider.addEventListener('input', () => {
        const pct = volSlider.value;
        window.prevVolume = pct;
        // atualiza o gradiente:
        document.documentElement.style.setProperty('--vol-percent', pct + '%');
        // restante da sua lógica de volume/mute:
        if (window.isMuted) window.isMuted = false;
        applyVolumeState();
    });

    // Botão de Mudo
    muteBtn.addEventListener('click', () => {
        // se ainda não está mudo, guarda o prevVolume antes de mutar
        if (!window.isMuted) {
            window.prevVolume = volSlider.value;
            window.isMuted = true;
        } else {
            // apenas desmuta, prevVolume já preserva o valor anterior
            window.isMuted = false;
        }
        applyVolumeState();
    });

    function applyVolumeState() {
        if (!window.nesGainNode) return;

        if (isMuted) {
            nesGainNode.gain.value = 0;
            volSlider.value = 0;
            volDisplay.textContent = '0%';
            muteBtn.textContent = 'Volume: Desilenciar';
        } else {
            nesGainNode.gain.value = prevVolume / 100;
            volSlider.value = prevVolume;
            volDisplay.textContent = prevVolume + '%';
            muteBtn.textContent = 'Volume: Silenciar';
        }
    }
    // FIM--Funções para gerenciar o volume e o slider do volume--FIM
};

// Funções para gerenciar o emulador e o canvas
const canvasId = 'nes-canvas';
const basePath = '../roms/';

function carregarRom(nomeArquivo) {
    if (window.resetAudioBuffer) resetAudioBuffer();
    nes_load_url(canvasId, basePath + nomeArquivo);
}

document.addEventListener('visibilitychange', () => {
    if (document.hidden) {
        isRunning = false;
    } else {
        lastFrameTime = performance.now();
        framesAccumulator = 0;
        isRunning = true;
    }
});

function salvarROMEmCookie(nomeROM) {
    document.cookie = `ultimaROM=${nomeROM}; path=/; max-age=31536000`;
}

function lerCookie(nome) {
    const cookies = document.cookie.split(';');
    for (let cookie of cookies) {
        const [chave, valor] = cookie.trim().split('=');
        if (chave === nome) return valor;
    }
    return null;
}

window.addEventListener('load', () => {
    const select = document.getElementById('rom-select');
    const romSalva = lerCookie('ultimaROM');
    const romInicial = romSalva || select.value;

    select.value = romInicial;
    carregarRom(romInicial);
});

document.getElementById('rom-select').addEventListener('change', function () {
    const rom = this.value;
    carregarRom(rom);
    salvarROMEmCookie(rom);
});

const wrapper = document.getElementById('canvas-wrapper');
document.getElementById('btn-fullscreen').addEventListener('click', () => {
    if (wrapper.requestFullscreen) wrapper.requestFullscreen();
    else if (wrapper.webkitRequestFullscreen) wrapper.webkitRequestFullscreen();
    else if (wrapper.msRequestFullscreen) wrapper.msRequestFullscreen();
});

const teclasBloqueadas = [
    'ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight',
    'a', 'q', 's', 'o', 'A', 'Q', 'S', 'O',
    'Tab', 'Enter'
];

document.addEventListener('keydown', function (e) {
    if (teclasBloqueadas.includes(e.key)) {
        e.preventDefault();
    }
});
// FIM--Funções para gerenciar o emulador e o canvas--FIM

// Função para tratar o FadeInOut das mensagens de sucesso
document.addEventListener('DOMContentLoaded', () => {
    const msg = document.getElementById('successMessage');
    if (!msg) return;

    setTimeout(() => {
        msg.remove();
    }, 7000);
});
// FIM--Função para tratar o FadeInOut das mensagens de sucesso--FIM