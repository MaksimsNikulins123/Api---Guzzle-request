<?php

namespace App;

require_once '../vendor/autoload.php';

use App\controllers\Cashe;

$mainController = new Cashe();

$cashe_file = $mainController->cashe_file;

if (!$mainController->exists($cashe_file)) {
    $mainController->connect();
    $data = $mainController->data;
    $mainController->set($cashe_file, json_encode($data), 60 * 5);
} else {
    $data = $mainController->data;
    $mainController->set($cashe_file, json_encode($data), 60 * 5);
    if ($mainController->exists($cashe_file)) {
        $mainController->get($cashe_file);
        $data = $mainController->data;
    } else {
        $mainController->connect();
        $data = $mainController->data;
        $mainController->set($cashe_file, json_encode($data), 60 * 5);
    }
}

if (array_key_exists('button1', $_POST)) {
    $mainController->clear($cashe_file);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row row-cols-2">
            <?php
            foreach ($data as $value) {
                $image = $value['image'];
                $id = $value['id'];
                $description = $value['description'];
            ?>
                <div class="col-2 border">
                    <svg aria-hidden="true" role="img" class="octicon octicon-mark-github" viewBox="0 0 16 16" width="32" height="32" fill="currentColor" style="display:inline-block;user-select:none;vertical-align:text-bottom;overflow:visible">
                        <path fill-rule="evenodd" d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z"></path>
                    </svg>
                </div>
                <div class="col-10 border">
                    ID : <?= $id ?>
                    <br>
                    Description: <?= $description ?>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="row row-cols-12">
            <form method="post">
                <input type="submit" name="button1" value="Delete all from cashe" />
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>