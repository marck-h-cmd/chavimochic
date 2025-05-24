<?php
// require __DIR__ . '/../dash/plantilla.php';
?>
    <div class="max-w-screen-2xl mx-auto my-8 px-4">
        <!-- Sección de detalles de contacto -->
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#2e5382]">Área (SIGLAS)</h1>
            <div class="w-1/4 mx-auto h-0.5 bg-[#64d423]"></div>
        </div>

        <div class="flex justify-between mb-6">
            <div class="flex space-x-4">
                <input type="text" id="search" placeholder="Buscar por Item, Emision o Documento" class="px-4 py-2 border rounded"
                    oninput="buscarRequerimientos(this.value)">
            </div>
            <button class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700" onclick="openCreateModal()">
                Crear
            </button>
        </div>

        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full text-sm text-left text-gray-600 table-fixed">
                <thead class="bg-gray-200 text-gray-700 uppercase">
                    <tr>
                        <th class="px-4 py-3">ITEM</th>
                        <th class="px-4 py-3">N_EMISION</th>
                        <th class="px-4 py-3">TIPO_DOC</th>
                        <th class="px-4 py-3">N_DOCUMENTO</th>
                        <th class="px-4 py-3">B_S_O</th>
                        <th class="px-4 py-3">MONTO_HOJA_SIGA</th>
                        <th class="px-4 py-3">AREA_USUARIA</th>
                        <th class="px-4 py-3">F_EMISION</th>
                        <th class="px-4 py-3">AREA_RECEPTORA</th>
                        <th class="px-4 py-3">F_RECEPCION</th>
                        <th class="px-4 py-3 w-60">SINTESIS_DEL_ASUNTO</th>
                        <th class="px-4 py-3">PLAZO_DE_ATENCION</th>
                        <th class="px-4 py-3">SEMAFORO_DE_COLORES</th>
                        <th class="px-4 py-3">MONTO_CP</th>
                        <th class="px-4 py-3">MONTO_CONTRATO</th>
                        <th class="px-4 py-3">CONTRATO</th>
                        <th class="px-4 py-3">ENTREGABLES</th>
                        <th class="px-4 py-3">PAGOS_ACUMULADO</th>
                        <th class="px-4 py-3">DEVENGADO_ACUMULADO</th>
                        <th class="px-4 py-3">EJECUCION_CONTRACTUAL</th>
                        <th class="px-4 py-3">ESTADO</th>
                        <th class="px-4 py-3">OEPS</th>
                        <th class="px-4 py-3">PROCESO</th>
                        <th class="px-4 py-3">INDAGACION_MERCADO</th>
                        <th class="px-4 py-3">CONFORMACION_EXP_CONTRATACION</th>
                        <th class="px-4 py-3">APROBACION_BASES</th>
                        <th class="px-4 py-3">CONVOCATORIA</th>
                        <th class="px-4 py-3">REGISTRO_PARTICIPANTES</th>
                        <th class="px-4 py-3">CONSULTAS_OBSERVACIONES</th>
                        <th class="px-4 py-3">INTEGRACION_BASES</th>
                        <th class="px-4 py-3">PRESENTACION_OFERTAS</th>
                        <th class="px-4 py-3">EVALUACION_CALIFICACION</th>
                        <th class="px-4 py-3">BUENA_PRO</th>
                        <th class="px-4 py-3">PRESENTACION_DOCS_PARA_CONTRATO</th>
                        <th class="px-4 py-3">F_FIRMA_CONTRATO</th>
                        <th class="px-4 py-3">RESULTADO</th>
                        <th class="px-4 py-3">F_CREACION</th>
                        <th class="px-4 py-3">F_EDICION</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <script>
        function cargarRequerimientos() {
            fetch('/chavimochic/src/obtener_requerimientos.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.querySelector('table tbody');
                    tbody.innerHTML = ''; // Limpiar la tabla

                    if (data && Array.isArray(data)) {
                        data.forEach(requerimiento => {
                            const row = tbody.insertRow();
                            row.classList.add('border-b', 'hover:bg-gray-50');
                            row.innerHTML = `
                                <td class="px-2 py-1">${requerimiento.ITEM || ''}</td>
                                <td class="px-2 py-1">${requerimiento.N_EMISION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.TIPO_DOC || ''}</td>
                                <td class="px-2 py-1">${requerimiento.N_DOCUMENTO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.B_S_O || ''}</td>
                                <td class="px-2 py-1">${requerimiento.MONTO_HOJA_SIGA || ''}</td>
                                <td class="px-2 py-1">${requerimiento.AREA_USUARIA || ''}</td>
                                <td class="px-2 py-1">${requerimiento.F_EMISION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.AREA_RECEPTORA || ''}</td>
                                <td class="px-2 py-1">${requerimiento.F_RECEPCION || ''}</td>
                                <td class="px-2 py-1 w-full whitespace-normal break-all">${requerimiento.SINTESIS_DEL_ASUNTO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PLAZO_DE_ATENCION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.SEMAFORO_DE_COLORES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.MONTO_CP || ''}</td>
                                <td class="px-2 py-1">${requerimiento.MONTO_CONTRATO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONTRATO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.ENTREGABLES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PAGOS_ACUMULADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.DEVENGADO_ACUMULADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.EJECUCION_CONTRACTUAL || ''}</td>
                                <td class="px-2 py-1">${requerimiento.ESTADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.OEPS || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PROCESO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.INDAGACION_MERCADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONFORMACION_EXP_CONTRATACION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.APROBACION_BASES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONVOCATORIA || ''}</td>
                                <td class="px-2 py-1">${requerimiento.REGISTRO_PARTICIPANTES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONSULTAS_OBSERVACIONES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.INTEGRACION_BASES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PRESENTACION_OFERTAS || ''}</td>
                                <td class="px-2 py-1">${requerimiento.EVALUACION_CALIFICACION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.BUENA_PRO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PRESENTACION_DOCS_PARA_CONTRATO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.F_FIRMA_CONTRATO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.RESULTADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.f_creacion || ''}</td>
                                <td class="px-2 py-1">${requerimiento.f_edicion || ''}</td>
                                <td class="px-4 py-3 flex items-center justify-center space-x-4">
                                    <a
                                        href="/chavimochic/src/Views/administrador/panel/seguimientoarea.php?id=${requerimiento.id}"
                                        class="text-blue-500 hover:text-blue-700 flex items-center justify-center"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-9 w-9"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M4 9a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4a1 1 0 0 1 1 1v4a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-4a1 1 0 0 1 1-1h4a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-4a1 1 0 0 1-1-1V4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4a1 1 0 0 1-1 1z"/>
                                        </svg>
                                    </a>

                                    <a href="/chavimochic/src/Views/administrador/panel/edit.php?id=${requerimiento.id}" 
                                       class="text-yellow-500 hover:text-yellow-700 flex items-center justify-center mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3l3 3-8 8H3v-3l8-8z" />
                                        </svg>
                                    </a>

                                   <button onclick="openDeleteModal(${requerimiento.id}, '${requerimiento.ITEM}')" class="text-red-500 hover:text-red-700 flex items-center justify-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                           <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2M10 11v6M14 11v6M5 6h14l1 16a1 1 0 01-1 1H5a1 1 0 01-1-1L5 6z" />
                                       </svg>
                                   </button>
                                </td>
                            `;
                        });
                    } else if (data && data.error) {
                        console.error(data.error);
                        // Aquí podrías mostrar un mensaje de error al usuario
                    }
                })
                .catch(error => {
                    console.error('Error al cargar los requerimientos:', error);
                    // Aquí podrías mostrar un mensaje de error al usuario
                });
        }

        document.addEventListener('DOMContentLoaded', cargarRequerimientos);

        function buscarNoticias(query) {
            fetch(`/chavimochic/src/buscar_requerimientos.php?search=${encodeURIComponent(query)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = ''; // Limpiar la tabla

                if (data && Array.isArray(data)) {
                    data.forEach(requerimiento => {
                        const row = tbody.insertRow();
                        row.classList.add('border-b', 'hover:bg-gray-50');
                        row.innerHTML = `
                            <td class="px-2 py-1">${requerimiento.ITEM || ''}</td>
                            <td class="px-2 py-1">${requerimiento.N_EMISION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.TIPO_DOC || ''}</td>
                            <td class="px-2 py-1">${requerimiento.N_DOCUMENTO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.B_S_O || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_HOJA_SIGA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.AREA_USUARIA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.F_EMISION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.AREA_RECEPTORA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.F_RECEPCION || ''}</td>
                            <td class="px-2 py-1 w-full whitespace-normal break-all">${requerimiento.SINTESIS_DEL_ASUNTO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PLAZO_DE_ATENCION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.SEMAFORO_DE_COLORES || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_CP || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_CONTRATO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.CONTRATO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.ENTREGABLES || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PAGOS_ACUMULADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.DEVENGADO_ACUMULADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.EJECUCION_CONTRACTUAL || ''}</td>
                            <td class="px-2 py-1">${requerimiento.ESTADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.OEPS || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PROCESO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.INDAGACION_MERCADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONFORMACION_EXP_CONTRATACION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.APROBACION_BASES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONVOCATORIA || ''}</td>
                                <td class="px-2 py-1">${requerimiento.REGISTRO_PARTICIPANTES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONSULTAS_OBSERVACIONES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.INTEGRACION_BASES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PRESENTACION_OFERTAS || ''}</td>
                                <td class="px-2 py-1">${requerimiento.EVALUACION_CALIFICACION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.BUENA_PRO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PRESENTACION_DOCS_PARA_CONTRATO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.F_FIRMA_CONTRATO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.RESULTADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.f_creacion || ''}</td>
                                <td class="px-2 py-1">${requerimiento.f_edicion || ''}</td>
                                <td class="px-4 py-3 flex items-center justify-center space-x-4">
                                    <a
                                        href="/chavimochic/src/Views/administrador/panel/seguimientoarea.php?id=${requerimiento.id}"
                                        class="text-blue-500 hover:text-blue-700 flex items-center justify-center"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-9 w-9"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M4 9a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4a1 1 0 0 1 1 1v4a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-4a1 1 0 0 1 1-1h4a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-4a1 1 0 0 1-1-1V4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4a1 1 0 0 1-1 1z"/>
                                        </svg>
                                    </a>

                                    <a href="/chavimochic/src/Views/administrador/panel/edit.php?id=${requerimiento.id}" 
                                       class="text-yellow-500 hover:text-yellow-700 flex items-center justify-center mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3l3 3-8 8H3v-3l8-8z" />
                                        </svg>
                                    </a>

                                   <button onclick="openDeleteModal(${requerimiento.id}, '${requerimiento.ITEM}')" class="text-red-500 hover:text-red-700 flex items-center justify-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                           <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2M10 11v6M14 11v6M5 6h14l1 16a1 1 0 01-1 1H5a1 1 0 01-1-1L5 6z" />
                                       </svg>
                                   </button>
                                </td>
                        `;
                    });
                } else if (data && data.error) {
                    console.error(data.error);
                    tbody.innerHTML = '<tr><td colspan="24" class="text-center text-red-500">Error al cargar los datos.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error al buscar los requerimientos:', error);
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '<tr><td colspan="24" class="text-center text-red-500">Error al cargar los datos.</td></tr>';
            });
        }

        function buscarRequerimientos(query) {
            fetch(`/chavimochic/src/buscar_requerimientos.php?search=${encodeURIComponent(query)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = ''; // Limpiar la tabla

                if (data && Array.isArray(data)) {
                    data.forEach(requerimiento => {
                        const row = tbody.insertRow();
                        row.classList.add('border-b', 'hover:bg-gray-50');
                        row.innerHTML = `
                            <td class="px-2 py-1">${requerimiento.ITEM || ''}</td>
                            <td class="px-2 py-1">${requerimiento.N_EMISION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.TIPO_DOC || ''}</td>
                            <td class="px-2 py-1">${requerimiento.N_DOCUMENTO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.B_S_O || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_HOJA_SIGA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.AREA_USUARIA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.F_EMISION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.AREA_RECEPTORA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.F_RECEPCION || ''}</td>
                            <td class="px-2 py-1 w-full whitespace-normal break-all">${requerimiento.SINTESIS_DEL_ASUNTO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PLAZO_DE_ATENCION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.SEMAFORO_DE_COLORES || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_CP || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_CONTRATO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.CONTRATO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.ENTREGABLES || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PAGOS_ACUMULADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.DEVENGADO_ACUMULADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.EJECUCION_CONTRACTUAL || ''}</td>
                            <td class="px-2 py-1">${requerimiento.ESTADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.OEPS || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PROCESO || ''}</td>
                        <td class="px-2 py-1">${requerimiento.INDAGACION_MERCADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONFORMACION_EXP_CONTRATACION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.APROBACION_BASES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONVOCATORIA || ''}</td>
                                <td class="px-2 py-1">${requerimiento.REGISTRO_PARTICIPANTES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.CONSULTAS_OBSERVACIONES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.INTEGRACION_BASES || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PRESENTACION_OFERTAS || ''}</td>
                                <td class="px-2 py-1">${requerimiento.EVALUACION_CALIFICACION || ''}</td>
                                <td class="px-2 py-1">${requerimiento.BUENA_PRO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.PRESENTACION_DOCS_PARA_CONTRATO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.F_FIRMA_CONTRATO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.RESULTADO || ''}</td>
                                <td class="px-2 py-1">${requerimiento.f_creacion || ''}</td>
                                <td class="px-2 py-1">${requerimiento.f_edicion || ''}</td>
                                <td class="px-4 py-3 flex items-center justify-center space-x-4">
                                    <a
                                        href="/chavimochic/src/Views/administrador/panel/seguimientoarea.php?id=${requerimiento.id}"
                                        class="text-blue-500 hover:text-blue-700 flex items-center justify-center"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-9 w-9"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path d="M4 9a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h4a1 1 0 0 1 1 1v4a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2v-4a1 1 0 0 1 1-1h4a2 2 0 0 0 2-2v-2a2 2 0 0 0-2-2h-4a1 1 0 0 1-1-1V4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4a1 1 0 0 1-1 1z"/>
                                        </svg>
                                    </a>

                                    <a href="/chavimochic/src/Views/administrador/panel/edit.php?id=${requerimiento.id}" 
                                       class="text-yellow-500 hover:text-yellow-700 flex items-center justify-center mt-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 3l3 3-8 8H3v-3l8-8z" />
                                        </svg>
                                    </a>

                                   <button onclick="openDeleteModal(${requerimiento.id}, '${requerimiento.ITEM}')" class="text-red-500 hover:text-red-700 flex items-center justify-center">
                                       <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                           <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2M10 11v6M14 11v6M5 6h14l1 16a1 1 0 01-1 1H5a1 1 0 01-1-1L5 6z" />
                                       </svg>
                                   </button>
                                </td>
                        `;
                    });
                } else if (data && data.error) {
                    console.error(data.error);
                    tbody.innerHTML = '<tr><td colspan="24" class="text-center text-red-500">Error al cargar los datos.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error al buscar los requerimientos:', error);
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '<tr><td colspan="24" class="text-center text-red-500">Error al cargar los datos.</td></tr>';
            });
        }

        // (Tu código JavaScript existente para los modales y la búsqueda)
        // ...
    </script>
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="flex justify-end text-sm mt-4">
            <!-- {{ $notici->links('pagination::tailwind') }} -->
        </div>
    </div>

    <!-- Modal Crear -->
    <div id="createModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 w-full h-full">
        <div class="flex items-center justify-center w-full h-full">
            <!-- Se aumentó el ancho máximo a max-w-5xl para que el modal sea más ancho -->
            <div class="bg-white px-8 py-6 rounded-lg shadow-xl max-w-6xl w-full relative max-h-screen overflow-y-auto">
                <!-- Título centrado -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-semibold text-blue-800">Crear Requerimiento</h2>
                    <div class="mx-auto mt-2 w-1/5 h-1 bg-green-400"></div>
                </div>

                <!-- Formulario -->
                <form id="form" action="/chavimochic/src/store_requerimiento.php" method="POST" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1"> 

                    <!-- Contenedor principal con Grid (2 columnas en md+) -->
                            <div>
                                <label for="ITEM" class="block text-gray-700 text-sm">ITEM</label>
                                <input type="text" id="ITEM" name="ITEM"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    required>
                            </div>

                            <div>
                                <label for="N_EMISION" class="block text-gray-700 text-sm">N_EMISION</label>
                                <input type="number" id="N_EMISION" name="N_EMISION"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="B_S_O" class="block text-gray-700 text-sm">B_S_O</label>
                                <input type="text" id="B_S_O" name="B_S_O" maxlength="1"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>

                            <div>
                                <label for="TIPO_DOC" class="block text-gray-700 text-sm">TIPO_DOC</label>
                                <input type="text" id="TIPO_DOC" name="TIPO_DOC"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>

                            <div>
                                <label for="N_DOCUMENTO" class="block text-gray-700 text-sm">N_DOCUMENTO</label>
                                <input type="number" id="N_DOCUMENTO" name="N_DOCUMENTO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="AREA_USUARIA" class="block text-gray-700 text-sm">AREA_USUARIA</label>
                                <input type="text" id="AREA_USUARIA" name="AREA_USUARIA"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>

                            <div>
                                <label for="F_EMISION" class="block text-gray-700 text-sm">F_EMISION</label>
                                <input type="date" id="F_EMISION" name="F_EMISION"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 "
                                    >
                            </div>

                            <div>
                                <label for="AREA_RECEPTORA" class="block text-gray-700 text-sm">AREA_RECEPTORA</label>
                                <input type="text" id="AREA_RECEPTORA" name="AREA_RECEPTORA"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
                                    >
                            </div>

                            <div>
                                <label for="F_RECEPCION" class="block text-gray-700 text-sm">F_RECEPCION</label>
                                <input type="date" id="F_RECEPCION" name="F_RECEPCION"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 ">
                            </div>

                            <div>
                                <label for="SINTESIS_DEL_ASUNTO" class="block text-gray-700">SINTESIS_DEL_ASUNTO</label>
                                <textarea id="SINTESIS_DEL_ASUNTO" name="SINTESIS_DEL_ASUNTO" rows="2"
                                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </textarea>
                            </div>

                            <div>
                                <label for="MONTO_HOJA_SIGA" class="block text-gray-700 text-sm">MONTO_HOJA_SIGA</label>
                                <input type="number" step="0.01" id="MONTO_HOJA_SIGA" name="MONTO_HOJA_SIGA"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="MONTO_CP" class="block text-gray-700 text-sm">MONTO_CP</label>
                                <input type="number" step="0.01" id="MONTO_CP" name="MONTO_CP"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="MONTO_CONTRATO" class="block text-gray-700 text-sm">MONTO_CONTRATO</label>
                                <input type="number" step="0.01" id="MONTO_CONTRATO" name="MONTO_CONTRATO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="CONTRATO" class="block text-gray-700 text-sm">CONTRATO</label>
                                <input type="text" id="CONTRATO" name="CONTRATO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="ENTREGABLES" class="block text-gray-700 text-sm">ENTREGABLES</label>
                                <input type="number" id="ENTREGABLES" name="ENTREGABLES"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="PAGOS_ACUMULADO" class="block text-gray-700 text-sm">PAGOS_ACUMULADO</label>
                                <input type="number" id="PAGOS_ACUMULADO" name="PAGOS_ACUMULADO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="ESTADO" class="block text-gray-700 text-sm">ESTADO</label>
                                <input type="text" id="ESTADO" name="ESTADO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="OEPS" class="block text-gray-700 text-sm">OEPS</label>
                                <input type="text" id="OEPS" name="OEPS"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="PROCESO" class="block text-gray-700 text-sm">PROCESO</label>
                                <input type="text" id="PROCESO" name="PROCESO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="INDAGACION_MERCADO" class="block text-gray-700 text-sm">INDAGACION_MERCADO</label>
                                <input type="text" id="INDAGACION_MERCADO" name="INDAGACION_MERCADO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="CONFORMACION_EXP_CONTRATACION" class="block text-gray-700 text-sm">CONFORMACION_EXP_CONTRATACION</label>
                                <input type="text" id="CONFORMACION_EXP_CONTRATACION" name="CONFORMACION_EXP_CONTRATACION"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="APROBACION_BASES" class="block text-gray-700 text-sm">APROBACION_BASES</label>
                                <input type="datetime-local" id="APROBACION_BASES" name="APROBACION_BASES"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="CONVOCATORIA" class="block text-gray-700 text-sm">CONVOCATORIA</label>
                                <input type="date" id="CONVOCATORIA" name="CONVOCATORIA"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="REGISTRO_PARTICIPANTES" class="block text-gray-700 text-sm">REGISTRO_PARTICIPANTES</label>
                                <input type="date" id="REGISTRO_PARTICIPANTES" name="REGISTRO_PARTICIPANTES"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="CONSULTAS_OBSERVACIONES" class="block text-gray-700 text-sm">CONSULTAS_OBSERVACIONES</label>
                                <input type="date" id="CONSULTAS_OBSERVACIONES" name="CONSULTAS_OBSERVACIONES"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="INTEGRACION_BASES" class="block text-gray-700 text-sm">INTEGRACION_BASES</label>
                                <input type="date" id="INTEGRACION_BASES" name="INTEGRACION_BASES"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="PRESENTACION_OFERTAS" class="block text-gray-700 text-sm">PRESENTACION_OFERTAS</label>
                                <input type="date" id="PRESENTACION_OFERTAS" name="PRESENTACION_OFERTAS"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="EVALUACION_CALIFICACION" class="block text-gray-700 text-sm">EVALUACION_CALIFICACION</label>
                                <input type="date" id="EVALUACION_CALIFICACION" name="EVALUACION_CALIFICACION"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="BUENA_PRO" class="block text-gray-700 text-sm">BUENA_PRO</label>
                                <input type="date" id="BUENA_PRO" name="BUENA_PRO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="PRESENTACION_DOCS_PARA_CONTRATO" class="block text-gray-700 text-sm">PRESENTACION_DOCS_PARA_CONTRATO</label>
                                <input type="date" id="PRESENTACION_DOCS_PARA_CONTRATO" name="PRESENTACION_DOCS_PARA_CONTRATO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>

                            <div>
                                <label for="F_FIRMA_CONTRATO" class="block text-gray-700 text-sm">F_FIRMA_CONTRATO</label>
                                <input type="date" id="F_FIRMA_CONTRATO" name="F_FIRMA_CONTRATO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                            <div>
                                <label for="RESULTADO" class="block text-gray-700 text-sm">RESULTADO</label>
                                <input type="text" id="RESULTADO" name="RESULTADO"
                                    class="mt-1 w-full px-1 py-0.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-center gap-4 mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Guardar
                        </button>
                        <button type="button" onclick="closeCreateModal()"
                            class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-700">
                            Cancelar
                        </button>
                    </div>
                </form>
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
            link_title: false,
            link_target_list: [
                { title: 'Misma ventana', value: '_self' },
                { title: 'Nueva ventana', value: '_blank' }
            ]
        });
    </script>

    <!-- Modal Editar -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 w-full h-full">
        <div class="flex items-center justify-center w-full h-full">
            <div class="bg-white px-8 py-6 rounded-lg shadow-xl max-w-6xl w-full relative max-h-screen overflow-y-auto">
                <!-- Título centrado -->
                <div class="text-center mb-8">
                    <h2 class="text-2xl font-semibold text-blue-800">Editar Seguimiento</h2>
                    <div class="mx-auto mt-2 w-1/5 h-1 bg-green-400"></div>
                </div>

                <!-- Formulario -->
                <form id="editForm" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Columna Izquierda -->
                        <div class="space-y-4">
                            <div>
                                <label for="edit_titulo" class="block text-gray-700">ITEM</label>
                                <input type="text" id="edit_titulo" name="edit_titulo"
                                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div>
                                <label for="edit_subtitulo" class="block text-gray-700">N Emisión</label>
                                <input type="text" id="edit_subtitulo" name="edit_subtitulo"
                                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="edit_autor" class="block text-gray-700">N Documento</label>
                                <input type="text" id="edit_autor" name="edit_autor"
                                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                            </div>
                            <div>
                                <label for="edit_fecha" class="block text-gray-700">Fecha Emisión</label>
                                <input type="date" id="edit_fecha" name="edit_fecha" min="{{ date('Y-m-d') }}"
                                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    >
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="space-y-4">
                            <div>
                                <label for="edit_contenido" class="block text-gray-700">Tipo Doc</label>
                                <textarea id="edit_contenido" name="edit_contenido" rows="7"
                                    class="mt-1 w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-center gap-4 mt-6">
                        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Actualizar
                        </button>
                        <button type="button" onclick="closeEditModal()"
                            class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-700">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        tinymce.init({
            selector: '#edit_contenido',
            language: 'es_MX',
            branding: false,
            menubar: false,
            height: 240,
            relative_urls: false,
            remove_script_host: false,
            plugins: 'autolink lists link image charmap preview anchor code',
            toolbar: 'undo redo | formatselect | bold italic underline forecolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | removeformat | code',
            statusbar: false,
            link_title: false,
            link_target_list: [
                { title: 'Misma ventana', value: '_self' },
                { title: 'Nueva ventana', value: '_blank' }
            ]
        });
    </script>

    <!-- Modal Eliminar -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 w-full h-full">
        <div class="flex items-center justify-center w-full h-full">
            <div class="bg-white p-7 rounded shadow-lg max-w-md w-full relative">
                <button class="absolute top-0.5 right-0.5 text-gray-500 hover:text-black text-3xl p-2"
                    onclick="closeDeleteModal()">&times;</button>
                <h2 class="text-xl font-bold mb-4">Eliminar Requerimiento</h2>
                <p>¿Estás seguro de que deseas eliminar el requerimiento "<span id="requerimientoTitulo"></span>"?</p>

                <!-- Formulario de eliminación -->
                <form id="deleteForm" method="POST" action="/chavimochic/src/delete_requerimiento.php" class="mt-4">
                    <input type="hidden" name="id" id="deleteRequerimientoId">
                    <button type="submit" class="bg-red-500 text-white px-6 py-2 rounded hover:bg-red-700">Aceptar</button>
                    <button type="button" onclick="closeDeleteModal()" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-700 mt-2">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

    
    <!-- @if (session('success')) 
        <script>
            Swal.fire({
                title: "Creado!",
                text: "{{ session('success') }}",
                icon: "success",

                customClass: {
                    confirmButton: 'bg-green-500 text-white hover:bg-green-600 focus:ring-2 focus:ring-green-300 rounded-lg py-2 px-4'
                }
            });
        </script>

     @elseif(session('edit')) 
        <script>
            Swal.fire({
                title: "Actualizado!",
                text: "{{ session('edit') }}",
                icon: "success",
                customClass: {
                    confirmButton: 'bg-green-500 text-white hover:bg-green-600 focus:ring-2 focus:ring-green-300 rounded-lg py-2 px-4'
                }
            });
        </script>
    @elseif (session('destroy')) 
        <script>
            Swal.fire({
                title: "Eliminado!",
                text: " ",
                icon: "success",
                customClass: {
                    confirmButton: 'bg-green-500 text-white hover:bg-green-600 focus:ring-2 focus:ring-green-300 rounded-lg py-2 px-4'
                }
            });
        </script> 
     @elseif (session('error')) 
        <script>
            Swal.fire({
                icon: 'error',
                title: '¡Hubo un error!',
                html: " ",
                showConfirmButton: true,
                confirmButtonText: 'Aceptar'
                customClass: {
                    confirmButton: 'bg-red-500 text-white hover:bg-red-600 focus:ring-2 focus:ring-red-300 rounded-lg py-2 px-4'
                }
            });
        </script>
    @endif -->

    <script>
        // Abre el modal
        function openCreateModal() {
            document.getElementById('createModal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.add('hidden');
            const formElement = document.getElementById('form');
            if (formElement) {
                formElement.reset();
            }
        }

        function openEditModal(button) {
            let noticia = JSON.parse(button.getAttribute('data-noticia'));
            document.getElementById('edit_titulo').value = noticia.titulo;
            document.getElementById('edit_subtitulo').value = noticia.subtitulo;
            document.getElementById('edit_autor').value = noticia.autor;
            document.getElementById('edit_fecha').value = noticia.fecha;
            tinymce.get('edit_contenido').setContent(noticia.contenido || '');
            document.getElementById('editForm').action = `/admin/areausuaria/${noticia.id}`;
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editForm').reset();
        }

        function openDeleteModal(id, titulo) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('requerimientoTitulo').innerText = titulo;
            document.getElementById('deleteRequerimientoId').value = id;
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function buscarNoticias(query) {
            fetch(`/chavimochic/src/buscar_requerimientos.php?search=${encodeURIComponent(query)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = ''; // Limpiar la tabla

                if (data && Array.isArray(data)) {
                    data.forEach(requerimiento => {
                        const row = tbody.insertRow();
                        row.classList.add('border-b', 'hover:bg-gray-50');
                        row.innerHTML = `
                            <td class="px-2 py-1">${requerimiento.ITEM || ''}</td>
                            <td class="px-2 py-1">${requerimiento.N_EMISION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.TIPO_DOC || ''}</td>
                            <td class="px-2 py-1">${requerimiento.N_DOCUMENTO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.B_S_O || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_HOJA_SIGA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.AREA_USUARIA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.F_EMISION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.AREA_RECEPTORA || ''}</td>
                            <td class="px-2 py-1">${requerimiento.F_RECEPCION || ''}</td>
                            <td class="px-2 py-1 w-full whitespace-normal break-all">${requerimiento.SINTESIS_DEL_ASUNTO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PLAZO_DE_ATENCION || ''}</td>
                            <td class="px-2 py-1">${requerimiento.SEMAFORO_DE_COLORES || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_CP || ''}</td>
                            <td class="px-2 py-1">${requerimiento.MONTO_CONTRATO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.CONTRATO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.ENTREGABLES || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PAGOS_ACUMULADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.DEVENGADO_ACUMULADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.EJECUCION_CONTRACTUAL || ''}</td>
                            <td class="px-2 py-1">${requerimiento.ESTADO || ''}</td>
                            <td class="px-2 py-1">${requerimiento.OEPS || ''}</td>
                            <td class="px-2 py-1">${requerimiento.PROCESO || ''}</td>
                        `;
                    });
                } else if (data && data.error) {
                    console.error(data.error);
                    tbody.innerHTML = '<tr><td colspan="24" class="text-center text-red-500">Error al cargar los datos.</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error al buscar los requerimientos:', error);
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '<tr><td colspan="24" class="text-center text-red-500">Error al cargar los datos.</td></tr>';
            });
        }

        function openModal(fileUrl, fileType) {
            const modal = document.getElementById('archivoModal');
            const modalContent = document.getElementById('modalContent');
            if (fileType === 'image') {
                modalContent.innerHTML =
                    `<img src="${fileUrl}" alt="Archivo" class="w-full max-h-[80vh] object-contain rounded">`;
            }
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('archivoModal');
            modal.classList.add('hidden');
        }

        document.getElementById('form').addEventListener('submit', function(e) {
            let content = tinymce.get('contenido').getContent({ format: 'text' }).trim();
            if (content === '') {
                e.preventDefault();
                alert('El campo contenido es obligatorio.');
                tinymce.get('contenido').focus();
            }
        });

        document.getElementById('editForm').addEventListener('submit', function(e) {
            let content = tinymce.get('edit_contenido').getContent({ format: 'text' }).trim();
            if (content === '') {
                e.preventDefault();
                alert('El campo contenido es obligatorio.');
                tinymce.get('edit_contenido').focus();
            }
        });
    </script>
<?php