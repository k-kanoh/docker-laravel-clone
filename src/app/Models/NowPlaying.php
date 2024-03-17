<?php declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\CustomSerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class NowPlaying
 *
 * @property string|null $TITLE
 * @property string|null $ARTIST
 * @property string|null $ALBUM
 * @property string|null $YEAR
 * @property string|null $CIRCLE
 * @property int|null    $DURATION
 * @property Carbon|null $SONGEND
 * @property float|null  $RATING
 * @property string|null $ALBUMART
 * @property int|null    $IN_WEEK
 * @property int|null    $IN_MONTH
 * @property int|null    $IN_YEAR
 */
class NowPlaying extends Model
{
    use CustomSerializeDate;

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'nowPlaying';

    protected $casts = [
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
        'ALBUMART',
        'IN_WEEK',
        'IN_MONTH',
        'IN_YEAR',
    ];
}
