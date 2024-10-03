<?php

namespace App\Exception;

use Symfony\Component\HttpFoundation\Response;

class YearIsClosedException extends \Exception
{
    public function __construct(string $name)
    {
        parent::__construct("The academic year $name has already been closed.", Response::HTTP_CONFLICT);
    }
}
