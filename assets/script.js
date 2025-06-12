/*
    ———————————————————————————————————————————————————————————————
    |Projeto NESPlay                                              |
    |Animações: Anime.js v3.2.1                                   |
    |Usando Anime.js para:                                        |
    |   – animação de spans no logotipo                           |
    |   – movimento aleatório dos blocos de fundo                 |
    ———————————————————————————————————————————————————————————————
*/

// Funções para alternar as animações
document.addEventListener("DOMContentLoaded", () => {
    // === BOTÃO: DESATIVAR ANIMAÇÕES ===
    const animBtn = document.getElementById("toggle-anim");
    const body = document.body;
    const LS_ANIM_KEY = "nesplay_no_anim";

    if (localStorage.getItem(LS_ANIM_KEY) === "true") {
        body.classList.add("no-anim");
        if (animBtn) animBtn.textContent = "Ativar Animações";
    }
    if (animBtn) {
        animBtn.addEventListener("click", () => {
            const desativado = body.classList.toggle("no-anim");
            animBtn.textContent = desativado ? "Ativar Animações" : "Desativar Animações";
            localStorage.setItem(LS_ANIM_KEY, desativado);
            location.reload();
        });
    }

    // === BOTÃO: DESATIVAR BORDAS NEON ===
    const bordaBtn = document.getElementById("toggle-bordas");
    const LS_BORDAS_KEY = "nesplay_bordas_neon";

    // Função para alternar neon e borda Bootstrap
    function toggleNeon(ativar) {
        document.querySelectorAll('.border-animated-glass, .border-top-animated-glass, .border-bottom-animated-glass')
            .forEach(el => {
                const tag = el.tagName.toLowerCase();
                if (ativar) {
                    el.classList.remove('no-neon');
                    // Remove bordas Bootstrap adicionadas antes
                    el.classList.remove('border', 'border-2', 'border-bottom', 'border-top', 'rounded-3');
                } else {
                    el.classList.add('no-neon');
                    // Header e nav: borda só embaixo
                    if (tag === 'header' || tag === 'nav') {
                        el.classList.add('border-bottom', 'border-2');
                        // opcional: sem rounded em header/nav
                        el.classList.remove('rounded-3');
                    }
                    // Footer: borda só em cima
                    else if (tag === 'footer') {
                        el.classList.add('border-top', 'border-2');
                        el.classList.remove('rounded-3');
                    }
                    // Outros elementos de conteúdo: borda em todos os lados
                    else {
                        el.classList.add('border', 'border-2', 'rounded-3');
                    }
                }
            });
    }

    // Inicialização: lê do localStorage e aplica
    if (bordaBtn) {
        const neonn = localStorage.getItem(LS_BORDAS_KEY);
        if (neonn === "false") {
            // Neon off: chamamos toggleNeon(false)
            toggleNeon(false);
            bordaBtn.textContent = "Ativar Bordas Neon";
        } else {
            // Neon on: certifique-se de mostrar texto correto
            bordaBtn.textContent = "Desativar Bordas Neon";
        }

        bordaBtn.addEventListener("click", () => {
            // Detecta se há algum elemento com neon ativo (sem .no-neon)
            const algumComNeon = document.querySelector(
                '.border-animated-glass:not(.no-neon), .border-top-animated-glass:not(.no-neon), .border-bottom-animated-glass:not(.no-neon)'
            ) !== null;

            const novoEstadoAtivarNeon = !algumComNeon;
            toggleNeon(novoEstadoAtivarNeon);

            bordaBtn.textContent = novoEstadoAtivarNeon
                ? "Desativar Bordas Neon"
                : "Ativar Bordas Neon";

            localStorage.setItem(LS_BORDAS_KEY, novoEstadoAtivarNeon);

            // Se quiser recarregar para garantir reaplicar estilos/estado:
            location.reload();
        });
    }
});
// FIM--Funções para alternar as animações--FIM

// Função global para aplicar estado de volume/mute
window.isMuted = false;
window.prevVolume = 50;

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
// FIM--Função global para aplicar estado de volume/mute--FIM

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
            targets: '#texto-logotipo span',
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

    // Funções para gerenciar as notícias
    function editarNoticia(id) {
        const wrapper = document.getElementById(`noticia-${id}`);
        if (!wrapper) return;
        const viewDiv = wrapper.querySelector('.noticia-view');
        const form = document.getElementById(`form-noticia-${id}`);
        if (viewDiv && form) {
            viewDiv.classList.add('d-none');
            form.classList.remove('d-none');
        }
    }

    function cancelarEdicaoNoticia(id) {
        const wrapper = document.getElementById(`noticia-${id}`);
        if (!wrapper) return;
        const viewDiv = wrapper.querySelector('.noticia-view');
        const form = document.getElementById(`form-noticia-${id}`);
        if (viewDiv && form) {
            form.classList.add('d-none');
            viewDiv.classList.remove('d-none');
        }
    }

    window.editarNoticia = editarNoticia;
    window.cancelarEdicaoNoticia = cancelarEdicaoNoticia;
    // FIM--Funções para gerenciar as notícias--FIM

    // Torne-as globais se necessário, e garanta que rodem após carregar o script:
    window.editarNoticia = editarNoticia;
    window.cancelarEdicaoNoticia = cancelarEdicaoNoticia;

    // Funções para gerenciar o volume e o slider do volume
    const volSlider = document.getElementById('volume-slider');
    const volDisplay = document.getElementById('volume-display');
    const muteBtn = document.getElementById('mute-btn');

    // Aplica estado na primeira carga
    document.documentElement.style.setProperty('--vol-percent', window.prevVolume + '%');
    applyVolumeState();

    // Slider de volume
    if (volSlider) {
        volSlider.addEventListener('input', () => {
            const pct = volSlider.value;
            window.prevVolume = pct;
            document.documentElement.style.setProperty('--vol-percent', pct + '%');
            if (window.isMuted) window.isMuted = false;
            applyVolumeState();
        });
    }

    // Botão de Mudo
    if (muteBtn) {
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
    }

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
    if (!select) return;

    const romSalva = lerCookie('ultimaROM');
    const romInicial = romSalva || select.value;

    select.value = romInicial;
    carregarRom(romInicial);

    select.addEventListener('change', function () {
        const rom = this.value;
        carregarRom(rom);
        salvarROMEmCookie(rom);
    });
});

const wrapper = document.getElementById('canvas-wrapper');
const fsBtn = document.getElementById('btn-fullscreen');
if (fsBtn && wrapper) {
    fsBtn.addEventListener('click', () => {
        if (wrapper.requestFullscreen) wrapper.requestFullscreen();
        else if (wrapper.webkitRequestFullscreen) wrapper.webkitRequestFullscreen();
        else if (wrapper.msRequestFullscreen) wrapper.msRequestFullscreen();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const wrapper = document.getElementById('canvas-wrapper');
    if (wrapper && wrapper.dataset.romPath) {
        nes_load_url('nes-canvas', wrapper.dataset.romPath);
    }
});

const teclasBloqueadas = [
    'ArrowUp', 'ArrowDown', 'a', 'q', 's', 'o', 'A', 'Q', 'S', 'O'
];

const canvas = document.getElementById('nes-canvas');
if (canvas) {
    document.addEventListener('keydown', function (e) {
        if (teclasBloqueadas.includes(e.key)) {
            e.preventDefault();
        }
    });
}
// FIM--Funções para gerenciar o emulador e o canvas--FIM

// Função para tratar o FadeInOut das mensagens de sucesso
document.addEventListener('DOMContentLoaded', () => {
    const msg = document.getElementById('successMessage');
    if (!msg) return;
    const wrapper = msg.closest('.border-animated-glass, .border-top-animated-glass, .border-bottom-animated-glass');
    const wrapperHadNoNeon = wrapper?.classList.contains('no-neon');

    if (wrapper) {
        if (!wrapperHadNoNeon) {
            wrapper.classList.remove('no-neon');
        }
        wrapper.classList.remove('fade-message');
        void wrapper.offsetWidth;
        wrapper.classList.add('fade-message');
    } else {
        msg.classList.remove('fade-message');
        void msg.offsetWidth;
        msg.classList.add('fade-message');
    }

    setTimeout(() => {
        if (wrapper) {
            if (!wrapperHadNoNeon) {
                wrapper.classList.add('no-neon');
            }
            wrapper.remove();
        } else {
            msg.remove();
        }
    }, 4000);
});
// FIM--Função para tratar o FadeInOut das mensagens de sucesso--FIM

// Função para fazer o scroll marquee da descrição dos jogos
function iniciarMarquee() {
    document.querySelectorAll('.scroll-marquee').forEach(container => {
        const span = container.querySelector('.marquee-text');
        if (!span) return;

        // reset das variáveis CSS
        span.style.animation = 'none';
        container.style.setProperty('--marquee-start', '0px');
        container.style.setProperty('--marquee-end', '0px');

        requestAnimationFrame(() => {
            const Wc = container.clientWidth;
            const Wt = span.scrollWidth;
            const dur = container.dataset.marqueeDuration || '15s';

            // dispara animação inclusive quando cabe exatamente
            if (Wt >= Wc) {
                container.style.setProperty('--marquee-start', `${Wc}px`);
                container.style.setProperty('--marquee-end', `-${Wt}px`);
                container.style.setProperty('--marquee-duration', dur);

                span.style.animation =
                    `marquee var(--marquee-duration) linear infinite, gradientFlow 3s linear infinite`;
            }
            // caso não queira nem o gradientFlow quando não rolar, pode zerar:
            // else span.style.animation = 'none';
        });
    });
}

window.addEventListener('DOMContentLoaded', iniciarMarquee);
window.addEventListener('resize', iniciarMarquee);
// FIM--Função para fazer o scroll marquee da descrição dos jogos--FIM

// Função para calcular os caracteres em textareas
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.descricao-textarea').forEach(textarea => {
        const maxLength = textarea.getAttribute('maxlength');
        const id = textarea.dataset.id;
        const contador = document.getElementById('contador-' + id);

        function atualizarContador() {
            if (!contador) return;
            const restante = maxLength - textarea.value.length;
            contador.textContent = restante;
        }

        textarea.addEventListener('input', atualizarContador);
        atualizarContador();
    });
});
// FIM--Função para calcular os caracteres em textareas--FIM


// Funções para avançar e retornar as notícias
document.addEventListener('DOMContentLoaded', () => {
    const items = Array.from(document.querySelectorAll('#news-container .news-item'));
    if (items.length === 0) return;  // nada a fazer se não houver notícias

    const prevBtn = document.getElementById('prev-news');
    const nextBtn = document.getElementById('next-news');
    const counter = document.getElementById('news-counter');
    let current = 0;

    function show(idx) {
        items.forEach((el, i) => {
            el.style.display = (i === idx ? 'block' : 'none');
        });
        if (counter) {
            counter.textContent = `${idx + 1}/${items.length}`;
        }
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            current = (current - 1 + items.length) % items.length;
            show(current);
        });
    }
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            current = (current + 1) % items.length;
            show(current);
        });
    }

    show(0);
});
// FIM--Funções para avançar e retornar as notícias--FIM