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

    public function isAdmin(array $roles): bool
    {
        return in_array(RoleEnum::ROLE_ADMIN->value, $roles);
    }

    public function isStudent(array $roles): bool
    {
        return in_array(RoleEnum::ROLE_STUDENT->value, $roles);
    }

    public function isChecker(array $roles): bool
    {
        return in_array(RoleEnum::ROLE_CHECKER->value, $roles);
    }
}
