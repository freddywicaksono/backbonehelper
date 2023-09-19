<?php
include('functions.php');
$header ="";
$footer = "";
$header .='<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>CRUD BackboneJS PHP MySQL</title>

    <!-- Bootstrap -->
    <link href="https://cdn.usebootstrap.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>';

$footer .='<!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://cdn.usebootstrap.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
<script src="https://unpkg.com/backbone@1.3.3/backbone.js"></script>';

echo printCode($header);
echo printCode($footer);
$folderPath = '../layouts';

if (!file_exists($folderPath) || !is_dir($folderPath)) {
    // Check if the folder does not exist or is not a directory
    if (mkdir($folderPath, 0755, true)) {
        echo "The folder was created successfully.\n";
        echo "<br/>";
        // File path
        $filePath1 = '../layouts/header.php';
        $filePath2 = '../layouts/footer.php';
        // Save the text to the file
        file_put_contents($filePath1, $header);
        file_put_contents($filePath2, $footer);

        // Check if the text was successfully saved
        if (file_exists($filePath1)) {
            echo $filePath1." saved to file successfully!";
        } else {
            echo "Error saving text to file.";
        }
        if (file_exists($filePath2)) {
            echo $filePath2." saved to file successfully!";
        } else {
            echo "Error saving text to file.";
        }
    } else {
        echo "Failed to create the folder.";
    }
} else {
    echo "The folder already exists.\n";
    echo "<br/>";
    // File path
    $filePath1 = '../layouts/header.php';
    $filePath2 = '../layouts/footer.php';

    if (file_exists($filePath1)) {
        echo "File ".$filePath1." sudah ada.";
    } else {
        // Save the text to the file
        file_put_contents($filePath1, $header);

        // Check if the text was successfully saved
        if (file_exists($filePath1)) {
            echo $filePath1." saved to file successfully!";
        } else {
            echo "Error saving text to file.";
        }
    }
    if (file_exists($filePath2)) {
        echo "File ".$filePath2." sudah ada.";
    } else {
        // Save the text to the file
        file_put_contents($filePath2, $footer);

        // Check if the text was successfully saved
        if (file_exists($filePath2)) {
            echo $filePath2." saved to file successfully!";
        } else {
            echo "Error saving text to file.";
        }
    }
}
?>
