<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestResultFile extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_result_id',
        'filename',
        'mime_type',
        'created_by',
        'path',
    ];

    function testResult()
    {
        return $this->belongsTo('App\Models\TestResult');
    }
}
