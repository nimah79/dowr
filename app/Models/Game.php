<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $started_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GameUserWord> $gameUserWords
 * @property-read int|null $game_user_words_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUpdatedAt($value)
 *
 * @property int $user_id
 * @property bool $is_on_left_users
 * @property int $turn_index
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WordCategory> $categories
 * @property-read int|null $categories_count
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereIsOnLeftUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereTurnIndex($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Game whereUserId($value)
 *
 * @mixin \Eloquent
 */
final class Game extends Model
{
    public function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'turn_index' => 'integer',
            'is_on_left_users' => 'boolean',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Team, $this>
     */
    public function teams(): HasMany
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\GameUserWord, $this>
     */
    public function gameUserWords(): HasMany
    {
        return $this->hasMany(GameUserWord::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<\App\Models\WordCategory, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(WordCategory::class);
    }
}
