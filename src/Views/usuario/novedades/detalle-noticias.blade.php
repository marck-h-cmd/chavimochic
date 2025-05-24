@extends('usuario.layout.plantilla')

@section('contenido')
    <section class="py-12">
        <div class="max-w-4xl mx-auto">
            <!-- Encabezado -->
            <div class="flex items-center mb-8">
                <!-- Fecha -->
                <div class="bg-gray-800 text-white text-sm px-4 py-2 rounded-none mr-8 mt-9">
                    {{ \Carbon\Carbon::parse($noticia->fecha)->format('d/m/Y') }}
                </div>

                <!-- Titulo y Subtitulo -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mt-20">{{ $noticia->titulo }}</h1>
                    <h2 class="text-xl text-gray-600">{{ $noticia->subtitulo }}</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Autor {{ $noticia->autor }}
                    </p>
                </div>
            </div>

            <!-- Imagen destacada  "{{ Storage::url($noticia->imagen) }}"-->
            <div class="flex-shrink-0 w-3/3">
                <img src="{{ url('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}"
                    class="w-full rounded-lg shadow-md">
            </div>

            <!-- <div class="flex mb-8"> -->
            <!-- Contenido de la noticia -->
            <div style="max-width: 100%; margin-top: 1rem;">
                <article id="descripcion-articulo"
                    style="font-size: 1rem; color: #4A5568; line-height: 1.5; word-wrap: break-word;">
                    {!! $noticia->contenido !!}
                </article>
            </div>
            <!-- </div> -->
            <!-- Botón para regresar -->
            <div class="mt-8 mb-4">
                <a href="{{ route('noticias') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                    Volver
                </a>
            </div>
        </div>
    </section>
@endsection
