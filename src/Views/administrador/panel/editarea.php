<?php
// require __DIR__ . '/../dash/plantilla.php';
?>
    <!-- <div class="max-w-screen-2xl mx-auto my-8 px-4">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2e5382]">Crear Seguimiento</h1>
            <div class="w-1/4 mx-auto h-0.5 bg-[#64d423]"></div>
           <div cl 
             ass="mx-auto mt-2 w-1/5 h-1 bg-green-400"></div> 
        </div>
        <form id="form" action="{{ route('notici.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                 

                 
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <div class="space-y-1">
                           
                            <div>
                                <label for="titulo" class="block text-gray-700 text-sm">TIPO_DOC</label>
                                <input type="text" id="titulo" name="titulo"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    required>
                            </div>

                            <div>
                                <label for="titulo" class="block text-gray-700 text-sm">N_DOCUMENTO</label>
                                <input type="text" id="titulo" name="titulo"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>
                            <div>
                                <label for="titulo" class="block text-gray-700 text-sm">AREA_USUARIA</label>
                                <input type="text" id="titulo" name="titulo"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>
                            <div>
                                <label for="fecha" class="block text-gray-700 text-sm">F_EMISION</label>
                                <input type="date" id="fecha" name="fecha" min="{{ date('Y-m-d') }}"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 "
                                    >
                            </div>

                            <div>
                                <label for="titulo" class="block text-gray-700 text-sm">AREA_RECEPTORA</label>
                                <input type="text" id="titulo" name="titulo"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>
                            <div>
                                <label for="fecha" class="block text-gray-700 text-sm">F_RECEPCION</label>
                                <input type="date" id="fecha" name="fecha" min="{{ date('Y-m-d') }}"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 "
                                    >
                            </div>
                           
                        </div>
                        
                    
                        <div class="space-y-4">
                           
                             <div>
                                <label for="contenido" class="block text-gray-700">SINTESIS_DEL_ASUNTO</label>
                                <textarea id="contenido" name="contenido" rows="2"
                                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </textarea>
                            </div>

                            <div>
                                <label for="titulo" class="block text-gray-700 text-sm">PLAZO_DE_ATENCION</label>
                                <input type="text" id="titulo" name="titulo"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>

                            <div>
                                <label for="titulo" class="block text-gray-700 text-sm">SEMAFORO_DE_COLORES</label>
                                <input type="text" id="titulo" name="titulo"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>
                         
                        </div>
                    </div>

               
                    <div class="flex justify-end space-x-4">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Guardar
                        </button>
                        <a href="/chavimochic/src/Views/administrador/panel/show.php" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700">
                            Volver
                        </a>
                    </div>
                </form>
    <div class="max-w-screen-2xl mx-auto my-8 px-4">
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-sm text-left text-gray-600 table-fixed">
                <thead class="bg-gray-200 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3">TIPO_DOC</th>
                        <th class="px-4 py-3">N_DOCUMENTO</th>
                        <th class="px-4 py-3">AREA_USUARIA</th>
                        <th class="px-4 py-3">F_EMISION</th>
                        <th class="px-4 py-3">AREA_RECEPTORA</th>
                        <th class="px-4 py-3">F_RECEPCION</th>
                        <th class="px-4 py-3 w-60">SINTESIS_DEL_ASUNTO</th>
                        <th class="px-4 py-3">PLAZO_DE_ATENCION</th>
                        <th class="px-4 py-3">SEMAFORO_DE_COLORES</th>
                        <th class="px-4 py-3">F_CREACION</th>
                        <th class="px-4 py-3">F_EDICION</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  
                        @php
                            // Instancia la clase TruncateService usando el namespace completo
                            $truncateService = new \Urodoz\Truncate\TruncateService();
                            // Trunca la contenido a 100 caracteres y agrega '...'
                            $htmlSnippet = $truncateService->truncate($noticia->contenido, 100, '...');
                      
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1 w-full whitespace-normal break-all"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-2 py-1"> </td>
                            <td class="px-4 py-3 flex items-center justify-center space-x-4">
                                <button type="button" onclick="openEditModal(this)" class="text-yellow-500 hover:text-yellow-700 flex items-center justify-center mt-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 3l3 3-8 8H3v-3l8-8z" />
                                    </svg>
                                </button>
                               
                               <button onclick="openDeleteModal({{ $noticia->id }}, '{{ $noticia->titulo }}')" class="text-red-500 hover:text-red-700 flex items-center justify-center">
                                   <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                       <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2M10 11v6M14 11v6M5 6h14l1 16a1 1 0 01-1 1H5a1 1 0 01-1-1L5 6z" />
                                   </svg>
                               </button>
                            </td>
                        </tr>
                 
                </tbody>
            </table>
        </div>

       
      </div>
    </div>

       <script>
        tinymce.init({
            selector: '#contenido',
            language: 'es_MX',
            branding: false,
            menubar: false,
            height: 150,
            relative_urls: false,
            remove_script_host: false,
            plugins: 'autolink lists link image charmap preview anchor code',
            toolbar: 'undo redo | formatselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | removeformat | code',
            statusbar: false,
            link_title: false, // No se mostrará el campo de título en el diálogo de enlace
            link_target_list: [{
                    title: 'Misma ventana',
                    value: '_self'
                },
                {
                    title: 'Nueva ventana',
                    value: '_blank'
                }
            ]
        });
    </script> -->
<?php