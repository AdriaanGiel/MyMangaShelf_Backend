<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMediaList extends Model
{
    use HasFactory;

    protected $table = 'user_media_list';
    protected $fillable = ['user_id', 'media_id', 'status_id', 'custom_status_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function customFolder()
    {
        return $this->belongsTo(CustomFolder::class);
    }
}
