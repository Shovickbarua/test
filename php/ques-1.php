<!-- <form action="ques-1.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="file" accept=".jpg, .jpeg, .png, .gif">
    <button type="submit">Upload</button>
</form> -->

<?php
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxFileSize = 2 * 1024 * 1024; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    
    $fileType = mime_content_type($file['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
        echo "Only JPG, PNG, and GIF files are allowed.";
        exit;
    }
    
    if ($file['size'] > $maxFileSize) {
        echo "The file size should not exceed 2MB.";
        exit;
    }

    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid() . '-' . basename($file['name']);
    $uploadPath = $uploadDir . $fileName;

    if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
        echo "File uploaded successfully: $uploadPath";
    } else {
        echo "Failed to move the uploaded file.";
    }
} else {
    echo "No file uploaded.";
}
?>
