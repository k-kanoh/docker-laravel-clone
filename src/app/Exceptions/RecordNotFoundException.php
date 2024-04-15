<?php declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class RecordNotFoundException extends Exception
{
    public function __construct($message = 'Record not found.')
    {
        parent::__construct($message);
    }

    public function render()
    {
        return response()->json(['message' => $this->getMessage()], 404);
    }

    public function report() {}
}
