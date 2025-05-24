<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PAGINA LABCAM</title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="icon" href="favicon.ico">
    <link href="/user/template/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <script defer src="/user/template/bundle.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
</head>

<body>
    <nav x-data="{ stickyMenu: false, openDropdown: null }"
        :class="{ 'bg-transparent opacity-0': stickyMenu, 'bg-[#1E5397] opacity-100': !stickyMenu }"
        @scroll.window="stickyMenu = (window.pageYOffset > 20); if(stickyMenu) openDropdown = null"
        @mouseenter="stickyMenu = false; openDropdown = null"
        @mouseleave="stickyMenu = (window.pageYOffset > 20); if(stickyMenu) openDropdown = null"
        class="transition-all duration-300 fixed top-0 w-full z-50 py-1 md:px-12" id="navbar">
        <div class="w-full flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img class="h-9 md:h-10 my-3" src="/user/template/images/logoLabCam.png" alt="Logo" />
            </a>
            <button data-collapse-toggle="navbar-multi-level" type="button"
                class="text-white inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg md:hidden focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-multi-level" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div class="hidden w-full md:block md:w-auto md:my-3" id="navbar-multi-level">
                <ul
                    class="flex flex-col font-medium p-4 space-y-1 md:space-y-0 md:p-0 mt-4 border border-gray-100 rounded-lg md:space-x-11 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:items-center">
                    <li>
                        <a href="{{ route('home') }}"
                            class="text-white block py-2 px-3 rounded md:border-0 md:hover:text-[#98C560] hover:bg-[#98C560] md:hover:bg-transparent md:p-0 {{ request()->routeIs('home') ? 'text-white bg-[#98C560] md:bg-transparent md:text-[#98C560]' : 'text-white bg-transparent' }}">
                            Inicio
                        </a>
                    </li>

                    <!-- Dropdown Nosotros -->
                    <li class="relative">
                        <button id="dropdownNavbarLink"
                            class="flex items-center justify-between w-full py-2 px-3 text-white hover:bg-[#98C560] rounded-md md:hover:bg-transparent md:border-0 md:hover:text-[#98C560] md:p-0 md:w-auto {{ request()->routeIs('about', 'historia') ? 'text-white bg-[#98C560] md:bg-transparent md:text-[#98C560]' : 'text-white bg-transparent' }}"
                            @click="openDropdown = openDropdown === 'dropdownNavbar' ? null : 'dropdownNavbar'">
                            Nosotros
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="dropdownNavbar" x-show="openDropdown === 'dropdownNavbar'"
                            class="z-10 font-normal rounded shadow w-44 bg-white absolute top-full mt-1 left-0"
                            @click="openDropdown = openDropdown === 'dropdownNavbar' ? null : 'dropdownNavbar'; if(openDropdown !== 'dropdownNavbar') openDropdown = 'dropdownNavbar'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:leave="transition ease-in duration-150">
                            <ul class="py-2 text-sm" aria-labelledby="dropdownLargeButton">
                                <li>
                                    <a href="{{ route('about') }}"
                                        class="block px-4 py-2 hover:text-[#98C560] {{ request()->routeIs('about') ? 'text-[#98C560]' : 'text-black' }}">
                                        Acerca
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('historia') }}"
                                        class="block px-4 py-2 hover:text-[#98C560] {{ request()->routeIs('historia') ? 'text-[#98C560]' : 'text-black' }}">
                                        Historia
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Dropdown Organización -->
                    <li class="relative">
                        <button id="dropdownNavbarLink2"
                            class="flex items-center justify-between w-full py-2 px-3 text-white hover:bg-[#98C560] rounded-md md:hover:bg-transparent md:border-0 md:hover:text-[#98C560] md:p-0 md:w-auto {{ request()->routeIs(['direccion', 'capital_usuario', 'areas']) ? 'text-white bg-[#98C560] md:bg-transparent md:text-[#98C560]' : 'text-white bg-transparent' }}"
                            @click="openDropdown = openDropdown === 'dropdownNavbar2' ? null : 'dropdownNavbar2'">
                            Organización
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="dropdownNavbar2" x-show="openDropdown === 'dropdownNavbar2'"
                            class="z-10 font-normal rounded shadow w-44 bg-white absolute top-full mt-1 left-0"
                            @click="openDropdown = openDropdown === 'dropdownNavbar2' ? null : 'dropdownNavbar2'; if(openDropdown !== 'dropdownNavbar2') openDropdown = 'dropdownNavbar2'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:leave="transition ease-in duration-150">
                            <ul class="py-2 text-sm">
                                <li>
                                    <a href="{{ route('direccion') }}"
                                        class="block px-4 py-2 hover:text-[#98C560] {{ request()->routeIs('direccion') ? 'text-[#98C560]' : 'text-black' }}">
                                        Dirección
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('capital_usuario') }}"
                                        class="block px-4 py-2 hover:text-[#98C560] {{ request()->routeIs('capital_usuario') ? 'text-[#98C560]' : 'text-black' }}">
                                        Capital Humano
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Dropdown Biblioteca -->
                    <li class="relative">
                        <button id="dropdownNavbarLink3"
                            class="flex items-center justify-between w-full py-2 px-3 text-white hover:bg-[#98C560] rounded-md md:hover:bg-transparent md:border-0 md:hover:text-[#98C560] md:p-0 md:w-auto {{ request()->routeIs(['biblioteca.papers.*', 'proyectos', 'proyectos.show']) ? 'text-white bg-[#98C560] md:bg-transparent md:text-[#98C560]' : 'text-white bg-transparent' }}"
                            @click="openDropdown = openDropdown === 'dropdownNavbar3' ? null : 'dropdownNavbar3'">
                            Biblioteca
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="dropdownNavbar3" x-show="openDropdown === 'dropdownNavbar3'"
                            class="z-10 font-normal rounded shadow w-44 bg-white absolute top-full mt-1 left-0"
                            @click="openDropdown = openDropdown === 'dropdownNavbar3' ? null : 'dropdownNavbar3'; if(openDropdown !== 'dropdownNavbar3') openDropdown = 'dropdownNavbar3'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:leave="transition ease-in duration-150">
                            <ul class="py-2 text-sm">
                                <li>
                                    <a href="{{ route('biblioteca.papers.index') }}"
                                        class="block px-4 py-2 hover:text-[#98C560] {{ request()->routeIs('biblioteca.papers.*') ? 'text-[#98C560]' : 'text-black' }}">
                                        Publicaciones
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('proyectos') }}"
                                        class="block px-4 py-2 hover:text-[#98C560] {{ request()->routeIs('proyectos', 'proyectos.show') ? 'text-[#98C560]' : 'text-black' }}">
                                        Proyectos
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Dropdown Novedades -->
                    <li class="relative">
                        <button id="dropdownNavbarLink4"
                            class="flex items-center justify-between w-full py-2 px-3 text-white hover:bg-[#98C560] rounded-md md:hover:bg-transparent md:border-0 md:hover:text-[#98C560] md:p-0 md:w-auto {{ request()->routeIs(['noticias', 'noticias.show', 'eventos', 'eventos.show']) ? 'text-white bg-[#98C560] md:bg-transparent md:text-[#98C560]' : 'text-white bg-transparent' }}"
                            @click="openDropdown = openDropdown === 'dropdownNavbar4' ? null : 'dropdownNavbar4'">
                            Novedades
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="dropdownNavbar4" x-show="openDropdown === 'dropdownNavbar4'"
                            class="z-10 font-normal rounded shadow w-44 bg-white absolute top-full mt-1 left-0"
                            @click="openDropdown = openDropdown === 'dropdownNavbar4' ? null : 'dropdownNavbar4'; if(openDropdown !== 'dropdownNavbar4') openDropdown = 'dropdownNavbar4'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:leave="transition ease-in duration-150">
                            <ul class="py-2 text-sm">
                                <li>
                                    <a href="{{ route('noticias') }}"
                                        class="block px-4 py-2 hover:text-[#98C560] {{ request()->routeIs('noticias', 'noticias.show') ? 'text-[#98C560]' : 'text-black' }}">
                                        Noticias
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('eventos') }}"
                                        class="block px-4 py-2 hover:text-[#98C560] {{ request()->routeIs('eventos', 'eventos.show') ? 'text-[#98C560]' : 'text-black' }}">
                                        Eventos
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="{{ route('contacto') }}"
                            class="text-white block py-2 px-3 rounded md:border-0 md:px-4 bg-[#98C560] w-max md:w-auto">
                            Contacto
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main id="main-content">
        @yield('contenido')
    </main>
    <footer class="bg-[#1E5397] px-6">
        <div class="mx-auto w-full py-6 lg:py-8">
            <div class="flex flex-col gap-8 sm:grid sm:grid-cols-2 lg:grid-cols-4 pt-4 w-full">
                <!-- Primera Columna -->
                <div class="flex flex-col items-center text-justify px-5">
                    <a href="https://www.unitru.edu.pe/">
                        <div class="flex justify-center">
                            <img src="/user/template/images/logo_unt.png" class="w-full max-w-xs mb-4"
                                alt="FlowBite Logo" />
                        </div>
                        <p class="text-white text-base font-normal mb-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad provident nostrum praesentium
                            itaque, quisquam blanditiis unde sapiente odit
                        </p>
                    </a>
                    <div class="flex mt-4 sm:justify-center sm:mt-0 gap-4">
                        <a href="" class="text-white border-2 rounded p-1">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 8 19">
                                <path fill-rule="evenodd"
                                    d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="" class="text-white border-2 rounded p-1">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 17">
                                <path fill-rule="evenodd"
                                    d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="" class="text-white border-2 rounded p-1">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.51 8.796v1.697a3.74 3.74 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766c-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483a1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.6 1.6 0 0 1 1.6 1.606"
                                        clip-rule="evenodd" />
                                    <path d="M7.2 8.809H4V19.5h3.2z" />
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Segunda Columna -->
                <div class="flex flex-col items-center text-left">

                    <ul class="text-white font-medium space-y-4">
                        <h2 class="mb-6 text-xl font-semibold text-white uppercase">Contacto</h2>
                        <li>
                            <span>Celular: 123456789</span>
                        </li>
                        <li>
                            <span>Correo: correo@gmail.com</span>
                        </li>
                        <li>
                            <span>Dirección: Av. Juan Pablo II</span>
                        </li>
                    </ul>
                </div>

                <!-- Tercera Columna (Duplicado de la Primera) -->
                <div class="flex flex-col items-center text-justify px-5">
                    <a href="{{ route('home') }}">
                        <img src="/user/template/images/logoLabCam.png" class="w-full max-w-md  mb-4"
                            alt="Logo LabCam" />
                        <p class="text-white text-base font-normal mb-4">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad provident nostrum praesentium
                            itaque, quisquam blanditiis unde sapiente odit
                        </p>
                    </a>
                    <div class="flex mt-4 sm:justify-center sm:mt-0 gap-4">
                        <a href="" class="text-white border-2 rounded p-1">
                            <svg class="w-5 h-5 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 8 19">
                                <path fill-rule="evenodd"
                                    d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="" class="text-white border-2 rounded p-1">
                            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 17">
                                <path fill-rule="evenodd"
                                    d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="" class="text-white border-2 rounded p-1">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M12.51 8.796v1.697a3.74 3.74 0 0 1 3.288-1.684c3.455 0 4.202 2.16 4.202 4.97V19.5h-3.2v-5.072c0-1.21-.244-2.766-2.128-2.766c-1.827 0-2.139 1.317-2.139 2.676V19.5h-3.19V8.796h3.168ZM7.2 6.106a1.61 1.61 0 0 1-.988 1.483a1.595 1.595 0 0 1-1.743-.348A1.607 1.607 0 0 1 5.6 4.5a1.6 1.6 0 0 1 1.6 1.606"
                                        clip-rule="evenodd" />
                                    <path d="M7.2 8.809H4V19.5h3.2z" />
                                </g>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Cuarta Columna (Duplicado de la Segunda) -->
                <div class="flex flex-col items-center text-left">
                    <ul class="text-white font-medium space-y-4">
                        <h2 class="mb-6 text-xl font-semibold text-white uppercase">Contacto</h2>
                        <li>
                            <span>Celular: 123456789</span>
                        </li>
                        <li>
                            <span>Correo: correo@gmail.com</span>
                        </li>
                        <li>
                            <span>Dirección: Av. Juan Pablo II</span>
                        </li>
                    </ul>
                </div>
            </div>


            <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />

            <div class="sm:flex sm:items-center sm:justify-between">
                <span class="text-base text-white sm:text-center">© 2025 LabCam. All Rights Reserved.
                </span>
            </div>
        </div>
    </footer>

    <!-- Botón para desplazarse al inicio -->
    <div x-data="{ scrollTop: false }" x-init="window.addEventListener('scroll', () => scrollTop = window.scrollY > 50)" class="fixed bottom-4 right-4">
        <button x-show="scrollTop" x-cloak @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="bg-[#98C560] text-white p-3 rounded-md shadow-lg focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </div>

    <script>
        // Obtener la altura del navbar y agregarla a main
        window.addEventListener('load', function() {
            const navbarHeight = document.getElementById('navbar').offsetHeight;
            document.getElementById('main-content').style.marginTop = `${navbarHeight}px`;
        });

        // Actualizar en caso de que el tamaño de la ventana cambie
        window.addEventListener('resize', function() {
            const navbarHeight = document.getElementById('navbar').offsetHeight;
            document.getElementById('main-content').style.marginTop = `${navbarHeight}px`;
        });
    </script>

</body>

</html>
