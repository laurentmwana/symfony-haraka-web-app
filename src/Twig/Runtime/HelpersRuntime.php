<?php

namespace App\Twig\Runtime;

use App\Enum\PaidEnum;
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

    /**
     * @param \App\Enum\PaidEnum $paidEnum
     * @return array<string, string>
     */
    public function statePaid(PaidEnum $paidEnum): array
    {
        if ($paidEnum->value === PaidEnum::TOTALITY->value) {
            return ['variant' => 'success', 'card' => 'border-green-200', 'name' => 'A payé la totalité'];
        } elseif ($paidEnum->value === PaidEnum::PAID_NO_TOTALITY->value) {
            return ['variant' => 'default', 'card' => 'border-blue-200', 'name' => 'A payé, mais pas la totalité'];
        } else {
            return ['variant' => 'destructive', 'card' => 'border-red-200', 'name' => 'n\'est pas en ordre'];
        }
    }

    public function isTotality(PaidEnum $paidEnum): bool
    {
        return  $paidEnum->value === PaidEnum::TOTALITY->value;
    }

    public function isNoPaid(PaidEnum $paidEnum): bool
    {
        return  $paidEnum->value === PaidEnum::NO_PAID->value;
    }

    public function isPaidNoTotality(PaidEnum $paidEnum): bool
    {
        return  $paidEnum->value === PaidEnum::PAID_NO_TOTALITY->value;
    }
}
