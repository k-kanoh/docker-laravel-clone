<?php declare(strict_types=1);

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\CustomSerializeDate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Gen
 *
 * @property string|null $TITLE
 * @property string|null $ARTIST
 * @property string|null $ALBUM
 * @property int|null    $YEAR
 * @property string|null $CIRCLE
 * @property int|null    $DURATION
 * @property Carbon|null $SONGSTART
 * @property Carbon|null $SONGEND
 * @property int         $SONGID
 * @property int         $ALBUMID
 * @property string|null $CIRCLELINK
 * @property float|null  $RATING
 * @property int|null    $TIMESRATED
 * @property int|null    $LISTENERS
 * @property Carbon      $LASTUPDATE
 * @property string|null $DEBUG
 * @property string|null $ALBUMART
 */
class Gen extends Model
{
    use CustomSerializeDate;

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'gen1';
    protected $primaryKey = 'LASTUPDATE';

    protected $casts = [
        'YEAR' => 'int',
        'DURATION' => 'int',
        'SONGSTART' => 'datetime',
        'SONGEND' => 'datetime',
        'SONGID' => 'int',
        'ALBUMID' => 'int',
        'RATING' => 'float',
        'TIMESRATED' => 'int',
        'LISTENERS' => 'int',
        'LASTUPDATE' => 'datetime',
    ];

    protected $fillable = [
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
        'CIRCLELINK',
        'RATING',
        'TIMESRATED',
        'LISTENERS',
        'DEBUG',
        'ALBUMART',
    ];
}
