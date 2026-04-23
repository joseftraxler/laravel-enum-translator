<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator\Contracts;

use UnitEnum;

interface Translator
{
    public function trans(UnitEnum $unit, ?string $locale = null): string;
}
