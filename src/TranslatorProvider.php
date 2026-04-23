<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator;

use Illuminate\Support\ServiceProvider;

class TranslatorProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            Contracts\Translator::class,
            fn () => $this->app->make(Translator::class),
        );
    }
}
