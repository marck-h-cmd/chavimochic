@extends('usuario.layout.plantilla')

@section('contenido')
    <section class="py-12">
        <div class="flex flex-col items-center gap-3 mb-12">
            <h2 class="text-blue-800 font-semibold text-4xl mb-1">Eventos</h2>
            <div class="blue-line w-1/3 h-0.5 bg-[#64d423]"></div>
        </div>

      
        <div class="flex items-center justify-center">
           
            <a href="{{ route('eventos', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}"
                class="text-gray-500 hover:text-gray-800 transition mr-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
            </a>

            
            <span class="text-lg font-semibold text-gray-700 uppercase">
                {{ \Carbon\Carbon::createFromDate($year, $month, 1)->locale('es')->translatedFormat('F, Y') }}
            </span>

            
            <a href="{{ route('eventos', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}"
                class="text-gray-500 hover:text-gray-800 transition ml-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

      
        <div class="flex justify-center mt-4 mb-14 space-x-4">
           
            <a href="{{ route('eventos', ['category' => 'todo', 'month' => $month, 'year' => $year]) }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white transition">Todo</a>

           
            <a href="{{ route('eventos', ['category' => 'pasado', 'month' => $month, 'year' => $year]) }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white transition">Pasados</a>

            
            <a href="{{ route('eventos', ['category' => 'futuro', 'month' => $month, 'year' => $year]) }}"
                class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-blue-500 hover:text-white transition">Futuros</a>
        </div>

        <div class="px-10 max-w-screen-2xl mx-auto grid grid-cols-1 lg:grid-cols-3 sm:grid-cols-2 gap-10 lg:gap-14">
            @foreach ($eventos as $evento)
                <div
                    class="relative w-full bg-white shadow-md rounded-xl duration-500 hover:scale-105 hover:shadow-xl group overflow-hidden">
                    <a href="#" class="w-full h-full block">
                        <img src="{{ url('storage/' . $evento->imagen) }}" alt="{{ $evento->titulo }}"
                            class="w-full h-[200px] object-cover rounded-t-xl" />
                        <div class="px-4 pt-6 w-full min-h-[150px]">
                            <span class="text-gray-600 mr-3 uppercase text-base">
                                {{ \Carbon\Carbon::parse($evento->fecha)->locale('es')->translatedFormat('d F, Y') }}
                            </span>
                            <p class="text-lg font-bold text-black truncate block capitalize mt-3 select-none">
                                {{ $evento->titulo }}
                            </p>
                            <p class="text-base font-normal text-black cursor-auto my-3 break-words select-none">
                                Categoría:
                                @if ($evento->categoria === 'pasado')
                                    <span class="text-red-500 font-medium">{{ $evento->categoria }}</span>
                                @elseif ($evento->categoria === 'futuro')
                                    <span class="text-green-500 font-medium">{{ $evento->categoria }}</span>
                                @endif
                            </p>
                        </div>
                    </a>
                 
                    <div
                        class="absolute inset-0 bg-[#1E5397] bg-opacity-35 flex items-center justify-center opacity-0 translate-y-full group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500 ease-in-out rounded-xl backdrop-blur-md">
                        <a href="{{ route('eventos.show', $evento->id) }}"
                            class="text-white text-base font-semibold select-none bg-[#98C560] hover:bg-[#a6d073] px-3 py-2 rounded-lg cursor-pointer">
                            Leer más
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

       
        <div class="flex justify-center mt-8">
            {{ $eventos->links() }}
        </div>
    </section>
@endsection
