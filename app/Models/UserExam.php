<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Exam;

class UserExam extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function exams() {
        return $this->hasMany(Exam::class, 'exam_id', 'id');
    }
    
    // public static function boot() {
    //     parent::boot();
    //     // before delete() method call, all related exam will be deleted
    //     self::deleting(function($userexam) {
    //          $userexam->exams()->each(function($exam) {
    //             $exam->delete();
    //          });
    //     });
    // }
}
