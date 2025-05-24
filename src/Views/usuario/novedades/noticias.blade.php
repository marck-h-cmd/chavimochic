@extends('usuario.layout.plantilla')

@section('contenido')
    <section class="py-12">
        <div class="flex flex-col items-center gap-3 mb-12">
            <h2 class="text-blue-800 font-semibold text-4xl mb-1">Noticias</h2>
            <div class="blue-line w-1/3 h-0.5 bg-[#64d423]"></div>
        </div>

        <div class="px-10 max-w-screen-2xl mx-auto grid grid-cols-1 lg:grid-cols-3 sm:grid-cols-2 gap-10 lg:gap-14">
            @foreach ($noticias as $noticia)
                <!-- Tarjeta como un div normal -->
                <div
                    class="relative w-full bg-white shadow-md rounded-xl duration-500
                            hover:scale-105 hover:shadow-xl group overflow-hidden">

                    <!-- Imagen -->
                    <img src="{{ url('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}"
                        class="w-full h-[200px] object-cover rounded-t-xl" />

                    <!-- Texto -->
                    <div class="px-4 py-6 w-full min-h-[150px]">
                        <span class="text-gray-600 mr-3 uppercase text-base">
                            {{ \Carbon\Carbon::parse($noticia->fecha)->locale('es')->translatedFormat('d F, Y') }}
                        </span>
                        <p class="text-lg font-bold text-black truncate block capitalize mt-3 select-none">
                            {{ $noticia->titulo }}
                        </p>
                        <!-- Mostrar HTML de la descripción -->
                        @php
                            // Instancia la clase TruncateService usando el namespace completo
                            $truncateService = new \Urodoz\Truncate\TruncateService();
                            // Trunca la descripción a 120 caracteres y agrega '...'
                            $htmlSnippet = $truncateService->truncate($noticia->contenido, 200, '...');
                        @endphp

                        <div class="text-base font-normal text-black cursor-auto my-3 break-words select-none">
                            {!! $htmlSnippet !!}
                        </div>
                    </div>

                    <!-- Overlay con enlace “Leer más” -->
                    <div
                        class="absolute inset-0 bg-[#1E5397] bg-opacity-35 flex items-center justify-center
                                opacity-0 translate-y-full group-hover:opacity-100 group-hover:translate-y-0
                                transition-all duration-500 ease-in-out rounded-xl backdrop-blur-md">
                        <a href="{{ route('noticias.show', $noticia->id) }}"
                            class="text-white text-base font-semibold select-none bg-[#98C560]
                                  hover:bg-[#a6d073] px-3 py-2 rounded-lg cursor-pointer">
                            Leer más
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="flex justify-center mt-8">
            {{ $noticias->links() }}
        </div>
    </section>
@endsection
