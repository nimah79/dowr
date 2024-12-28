<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Word> $words
 * @property-read int|null $words_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WordCategory whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
final class WordCategory extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Word, $this>
     */
    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }
}
