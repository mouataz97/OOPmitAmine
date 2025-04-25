<?php

function dd (mixed ...$values): void
{
    echo '<pre>';
    foreach ($values as $value) {
        var_dump($value);
    }
    die();
}