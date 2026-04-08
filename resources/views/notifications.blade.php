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

        <a href="/" class="flex items-center gap-2 text-xl font-black hover:scale-105 transition">
            <img src="/images/southparklogo.png" class="h-8 w-auto object-contain">
            South Chirper
        </a>

        <div class="flex gap-3 items-center">

            <a href="/notifications"
               class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full font-bold">
               🔔
            </a>

            @auth
                <div class="flex items-center gap-2 ml-4">
                    <span class="font-black text-black uppercase text-sm">{{ auth()->user()->name }}</span>
                    
                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . auth()->user()->id }}" 
                         class="w-8 h-8 border-2 border-black rounded-full bg-white object-cover">

                    <form method="POST" action="/logout">
                        @csrf
                        <button class="bg-red-500 text-white border-2 border-black px-3 py-1 rounded-full text-xs font-bold">
                            SAIR
                        </button>
                    </form>
                </div>
            @endauth

        </div>
    </div>
</nav>

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
                <div class="flex items-center gap-3 border-b-2 border-black/10 pb-3 mb-3">

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

                </div>
            @empty
                <p class="text-center font-bold text-gray-500">
                    Nenhuma notificação ainda 😴
                </p>
            @endforelse

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
    snowflake.style.opacity = Math.random();
    document.body.appendChild(snowflake);
    setTimeout(() => snowflake.remove(), 10000);
}
setInterval(createSnowflake, 100);
</script>

</body>
</html>