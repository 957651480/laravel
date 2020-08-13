<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Information
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Information newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Information newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Information query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Information whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Information whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Information whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Information extends Model
{
    //

    protected $table='information';

    protected $guarded=[];


    public function images()
    {
        return $this->belongsToMany(File::class,'group_id');
    }
}
