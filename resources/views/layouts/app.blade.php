<!DOCTYPE html>
<body x-data="data()" lang="pt-BR">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="{{ asset('storage/brasaopc.ico') }}" type="image/x-icon">
    <title>Polícia Civil da Paraíba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/assets/css/tailwind.output.css') }}" />
    <script src="{{ asset('/assets/js/alpinejs@3.x.x.min.js') }}"></script>
    <script src="{{ asset('/assets/js/init-alpine.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/assets/css/chartjs@2.9.3.min.css') }}" />
    <script src="{{ asset('/assets/js/chartjs@2.9.3.min.js') }}" defer></script>
    <script src="{{ asset('/assets/js/jquery@3.1.0.min.js')}}"></script>
    @vite('resources/css/app.css')
</head>

<body>
    <div class="flex w-full h-screen" >
        @include('layouts.partials.navbar')
        <div class="flex flex-col w-full h-screen">
            @include('layouts.partials.sidebar')
            <div class="flex flex-col bg-white dark:bg-gray-900 h-full text-black dark:text-white">
                @yield('conteudo')
                @yield('scripts')
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>

    <script>
        const toggleButton = document.getElementById('toggle-navbar');
        const navbar = document.getElementById('navbar');
        toggleButton.addEventListener('click', () => {
            navbar.classList.toggle('hidden');
        });
    </script>

    <script>
        const toggleTheme = () => {
            // Obtém o tema atual definido no atributo `data-theme` no elemento `html`
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';

            // Determina o próximo tema
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

            // Atualiza o atributo `data-theme`
            document.documentElement.setAttribute('data-theme', newTheme);

            // Salva a preferência do tema no Local Storage
            localStorage.setItem('theme', newTheme);
        };

        // Aplica o tema salvo no Local Storage ao carregar a página
        document.addEventListener('DOMContentLoaded', () => {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
        });
    </script>

    <script src="{{ asset('/assets/js/jquery@3.6.4.min.js')}}"></script>
    <script src="{{ asset('/assets/js/jquery.mask@1.14.16.min.js')}}"></script>

    <script>
        $(document).ready(function() {
            // Aplica máscara ao campo de telefone
            $('#telefone').mask('(00) 00000-0000', {
                placeholder: "(00) 00000-0000" // Exibe a máscara no campo
            });
        });

        function abrirPagina(URL, w, h) {
            let LeftPosition = (screen.width) ? (screen.width - w) / 2 : 0;
            let TopPosition = (screen.height) ? (screen.height - h) / 2 : 0;
            window.open(URL, 'janela', 'width=' + w + ', height=' + h + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=no, status=no, toolbar=no, location=no, menubar=no, resizable=no, fullscreen=no');
        }
    </script>
</body>
</html>
