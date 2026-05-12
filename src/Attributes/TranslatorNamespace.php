<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator\Attributes;

#[\Attribute(\Attribute::TARGET_CLASS)]
class TranslatorNamespace
{
    public function __construct(
        public readonly string $path,
    ) {
        if ($path === '') {
            throw new \InvalidArgumentException('Translator namespace path cannot be empty.');
        }
    }
}
