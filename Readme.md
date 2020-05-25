# User provider system for Laravel thirty party auth

# Installation

To get started with user-provider, simply run:


````
    composer require murataygun/user-provider
````

````
    php artisan vendor:publish --provider="murataygun\UserProvider\UserProviderServiceProvider" --tag=config --force
````

Open config/user-provider.php file  and change your User model

````
'models' => [
        'user' => \App\User::class,
    ]
````

