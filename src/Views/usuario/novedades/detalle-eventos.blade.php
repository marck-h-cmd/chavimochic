@extends('usuario.layout.plantilla')

@section('contenido')
    <section class="pt-16 pb-2">
        <div class="max-w-4xl mx-auto p-4">

            <div class="flex items-center mb-8">

                <div class="text-center">
                    <div class="bg-gray-800 text-white text-sm px-4 py-2 rounded-none mr-8 mt-20">
                        {{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}
                    </div>
                    <div class="bg-gray-600 text-white text-sm px-4 py-2 rounded-none mr-8 mt-1">
                        Categoría:
                        @if ($evento->categoria === 'pasado')
                            <span class="text-red-500">{{ $evento->categoria }}</span>
                        @elseif ($evento->categoria === 'futuro')
                            <span class="text-green-500">{{ $evento->categoria }}</span>
                        @endif
                    </div>
                </div>


                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mt-20">{{ $evento->titulo }}</h1>
                    <h2 class="text-xl text-gray-600">{{ $evento->subtitulo }}</h2>
                    <p class="text-sm text-gray-500 mt-2">
                        Autor {{ $evento->autor }}
                    </p>
                </div>
            </div>


            <div class="flex-shrink-0 w-3/3">
                <img src="{{ url('storage/' . $evento->imagen) }}" alt="{{ $evento->titulo }}"
                    class="w-full rounded-lg shadow-md">
            </div>

            <!-- <div class="flex mb-8">  -->

            <div style="max-width: 100%; margin-top: 1rem;">
                <article id="descripcion-articulo"
                    style="font-size: 1rem; color: #4A5568; line-height: 1.5; word-wrap: break-word;">
                    {!! $evento->descripcion !!}
                </article>
            </div>

            <!-- </div> -->

            <div class="mt-8 mb-4">
                <a href="{{ route('eventos') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-green-600 transition">
                    Volver
                </a>
            </div>
        </div>
    </section>

    <style>
        article a {
            color: #1E40AF;
            text-decoration: none;
        }

        article a:hover {
            text-decoration: underline;
        }

        article ul {
            list-style-type: disc;
            margin-left: 1.5rem;
        }

        article ol {
            list-style-type: decimal;
            margin-left: 1.5rem;
        }

        article li {
            margin-bottom: 0.5rem;
        }

        article a {
            color: #1E40AF;
            text-decoration: none;
        }

        article a:hover {
            text-decoration: underline;
        }

        article {
            font-size: 16px;
            line-height: 1.5;
        }

        article p {
            text-align: justify;
        }


        article .ql-size-small {
            font-size: 12px;
        }

        article .ql-size-large {
            font-size: 24px;
        }

        article .ql-size-huge {
            font-size: 32px;
        }

        article .ql-align-center {
            text-align: center;
        }

        article .ql-align-right {
            text-align: right;
        }

        article .ql-align-left {
            text-align: left;
        }
    </style>
@endsection
