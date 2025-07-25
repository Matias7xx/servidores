<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Windmill Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/tailwind.output.css" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="../assets/js/init-alpine.js"></script>
    @vite('resources/css/app.css')
</head>

<body>

    <div class="flex items-center min-h-screen bg-[rgb(45,49,51)]">
        <div class="flex flex-col w-96 mx-auto overflow-hidden rounded-lg ">
            <div class="flex justify-center items-center">
                <img class="w-3/4" src="../assets/img/brasao_pcpb_branca.png" alt="Office" />
            </div>
            <div class="font-semibold text-white font-sans text-3xl mb-9 mt-2 text-center">
                Polícia Civil da Paraíba
            </div>
            <div class="flex flex-col w-full overflow-y-auto">

                <!-- Exibir mensagens de erro -->
                @if ($errors->any())
                    <div class="mb-4 text-sm text-red-600">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <x-auth-session-status class="mb-4" :status="session('status')" />
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <label class="block text-sm">
                        <input
                            class="block w-full text-sm focus:border-gray-300 focus:outline-none focus:shadow-outline-gray form-input rounded-md"
                            name="matricula" placeholder="Matrícula" required />
                    </label>
                    <label class="block mt-1 text-sm">
                        <input
                            class="block w-full text-sm focus:border-gray-400 focus:outline-none focus:shadow-outline-gray form-input rounded-md"
                            type="password" name="password" placeholder="Senha" required value=""/>
                    </label>
                    <button type="submit"
                        class="flex items-center justify-center w-full px-4 py-2 mt-1 text-sm font-medium leading-5 transition-colors duration-150 bg-[rgb(193,168,90)] border border-transparent rounded-lg active:bg-gray-600 hover:bg-gray-700 focus:outline-none focus:shadow-outline-gray text-gray-900 dark:text-black">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                        </svg>
                        <span>Entrar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
