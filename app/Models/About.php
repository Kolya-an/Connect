<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'meta_name',
        'meta_description',
        'first_name',
        'first_sentience',
        'second_sentience',
        'second_text',
        'grey_name',
        'grey_title',
        'grey_text',
        'action_text',
        'rating_text',
        'photobank_text',
        'our_text',
        'our_rose_text',
        'disclamer',
    ];
    protected $casts = [
        'second_text' => 'array',
        'grey_text' => 'array',
        'action_text' => 'array',
        'rating_text' => 'array',
        'photobank_text' => 'array',
        'our_text' => 'array',
    ];
}
