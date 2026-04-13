<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre - South Chirper</title>
    <link rel="icon" type="image/png" href="{{ asset('images/southparkicon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { margin: 0; overflow-x: hidden; font-family: 'Arial', sans-serif; }

        .snowflake {
            position: fixed; top: -10px; width: 6px; height: 6px;
            background: white; border-radius: 50%; opacity: 0.8;
            filter: blur(1px); animation: fall linear infinite;
            z-index: 10; pointer-events: none;
        }

        @keyframes fall { to { transform: translateY(100vh); } }
    </style>
</head>

<body class="flex flex-col min-h-screen text-gray-800">

<!-- NAV -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white/90 backdrop-blur border-b-4 border-black shadow">
    <div class="flex justify-between items-center px-6 py-4">

        <a href="/" class="flex items-center gap-2 text-xl font-black hover:scale-105 transition">
            <img src="/images/southparklogo.png" class="h-8 w-auto object-contain">
            South Chirper
        </a>

        <div class="flex gap-3 items-center">

            <a href="{{ route('about') }}" class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                Sobre
            </a>

            <a href="/login" class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                Login
            </a>

            <a href="/signup" class="bg-yellow-300 text-black border-2 border-black px-3 py-1 rounded-full">
                Cadastro
            </a>

        </div>
    </div>
</nav>

<!-- SNOW -->
<div id="snow-container" class="fixed inset-0 pointer-events-none z-10"></div>

<!-- BACKGROUND -->
<div class="relative min-h-screen bg-cover bg-center bg-fixed pt-32 pb-20 flex justify-center items-start"
     style="background-image: url('/images/southpark.png');">

    <div class="absolute inset-0 bg-black/60 z-0"></div>

    <div class="relative z-20 w-full max-w-4xl px-6">

        <!-- HEADER -->
        <div class="bg-white border-4 border-black rounded-3xl p-8 mb-8 shadow-[8px_8px_0px_black] text-center">
            <h1 class="text-4xl font-black uppercase mb-2">Sobre o South Chirper</h1>
            <p class="text-gray-600 uppercase text-sm italic">"I'm not fat, I'm big boned!" — Cartman</p>
        </div>

        <!-- GRID PRINCIPAL -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- CARD 1 -->
            <div class="bg-white border-4 border-black rounded-3xl p-6 shadow-[6px_6px_0px_black]">
                <h2 class="text-2xl font-black mb-4 text-pink-600 uppercase italic">Desenvolvedora</h2>
                <br>
                <img src="{{ asset('images/eu3.jpeg') }}"
                class="mx-auto w-32 h-32 border-4 border-black rounded-full mb-3 bg-white shadow-[4px_4px_0px_black] object-cover">

                <h2 class="text-2xl font-black uppercase italic text-center">Sofia Moura</h2>

                <p class="text-xs uppercase mb-4 text-black/50 text-center">
                    Desenvolvedora Web & Estudante
                </p>

                <p class="text-sm text-justify">
                    Tenho 18 anos e gosto de criar coisas que misturam criatividade, estética e um toque de caos organizado.

Responsável por todo o design caótico e funcionalidade deste Chirper (tive a ajudinha do GPT).

Sempre explorando novas ideias e formas de expressão, seja no design, na tecnologia ou na arte.

                </p>
            </div>
            
            <!-- CARD 2 -->
           <div class="bg-white border-4 border-black rounded-3xl p-6 shadow-[6px_6px_0px_black]">
                <h2 class="text-2xl font-black mb-4 text-sky-600 uppercase italic">O Trabalho</h2>

                <p class="text-gray-800 leading-tight">
                    Projeto desenvolvido para a disciplina de Sistemas de Desenvolvimento sob orientação do
                    <a href="https://github.com/prosalomaon" target="_blank" class="underline hover:text-blue-800">
                        Professor Salomão
                    </a>.
                </p>

                <br>

              <video autoplay loop muted playsinline
            class="w-32 h-32 mx-auto object-cover">
            <source src="{{ asset('videos/euuu.mp4') }}" type="video/mp4">
        </video>
                <br>

                <div class="mt-4 p-3 bg-yellow-100 border-2 border-black rounded-xl text-sm italic">
                    A proposta foi criar uma rede social funcional (CRUD) utilizando o framework Laravel.
                </div>
            </div>


            <!-- CARD 3 -->
           <div class="bg-white border-4 border-black rounded-3xl p-6 shadow-[6px_6px_0px_black]">
                <h2 class="text-2xl font-black mb-4 text-green-600 uppercase italic">Estética</h2>

                <p class="text-sm mb-3">
                    A escolha de South Park foi baseada no estilo louco da animação, por mais que possua muitas coisas erradas, consegue fazer muitos de nós rirem.
                </p>

                <div class="rounded-lg overflow-hidden border-2 border-black h-24 bg-black">
                    <img src="https://media.giphy.com/media/3o7TKUBkZ2xmlka4rm/giphy.gif"
                         class="w-full h-full object-cover opacity-80">
                </div>
            </div>

            <!-- CARD 4 -->
            <div class="bg-white border-4 border-black rounded-3xl p-6 shadow-[6px_6px_0px_black]">

    <h2 class="text-2xl font-black mb-4 text-orange-500 uppercase italic">
        Referência
    </h2>

    <p class="text-sm mb-4">
        Este projeto seguiu a lógica inicial do tutorial oficial do Laravel:
        <a href="https://laravel.com/learn/getting-started-with-laravel/what-are-we-building"
           target="_blank" class="underline hover:text-blue-800">
            What are we building?
        </a>.
    </p>

    <p class="text-sm">
        As funcionalidades de Likes e Comentários foram implementadas via AJAX.
    </p>

    <!-- PERSONAGENS -->
    <div class="flex justify-between items-center mt-6">

        <!-- ESQUERDA (você) -->
        <video autoplay loop muted playsinline
            class="w-24 h-24 object-cover">
            <source src="{{ asset('videos/euu.mp4') }}" type="video/mp4">
        </video>

        <!-- DIREITA (Kenny) -->
        <img src="{{ asset('gif/kenny.gif') }}"
             class="w-32 h-32 object-contain">

    </div>

</div>

            <!-- CARD CONTATOS (CORRIGIDO) -->
            <div class="bg-white border-4 border-black rounded-3xl p-6 shadow-[6px_6px_0px_black] col-span-1 md:col-span-2 relative overflow-hidden text-center">

                <img src="/images/southparklogo.png"
                     class="absolute -top-6 -right-6 h-28 opacity-10 rotate-12">

                <h2 class="text-2xl font-black uppercase italic mb-2 text-red-600 relative z-10">
                    Meus Contatos
                </h2>

                <br>

                <div class="grid grid-cols-3 gap-4 justify-items-center relative z-10">

                     <a href="https://instagram.com/sofismoura" target="_blank">
            <img src="https://img.shields.io/badge/Instagram-%23E4405F.svg?logo=Instagram&logoColor=white"
                 class="w-28 h-8 object-contain hover:scale-110 transition">
        </a>

        <a href="https://discord.com/channels/@harumiowo" target="_blank">
            <img src="https://img.shields.io/badge/Discord-%235865F2.svg?&logo=discord&logoColor=white"
                 class="w-28 h-8 object-contain hover:scale-110 transition">
        </a>

        <a href="https://www.tiktok.com/@sofis_moura" target="_blank">
            <img src="https://img.shields.io/badge/TikTok-black?logo=tiktok&logoColor=white"
                 class="w-28 h-8 object-contain hover:scale-110 transition">
        </a>

        <a href="mailto:sofia.moura494@gmail.com">
            <img src="https://img.shields.io/badge/Gmail-D14836?logo=gmail&logoColor=white"
                 class="w-28 h-8 object-contain hover:scale-110 transition">
        </a>

        <a href="https://www.linkedin.com/in/sofismoura" target="_blank">
            <img src="https://custom-icon-badges.demolab.com/badge/LinkedIn-0A66C2?logo=linkedin-white&logoColor=fff"
                 class="w-28 h-8 object-contain hover:scale-110 transition">
        </a>

        <a href="https://github.com/sofismoura" target="_blank">
            <img src="https://img.shields.io/badge/GitHub-000000?logo=github&logoColor=white"
                 class="w-28 h-8 object-contain hover:scale-110 transition">
        </a>

                </div>
            </div>

        </div>

        <!-- FOOTER -->
        <div class="mt-8 text-center bg-white border-4 border-black rounded-2xl p-4 shadow-[4px_4px_0px_black]">
            <p class="uppercase text-xs font-black">© 2026 South Chirper Inc. - Sofia de Oliveira Silva Moura</p>
        </div>

    </div>
</div>

<!-- SNOW SCRIPT -->
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

</body>
</html>