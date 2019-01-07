<?php

namespace Elantha\Api\Http\Exceptions;


class EmptyException extends BaseHttpException
{
    public function getStatusCode(): int
    {
        return 0;
    }
}
