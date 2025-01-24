<?php

/** 
 * Tudo aqui tem relação com o cache
 * **/

$validate = 1;

function create($full_name, $data)
{
    file_exists($full_name) or file_put_contents($full_name, json_encode($data));
}

function read($full_name)
{
    return json_decode(file_get_contents($full_name));
}

function remover($full_name)
{
    unlink($full_name);
}

function validate($full_name, $validateTime)
{
    $now = new DateTime();
    $file_time = new DateTime();

    $file_mtime = filemtime($full_name);

    $file_time->setTimestamp($file_mtime);
    $date_diff = $now->diff($file_time);

    return $date_diff->i > $validateTime;
}

function useCache($name, $data, $validateTime = 1)
{
    $full_name = __DIR__ . DIRECTORY_SEPARATOR . $name . '.txt';

    create($full_name, $data);

    $validate = validate($full_name, $validateTime);

    $cache = read($full_name);

    remover($full_name);

    create($full_name, $data);

    return [$cache, $validate];
}

// useCache('products', 'list Producst',  1);
// useCache('users', 'list users',  1);
