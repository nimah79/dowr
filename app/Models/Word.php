<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $word_category_id
 * @property string $name
 * @property int $difficulty
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GameUserWord> $gameUserWords
 * @property-read int|null $game_user_words_count
 * @property-read \App\Models\WordCategory $wordCategory
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereDifficulty($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Word whereWordCategoryId($value)
 *
 * @mixin \Eloquent
 */
class Word extends Model
{
    use HasFactory;

    public function casts(): array
    {
        return [
            'difficulty' => 'integer',
        ];
    }

    public function wordCategory(): BelongsTo
    {
        return $this->belongsTo(WordCategory::class);
    }

    public function gameUserWords(): HasMany
    {
        return $this->hasMany(GameUserWord::class);
    }
}
