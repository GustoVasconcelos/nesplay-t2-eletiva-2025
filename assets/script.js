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
window.nesGainNode = window.nesGainNode || null;
window.prevVolume = localStorage.getItem('volume') || 50;
window.isMuted = localStorage.getItem('muted') === 'true' || false;

// Função para aplicar o estado do volume
window.applyVolumeState = function () {
    // Verificação extra para contexto não inicializado
    if (!window.nesGainNode || (window.audioCtx && window.audioCtx.state === 'closed')) {
        console.warn('Áudio não disponível para ajuste de volume');
        return;
    }

    try {
        const volSlider = document.getElementById('volume-slider');
        const volDisplay = document.getElementById('volume-display');
        const muteBtn = document.getElementById('mute-btn');

        if (!volSlider || !volDisplay || !muteBtn) {
            console.warn('Elementos de volume não encontrados');
            return;
        }

        if (window.isMuted) {
            if (window.nesGainNode) window.nesGainNode.gain.value = 0;
            volSlider.value = 0;
            volDisplay.textContent = '0%';
            muteBtn.textContent = 'Volume: Desilenciar';
            muteBtn.classList.add('muted');
        } else {
            const volume = window.prevVolume;
            if (window.nesGainNode) window.nesGainNode.gain.value = volume / 100;
            volSlider.value = volume;
            volDisplay.textContent = volume + '%';
            muteBtn.textContent = 'Volume: Silenciar';
            muteBtn.classList.remove('muted');
        }

        // Salva estado no localStorage
        localStorage.setItem('volume', window.prevVolume);
        localStorage.setItem('muted', window.isMuted);
    } catch (e) {
        console.error('Erro em applyVolumeState:', e);
    }
};

// Função para atualizar o volume quando o slider é movido
function handleVolumeChange(event) {
    const newVolume = parseInt(event.target.value);
    window.prevVolume = newVolume;

    // Se estava mudo e aumentou o volume, tira do mudo
    if (window.isMuted && newVolume > 0) {
        window.isMuted = false;
    }

    window.applyVolumeState();
}

// Função para alternar mudo
function toggleMute() {
    window.isMuted = !window.isMuted;

    // Se está saindo do mudo, restaura o volume anterior
    if (!window.isMuted && window.prevVolume === 0) {
        window.prevVolume = 50;
    }

    window.applyVolumeState();
}

// Inicialização do sistema de volume
function initVolumeControls() {
    const volSlider = document.getElementById('volume-slider');
    const muteBtn = document.getElementById('mute-btn');

    if (volSlider && muteBtn) {
        // Configura eventos
        volSlider.addEventListener('input', handleVolumeChange);
        muteBtn.addEventListener('click', toggleMute);

        // Aplica estado inicial
        window.applyVolumeState();
    } else {
        console.log('Controles de volume não encontrados!');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Inicializa controles de volume
    initVolumeControls();

    // Atualiza controles se o estado estiver disponível
    setTimeout(() => {
        if (window.applyVolumeState) window.applyVolumeState();
    }, 500);

    // Verifica periodicamente se o áudio foi inicializado
    const volumeCheckInterval = setInterval(() => {
        if (window.nesGainNode && window.applyVolumeState) {
            window.applyVolumeState();
            clearInterval(volumeCheckInterval);
        }
    }, 1000);
});
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

    window.audioState = {
        gainNode: null,
        prevVolume: localStorage.getItem('volume') || 50,
        isMuted: localStorage.getItem('muted') === 'true' || false
    };

    // Função para aplicar o estado do volume
    window.applyVolumeState = function () {
        try {
            const volSlider = document.getElementById('volume-slider');
            const volDisplay = document.getElementById('volume-display');
            const muteBtn = document.getElementById('mute-btn');

            if (!volSlider || !volDisplay || !muteBtn) {
                console.warn('Elementos de volume não encontrados');
                return;
            }

            // Usa window.nesGainNode se disponível
            const gainNode = window.nesGainNode || window.audioState.gainNode;

            if (window.audioState.isMuted) {
                if (gainNode) gainNode.gain.value = 0;
                volSlider.value = 0;
                volDisplay.textContent = '0%';
                muteBtn.textContent = 'Volume: Desilenciar';
                muteBtn.classList.add('muted');
            } else {
                const volume = window.audioState.prevVolume;
                if (gainNode) gainNode.gain.value = volume / 100;
                volSlider.value = volume;
                volDisplay.textContent = volume + '%';
                muteBtn.textContent = 'Volume: Silenciar';
                muteBtn.classList.remove('muted');
            }

            // Salva estado no localStorage
            localStorage.setItem('volume', window.audioState.prevVolume);
            localStorage.setItem('muted', window.audioState.isMuted);
        } catch (e) {
            console.error('Erro em applyVolumeState:', e);
        }
    };

    // Configura eventos de volume
    function setupVolumeControls() {
        const volSlider = document.getElementById('volume-slider');
        const muteBtn = document.getElementById('mute-btn');

        if (!volSlider || !muteBtn) return;

        volSlider.addEventListener('input', function (e) {
            window.audioState.prevVolume = parseInt(e.target.value);

            // Se estava mudo e aumentou o volume, tira do mudo
            if (window.audioState.isMuted && window.audioState.prevVolume > 0) {
                window.audioState.isMuted = false;
            }

            window.applyVolumeState();
        });

        muteBtn.addEventListener('click', function () {
            window.audioState.isMuted = !window.audioState.isMuted;

            // Se está saindo do mudo, restaura o volume anterior
            if (!window.audioState.isMuted && window.audioState.prevVolume === 0) {
                window.audioState.prevVolume = 50;
            }

            window.applyVolumeState();
        });
    }

    // Inicialização quando o DOM estiver pronto
    document.addEventListener('DOMContentLoaded', function () {
        setupVolumeControls();

        // Aplica estado inicial
        window.applyVolumeState();

        // Verificação periódica se o áudio foi inicializado
        const volumeCheckInterval = setInterval(() => {
            if (window.nesGainNode) {
                // Atualiza o estado do gainNode
                window.audioState.gainNode = window.nesGainNode;
                window.applyVolumeState();
                clearInterval(volumeCheckInterval);
            }
        }, 1000);
    });
};
// FIM--Funções para gerenciar o volume e o slider do volume--FIM

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

function resizeGamepad() {
    const gamepad = document.querySelector('.nes-gamepad');
    if (!gamepad) return; // Sai se o elemento não existir
    const viewportWidth = window.innerWidth;

    // Define a largura baseada na viewport com limites
    const maxWidth = 500; // Largura máxima do gamepad
    const minWidth = 300; // Largura mínima do gamepad
    let gamepadWidth = Math.min(viewportWidth * 0.9, maxWidth);
    gamepadWidth = Math.max(gamepadWidth, minWidth);

    gamepad.style.width = gamepadWidth + 'px';

    // Mantém a proporção altura/largura
    const aspectRatio = 180 / 330; // Proporção original
    gamepad.style.height = (gamepadWidth * aspectRatio) + 'px';
}

function adjustCanvasAndGamepad() {
    const wrapper = document.getElementById('canvas-wrapper');
    const canvas = document.getElementById('nes-canvas');
    const gamepad = document.querySelector('.gamepad-section');
    if (!wrapper || !canvas || !gamepad) return;

    const isFull = wrapper.classList.contains('isFull');

    if (isFull) {
        const vw = window.innerWidth;
        const vh = window.innerHeight;
        const aspect = 256 / 240;
        const gpH = Math.min(180, vh * 0.25);

        // calcula o canvas sem distorcer
        let cH = vh - gpH;
        let cW = cH * aspect;
        if (cW > vw) {
            cW = vw;
            cH = cW / aspect;
        }

        // aplica ao canvas
        canvas.style.width = `${cW}px`;
        canvas.style.height = `${cH}px`;

        // aplica ao gamepad: largura da viewport e altura remanescente
        gamepad.style.width = `${vw}px`;
        gamepad.style.height = `${vh - cH}px`;
    } else {
        // limpa estilos inline
        [canvas, gamepad].forEach(el => {
            el.style.width = '';
            el.style.height = '';
        });
    }
}

window.addEventListener('load', () => {
    // Só registra os eventos se os elementos existirem
    if (document.querySelector('.nes-gamepad')) {
        window.addEventListener('resize', resizeGamepad);
        resizeGamepad(); // Executa inicialmente
    }

    if (document.getElementById('canvas-wrapper')) {
        window.addEventListener('resize', adjustCanvasAndGamepad);
        adjustCanvasAndGamepad(); // Executa inicialmente
    }
});

window.addEventListener('load', adjustCanvasAndGamepad);
window.addEventListener('resize', adjustCanvasAndGamepad);

// ========================
// SISTEMA DE CONTROLE TÁTIL
// ========================

// Variáveis globais para controle de estado
const activeTouches = new Map();
let activeTouchId = null;
let activeDirection = null;
let activeButtons = {};
let lastActiveElement = null; // armazena o último elemento ativo
function isMobileDevice() {
    const userAgent = navigator.userAgent.toLowerCase();
    const isMobileUA = /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(userAgent);
    const isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    const isSmallScreen = window.innerWidth <= 768;
    const isCoarsePointer = matchMedia('(pointer: coarse)').matches;
    const hasHover = matchMedia('(hover: hover)').matches;

    return isTouch && isCoarsePointer && (isSmallScreen || isMobileUA) && !hasHover;
}

function toggleGamepadVisibility() {
    const gamepadSection = document.querySelector('.gamepad-section');
    if (!gamepadSection) return;

    gamepadSection.style.display = isMobileDevice() ? 'flex' : 'none';
}

// ========================
// CONTROLES PARA MOBILE
// ========================

let touchControlsInitialized = false;


// Inicialização dos controles
function initTouchControls() {
    const dpad = document.querySelector('.d-pad');
    const actionButtons = document.querySelector('.action-buttons');
    const menuButtons = document.querySelector('.menu-buttons');
    if (touchControlsInitialized) return;
    touchControlsInitialized = true;

    if (!dpad || !actionButtons || !menuButtons) return;

    // Configura eventos para todos os elementos de controle
    const controlElements = [dpad, actionButtons, menuButtons];
    controlElements.forEach(el => {
        el.addEventListener('pointerdown', handleTouchStart);
        el.addEventListener('pointermove', handleTouchMove);
        el.addEventListener('pointerup', handleTouchEnd);
        el.addEventListener('pointerleave', handleTouchEnd);
        el.addEventListener('pointercancel', handleTouchEnd);
    });

    // Adiciona classe para feedback tátil
    document.head.appendChild(createTouchFeedbackStyle());
}

// Estilos para feedback visual
function createTouchFeedbackStyle() {
    const style = document.createElement('style');
    style.textContent = `
        .d-btn.touch-active,
        .action-btn.touch-active,
        .menu-btn.touch-active {
            transform: scale(0.85) !important;
            filter: brightness(1.4) !important;
            box-shadow: 0 1px 3px rgba(255, 255, 255, 0.5) !important;
        }
        
        .d-pad,
        .action-buttons,
        .menu-buttons {
            touch-action: none;
            -webkit-user-select: none;
            user-select: none;
        }
    `;
    return style;
}

// Mapeamento de controles para teclas
const controlMappings = {
    // Direções cardinais
    'up': 38,
    'down': 40,
    'left': 37,
    'right': 39,

    // Diagonais
    'up-left': [38, 37],
    'up-right': [38, 39],
    'down-left': [40, 37],
    'down-right': [40, 39],

    // Botões de ação
    'btn-a': 65,
    'btn-b': 83,
    'btn-select': 9,
    'btn-start': 13
};

// Função para encontrar o controle sob o ponteiro
function findControlUnderPoint(x, y) {
    const elements = document.querySelectorAll('.d-btn, .action-btn, .menu-btn');

    for (const element of elements) {
        const rect = element.getBoundingClientRect();
        if (x >= rect.left && x <= rect.right && y >= rect.top && y <= rect.bottom) {
            return element;
        }
    }

    return null;
}

// Início do toque
function handleTouchStart(event) {
    const pointerId = event.pointerId;
    const control = findControlUnderPoint(event.clientX, event.clientY);

    if (!control) return;

    // Configura o novo toque
    const touchInfo = {
        element: control,
        controlKey: null,
        isDirection: false
    };

    activeTouches.set(pointerId, touchInfo);
    processTouchForPointer(pointerId, event.clientX, event.clientY);
}

// Movimento do toque
function handleTouchMove(event) {
    const pointerId = event.pointerId;

    if (!activeTouches.has(pointerId)) return;

    processTouchForPointer(pointerId, event.clientX, event.clientY);
}

// Fim do toque
function handleTouchEnd(event) {
    const pointerId = event.pointerId;

    if (!activeTouches.has(pointerId)) return;

    const touchInfo = activeTouches.get(pointerId);

    // Remove feedback visual
    if (touchInfo.element) {
        touchInfo.element.classList.remove('touch-active');
    }

    // Desativa o controle
    if (touchInfo.controlKey) {
        if (touchInfo.isDirection) {
            deactivateDirection(touchInfo.controlKey);
        } else {
            deactivateControl(touchInfo.controlKey);
        }
    }

    // Remove o toque do mapa
    activeTouches.delete(pointerId);
}

// Processa o toque para um ponteiro específico
function processTouchForPointer(pointerId, x, y) {
    const touchInfo = activeTouches.get(pointerId);
    if (!touchInfo) return;

    const control = findControlUnderPoint(x, y);
    let controlKey = null;
    let isDirection = false;

    // Atualiza o elemento se mudou para um novo controle
    if (control && control !== touchInfo.element) {
        // Remove feedback do elemento anterior
        if (touchInfo.element) {
            touchInfo.element.classList.remove('touch-active');
        }

        // Atualiza para o novo elemento
        touchInfo.element = control;
        control.classList.add('touch-active');
    }

    if (!control) {
        // Se não está sobre nenhum controle, desativa a ação anterior
        if (touchInfo.controlKey) {
            if (touchInfo.isDirection) {
                deactivateDirection(touchInfo.controlKey);
            } else {
                deactivateControl(touchInfo.controlKey);
            }
            touchInfo.controlKey = null;
        }
        return;
    }

    const controlClasses = Array.from(control.classList);

    // Identifica o tipo de controle
    if (controlClasses.includes('d-btn')) {
        controlKey = controlClasses.find(cls =>
            ['up', 'down', 'left', 'right', 'up-left', 'up-right', 'down-left', 'down-right'].includes(cls)
        );

        if (controlKey) {
            isDirection = controlKey.includes('-');
        }
    } else {
        controlKey = controlClasses.find(cls =>
            ['btn-a', 'btn-b', 'btn-select', 'btn-start'].includes(cls)
        );
    }

    if (!controlKey) return;

    // Se o controle mudou, atualiza
    if (touchInfo.controlKey !== controlKey) {
        // Desativa o controle anterior
        if (touchInfo.controlKey) {
            if (touchInfo.isDirection) {
                deactivateDirection(touchInfo.controlKey);
            } else {
                deactivateControl(touchInfo.controlKey);
            }
        }

        // Ativa o novo controle
        if (isDirection) {
            activateDirection(controlKey);
        } else {
            activateControl(controlKey);
        }

        // Atualiza as informações do toque
        touchInfo.controlKey = controlKey;
        touchInfo.isDirection = isDirection;
    }
}

// Remove todas as classes de feedback visual
function removeAllTouchActiveClasses() {
    document.querySelectorAll('.touch-active').forEach(element => {
        element.classList.remove('touch-active');
    });
}

// Processa o evento de toque
function processTouchEvent(event) {
    const control = findControlUnderPoint(event.clientX, event.clientY);

    // Remove o feedback visual do elemento anterior
    if (lastActiveElement && lastActiveElement !== control) {
        lastActiveElement.classList.remove('touch-active');
    }

    // Atualiza o último elemento ativo
    lastActiveElement = control;

    if (!control) {
        // Se não há controle sob o ponteiro, desativa tudo
        for (const buttonClass in activeButtons) {
            deactivateControl(buttonClass);
            delete activeButtons[buttonClass];
        }

        if (activeDirection) {
            deactivateDirection(activeDirection);
            activeDirection = null;
        }

        return;
    }

    // Adiciona feedback visual imediatamente
    control.classList.add('touch-active');

    const controlClasses = Array.from(control.classList);
    let controlKey = null;

    // Identifica o tipo de controle
    if (controlClasses.includes('d-btn')) {
        // Direções cardinais ou diagonais
        controlKey = controlClasses.find(cls =>
            ['up', 'down', 'left', 'right', 'up-left', 'up-right', 'down-left', 'down-right'].includes(cls)
        );

        // Se for uma direção diagonal, trata como especial
        if (controlKey && controlKey.includes('-')) {
            if (activeDirection !== controlKey) {
                // Desativa a direção anterior
                if (activeDirection) {
                    deactivateDirection(activeDirection);
                }

                // Ativa a nova direção
                activateDirection(controlKey);
                activeDirection = controlKey;
            }
            return;
        }
    } else {
        // Botões de ação
        controlKey = controlClasses.find(cls =>
            ['btn-a', 'btn-b', 'btn-select', 'btn-start'].includes(cls)
        );
    }

    if (!controlKey) return;

    // Ativa o controle se ainda não está ativo
    if (!activeButtons[controlKey]) {
        activeButtons[controlKey] = true;
        activateControl(controlKey);
    }
}

// Ativa uma direção diagonal
function activateDirection(direction) {
    const keys = controlMappings[direction];
    if (!keys) return;

    keys.forEach(keyCode => {
        simulateKeyEvent(keyCode, 'keydown');
    });
}

// Desativa uma direção diagonal
function deactivateDirection(direction) {
    const keys = controlMappings[direction];
    if (!keys) return;

    keys.forEach(keyCode => {
        simulateKeyEvent(keyCode, 'keyup');
    });
}

// Ativa um controle individual
function activateControl(controlKey) {
    const keyCode = controlMappings[controlKey];
    if (Array.isArray(keyCode)) {
        keyCode.forEach(kc => simulateKeyEvent(kc, 'keydown'));
    } else {
        simulateKeyEvent(keyCode, 'keydown');
    }
}

// Desativa um controle individual
function deactivateControl(controlKey) {
    const keyCode = controlMappings[controlKey];
    if (Array.isArray(keyCode)) {
        keyCode.forEach(kc => simulateKeyEvent(kc, 'keyup'));
    } else {
        simulateKeyEvent(keyCode, 'keyup');
    }
}

// Função para simular eventos de teclado
function simulateKeyEvent(keyCode, type) {
    const event = new KeyboardEvent(type, {
        keyCode: keyCode,
        bubbles: true,
        cancelable: true
    });
    document.dispatchEvent(event);
}

// ========================
// INICIALIZAÇÃO
// ========================

document.addEventListener('DOMContentLoaded', () => {
    // Inicializa os controles quando o DOM estiver pronto
    initTouchControls();

    // Inicializa o emulador
    const wrapper = document.getElementById('canvas-wrapper');
    if (wrapper && wrapper.dataset.romPath) {
        nes_load_url('nes-canvas', wrapper.dataset.romPath);
    }
});

document.addEventListener('DOMContentLoaded', () => {
    // Mostra/oculta o gamepad
    toggleGamepadVisibility();

    // Inicializa controles apenas em dispositivos móveis
    if (isMobileDevice()) {
        initTouchControls();
    }

    // Inicializa o emulador
    const wrapper = document.getElementById('canvas-wrapper');
    if (wrapper && wrapper.dataset.romPath) {
        nes_load_url('nes-canvas', wrapper.dataset.romPath);
    }
});

// Atualiza ao redimensionar
window.addEventListener('resize', () => {
    toggleGamepadVisibility();

    // Reinicializa controles se mudou para mobile
    if (isMobileDevice() && !touchControlsInitialized) {
        initTouchControls();
    }
});

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