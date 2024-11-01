<?php

namespace AllanDereal\PesaPal\Enums;

enum StatusCode: int
{
    case INVALID = 0;
    case COMPLETED = 1;
    case FAILED = 2;
    case REVERSED = 3;

    public function isSuccessful(string $status, int $code): bool
    {
        return strtolower($status) === 'completed' && $code === self::COMPLETED->value;
    }
}
