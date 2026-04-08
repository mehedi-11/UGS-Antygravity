<?php
// admin/components/footer.php
?>
        </main>
        
        <footer class="bg-white p-4 border-t border-slate-200 mt-auto flex items-center justify-between text-sm text-slate-500 z-10 relative">
            <p>&copy; <?php echo date('Y'); ?> Unilink Global Solution. All rights reserved.</p>
            <p>Developed with <i class="ph-fill ph-heart text-secondary"></i></p>
        </footer>
    </div>
    <!-- Main Content End -->

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            if($('.datatable').length) {
                $('.datatable').DataTable({
                    "pageLength": 10,
                    "ordering": false 
                });
            }

            // Custom search for tables that don't use DataTables (e.g. Sortable ones)
            const tables = document.querySelectorAll('table:not(.datatable)');
            tables.forEach(table => {
                if (table.rows.length > 2) {
                    const searchContainer = document.createElement('div');
                    searchContainer.className = 'mb-4 flex flex-col sm:flex-row justify-between items-center bg-white p-3 rounded-lg border border-slate-100 shadow-sm';
                    const title = document.createElement('span');
                    title.className = 'text-sm font-semibold text-slate-500 mb-2 sm:mb-0 hidden sm:block';
                    title.innerText = 'Quick Filter:';
                    
                    const searchInput = document.createElement('input');
                    searchInput.type = 'text';
                    searchInput.placeholder = 'Search records by name...';
                    searchInput.className = 'px-4 py-2 border border-slate-200 rounded-lg text-sm w-full sm:w-64 focus:ring-secondary focus:border-secondary outline-none';
                    
                    searchContainer.appendChild(title);
                    searchContainer.appendChild(searchInput);
                    table.parentNode.insertBefore(searchContainer, table);

                    searchInput.addEventListener('keyup', function() {
                        const filter = this.value.toLowerCase();
                        const tbody = table.querySelector('tbody');
                        if (!tbody) return;
                        const rows = tbody.querySelectorAll('tr');
                        
                        rows.forEach(row => {
                            const text = row.textContent || row.innerText;
                            row.style.display = text.toLowerCase().indexOf(filter) > -1 ? '' : 'none';
                        });
                    });
                }
            });
        });
    </script>
</body>
</html>
