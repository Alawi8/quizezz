<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Answer extends Model
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
    protected $fillable = ['question_id', 'answer_text', 'is_correct'];
    

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
