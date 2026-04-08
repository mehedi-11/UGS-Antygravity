<?php
// admin/events.php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/functions.php';

check_login();

if (!has_permission('manage_events')) {
    set_flash_msg('error', 'Permission denied.');
    redirect('dashboard.php');
}

require_once __DIR__ . '/components/header.php';

// Handle Delete
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = (int)$_POST['id'];
    $item = $pdo->query("SELECT event_image FROM event WHERE id=$id")->fetch();
    if ($item && $item['event_image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/events/' . $item['event_image'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/events/' . $item['event_image']);
    }
    $pdo->prepare("DELETE FROM event WHERE id = ?")->execute([$id]);
    set_flash_msg('success', 'Event deleted.');
    redirect('events.php');
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'save') {
    $id = $_POST['id'] ?? '';
    $title = sanitize($_POST['title']);
    $date_time = $_POST['date_time'];
    $location = sanitize($_POST['location']);
    $description = $_POST['description'];
    $event_image = '';

    if (isset($_FILES['event_image']['name']) && !empty($_FILES['event_image']['name'])) {
        $uploaded = upload_image($_FILES['event_image'], 'events');
        if ($uploaded) {
            $event_image = $uploaded;
        }
    }

    if ($id) {
        $old = $pdo->query("SELECT event_image FROM event WHERE id=".(int)$id)->fetch();
        if ($event_image) {
            if ($old && $old['event_image'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/events/' . $old['event_image'])) {
                unlink($_SERVER['DOCUMENT_ROOT'] . '/uploads/events/' . $old['event_image']);
            }
        } else {
            $event_image = $old['event_image'] ?? '';
        }

        $stmt = $pdo->prepare("UPDATE event SET title=?, date_time=?, location=?, description=?, event_image=? WHERE id=?");
        $stmt->execute([$title, $date_time, $location, $description, $event_image, $id]);
        set_flash_msg('success', 'Event updated.');
    } else {
        $pos = $pdo->query("SELECT MAX(position) FROM event")->fetchColumn();
        $pos = $pos ? $pos + 1 : 1;

        $stmt = $pdo->prepare("INSERT INTO event (title, date_time, location, description, event_image, position) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$title, $date_time, $location, $description, $event_image, $pos]);
        set_flash_msg('success', 'Event added.');
    }
    redirect('events.php');
}

$events = $pdo->query("SELECT * FROM event ORDER BY position ASC, date_time DESC")->fetchAll();
?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h3 class="text-xl font-bold text-slate-800">Events Management</h3>
            <p class="text-slate-500 text-sm">Organize seminars and events. Drag to reorder.</p>
        </div>
        <button onclick="openModal()" class="px-4 py-2 bg-secondary hover:bg-accent text-white font-medium rounded-lg shadow transform transition flex items-center gap-2">
            <i class="ph ph-plus-circle text-xl"></i> Add Event
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 text-slate-500 text-sm uppercase tracking-wider">
                    <th class="p-4 border-b w-10"></th>
                    <th class="p-4 border-b w-24">Image</th>
                    <th class="p-4 border-b">Title & Location</th>
                    <th class="p-4 border-b">Date & Time</th>
                    <th class="p-4 border-b text-center">Actions</th>
                </tr>
            </thead>
            <tbody id="sortableBody" class="text-slate-700 text-sm">
                <?php foreach($events as $item): ?>
                <tr class="hover:bg-slate-50 border-b cursor-move" data-id="<?php echo $item['id']; ?>">
                    <td class="p-4 text-slate-400"><i class="ph ph-dots-six-vertical text-xl"></i></td>
                    <td class="p-4">
                        <?php if($item['event_image']): ?>
                        <div class="w-16 h-12 object-cover overflow-hidden rounded border">
                            <img src="/uploads/events/<?php echo $item['event_image']; ?>" class="w-full h-full object-cover">
                        </div>
                        <?php endif; ?>
                    </td>
                    <td class="p-4">
                        <div class="font-semibold text-slate-800"><?php echo htmlspecialchars($item['title']); ?></div>
                        <div class="text-xs text-slate-400"><i class="ph ph-map-pin"></i> <?php echo htmlspecialchars($item['location']); ?></div>
                    </td>
                    <td class="p-4 text-slate-500"><?php echo date('M d, Y H:i', strtotime($item['date_time'])); ?></td>
                    <td class="p-4 flex gap-2 justify-center">
                        <a href="event_registrations.php?id=<?php echo $item['id']; ?>" class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-200 transition" title="View Registrations">
                            <i class="ph ph-users text-lg"></i>
                        </a>
                        <button type="button" onclick='editItem(<?php echo json_encode($item); ?>)' class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center hover:bg-blue-200 transition">
                            <i class="ph ph-pencil-simple text-lg"></i>
                        </button>
                        <form action="events.php" method="POST" onsubmit="return confirm('Delete this event?');" class="inline">
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
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl overflow-hidden mt-10 mb-10 h-fit max-h-[90vh] flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 shrink-0">
            <h3 class="text-lg font-bold text-slate-800" id="modalTitle">Add Event</h3>
            <button onclick="closeModal()" class="text-slate-400 hover:text-slate-600 transition"><i class="ph ph-x text-xl"></i></button>
        </div>
        <div class="overflow-y-auto custom-scrollbar p-6">
            <form method="POST" action="events.php" enctype="multipart/form-data" class="space-y-4" id="itemForm">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id" id="item_id">
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Event Title</label>
                    <input type="text" name="title" id="title" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Date & Time</label>
                        <input type="datetime-local" name="date_time" id="date_time" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Location</label>
                        <input type="text" name="location" id="location" required class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none" placeholder="e.g. Dhaka Office">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Event Image</label>
                    <input type="file" name="event_image" id="event_image" accept="image/*" class="w-full text-sm px-3 py-2 border rounded-lg">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-secondary focus:outline-none"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t mt-4">
                    <button type="button" onclick="closeModal()" class="px-5 py-2.5 rounded-lg border border-slate-300 text-slate-600 hover:bg-slate-50 transition">Cancel</button>
                    <button type="submit" class="px-5 py-2.5 rounded-lg bg-secondary text-white hover:bg-accent transition">Save Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    if(document.getElementById('sortableBody')) {
        new Sortable(document.getElementById('sortableBody'), {
            animation: 150, ghostClass: 'bg-orange-50',
            onEnd: function (evt) {
                let order = [];
                $('#sortableBody tr').each(function() { order.push($(this).data('id')); });
                $.post('api/update_position.php', { table: 'event', order: order });
            }
        });
    }

    const modal = document.getElementById('itemModal');

    function openModal() {
        document.getElementById('itemForm').reset();
        document.getElementById('modalTitle').innerText = 'Add Event';
        document.getElementById('item_id').value = '';
        modal.classList.remove('hidden');
    }
    function editItem(data) {
        document.getElementById('itemForm').reset();
        document.getElementById('modalTitle').innerText = 'Edit Event';
        document.getElementById('item_id').value = data.id;
        document.getElementById('title').value = data.title;
        document.getElementById('date_time').value = data.date_time.replace(' ', 'T');
        document.getElementById('location').value = data.location;
        document.getElementById('description').value = data.description;
        modal.classList.remove('hidden');
    }
    function closeModal() { modal.classList.add('hidden'); }
</script>
<?php require_once __DIR__ . '/components/footer.php'; ?>
