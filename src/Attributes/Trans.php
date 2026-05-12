<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS_CONSTANT)]
class Trans
{
    public function __construct(
        public readonly string $label,
    ) {
    }
}
