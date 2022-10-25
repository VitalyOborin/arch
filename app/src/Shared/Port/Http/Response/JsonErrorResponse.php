<?php

declare(strict_types=1);

namespace Acme\Shared\Port\Http\Response;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonErrorResponse extends JsonResponse
{
    private const RESULT = 1;

    public function __construct(Exception $exception, int $status = 500, array $headers = [], bool $json = false)
    {
        $data = [
            'result' => self::RESULT,
            'error' => $exception->getMessage(),
            'error_code' => $exception->getCode(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => $exception->getTrace(),
        ];

        parent::__construct($data, $status, $headers, $json);
    }
}
