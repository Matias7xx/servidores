<div class="flex-grow flex-col fixed top-0 w-screen">
    <header class="z-8 bg-black shadow-md dark:bg-gray-700">
        <div class="grid grid-cols-3 gap-4">
            <div class="col-span-1">
                <div
                    class="container flex items-center justify-between h-full px-6 mx-auto text-gray-600 dark:text-gray-300">
                    <ul class="flex items-center flex-shrink-0 space-x-6 w-full">
                        <!-- Ocultar / Exibir Menu  -->
                        <li class="flex">
                            <button id="toggle-navbar" class="focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                        </li>

                        <!-- Trocar tema Light / Dark -->
                        <li class="flex">
                            <div x-data="{ dark: false }" x-init="dark = window.matchMedia('(prefers-color-scheme: light)').matches;"
                                x-effect="
                            if (dark) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                         ">
                                <button @click="dark = !dark"
                                    class="rounded-md focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Toggle color mode">
                                    <template x-if="!dark">
                                        <!-- Ícone modo claro -->
                                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z">
                                            </path>
                                        </svg>
                                    </template>
                                    <template x-if="dark">
                                        <!-- Ícone modo escuro -->
                                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </template>
                                </button>
                            </div>
                        </li>

                        <!-- Notifications Menu -->
                        {{-- <li class="flex">
                            <div class="dropdown dropdown-end">
                                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                                    <div class="indicator">
                                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z">
                                            </path>
                                        </svg>
                                        <span class="badge badge-sm indicator-item">8</span>
                                    </div>
                                </div>
                                <div tabindex="0"
                                    class="card card-compact dropdown-content bg-base-100 z-[1] mt-3 w-52 shadow">
                                    <div class="card-body">
                                        <span class="text-lg font-bold">8 Items</span>
                                        <span class="text-info">Subtotal: $999</span>
                                        <div class="card-actions">
                                            <button class="btn btn-primary btn-block">View cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> --}}
                    </ul>
                </div>
            </div>

            <div class="col-span-1 text-right text-white flex items-center justify-end">
              {{ Session::get('servidor_nome')  ? Session::get('servidor_nome') : '' }}
            </div>

            <div class="col-span-1">
                <ul class="flex items-center flex-shrink-0 space-x-6">
                    <li class="flex">
                        <div class="dropdown dropdown-end">
                            <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                                <div class="w-10 rounded-full">
                                    @if(Session::get('foto_servidor') && filter_var(Session::get('foto_servidor'), FILTER_VALIDATE_URL))
                                        <img src="{{ Session::get('foto_servidor') }}" alt="Foto do Servidor" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <span class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-300 text-gray-600 text-2xl">
                                            <i class="fa fa-user"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <ul tabindex="0"
                                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                                {{-- <li>
                                    <a class="justify-between">
                                        Profile
                                        <span class="badge">New</span>
                                    </a>
                                </li>
                                <li><a>Settings</a></li> --}}
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        Sair
                                        <i class="fa fa-sign-out"></i>
                                    </a>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>



    </header>
</div>
