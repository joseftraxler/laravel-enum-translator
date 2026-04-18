<?php

declare(strict_types = 1);

namespace JosefTraxler\LaravelEnumTranslator\Attributes;

#[\Attribute]
class Trans
{
    public function __construct(
        public string $label,
    ) {
    }
}
