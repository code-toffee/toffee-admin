<?php
declare(strict_types=1);

namespace App\Annotation;

use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

/**
 * Annotation class for @LogAction()
 *
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("METHOD")
 */
class LogAction
{
    private string $name;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
