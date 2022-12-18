<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
