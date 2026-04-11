<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
    <link rel="icon" type="image/png" href="{{ asset('images/southparkicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            margin: 0;
            overflow-x: hidden;
        }

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
            z-index: 10; /* 🔥 ATRÁS DO CONTEÚDO */
            pointer-events: none;
        }

        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }
    </style>
</head>

<body>

<!-- 🎵 Música -->
<audio id="music" preload="auto">
    <source src="https://www.myinstants.com/media/sounds/south-park-theme-song.mp3" type="audio/mpeg">
</audio>

<!-- 🔝 NAVBAR -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur border-b-4 border-black shadow">
    <div class="flex justify-between items-center px-6 py-4">

        @php
        $countNotifications = \App\Models\Notification::where('user_id', auth()->id())
        ->where('read', false)
        ->count();
        @endphp

        <a href="/" class="flex items-center gap-2 text-xl font-black">
            <img src="/images/southparklogo.png" class="h-8">
            South Chirper
        </a>

        <div class="flex gap-3 items-center">

            <button class="bg-yellow-300 border-2 border-black px-3 py-1 rounded-full hover:scale-105 transition">
                Assistir
            </button>

            <button class="bg-yellow-300 border-2 border-black px-3 py-1 rounded-full hover:scale-105 transition">
                Música
            </button>

            @auth
            <div class="flex items-center gap-3 ml-2 pl-3 border-l-2 border-black/20">

                <!-- 🔔 -->
                <a href="/notifications" class="relative">
                    <svg class="w-6 h-6 text-black hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M15 17h5l-1.4-1.4A2 2 0 0118 14V11a6 6 0 00-4-5.6V5a2 2 0 10-4 0v.3A6 6 0 006 11v3c0 .5-.2 1-.6 1.4L4 17h5"/>
                    </svg>

                    @if($countNotifications > 0)
                        <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 rounded-full">
                            {{ $countNotifications }}
                        </span>
                    @endif
                </a>

                <!-- 👤 -->
                <a href="/profile/edit">
                    <img 
                        src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . auth()->user()->id }}"
                        class="w-10 h-10 border-2 border-black rounded-full"
                    >
                </a>

                <span class="text-sm font-black uppercase">
                    {{ auth()->user()->name }}
                </span>

                <form method="POST" action="/logout">
                    @csrf
                    <button class="bg-red-500 text-white px-2 py-1 text-xs rounded hover:bg-red-600">
                        SAIR
                    </button>
                </form>

            </div>
            @endauth

        </div>
    </div>
</nav>

<!-- ❄️ NEVE -->
<div id="snow-container" class="fixed inset-0 pointer-events-none z-10"></div>

<!-- 🌄 FUNDO -->
<div class="relative min-h-screen bg-cover bg-center pt-28 flex justify-center items-center"
     style="background-image: url('/images/southpark.png');">

    <!-- 🌑 overlay -->
    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <!-- 📦 CONTEÚDO -->
    <div class="relative z-20 w-full max-w-md">

        <div class="bg-white border-4 border-black rounded-3xl p-6 shadow-[6px_6px_0px_black]">

            <h2 class="text-2xl font-black mb-4 text-center">
                Editar Perfil
            </h2>

            <form method="POST" action="/profile/update" enctype="multipart/form-data">
                @csrf

                <input type="text" name="name" value="{{ auth()->user()->name }}"
                    class="w-full border-2 border-black p-2 mb-3 rounded">

                <!-- PREVIEW -->
                <div class="flex flex-col items-center mb-4">
                    <img 
                        id="preview"
                        src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . auth()->user()->id }}"
                        class="w-24 h-24 border-4 border-black rounded-full object-cover mb-2"
                    >

                    <label class="bg-yellow-300 border-2 border-black px-4 py-1 rounded-full cursor-pointer hover:scale-105 transition">
                        Trocar foto
                        <input type="file" name="photo" id="photoInput" class="hidden" accept="image/*">
                    </label>
                </div>

                <button class="w-full bg-yellow-300 border-2 border-black py-2 rounded-full font-bold hover:scale-105 transition">
                    Salvar
                </button>
            </form>

            <!-- DELETE -->
            <div class="mt-6 border-t pt-4 text-center">
                <h3 class="text-red-600 font-black mb-2 ">Zona de perigo ⚠️</h3>

                <button onclick="openDeleteAccountModal()"
                    class="bg-red-600 text-white border-2 border-black px-4 py-2 rounded-full font-bold hover:bg-red-800 transition">
                    Excluir conta permanentemente
                </button>
            </div>

        </div>

    </div>
</div>

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

    document.getElementById('snow-container').appendChild(snowflake);

    setTimeout(() => snowflake.remove(), 10000);
}
setInterval(createSnowflake, 120);
</script>

<!-- PREVIEW -->
<script>
document.getElementById('photoInput').addEventListener('change', function(event) {
    const file = event.target.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
    }
});
</script>

<!-- MODAL -->
<div id="delete-account-modal" class="fixed inset-0 bg-black/80 hidden flex items-center justify-center z-[100]">
    <div class="bg-white border-4 border-black rounded-3xl p-6 text-center">

        <h2 class="text-2xl font-black text-red-600 mb-3">TEM CERTEZA?!</h2>
        <p class="mb-4">Não que eu me importe com você, mas essa ação é irreversível! 💀</p>

        <div class="flex gap-4 justify-center">
            <button onclick="closeDeleteAccountModal()"
                class="bg-green-500 text-white border-2 border-black px-6 py-2 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">
                Não
            </button>

            <form method="POST" action="/profile/delete">
                @csrf
                @method('DELETE')

                <button class="bg-red-600 text-white border-2 border-black px-6 py-2 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]"">
                    Sim
                </button>
            </form>
        </div>

    </div>
</div>

<audio id="deleteSound">
    <source src="{{ asset('audio/apagar_conta.mp3') }}" type="audio/mpeg">
</audio>

<script>
function openDeleteAccountModal() {
    document.getElementById('delete-account-modal').classList.remove('hidden');

    const audio = document.getElementById('deleteSound');
    audio.currentTime = 0; // reinicia sempre
    audio.play();
}

function closeDeleteAccountModal() {
    document.getElementById('delete-account-modal').classList.add('hidden');

    const audio = document.getElementById('deleteSound');
    audio.pause();
    audio.currentTime = 0;
}
</script>

</body>
</html>