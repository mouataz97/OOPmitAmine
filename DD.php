<?php

class DD
{
    public function dd(...$values): void
    {
        echo '<pre>';
        var_dump(...$values);
        die();
    }
}