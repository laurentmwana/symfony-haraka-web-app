<?php

namespace App\Helpers;

use App\Enum\RoleEnum;

class CheckRoleUser
{

  public static function isStudent(array $roles): bool
  {
    return in_array(RoleEnum::ROLE_STUDENT->value, $roles);
  }


  public static function isChecker(array $roles): bool
  {
    return in_array(RoleEnum::ROLE_CHECKER->value, $roles);
  }
}
