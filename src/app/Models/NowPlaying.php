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
 * @property int|null    $ID
 * @property string|null $TITLE
 * @property string|null $ARTIST
 * @property string|null $ALBUM
 * @property string|null $YEAR
 * @property string|null $CIRCLE
 * @property int|null    $DURATION
 * @property Carbon|null $SONGSTART
 * @property Carbon|null $SONGEND
 * @property int|null    $SONGID
 * @property int|null    $ALBUMID
 * @property float|null  $RATING
 * @property int|null    $TIMESRATED
 * @property int|null    $LISTENERS
 * @property string|null $LASTUPDATE
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
        'ID' => 'int',
        'DURATION' => 'int',
        'SONGSTART' => 'datetime',
        'SONGEND' => 'datetime',
        'SONGID' => 'int',
        'ALBUMID' => 'int',
        'RATING' => 'float',
        'TIMESRATED' => 'int',
        'LISTENERS' => 'int',
        'IN_WEEK' => 'int',
        'IN_MONTH' => 'int',
        'IN_YEAR' => 'int',
    ];

    protected $fillable = [
        'ID',
        'TITLE',
        'ARTIST',
        'ALBUM',
        'YEAR',
        'CIRCLE',
        'DURATION',
        'SONGSTART',
        'SONGEND',
        'SONGID',
        'ALBUMID',
        'RATING',
        'TIMESRATED',
        'LISTENERS',
        'LASTUPDATE',
        'ALBUMART',
        'IN_WEEK',
        'IN_MONTH',
        'IN_YEAR',
    ];
}
