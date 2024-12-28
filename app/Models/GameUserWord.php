<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $game_id
 * @property int $user_id
 * @property int $word_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Game $game
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Word $word
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord whereWordId($value)
 *
 * @property string|null $solved_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GameUserWord whereSolvedAt($value)
 *
 * @mixin \Eloquent
 */
class GameUserWord extends Model
{
    protected $fillable = [
        'game_id',
        'user_id',
        'word_id',
    ];

    public function casts(): array
    {
        return [
            'solved_at' => 'datetime',
        ];
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }
}
