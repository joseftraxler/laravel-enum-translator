<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator\Attributes;

#[\Attribute]
class TranslatorNamespace
{
    public function __construct(
        public readonly string $path,
    ) {
    }
}
