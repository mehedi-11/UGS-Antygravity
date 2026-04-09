<?php
// admin/hero.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_hero')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Handle Delete
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $pdo->prepare("DELETE FROM hero WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Slide deleted.');
    redirect('hero.php');
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $title = sanitize($_POST['title']);
    $subtitle = sanitize($_POST['subtitle']);
    $button_text = sanitize($_POST['button_text']);
    $button_link = sanitize($_POST['button_link']);
    $button2_text = sanitize($_POST['button2_text'] ?? '');
    $button2_link = sanitize($_POST['button2_link'] ?? '');

    if ($id) {
        $stmt = $pdo->prepare("UPDATE hero SET title=?, subtitle=?, button_text=?, button_link=?, button2_text=?, button2_link=? WHERE id=?");
        $stmt->execute([$title, $subtitle, $button_text, $button_link, $button2_text, $button2_link, $id]);
        set_flash_msg('success', 'Slide updated.');
    } else {
        $pos = $pdo->query("SELECT MAX(position) FROM hero")->fetchColumn();
        $pos = $pos ? $pos + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO hero (title, subtitle, button_text, button_link, button2_text, button2_link, position) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $subtitle, $button_text, $button_link, $button2_text, $button2_link, $pos]);
        set_flash_msg('success', 'Slide added.');
    }
    redirect('hero.php');
}

$hero_slides = $pdo->query("SELECT * FROM hero ORDER BY position ASC")->fetchAll();

$pages = [
    '' => 'None / Select Page',
    'index.php' => 'Home',
    'about.php' => 'About Us',
    'appointment.php' => 'Book Appointment',
    'blog.php' => 'Blog / News',
    'contact.php' => 'Contact Us',
    'destinations.php' => 'Study Destinations',
    'events.php' => 'Events',
    'gallery.php' => 'Gallery',
    'partners.php' => 'Partners',
    'team.php' => 'Our Team',
    'testimonials.php' => 'Testimonials',
    'universities.php' => 'Universities'
];
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Hero Section Slides</h3>
            <p class="text-slate-500 text-sm">Manage dynamic animations and hero slides.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add Slide
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" id="dataTable">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-10"></th>
                    <th class="p-4 border-b">Title</th>
                    <th class="p-4 border-b">Subtitle</th>
                    <th class="p-4 border-b">Button Details</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableBody" class="text-slate-700 text-sm">
                <?php foreach($hero_slides as $item): ?>
                <tr class="hover:bg-slate-50 border-b cursor-move" data-id="<?php echo $item['id']; ?>">
                    <td class="p-4 text-slate-400"><i class="ph ph-dots-six-vertical text-xl"></i></td>
                    <td class="p-4 font-semibold text-slate-800">
                        <?php echo htmlspecialchars($item['title']); ?>
                    </td>
                    <td class="p-4">
                        <div class="text-sm font-normal text-slate-500 truncate w-48"><?php echo htmlspecialchars($item['subtitle']); ?></div>
                    </td>
                    <td class="p-4 text-xs space-y-2">
                        <?php if($item['button_text']): ?>
                        <div class="flex items-center gap-2">
                            <span class="bg-secondary/10 text-secondary px-2 py-1 rounded font-semibold whitespace-nowrap"><?php echo htmlspecialchars($item['button_text']); ?></span> 
                            <span class="text-slate-400 truncate w-32"><i class="ph ph-link"></i> <?php echo htmlspecialchars($item['button_link']); ?></span>
                        </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($item['button2_text'])): ?>
                        <div class="flex items-center gap-2">
                            <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded font-semibold whitespace-nowrap"><?php echo htmlspecialchars($item['button2_text']); ?></span> 
                            <span class="text-slate-400 truncate w-32"><i class="ph ph-link"></i> <?php echo htmlspecialchars($item['button2_link']); ?></span>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4 flex gap-2 justify-center">
                        <button type="button" onclick='editItem(<?php echo json_encode($item); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="hero.php" method="POST" onsubmit="return confirm('Delete this slide?');" class="inline">
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
<div id="itemModal" class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto w-full">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden mt-10 mb-10">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add Slide</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition">
                <i class="ph ph-x text-xl"></i>
            </button>
        </div>
        <form method="POST" action="hero.php" class="p-6 space-y-6">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" id="item_id">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Slide Title</label>
                    <input type="text" name="title" id="title" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-300" placeholder="e.g. Empower Your Future">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Subtitle / Short Text</label>
                    <textarea name="subtitle" id="subtitle" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-300" placeholder="e.g. Set up your hero slides..."></textarea>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <h4 class="text-sm font-bold text-slate-600 uppercase tracking-wider mb-4"><i class="ph ph-hand-pointing"></i> Primary Button (Button 1)</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Text</label>
                        <input type="text" name="button_text" id="button_text" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-300" placeholder="e.g. Discover More">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Link URL</label>
                        <select name="button_link" id="button_link" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                            <?php foreach($pages as $url => $label): ?>
                                <option value="<?php echo $url; ?>"><?php echo $label; ?><?php echo $url ? " ($url)" : ""; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <h4 class="text-sm font-bold text-slate-600 uppercase tracking-wider mb-4"><i class="ph ph-hand-pointing"></i> Secondary Button (Button 2) <span class="text-xs font-normal text-slate-400 lowercase">(Optional)</span></h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Text</label>
                        <input type="text" name="button2_text" id="button2_text" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none placeholder:text-slate-300" placeholder="e.g. Contact Us">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Link URL</label>
                        <select name="button2_link" id="button2_link" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                            <?php foreach($pages as $url => $label): ?>
                                <option value="<?php echo $url; ?>"><?php echo $label; ?><?php echo $url ? " ($url)" : ""; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t font-medium">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition transform hover:-translate-y-0.5 shadow-md">Save Slide Data</button>
            </div>
        </form>
    </div>
</div>

<script>
    if(document.getElementById('sortableBody')) {
        new Sortable(document.getElementById('sortableBody'), {
            animation: 150,
            ghostClass: 'bg-orange-50',
            onEnd: function (evt) {
                let order = [];
                $('#sortableBody tr').each(function() {
                    order.push($(this).data('id'));
                });
                
                $.post('api/update_position.php', {
                    table: 'hero',
                    order: order
                });
            }
        });
    }

    const modal = document.getElementById('itemModal');
    
    function openModal() {
        document.getElementById('modalTitle').innerText = 'Add Slide';
        document.getElementById('item_id').value = '';
        document.getElementById('title').value = '';
        document.getElementById('subtitle').value = '';
        document.getElementById('button_text').value = '';
        document.getElementById('button_link').value = '';
        document.getElementById('button2_text').value = '';
        document.getElementById('button2_link').value = '';
        modal.classList.remove('hidden');
    }

    function editItem(data) {
        document.getElementById('modalTitle').innerText = 'Edit Slide';
        document.getElementById('item_id').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('subtitle').value = data.subtitle;
        document.getElementById('button_text').value = data.button_text;
        document.getElementById('button_link').value = data.button_link;
        document.getElementById('button2_text').value = data.button2_text || '';
        document.getElementById('button2_link').value = data.button2_link || '';
        modal.classList.remove('hidden');
    }

    function closeModal() {
        modal.classList.add('hidden');
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
