<?php

namespace Project\Domain\Entity\Type;

use MyCLabs\Enum\Enum;

class ApiRequestTypeEnum extends Enum
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const PATCH = 'PATCH';
    public const DELETE = 'DELETE';
}
