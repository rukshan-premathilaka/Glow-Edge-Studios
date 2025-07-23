<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];

        // Check for upload errors
        if ($image['error'] === 0) {
            $uploadDir = '/';
            $imageName = basename($image['name']);
            $uploadPath = $uploadDir . $imageName;

            // Save the uploaded file
            if (move_uploaded_file($image['tmp_name'], __DIR__ . '/' . $uploadPath)) {
                echo "Image uploaded successfully!";
            } else {
                echo "Failed to move uploaded file.";
            }
        } else {
            echo "Upload error: " . $image['error'];
        }
    } else {
        echo "No image found in request.";
    }
} else {
    echo "Invalid request.";
}
