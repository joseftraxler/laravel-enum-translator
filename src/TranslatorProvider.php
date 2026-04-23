<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator;

use Illuminate\Contracts\Foundation\Application;

class TranslatorProvider
{
    public function __construct(
        private readonly Application $app
    ) {
    }

    public function register(): void
    {
        $this->app->singleton(
            Contracts\Translator::class,
            fn () => $this->app->make(Translator::class),
        );
    }
}
