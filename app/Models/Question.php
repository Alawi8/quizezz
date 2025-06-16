<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
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


    protected $fillable = ['id', 'question_text', 'test_id'];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'question_id');
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }
}
