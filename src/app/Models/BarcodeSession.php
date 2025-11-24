<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarcodeSession extends Model
{
    protected $fillable = [
        'session_id',
        'create_ip',
        'create_host',
        'scanned_data',
        'scanner_ip',
        'scanner_host',
    ];

    protected $casts = [
        'scanned_data' => 'array',
    ];

    public function addScannedData(string $text, ?string $ip = null, ?string $host = null) : void
    {
        $scanned_data = $this->scanned_data ?? [];
        $scanned_data[] = [
            'x' => $text,
            't' => now()->toDateTimeString(),
        ];

        $this->scanned_data = $scanned_data;
        $this->scanner_ip = $ip;
        $this->scanner_host = $host;
        $this->save();
    }

    public function clearScannedData() : void
    {
        $this->scanned_data = null;
        $this->save();
    }
}
