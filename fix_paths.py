import os
import glob

admin_dir = r"e:\xampp\htdocs\antygravity_UGS\admin"
php_files = glob.glob(os.path.join(admin_dir, "*.php"))

for file_path in php_files:
    with open(file_path, 'r', encoding='utf-8') as f:
        content = f.read()
    
    new_content = content.replace("$_SERVER['DOCUMENT_ROOT'] . '/uploads/", "__DIR__ . '/../uploads/")
    new_content = new_content.replace('src="/uploads/', 'src="../uploads/')
    new_content = new_content.replace("src='<?php echo $item['image'] ? '/uploads/", "src='<?php echo $item['image'] ? '../uploads/")
    new_content = new_content.replace('src="<?php echo $item[\'image\'] ? \'/uploads/', 'src="<?php echo $item[\'image\'] ? \'../uploads/')
    new_content = new_content.replace("window.open('/uploads/", "window.open('../uploads/")
    
    if new_content != content:
        with open(file_path, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Updated {os.path.basename(file_path)}")

print("Done")
