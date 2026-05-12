<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string trans(\UnitEnum $enum, ?string $locale = null)
 */
class Translator extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JosefTraxler\LaravelEnumTranslator\Contracts\Translator::class;
    }
}
