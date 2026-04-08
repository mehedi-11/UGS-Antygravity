<?php
// admin/blogs.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_blogs')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Handle Delete
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $item = $pdo->query("SELECT image FROM blogs WHERE id=$id")->fetch();
    if ($item && $item['image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/blogs/' . $item['image'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/blogs/' . $item['image']);
    }
    $pdo->prepare("DELETE FROM blogs WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Blog deleted.');
    redirect('blogs.php');
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $title = sanitize($_POST['title']);
    $content = $_POST['content']; // HTML allowed here for rich text
    $seo_title = sanitize($_POST['seo_title']);
    $seo_description = sanitize($_POST['seo_description']);
    $image = '';

    if (isset($_FILES['image']['name']) && !empty($_FILES['image']['name'])) {
        $uploaded = upload_image($_FILES['image'], 'blogs');
        if ($uploaded) {
            $image = $uploaded;
        }
    }

    if ($id) {
        $old = $pdo->query("SELECT image FROM blogs WHERE id=".(int)$id)->fetch();
        if ($image) {
            if ($old && $old['image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/blogs/' . $old['image'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/blogs/' . $old['image']);
            }
        } else {
            $image = $old['image'] ?? '';
        }

        $stmt = $pdo->prepare("UPDATE blogs SET title=?, content=?, seo_title=?, seo_description=?, image=? WHERE id=?");
        $stmt->execute([$title, $content, $seo_title, $seo_description, $image, $id]);
        set_flash_msg('success', 'Blog updated.');
    } else {
        $stmt = $pdo->prepare("INSERT INTO blogs (title, content, seo_title, seo_description, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$title, $content, $seo_title, $seo_description, $image]);
        set_flash_msg('success', 'Blog added.');
    }
    redirect('blogs.php');
}

$blogs = $pdo->query("SELECT * FROM blogs ORDER BY created_at DESC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Blog Posts</h3>
            <p class="text-slate-500 text-sm">Manage articles and company news updates.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add New Blog
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse datatable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-24">Image</th>
                    <th class="p-4 border-b">Title</th>
                    <th class="p-4 border-b">Date</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="text-slate-700 text-sm">
                <?php foreach($blogs as $item): ?>
                <tr class="hover:bg-slate-50 border-b">
                    <td class="p-4">
                        <?php if($item['image']): ?>
                        <div class="w-16 h-12 object-cover overflow-hidden rounded border">
                            <img src="/uploads/blogs/<?php echo $item['image']; ?>" class="w-full h-full object-cover">
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4">
                        <div class="font-semibold text-slate-800"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="text-xs text-slate-400">SEO: <?php echo htmlspecialchars($item['seo_title'] ?: 'N/A'); ?></div>
                    </td>
                    <td class="p-4 text-slate-500"><?php echo date('M d, Y', strtotime($item['created_at'])); ?></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button type="button" onclick="editItem(<?php echo htmlspecialchars(json_encode($item), ENT_QUOTES, 'UTF-8'); ?>)" class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="blogs.php" method="POST" onsubmit="return confirm('Delete this blog?');" class="inline">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <button type="submit" class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-200 transition">
                                <i class="ph ph-trash text-lg"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="itemModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-4xl overflow-hidden my-4 max-h-[90vh] flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Create Blog</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition"><i class="ph ph-x text-xl"></i></button>
        </div>
        <div class="overflow-y-auto custom-scrollbar p-6">
            <form method="POST" action="blogs.php" enctype="multipart/form-data" class="space-y-4" id="itemForm">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id" id="item_id">
                
                <div class="flex items-center justify-between mb-1">
                    <label class="block text-sm font-medium text-slate-700">Blog Title</label>
                    <button type="button" onclick="generateAIContent(this, 'blog_editor', 'title', 'blog')" class="text-xs px-2 py-1 bg-purple-100 text-purple-700 rounded-md hover:bg-purple-200 flex items-center gap-1 transition">
                        <i class="ph ph-magic-wand"></i> Magic AI Content
                    </button>
                </div>
                <input type="text" name="title" id="title" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none mb-4">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Content</label>
                    <input type="hidden" name="content" id="content_hidden">
                    <div id="blog_editor" style="height: 300px;" class="bg-white rounded-b-lg"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t pt-4">
                    <div class="md:col-span-2">
                         <h4 class="text-sm font-bold text-slate-600 uppercase tracking-wider mb-2">SEO Settings</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">SEO Meta Title</label>
                        <input type="text" name="seo_title" id="seo_title" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Featured Image</label>
                        <input type="file" name="image" id="image" accept="image/*" class="w-full text-sm px-3 py-2 border rounded-lg bg-white">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-700 mb-1">SEO Meta Description</label>
                        <textarea name="seo_description" id="seo_description" rows="2" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t mt-4">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition">Publish Blog</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const modal = document.getElementById('itemModal');
    
    // Initialize Quill when page loads
    $(document).ready(function() {
        initQuill('blog_editor', 'content_hidden');
    });

    function openModal() {
        document.getElementById('itemForm').reset();
        document.getElementById('modalTitle').innerText = 'Create Blog';
        document.getElementById('item_id').value = '';
        if (quillEditors['blog_editor']) {
            quillEditors['blog_editor'].root.innerHTML = '';
        }
        modal.classList.remove('hidden');
    }
    function editItem(data) {
        document.getElementById('itemForm').reset();
        document.getElementById('modalTitle').innerText = 'Edit Blog';
        document.getElementById('item_id').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('content_hidden').value = data.content;
        document.getElementById('seo_title').value = data.seo_title;
        document.getElementById('seo_description').value = data.seo_description;
        
        if (quillEditors['blog_editor']) {
            quillEditors['blog_editor'].root.innerHTML = data.content;
        }
        modal.classList.remove('hidden');
    }
    function closeModal() { modal.classList.add('hidden'); }
</script>
<?php require_once __DIR__ . '/components/footer.php'; ?>
