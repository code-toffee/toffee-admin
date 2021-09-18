<?php
declare(strict_types=1);

namespace App\Dto\Transformer;

use Doctrine\Common\Annotations\Annotation\NamedArgumentConstructor;

/**
 * Annotation class for @ValidatorGroup().
 *
 * @Annotation
 * @NamedArgumentConstructor
 * @Target("METHOD")
 *
 */
class ValidatorGroup
{
    /**
     * @var array
     */
    private array $groups;

    public function __construct(array $values = [], array $groups = [])
    {
        $this->groups = $values['groups'] ?? $groups;
    }

    public function getGroups()
    {
        return $this->groups;
    }

    public function setGroups($groups)
    {
        $this->groups = $groups;
    }
}
