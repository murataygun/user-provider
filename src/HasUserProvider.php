<?php
/*
 * laravel-packages - HasUserProvider.php
 * Initial version by : murataygun
 * Initial version created on : 25.5.2020 21:05
 */

namespace murataygun\UserProvider;

use murataygun\UserProvider\Model\UserProvider;

/**
 * Trait HasUserProvider
 * @author Murat AYGÜN <info@murataygun.com>
 * @package murataygun\UserProvider
 */
trait HasUserProvider
{
    /**
     * Get all of the user's user providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function providers()
    {
        return $this->hasMany(UserProvider::class, 'user_id');

    }
}