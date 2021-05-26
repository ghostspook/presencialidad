<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResultComment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_result_id',
        'comment_text',
        'added_by',
    ];

    function testResult() {
        return $this->belongsTo('App\Models\TestResult');
    }
}
