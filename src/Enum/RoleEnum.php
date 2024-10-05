<?php

namespace App\Enum;

enum RoleEnum: string
{
  case ROLE_ADMIN = "ROLE_ADMIN";

  case ROLE_STUDENT = "ROLE_STUDENT";

  case ROLE_CHECKER = "ROLE_CHECKER";
}
