<?php declare(strict_types=1);

namespace App\Traits;

use DateTimeInterface;

trait CustomSerializeDate
{
    protected function serializeDate(DateTimeInterface $date) : string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
