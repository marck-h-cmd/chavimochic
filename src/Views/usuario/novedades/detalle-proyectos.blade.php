@extends('usuario.layout.plantilla')

@section('contenido')
    <section class="pt-16 pb-2">
        <div class="max-w-4xl mx-auto">
            <!-- Encabezado -->
            <div class="flex items-center mb-8">
                <!-- Fecha -->
                <div class="bg-gray-800 text-white text-sm px-4 py-2 rounded-none mr-8 mt-9">
                    {{ \Carbon\Carbon::parse($proyecto->fecha_publicacion)->format('d/m/Y') }}
                </div>

                <!-- Titulo -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mt-20">{{ $proyecto->titulo }}</h1>
                    <h2 class="text-xl text-gray-600">{{ $proyecto->subtitulo }}</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Autor {{ $proyecto->autor }}
                    </p>

                </div>
            </div>

            <div class="flex-shrink-0 w-3/3">
                <img src="{{ url('storage/' . $proyecto->imagen) }}" alt="{{ $proyecto->titulo }}"
                    class="w-full rounded-lg shadow-md">
            </div>

            <!-- Contenido del proyecto -->
            <div style="max-width: 100%; margin-top: 1rem;">
                <article id="descripcion-articulo"
                    style="font-size: 1rem; color: #4A5568; line-height: 1.5; word-wrap: break-word;">
                    {!! $proyecto->descripcion !!}
                </article>
            </div>

            <!-- Botón para regresar -->
            <div class="mt-8 mb-4">
                <a href="{{ route('proyectos') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                    Volver
                </a>
            </div>
        </div>
    </section>
@endsection
