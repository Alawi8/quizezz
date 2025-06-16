<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Test extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
    protected $fillable = ['title', 'description', 'duration'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
