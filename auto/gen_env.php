<?php
// Define the path where you want to create the .env file
$filePath = '../.env';

if (file_exists($filePath)) {
    echo "file '$filePath' sudah ada.";
} else {
    $envFile = fopen($filePath, 'w');

    if (!$envFile) {
        die("Failed to open .env file for writing.");
    }

    $variables = [
        "DB_CONNECTION=mysql",
        "DB_HOST=127.0.0.1",
        "DB_PORT=3306",
        "DB_DATABASE=your_db_name",
        "DB_USERNAME=root",
        "DB_PASSWORD=your_db_password",
        "DB_CHARSET=utf8",
    ];

    foreach ($variables as $variable) {
        fwrite($envFile, $variable . "\n");
    }

    fclose($envFile);

    echo ".env file created successfully at $filePath!";
}
?>