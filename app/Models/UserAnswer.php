<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserAnswer extends Model
{
    use HasFactory;

    protected $table = 'useranswer';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'question_id', 'answer_id', 'is_correct'];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answer_id');
    }
}
