<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Функция для применения стилей к тулбарам
        function makeToolbarsSticky() {
            document.querySelectorAll('.fi-fo-rich-editor-toolbar').forEach(toolbar => {
                toolbar.style.position = 'sticky';
                toolbar.style.top = '0';
                toolbar.style.zIndex = '100';
                toolbar.style.backgroundColor = 'white';
                toolbar.style.boxShadow = '0 2px 4px rgba(0,0,0,0.1)';
            });
        }

        // Применяем при загрузке
        makeToolbarsSticky();

        // И при динамических изменениях (для Filament)
        const observer = new MutationObserver(makeToolbarsSticky);
        observer.observe(document.body, { childList: true, subtree: true });
    });
</script>
