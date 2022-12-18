<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Application
 *
 * @property int $id
 * @property string $theme
 * @property string $message
 * @property string|null $file
 * @property int $user_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereTheme($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUserId($value)
 * @mixin \Eloquent
 */
class Application extends Model
{
    use HasFactory;

    protected $fillable = ['theme', 'message', 'file', 'user_id', 'status'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function uploadFile(Request $request)
    {
        if ($request->hasFile('file')) {
            $folder = date('Y-m-d');
            return $request->file('file')->store("files/{$folder}");
        }
        return null;
    }

    public function getFile()
    {
        return asset("uploads/{$this->file}");
    }
}
