<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold mb-4">Mapa de Procesos</h2>
        
        @if(isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Error:</strong> {{ $error }}
            </div>
        @endif

        @if(isset($debug))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                <strong>Debug:</strong> 
                Procesos: {{ $debug['procesos_count'] }}, 
                Tipos: {{ $debug['tipoprocesos_count'] }}, 
                Nodos: {{ $debug['nodes_count'] }}
            </div>
        @endif

        <div id="gojs-diagram" style="width: 100%; height: 600px; border: 1px solid #ccc;"></div>
        <div id="loading-message" class="text-center py-4">Cargando mapa de procesos...</div>
        <div id="error-message" class="text-center py-4 text-red-600 hidden">Error al cargar la librería GoJS</div>
        <div id="no-data-message" class="text-center py-4 text-gray-600 hidden">No hay datos para mostrar</div>

        @push('scripts')
        
        <script>
            console.log('=== INICIO DEL SCRIPT MapaProcesosWidget ===');

            
            // Función para cargar GoJS de forma más robusta
            function loadGoJS() {
                console.log('🔄 Iniciando carga de GoJS...');
                console.log('📊 Estado actual del DOM:', document.readyState);
                
                return new Promise((resolve, reject) => {
                    // Verificar si ya está cargado
                    if (typeof go !== 'undefined') {
                        console.log('✅ GoJS ya está cargado');
                        resolve();
                        return;
                    }

                    console.log('📥 Creando elemento script para GoJS...');
                    const script = document.createElement('script');
                    script.src = 'https://unpkg.com/gojs/release/go.js';
                    
                    script.onload = () => {
                        console.log('✅ GoJS cargado exitosamente desde CDN');
                        console.log('🔍 Verificando objeto go:', typeof go);
                        resolve();
                    };
                    
                    script.onerror = (error) => {
                        console.error('❌ Error al cargar GoJS:', error);
                        reject(new Error('No se pudo cargar GoJS desde CDN'));
                    };
                    
                    document.head.appendChild(script);
                    console.log('📤 Script de GoJS agregado al DOM');
                });
            }

            // Función para inicializar el diagrama
            function initDiagram() {
                console.log('🎯 Iniciando inicialización del diagrama...');
                
                try {
                    const nodes = @json($nodes ?? []);
                    const links = @json($links ?? []);

                    console.log('📊 Datos recibidos del servidor:');
                    console.log('   - Nodos:', nodes);
                    console.log('   - Enlaces:', links);
                    console.log('   - Cantidad de nodos:', nodes.length);
                    console.log('   - Cantidad de enlaces:', links.length);

                    if (nodes.length === 0) {
                        console.log('⚠️ No hay nodos para mostrar');
                        document.getElementById('loading-message').style.display = 'none';
                        document.getElementById('no-data-message').classList.remove('hidden');
                        return;
                    }

                    console.log('🔧 Verificando objeto go:', typeof go);
                    if (typeof go === 'undefined') {
                        throw new Error('GoJS no está disponible');
                    }

                    const $ = go.GraphObject.make;
                    console.log('🔧 Función $ creada:', typeof $);

                    const myDiagram = $(go.Diagram, "gojs-diagram", {
                        layout: null,
                        initialContentAlignment: go.Spot.Top,
                        "undoManager.isEnabled": true,
                        "clickCreatingTool.archetypeNodeData": { text: "Nuevo Proceso" }
                    });

                    console.log('📐 Diagrama creado:', myDiagram);

                    // Asignar coordenadas automáticas según nivel y orden
                    const nivelMap = {};
                    nodes.forEach(node => {
                        const nivel = node.nivel || 1;
                        nivelMap[nivel] = nivelMap[nivel] || [];
                        nivelMap[nivel].push(node);
                    });

                    console.log('🗺️ Mapa de niveles:', nivelMap);

                    const spacingX = 200;
                    const spacingY = 180;

                    Object.keys(nivelMap).forEach(nivel => {
                        nivelMap[nivel].forEach((node, i) => {
                            node.loc = `${i * spacingX} ${nivel * spacingY}`;
                        });
                    });

                    console.log('📍 Coordenadas asignadas a nodos');

                    myDiagram.nodeTemplate =
                        $(go.Node, "Auto",
                            { locationSpot: go.Spot.Center },
                            new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
                            $(go.Shape, "RoundedRectangle",
                                { strokeWidth: 0 },
                                new go.Binding("fill", "fill")
                            ),
                            $(go.TextBlock,
                                {
                                    margin: 8,
                                    textAlign: "center",
                                    font: "bold 10pt sans-serif",
                                    wrap: go.TextBlock.WrapFit,
                                    width: 160
                                },
                                new go.Binding("text", "text")
                            )
                        );

                    console.log('🎨 Template de nodo configurado');

                    myDiagram.model = new go.GraphLinksModel(nodes, links);
                    console.log('📋 Modelo asignado al diagrama');
                    
                    // Ocultar mensaje de carga
                    document.getElementById('loading-message').style.display = 'none';
                    console.log('✅ Diagrama inicializado exitosamente');
                    
                } catch (error) {
                    console.error('❌ Error al inicializar el diagrama:', error);
                    console.error('📋 Stack trace:', error.stack);
                    document.getElementById('loading-message').style.display = 'none';
                    document.getElementById('error-message').classList.remove('hidden');
                }
            }

            // Inicializar cuando el DOM esté listo
            console.log('🚀 Configurando event listener para DOMContentLoaded...');
            console.log('📊 Estado actual del DOM:', document.readyState);
            
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function () {
                    console.log('🎉 DOM completamente cargado');
                    loadGoJS()
                        .then(() => {
                            console.log('✅ GoJS cargado, iniciando diagrama...');
                            initDiagram();
                        })
                        .catch((error) => {
                            console.error('❌ Error en la carga:', error);
                            document.getElementById('loading-message').style.display = 'none';
                            document.getElementById('error-message').classList.remove('hidden');
                        });
                });
            } else {
                console.log('⚡ DOM ya está listo, ejecutando inmediatamente');
                loadGoJS()
                    .then(() => {
                        console.log('✅ GoJS cargado, iniciando diagrama...');
                        initDiagram();
                    })
                    .catch((error) => {
                        console.error('❌ Error en la carga:', error);
                        document.getElementById('loading-message').style.display = 'none';
                        document.getElementById('error-message').classList.remove('hidden');
                    });
            }
            
            console.log('=== FIN DEL SCRIPT MapaProcesosWidget ===');
        </script>
        @endpush
    </x-filament::card>
</x-filament::widget>
