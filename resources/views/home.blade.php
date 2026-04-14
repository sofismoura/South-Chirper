<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>South Chirper</title>
    <link rel="icon" type="image/png" href="{{ asset('images/southparkicon.png') }}">

    <script src="https://cdn.tailwindcss.com"></script>


    <!-- css básico -->
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
        }

        @keyframes fall {
            to {
                transform: translateY(100vh);
            }
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <main class="flex-1">

        <audio id="music" preload="auto">
            <source src="https://www.myinstants.com/media/sounds/south-park-theme-song.mp3" type="audio/mpeg">
        </audio>

        <!-- navbar -->
        <nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur border-b-4 border-black shadow">
            <div class="flex justify-between items-center px-6 py-4">

                @php
                    $countNotifications = \App\Models\Notification::where('user_id', auth()->id())
                        ->where('read', false)
                        ->count();
                @endphp
                <a href="/" class="flex items-center gap-2 text-xl font-black hover:scale-105 transition">
                    <img src="/images/southparklogo.png" class="h-8 w-auto object-contain">
                    South Chirper
                </a>

                <div class="flex gap-3 items-center">

                    <button id="assitir" class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                        Assistir
                    </button>

                    <button id="playBtn" class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                        Música
                    </button>

                    <a href="{{ route('about') }}"
                        class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                        Sobre
                    </a>

                    <a href="/login" class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                        Login
                    </a>

                    <a href="/signup" class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                        Cadastro
                    </a>

                    @auth

                        <div class="flex items-center gap-3 ml-2 pl-3 border-l-2 border-black/20">

                            <!-- notificações -->
                            <a href="/notifications" class="relative">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-6 h-6 text-black hover:scale-110 transition" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 
                                    14.158V11a6.002 6.002 0 00-4-5.659V5a2 
                                    2 0 10-4 0v.341C7.67 6.165 6 8.388 
                                    6 11v3.159c0 .538-.214 1.055-.595 
                                    1.436L4 17h5m6 0v1a3 3 0 11-6 
                                    0v-1m6 0H9" />
                                </svg>

                                @if($countNotifications > 0)
                                    <span
                                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs px-2 rounded-full font-bold animate-pulse">
                                        {{ $countNotifications }}
                                    </span>
                                @endif

                            </a>

                            <!-- user -->
                            <div class="relative group cursor-pointer">

                                <a href="/profile/edit">
                                    <img src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . auth()->user()->id }}"
                                        class="w-10 h-10 border-2 border-black rounded-full bg-white object-cover shadow-[2px_2px_0px_black]">


                                    <div
                                        class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                        ✏️
                                    </div>
                                </a>

                            </div>

                            <div class="flex flex-col">
                                <span class="text-[10px] font-black uppercase leading-none text-black/50">Logado
                                    como:</span>
                                <span class="text-sm font-black uppercase leading-none">{{ auth()->user()->name }}</span>
                            </div>

                            <!-- sair -->
                            <form method="POST" action="/logout" class="ml-1">
                                @csrf
                                <button type="submit"
                                    class="text-[10px] font-bold bg-red-500 text-white border border-black px-2 py-0.5 rounded-md hover:bg-red-600 transition">
                                    SAIR
                                </button>
                            </form>

                        </div>

                    @endauth

                </div>
            </div>
        </nav>

        <!-- lógica do botâo de assistir -->
        <div id="age-popup"
            class="fixed inset-0 bg-black/80 z-[100] hidden flex items-center justify-center p-4 backdrop-blur-sm">
            <div
                class="bg-white border-4 border-black rounded-3xl shadow-[8px_8px_0px_black] p-8 max-w-md w-full text-center relative overflow-hidden">

                <img src="/images/southparklogo.png"
                    class="absolute -top-10 -right-10 h-32 opacity-10 rotate-12 pointer-events-none">

                <h3 class="text-3xl font-black mb-6 text-black drop-shadow-[1px_1px_0px_white]">
                    PERGUNTA SÉRIA!
                </h3>

                <div id="popup-content">
                    <p class="text-xl font-bold mb-8">Você tem idade para assistir isso, cara?</p>

                    <div class="flex gap-4 justify-center">
                        <button id="age-yes"
                            class="bg-green-500 text-white border-2 border-black px-6 py-2 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">
                            Sim, sou adulto!
                        </button>
                        <button id="age-no"
                            class="bg-red-500 text-white border-2 border-black px-6 py-2 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">
                            Não... sou criancinha
                        </button>
                    </div>
                </div>

            </div>
        </div>

        <script>

            // lógica das opções do botão de assistir
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

                //  toca o som ao abrir
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

                //  toca o som ao abrir
                somExcluir.currentTime = 0;
                somExcluir.play();

                modal.classList.remove('hidden');
            }

            // fecha modal ao cancelar (fica sem som)
            document.getElementById('cancel-delete').addEventListener('click', () => {
                document.getElementById('delete-popup').classList.add('hidden');
            });

            // fecha clicando fora
            document.getElementById('delete-popup').addEventListener('click', (e) => {
                if (e.target === document.getElementById('delete-popup')) {
                    document.getElementById('delete-popup').classList.add('hidden');
                }
            });

        </script>

        <div id="snow-container" class="fixed inset-0 pointer-events-none z-0"></div>

        <div class="min-h-screen bg-cover bg-center bg-fixed bg-no-repeat relative z-0 pt-28"
            style="background-image: url('/images/southpark.png');">

            <div class="absolute inset-0 bg-black/40 z-0"></div>

            <div class="relative z-20 max-w-2xl mx-auto p-6">

                <h2 class="text-3xl text-left font-black mb-6 text-white drop-shadow-[2px_2px_6px_black]">
                    Últimos Chirps
                </h2>

                <div
                    class="bg-white/90 backdrop-blur border-4 border-black rounded-3xl shadow-[6px_6px_0px_black] p-5 mb-6">

                    <form method="POST" action="/chirps">
                        @csrf

                        <textarea name="message" placeholder="O que está passando pela sua mente, cara?
Já disponível na internet🎉"
                        
                            class="w-full border-2 border-black rounded-xl p-3 bg-white"></textarea>
                            

                        <div class="text-right mt-3">
                            <button
                                class="bg-yellow-300 border-2 border-black rounded-full px-5 py-2 font-bold hover:scale-105 transition">
                                Chirp!
                            </button>
                        </div>

                    </form>
                </div>

                @foreach ($chirps as $chirp)
                    <div id="chirp-{{ $chirp->id }}"
                        class="bg-white/90 backdrop-blur border-4 border-black rounded-3xl shadow-[6px_6px_0px_black] p-5 mb-8 flex flex-col">

                        <div class="flex gap-4 items-start">
                            <img src="{{ $chirp->user->photo ? asset('storage/' . $chirp->user->photo) : 'https://api.dicebear.com/7.x/adventurer/svg?seed=' . $chirp->user->id }}"
                                class="w-14 h-14 border-2 border-black rounded-full bg-white object-cover shadow-[2px_2px_0px_black] flex-shrink-0">

                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <p class="font-black text-sm uppercase text-black">
                                        {{ $chirp->user->name ?? 'User' }}
                                    </p>
                                    <p class="text-[10px] font-bold text-gray-500 uppercase">
                                        • {{ $chirp->created_at->diffForHumans() }}
                                    </p>
                                </div>

                                <p class="text-lg mt-1 mb-3 font-medium leading-tight">
                                    {{ $chirp->message }}
                                </p>

                                <button onclick="likeChirp({{ $chirp->id }})"
                                    class="flex items-center gap-1 group transition mb-4">

                                    <svg id="heart-{{ $chirp->id }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        class="w-5 h-5 transition
                                {{ $chirp->likes->where('user_id', auth()->id())->count() ? 'text-red-500 fill-current' : 'text-gray-600' }}">

                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                                2 6 4 4 6.5 4c1.74 0 3.41 1.01 
                                4.22 2.44h.56C12.09 5.01 13.76 4 
                                15.5 4 18 4 20 6 20 8.5 
                                c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
                                    </svg>

                                    <span id="like-count-{{ $chirp->id }}" class="text-sm font-bold">
                                        {{ $chirp->likes->count() }}
                                    </span>
                                </button>

                                <div class="flex gap-2 mb-4">
                                    <input type="text" id="comment-input-{{ $chirp->id }}" placeholder="Comentar..."
                                        class="flex-1 border-2 border-black rounded-full px-4 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-yellow-400">

                                    <button onclick="commentChirp({{ $chirp->id }})"
                                        class="bg-white text-black border-2 border-black px-4 rounded-full font-bold hover:bg-yellow-300 transition">
                                        💬
                                    </button>
                                </div>

                                <!-- botão de ver os comentários de um post -->
                                <button onclick="toggleComments({{ $chirp->id }})"
                                    class="text-black-600 font-bold text-sm mb-2 hover:underline">
                                    Ver comentários ({{ $chirp->comments->count() }})
                                </button>


                                <div id="comments-{{ $chirp->id }}" class="hidden space-y-2">
                                    @foreach($chirp->comments as $comment)
                                        <div class="bg-black/5 border-2 border-black/10 rounded-2xl p-3 text-sm">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-black uppercase text-[10px]">
                                                    {{ $comment->user->name }}
                                                </span>
                                                <span class="text-gray-500 text-[9px]">
                                                    • {{ $comment->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            <p class="text-gray-800">
                                                {{ $comment->message }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>

                                @if ($chirp->user->is(auth()->user()))
                                    <div class="mt-4 text-right">
                                        <button type="button" onclick="openDeleteModal('{{ route('chirps.destroy', $chirp) }}')"
                                            class="text-[10px] font-black uppercase bg-red-500 text-white border-2 border-black px-4 py-1.5 rounded-md hover:bg-red-700 transition shadow-[2px_2px_0px_black]">
                                            Excluir Chirp
                                        </button>
                                    </div>
                                @endif

                            </div>
                        </div>
                    </div>

                @endforeach

                <!-- lógica likes -->
                <script>
                    function likeChirp(id) {
                        fetch(`/chirps/${id}/like`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data => {

                                // atualiza número
                                document.getElementById(`like-count-${id}`).innerText = data.likes;

                                // pega o coração
                                const heart = document.getElementById(`heart-${id}`);

                                // troca cor
                                if (data.liked) {
                                    heart.classList.add('text-red-500', 'fill-current');
                                    heart.classList.remove('text-gray-600');
                                } else {
                                    heart.classList.remove('text-red-500', 'fill-current');
                                    heart.classList.add('text-gray-600');
                                }
                            });

                        heart.classList.add('scale-125');
                        setTimeout(() => heart.classList.remove('scale-125'), 150);
                    }

                    // lógica comentários
                    function commentChirp(id) {
                        const input = document.getElementById(`comment-input-${id}`);
                        const message = input.value;

                        if (!message.trim()) return;

                        fetch(`/chirps/${id}/comment`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ message })
                        })
                            .then(res => res.json())
                            .then(data => {
                                input.value = "";

                                const container = document.getElementById(`comments-${id}`);

                                container.classList.remove('hidden'); // abre automático

                                container.innerHTML += `
            <div class="bg-black/5 border-2 border-black/10 rounded-2xl p-3 text-sm">
                <div class="flex items-center gap-2 mb-1">
                    <span class="font-black uppercase text-[10px]">${data.user}</span>
                    <span class="text-gray-500 text-[9px]">agora</span>
                </div>
                <p class="text-gray-800">${data.message}</p>
            </div>
        `;
                            });
                    }
                </script>

                <script>
                    function toggleComments(chirpId) {
                        const el = document.getElementById('comments-' + chirpId);
                        const btn = event.target;

                        el.classList.toggle('hidden');

                        if (el.classList.contains('hidden')) {
                            btn.innerText = "Ver comentários";
                        } else {
                            btn.innerText = "Ocultar comentários";
                        }
                    }

                    // neve
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


                    // lógica dos aúdios sem repetir

                    const musicPlayer = document.getElementById("music");
                    const btn = document.getElementById("playBtn");

                    //  lista original com as músicas ou efeitos sonoros
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

                    // fila de reprodução
                    let filaDeSons = [];

                    // função para embaralhar a lista (Algoritmo Fisher-Yates)
                    function embaralhar(array) {
                        let lista = [...array];
                        for (let i = lista.length - 1; i > 0; i--) {
                            const j = Math.floor(Math.random() * (i + 1));
                            [lista[i], lista[j]] = [lista[j], lista[i]];
                        }
                        return lista;
                    }

                    // função para tocar a próxima música
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

                    // 1 clique = Play/Pause
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

                    // 2 cliques = Pular Música
                    btn.addEventListener("dblclick", () => {
                        tocarProxima();
                    });

                    // reseta quando acaba
                    musicPlayer.onended = () => {
                        btn.innerText = "Música";
                        btn.classList.remove('bg-green-400');
                    };

                </script>


                <!-- lógica do botão de excluir chirp -->
                <div id="delete-popup"
                    class="fixed inset-0 bg-black/80 z-[110] hidden flex items-center justify-center p-4 backdrop-blur-sm">
                    <div
                        class="bg-white border-4 border-black rounded-3xl shadow-[8px_8px_0px_black] p-8 max-w-md w-full text-center relative">
                        <h3 class="text-2xl font-black mb-4 text-red-600">PERAÍ, CACETE!</h3>

                        <div id="delete-text-container">
                            <p class="text-lg font-bold mb-6">Você tem certeza que quer apagar essa porcaria, cara? Não
                                tem volta!</p>

                            <div class="flex gap-4 justify-center">
                                <button id="cancel-delete" type="button"
                                    class="bg-green-500 text-white border-2 border-black px-6 py-2 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">
                                    Não
                                </button>

                                <form id="confirm-delete-form" method="POST" action="">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white border-2 border-black px-6 py-2 rounded-full font-bold hover:scale-105 transition shadow-[4px_4px_0px_black]">
                                        Sim
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>

                    // fecha modal ao cancelar
                    document.getElementById('cancel-delete').addEventListener('click', () => {
                        document.getElementById('delete-popup').classList.add('hidden');
                    });

                    // Fecha modal ao clicar fora dele
                    document.getElementById('delete-popup').addEventListener('click', (e) => {
                        if (e.target === document.getElementById('delete-popup')) {
                            document.getElementById('delete-popup').classList.add('hidden');
                        }
                    });
                </script>

                <!-- leva a notificação para o post exato -->
                <script>
                    const urlParams = new URLSearchParams(window.location.search);
                    const chirpId = urlParams.get('chirp');

                    if (chirpId) {
                        const el = document.getElementById('chirp-' + chirpId);
                        if (el) {
                            el.scrollIntoView({ behavior: 'smooth', block: 'center' });


                            el.classList.add('ring-4', 'ring-yellow-400');

                            setTimeout(() => {
                                el.classList.remove('ring-4', 'ring-yellow-400');
                            }, 3000);
                        }
                    }
                </script>

    </main>

    <!-- footer -->
    <footer
        class="bottom-0 left-0 w-full z-50 bg-white/90 backdrop-blur border-t-4 border-black shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)]">
        <div class="max-w-6xl mx-auto px-6 py-3 flex justify-between items-center">

            <div class="flex flex-col">
                <span class="text-[10px] font-black uppercase text-black/40 leading-none">© 2026 South Chirper
                    Inc.</span>
                <span class="text-xs font-black uppercase tracking-tighter">Respeite minha autoridade!</span>
            </div>

            <div class="hidden md:flex items-center gap-3">

                <img src="/images/cartmanpolice.png" class="h-10 w-auto hover:rotate-12 transition-transform"
                    alt="Cartman Police">

                <div class="h-2 w-2 bg-red-500 rounded-full animate-pulse"></div>

                <span class="text-[11px] font-bold uppercase tracking-widest text-black">
                    Sofia de Oliveira Silva Moura - 2026
                </span>

                <div class="h-2 w-2 bg-red-500 rounded-full animate-pulse"></div>

                <img src="/images/cartmanpolice.png" class="h-10 w-auto hover:rotate-12 transition-transform"
                    alt="Cartman Police">

            </div>

            <div class="text-right">
                <p class="text-[10px] font-black uppercase text-green-600 leading-none">Status: Online</p>
                <p class="text-[9px] font-bold text-black/60">Localização: South Park, Colorado</p>
            </div>

        </div>
    </footer>

</body>

</html>