<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends BaseModel
{
    use HasFactory;

    public static $cacheKey = 'events';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'max_participants',
        'status'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function rules($id = null): array
    {
        $id = $id ?? request()->route('id');

        $rules = [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'max_participants' => 'required|integer|min:1',
        ];

        if (! $id) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        return $rules;
    }
}
