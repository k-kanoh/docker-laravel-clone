<?php declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NowPlaying
 *
 * @property string|null $TITLE
 * @property string|null $ARTIST
 * @property string|null $ALBUM
 * @property Carbon|null $YEAR
 * @property string|null $CIRCLE
 * @property int|null    $DURATION
 * @property Carbon|null $SONGEND
 * @property float|null  $RATING
 * @property int|null    $IN_WEEK
 * @property int|null    $IN_MONTH
 * @property int|null    $IN_YEAR
 * @property string|null $ALBUMART
 */
class NowPlaying extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'nowPlaying';

    protected $casts = [
        'YEAR' => 'datetime',
        'DURATION' => 'int',
        'SONGEND' => 'datetime',
        'RATING' => 'float',
        'IN_WEEK' => 'int',
        'IN_MONTH' => 'int',
        'IN_YEAR' => 'int',
    ];

    protected $fillable = [
        'TITLE',
        'ARTIST',
        'ALBUM',
        'YEAR',
        'CIRCLE',
        'DURATION',
        'SONGEND',
        'RATING',
        'IN_WEEK',
        'IN_MONTH',
        'IN_YEAR',
        'ALBUMART',
    ];
}
