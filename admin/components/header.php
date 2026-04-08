<?php
// admin/components/header.php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../config/functions.php';

check_login();

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Unilink Global Solution</title>
    
    <!-- Fonts -->
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#f8fafc',
                        secondary: '#f97316',
                        accent: '#ea580c',
                        dark: '#1e293b'
                    },
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <!-- jQuery & DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Quill Rich Text Editor -->
    <link href="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.6/dist/quill.min.js"></script>

    <script>
        const quillEditors = {};

        function initQuill(containerId, hiddenInputId) {
            const container = document.getElementById(containerId);
            if (!container) return;
            
            if (typeof Quill === 'undefined') {
                console.error('Quill library not loaded.');
                return;
            }

            quillEditors[containerId] = new Quill('#' + containerId, {
                theme: 'snow',
                placeholder: 'Write or generate content...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['clean']
                    ]
                }
            });

            const hidden = document.getElementById(hiddenInputId);
            if (hidden && hidden.value) {
                quillEditors[containerId].root.innerHTML = hidden.value;
            }

            quillEditors[containerId].on('text-change', function() {
                if (hidden) hidden.value = quillEditors[containerId].root.innerHTML;
            });
        }

        async function generateAIContent(btn, editorId, titleId, type) {
            const titleInput = document.getElementById(titleId);
            const title = titleInput ? titleInput.value.trim() : '';

            if (!title) {
                alert('Please enter a title first!');
                return;
            }

            const originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="ph ph-spinner animate-spin"></i> Writing...';
            btn.disabled = true;

            try {
                const response = await fetch('api/generate_ai.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ title, type })
                });
                const result = await response.json();
                if (result.success) {
                    const editor = quillEditors[editorId];
                    if (editor) {
                        editor.root.innerHTML = result.content;
                        editor.emit('text-change');
                    }
                } else {
                    alert(result.message);
                }
            } catch (error) {
                console.error(error);
                alert('Error generating content.');
            } finally {
                btn.innerHTML = originalHtml;
                btn.disabled = false;
            }
        }

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if(sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; background-color: #f1f5f9; color: #334155; }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #f97316 !important;
            color: white !important;
            border: 1px solid #ea580c !important;
        }
        /* Custom scrollbar for modals */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f5f9; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="flex min-h-screen">

    <!-- Sidebar Start -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/50 z-30 hidden" onclick="toggleSidebar()"></div>
    <?php include __DIR__ . '/sidebar.php'; ?>
    <!-- Sidebar End -->

    <!-- Main Content Start -->
    <div class="flex-1 flex flex-col sm:ml-64 transition-all duration-300 relative">
        <!-- Top Navbar -->
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-10 sticky top-0">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="sm:hidden text-slate-500 hover:text-secondary">
                    <i class="ph ph-list text-2xl"></i>
                </button>
                <h2 class="text-lg font-semibold text-slate-800 capitalize">
                    <?php echo str_replace(['_', '.php'], [' ', ''], $current_page); ?>
                </h2>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-sm text-slate-600 hidden sm:block">
                    Welcome, <span class="font-bold text-slate-800"><?php echo htmlspecialchars($_SESSION['admin_name']); ?></span>
                </div>
                <a href="profile.php" class="w-10 h-10 rounded-full bg-orange-100 text-secondary flex items-center justify-center hover:bg-orange-200 transition">
                    <i class="ph ph-user text-xl"></i>
                </a>
                <a href="logout.php" class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition" title="Logout">
                    <i class="ph ph-sign-out text-xl"></i>
                </a>
            </div>
        </header>

        <!-- Main Wrapper -->
        <main class="flex-1 p-6">
            <?php display_flash_msg(); ?>
