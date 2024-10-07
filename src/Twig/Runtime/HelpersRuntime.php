<?php

namespace App\Twig\Runtime;

use App\Enum\RoleEnum;
use Twig\Extension\RuntimeExtensionInterface;

class HelpersRuntime implements RuntimeExtensionInterface
{
    public function __construct() {}

    public function cn(string $className, string ...$classNames): string
    {
        return implode(' ', array_merge([$className], $classNames));
    }

    /**
     * @param array<int, string> $roles
     * @return bool
     */
    public function isAdmin(array $roles): bool
    {
        return in_array(RoleEnum::ROLE_ADMIN->value, $roles);
    }


    /**
     * @param array<int, string> $roles
     * @return bool
     */
    public function isStudent(array $roles): bool
    {
        return in_array(RoleEnum::ROLE_STUDENT->value, $roles);
    }

    /**
     * @param array<int, string> $roles
     * @return bool
     */
    public function isChecker(array $roles): bool
    {
        return in_array(RoleEnum::ROLE_CHECKER->value, $roles);
    }
}
