<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - South Chirper</title>
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

            @auth
    <div class="flex items-center gap-2 ml-4">
        <span class="font-black text-black uppercase text-sm">{{ auth()->user()->name }}</span>
        
        <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . auth()->user()->id }}" 
             class="w-8 h-8 border-2 border-black rounded-full bg-white object-cover">

        <form method="POST" action="/logout" class="inline">
            @csrf
            <button type="submit" class="bg-red-500 text-white border-2 border-black px-3 py-1 rounded-full font-bold text-xs hover:bg-red-600 transition">
                SAIR
            </button>
        </form>
    </div>
@else
    <a href="/login"
       class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
       Login
    </a>

    <a href="/signup"
       class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
       Cadastro
    </a>
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
    const assistirBtn = document.getElementById('assitir');
    const agePopup = document.getElementById('age-popup');
    const popupContent = document.getElementById('popup-content');
    const targetUrl = 'https://www.southparkstudios.com.br/';

    // --- FUNÇÃO PARA MOSTRAR O POPUP ---
    assistirBtn.addEventListener('click', (e) => {
        e.preventDefault(); // Impede qualquer comportamento padrão (caso fosse um link)
        agePopup.classList.remove('hidden'); // Mostra o popup tirando a classe 'hidden'

         const vozCartman = new Audio("{{ asset('audio/idade.mp3') }}");
    vozCartman.play();
    });

    // --- FUNÇÃO SE CLICAR EM "SIM" ---
    document.getElementById('age-yes').addEventListener('click', () => {
        window.location.href = targetUrl; // Redireciona direto
    });

    // --- FUNÇÃO SE CLICAR EM "NÃO" ---
    document.getElementById('age-no').addEventListener('click', () => {

    // Tocar a voz do Cartman
    const vozCartman = new Audio("{{ asset('audio/burro.mp3') }}");
    vozCartman.play();

        // Muda o conteúdo do popup com a frase zoada
        popupContent.innerHTML = `
            <p class="text-2xl font-black mb-3 text-red-600">SÉRIO?! VOCÊ É BURRO?</p>
            <p class="text-lg font-bold mb-8">É só mentir idiota, eu tô pouco me fudendo! Vai lá assistir seu babaca!</p>
            
            <div class="flex gap-4 justify-center">
                <button id="age-redirect-anyway" class="bg-yellow-300 text-black border-2 border-black px-8 py-3 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black] text-lg">
                    Tá bom😭
                </button>
            </div>
        `;

        // Cria o ouvinte para o novo botão que acabamos de criar dinamicamente
        document.getElementById('age-redirect-anyway').addEventListener('click', () => {
            window.location.href = targetUrl; // Redireciona
        });
    });

    // --- (OPCIONAL) FECHAR O POPUP SE CLICAR FORA ---
    agePopup.addEventListener('click', (e) => {
        if (e.target === agePopup) {
            agePopup.classList.add('hidden');
        }
    });
</script>

<!-- ❄️ NEVE -->
<div id="snow-container" class="fixed inset-0 pointer-events-none z-0"></div>

<!-- 🌄 FUNDO -->
<div class="min-h-screen bg-cover bg-center flex items-center justify-center pt-24"
     style="background-image: url('/images/southpark.png');">

     <!-- 🌑 OVERLAY ESCURO (MELHORA VISUAL) -->
    <div class="absolute inset-0 bg-black/40 z-0"></div>

    <!-- 📦 CARD -->
    <div class="bg-white/90 backdrop-blur border-4 border-black rounded-3xl shadow-[6px_6px_0px_black] p-6 w-96 z-10">

        <h2 class="text-2xl font-bold text-center mb-4">Criar Conta</h2>

        <!-- 🔥 FORM COM UPLOAD -->
        <form method="POST" action="/signup" enctype="multipart/form-data">
            @csrf

            <input type="text" name="name" placeholder="Nome"
                class="w-full mb-3 border-2 border-black rounded-xl p-2">

            <input type="email" name="email" placeholder="Email"
                class="w-full mb-3 border-2 border-black rounded-xl p-2">

            <input type="password" name="password" placeholder="Senha"
                class="w-full mb-3 border-2 border-black rounded-xl p-2">

            <!-- 📸 FOTO -->
            <input type="file" name="photo" id="photoInput"
                class="w-full mb-3 border-2 border-black rounded-xl p-2 bg-white">

            <!-- 👀 PREVIEW -->
            <img id="preview" class="hidden w-20 h-20 rounded-full object-cover border-2 border-black mx-auto mb-3"/>

            <button class="w-full bg-blue-500 text-white border-2 border-black rounded-full py-2 font-bold">
                Criar Conta
            </button>
        </form>

    </div>

</div>

<!-- ❄️ SCRIPT NEVE -->
<script>
// --- SCRIPT DA NEVE (Mantido) ---
function createSnowflake() {
    const snowflake = document.createElement('div');
    snowflake.classList.add('snowflake');
    const size = Math.random() * 6 + 4;
    snowflake.style.left = Math.random() * window.innerWidth + 'px';
    snowflake.style.width = size + 'px';
    snowflake.style.height = size + 'px';
    snowflake.style.animationDuration = (Math.random() * 5 + 5) * 1 + 's';
    snowflake.style.opacity = Math.random();
    document.body.appendChild(snowflake);
    setTimeout(() => snowflake.remove(), 10000);
}
setInterval(createSnowflake, 100);


// --- 🎵 LÓGICA DE ÁUDIO SEM REPETIÇÃO ---
const musicPlayer = document.getElementById("music");
const btn = document.getElementById("playBtn");

// 1. Lista original com os seus 11 arquivos
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

// 2. Criamos uma cópia que será a nossa "fila de reprodução"
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

btn.addEventListener("click", () => {
    // 3. Se a fila estiver vazia, recarregamos e embaralhamos tudo de novo
    if (filaDeSons.length === 0) {
        console.log("Fila vazia! Reembaralhando todos os 11 sons...");
        filaDeSons = embaralhar(sonsOriginais);
    }

    // 4. "Tira" o último som da fila (pop) para tocar
    const proximoSom = filaDeSons.pop();

    // 5. Configura e toca o áudio
    musicPlayer.pause();
    musicPlayer.currentTime = 0;
    musicPlayer.src = proximoSom;
    musicPlayer.play();

    // Feedback visual
    btn.innerText = "🔊 Tocando (" + (sonsOriginais.length - filaDeSons.length) + "/11)";
    
    musicPlayer.onended = () => {
        btn.innerText = "Música";
    };
    
    console.log("Restam na fila: " + filaDeSons.length);
});
</script>

</body>
</html>