<?php
declare(strict_types=1);

namespace App\Task\Admin;

class ParsePathIdTask
{
    public function run(string $path): string
    {
        $index = strripos($path, '-');
        if ($index === false) {
            return $path;
        }
        return substr($path, $index + 1);
    }
}
