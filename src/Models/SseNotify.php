<?php

namespace LuizFabianoNogueira\SseNotify\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class SseNotify
 *
 * This model represents a notification for Server-Sent Events (SSE).
 * It uses UUIDs for primary keys and has a one-to-one relationship with the User model.
 *
 * @package App\Models
 */
class SseNotify extends Model
{
    use HasUuids;

    /**
     * @var string
     */
    protected $table = 'sse_notify';

    /**
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'user_id',
        'event',
        'type',
        'data',
        'read'
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'user_id' => 'string',
            'data' => 'json',
            'read' => 'boolean'
        ];
    }

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
