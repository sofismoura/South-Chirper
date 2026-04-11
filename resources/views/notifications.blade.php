<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notificações - South Chirper</title>
    <link rel="icon" type="image/png" href="{{ asset('images/southparkicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .snowflake {
            position: fixed;
            top: -10px;
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
            opacity: 0.8;
            filter: blur(1px);
            animation: fall linear infinite;
        }

        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }
    </style>
</head>

<body>

<!-- 🎵 MÚSICA -->
<audio id="music" preload="auto">
    <source src="https://www.myinstants.com/media/sounds/south-park-theme-song.mp3" type="audio/mpeg">
</audio>

<!-- 🔝 NAVBAR -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur border-b-4 border-black shadow">
    <div class="flex justify-between items-center px-6 py-4">

    @php
// 🔥 MARCA COMO LIDO AO ENTRAR NA PÁGINA DE NOTIFICAÇÕES
if (request()->is('notifications')) {
    \App\Models\Notification::where('user_id', auth()->id())
        ->where('read', false)
        ->update(['read' => true]);
}

// 🔔 AGORA CONTA NORMAL
$countNotifications = \App\Models\Notification::where('user_id', auth()->id())
    ->where('read', false)
    ->count();
@endphp
        <a href="/" class="flex items-center gap-2 text-xl font-black hover:scale-105 transition">
            <img src="/images/southparklogo.png" class="h-8 w-auto object-contain">
            South Chirper
        </a>

        <div class="flex gap-3 items-center">

         <button id="assitir"
                class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                 Assistir
            </button>

            <button id="playBtn"
                 class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                 Música
            </button>

            <a href="/login"
               class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
               Login
            </a>

            <a href="/signup"
               class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
               Cadastro
            </a>
            
    @auth

<div class="flex items-center gap-3 ml-2 pl-3 border-l-2 border-black/20">

    <!-- 🔔 NOTIFICAÇÕES -->
    <a href="/notifications" class="relative">

        <svg xmlns="http://www.w3.org/2000/svg" 
            class="w-6 h-6 text-black hover:scale-110 transition"
            fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 
            14.158V11a6.002 6.002 0 00-4-5.659V5a2 
            2 0 10-4 0v.341C7.67 6.165 6 8.388 
            6 11v3.159c0 .538-.214 1.055-.595 
            1.436L4 17h5m6 0v1a3 3 0 11-6 
            0v-1m6 0H9"/>
        </svg>

        @if($countNotifications > 0)
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 rounded-full font-bold animate-pulse">
                {{ $countNotifications }}
            </span>
        @endif

    </a>

    <!-- 👤 USER -->
    <img 
        src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . auth()->user()->id }}"
        class="w-10 h-10 border-2 border-black rounded-full bg-white object-cover shadow-[2px_2px_0px_black]"
    >

    <div class="flex flex-col">
        <span class="text-[10px] font-black uppercase leading-none text-black/50">Logado como:</span>
        <span class="text-sm font-black uppercase leading-none">{{ auth()->user()->name }}</span>
    </div>

    <!-- 🚪 LOGOUT -->
    <form method="POST" action="/logout" class="ml-1">
        @csrf
        <button type="submit" class="text-[10px] font-bold bg-red-500 text-white border border-black px-2 py-0.5 rounded-md hover:bg-red-600 transition">
            SAIR
        </button>
    </form>

</div>

@endauth

        </div>
    </div>
</nav>

<div id="age-popup" class="fixed inset-0 bg-black/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white border-4 border-black rounded-3xl shadow-[8px_8px_0px_black] p-8 max-w-md w-full text-center relative overflow-hidden">
        
        <img src="/images/southparklogo.png" class="absolute -top-10 -right-10 h-32 opacity-10 rotate-12 pointer-events-none">

        <h3 class="text-3xl font-black mb-6 text-black drop-shadow-[1px_1px_0px_white]">
            PERGUNTA SÉRIA!
        </h3>

        <div id="popup-content">
            <p class="text-xl font-bold mb-8">Você tem idade para assistir isso, cara?</p>
            
            <div class="flex gap-4 justify-center">
                <button id="age-yes" class="bg-green-500 text-white border-2 border-black px-6 py-2 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">
                    Sim, sou adulto!
                </button>
                <button id="age-no" class="bg-red-500 text-white border-2 border-black px-6 py-2 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">
                    Não... sou criancinha
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    
    // --- LÓGICA POPUP DE IDADE ---
    const assistirBtn = document.getElementById('assitir');
    const agePopup = document.getElementById('age-popup');
    const popupContent = document.getElementById('popup-content');
    const targetUrl = 'https://www.southparkstudios.com.br/';

    const somIdade = new Audio("{{ asset('audio/idade.mp3') }}");
    const somBurro = new Audio("{{ asset('audio/burro.mp3') }}");
    const somExcluir = new Audio("{{ asset('audio/excluir.mp3') }}");

    function openDeleteModal(actionUrl) {
    const modal = document.getElementById('delete-popup');
    const form = document.getElementById('confirm-delete-form');

    form.action = actionUrl;

    // 🔊 toca o som ao abrir (SÓ aqui)
    somExcluir.currentTime = 0;
    somExcluir.play();

    modal.classList.remove('hidden');
}

    assistirBtn.addEventListener('click', (e) => {
        e.preventDefault();
        agePopup.classList.remove('hidden');
        somIdade.currentTime = 0;
        somIdade.play();
    });

    document.getElementById('age-yes').addEventListener('click', () => {
        window.location.href = targetUrl;
    });

    document.getElementById('age-no').addEventListener('click', () => {
        somBurro.currentTime = 0;
        somBurro.play();

        popupContent.innerHTML = `
            <p class="text-2xl font-black mb-3 text-red-600">SÉRIO?! VOCÊ É BURRO?</p>
            <p class="text-lg font-bold mb-8">É só mentir idiota, eu tô pouco me fudendo! Vai lá assistir seu babaca!</p>
            <div class="flex justify-center">
                <button id="age-redirect-anyway" class="bg-yellow-300 text-black border-2 border-black px-6 py-2 rounded-full font-bold">
                    Tá bom😭
                </button>
            </div>
        `;

        document.getElementById('age-redirect-anyway').onclick = () => {
            window.location.href = targetUrl;
        };
    });

    agePopup.addEventListener('click', (e) => {
        if (e.target === agePopup) agePopup.classList.add('hidden');
    });

    function openDeleteModal(actionUrl) {
    const modal = document.getElementById('delete-popup');
    const form = document.getElementById('confirm-delete-form');

    form.action = actionUrl;

    // 🔊 toca o som ao abrir
    somExcluir.currentTime = 0;
    somExcluir.play();

    modal.classList.remove('hidden');
}

// Fechar modal ao cancelar (SEM SOM)
document.getElementById('cancel-delete').addEventListener('click', () => {
    document.getElementById('delete-popup').classList.add('hidden');
});

// Fechar clicando fora
document.getElementById('delete-popup').addEventListener('click', (e) => {
    if (e.target === document.getElementById('delete-popup')) {
        document.getElementById('delete-popup').classList.add('hidden');
    }
});

</script>

<!-- ❄️ NEVE -->
<div id="snow-container" class="fixed inset-0 pointer-events-none z-0"></div>

<!-- 🌄 FUNDO -->
<div class="min-h-screen bg-cover bg-center flex items-start justify-center pt-28"
     style="background-image: url('/images/southpark.png');">

    <div class="absolute inset-0 bg-black/40 z-0"></div>

    <!-- 📦 CARD NOTIFICAÇÕES -->
    <div class="relative z-10 w-full max-w-xl">

        <h2 class="text-3xl font-black text-white mb-4 drop-shadow-[2px_2px_6px_black]">
            🔔 Notificações
        </h2>

        <div class="bg-white/90 backdrop-blur border-4 border-black rounded-3xl shadow-[6px_6px_0px_black] p-5">

   @forelse($notifications as $n)
    <a href="/notifications/{{ $n->id }}"
       class="block flex items-center gap-3 pb-3 mb-3 rounded-xl p-2 transition
       {{ $n->read ? 'opacity-60' : 'bg-red-50 border border-red-400' }}">

        <!-- Avatar -->
        <img src="{{ $n->fromUser->photo ? asset('storage/' . $n->fromUser->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . $n->fromUser->id }}"
             class="w-10 h-10 border-2 border-black rounded-full bg-white object-cover">

        <!-- Texto -->
        <div class="flex-1 text-sm">

            <span class="font-bold">
                {{ $n->fromUser->name }}
            </span>

            @if($n->type == 'like')
                curtiu seu post ❤️
            @else
                comentou no seu post 💬
            @endif

            <div class="text-xs text-gray-500">
                {{ $n->created_at->diffForHumans() }}
            </div>

        </div>

    </a>
@empty
                <p class="text-center font-bold text-gray-500">
                    Nenhuma notificação ainda 😴
                </p>
            @endforelse

        </div>

    </div>
</a>

<!-- ❄️ SCRIPT NEVE -->
<script>
function createSnowflake() {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');
    const size = Math.random() * 6 + 4;
    snowflake.style.left = Math.random() * window.innerWidth + 'px';
    snowflake.style.width = size + 'px';
    snowflake.style.height = size + 'px';
    snowflake.style.animationDuration = (Math.random() * 5 + 5) + 's';
    snowflake.style.opacity = Math.random();
    document.body.appendChild(snowflake);
    setTimeout(() => snowflake.remove(), 10000);
}
setInterval(createSnowflake, 100);
</script>

<script>
    
// Lógica dos aúdios sem repetir

const musicPlayer = document.getElementById("music");
const btn = document.getElementById("playBtn");

//  Lista original com as músicas ou efeitos sonoros
const sonsOriginais = [
    "{{ asset('audio/som1.mp3') }}",
    "{{ asset('audio/som2.mp3') }}",
    "{{ asset('audio/som3.mp3') }}",
    "{{ asset('audio/som4.mp3') }}",
    "{{ asset('audio/som5.mp3') }}",
    "{{ asset('audio/som6.mp3') }}",
    "{{ asset('audio/som7.mp3') }}",
    "{{ asset('audio/som8.mp3') }}",
    "{{ asset('audio/som9.mp3') }}",
    "{{ asset('audio/som10.mp3') }}",
    "{{ asset('audio/som11.mp3') }}"
];

// Fila de reprodução
let filaDeSons = [];

// Função para embaralhar a lista (Algoritmo Fisher-Yates)
function embaralhar(array) {
    let lista = [...array];
    for (let i = lista.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [lista[i], lista[j]] = [lista[j], lista[i]];
    }
    return lista;
}

// Função para tocar a próxima música
function tocarProxima() {
    if (filaDeSons.length === 0) {
        filaDeSons = embaralhar(sonsOriginais);
    }
    const proximoSom = filaDeSons.pop();
    musicPlayer.src = proximoSom;
    musicPlayer.play();
    btn.innerText = "⏸️ Pausar (" + (sonsOriginais.length - filaDeSons.length) + "/11)";
    btn.classList.add('bg-green-400');
}

// 1. Clique Simples: Play/Pause
btn.addEventListener("click", () => {
    if (musicPlayer.src === "") {
        tocarProxima();
    } else {
        if (!musicPlayer.paused) {
            musicPlayer.pause();
            btn.innerText = "▶️ Continuar";
            btn.classList.replace('bg-green-400', 'bg-yellow-300');
        } else {
            musicPlayer.play();
            btn.innerText = "⏸️ Pausar";
            btn.classList.replace('bg-yellow-300', 'bg-green-400');
        }
    }
});

// 2. Clique Duplo: Pular Música
btn.addEventListener("dblclick", () => {
    tocarProxima();
});

// Resetar quando acabar
musicPlayer.onended = () => {
    btn.innerText = "Música";
    btn.classList.remove('bg-green-400');
};

</script>

</body>
</html>