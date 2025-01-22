<?php
date_default_timezone_set('America/Sao_Paulo');

function logMe($msg)
{
    $fileName = date('H');

    $foldName = date('MY');

    $key = date('[d/M/Y-H:i]');

    $currentDir = __DIR__ . "/logs/$foldName";

    $fullPath = $currentDir . DIRECTORY_SEPARATOR . $fileName . '.txt';

    is_dir(__DIR__ . "/logs") or mkdir(__DIR__ . "/logs", 0777);

    is_dir($currentDir) or mkdir($currentDir, 0777);

    is_file($fullPath) or file_put_contents($fullPath, "$key = created\n");

    $fp = fopen($fullPath, "a");

    fwrite($fp, "$key =>  $msg\n");

    fclose($fp);
}

// logMe("teste");
