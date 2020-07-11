<?php

namespace App\Models;


/**
 * App\Models\File
 *
 * @property int $id
 * @property string $name 文件名
 * @property string $path 文件上传路径
 * @property int $group_id 分组id
 * @property int $company_id 公司id
 * @property int $extension 文件扩展名
 * @property int $mime_type 文件mine_type
 * @property int $size 文件大小
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EloquentModel apiPaginate($limit = 10)
 */
class File extends EloquentModel
{
    //
    protected $table='file';

    protected $guarded=[];


    public function getUrlAttribute()
    {
        return sprintf("%s/%s",url('storage'),$this->path);
    }
}
