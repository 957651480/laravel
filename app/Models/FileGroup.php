<?php

namespace App\Models;



/**
 * App\Models\FileGroup
 *
 * @property int $id
 * @property string $name 文件分组名
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read int|null $files_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FileGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FileGroup extends EloquentModel
{
    //
    protected $table='file_group';

    protected $guarded=[];


    public function files()
    {
        return $this->hasMany(File::class,'group_id');
    }
}
