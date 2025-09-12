<?php

namespace App\Models;

use App\Models\RequestTemplates\RequestTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MSA\LaravelGrapes\Models\Page;

class Requests extends Model
{
    use HasFactory;
    // protected $tabel = "requests";


    protected $fillable = [
        'id',
        'name',
        'type_id',
        "page_id",
        'request_template_id',
        'isActive',

    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(RequestType::class);
    }

    public function requestList(): HasMany
    {
        return $this->hasMany(RequestList::class);
    }

    public function requireData(): HasMany
    {
        return $this->hasMany(RequireData::class);
    }
    public function template(): BelongsTo
    {
        return $this->belongsTo(RequestTemplate::class, 'request_template_id');
    }

    /**
     * scope retrun just active itme
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('isActive', "=", 1);
    }


    public function active()
    {
        $this->update(['isActive' => 1]);
    }
    public function unactive()
    {
        $this->update(['isActive' => 0]);
    }
    public function isActive(): bool
    {
        if ($this->isActive > 0) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
