// Estilos para el componente note-board
const styles = `
    .sortable-fallback {
        opacity: 0.8;
        background: #f3f4f6;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    [wire\\:sortable] {
        touch-action: none;
    }
`;

// Agregar estilos al documento
const styleSheet = document.createElement("style");
styleSheet.textContent = styles;
document.head.appendChild(styleSheet);

// Inicializar Sortable
document.addEventListener('livewire:load', function () {
    Livewire.on('loadSortable', () => {
        const containers = document.querySelectorAll('[wire\\:sortable]');
        containers.forEach(container => {
            new Sortable(container, {
                animation: 150,
                scroll: true,
                scrollSensitivity: 30,
                scrollSpeed: 10,
                forceFallback: true,
                fallbackClass: 'sortable-fallback',
                handle: '[wire\\:sortable\\.handle]'
            });
        });
    });
}); 