<?php

namespace murataygun\UserProvider\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class UserProvider
 * @package murataygun\UserProvider\Model
 */
class UserProvider extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $primaryKey = "id";
    /**
     * @var string
     */
    protected $table = 'user_providers';
    /**
     * @var bool
     */
    protected $timestamps = true;
    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id', 'provider', 'access_token', 'expires_at', 'provider_user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config('user-provider.models.user'));
    }
}
