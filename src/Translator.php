<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator;

use Illuminate\Contracts\Translation\Translator as LaravelTranslator;
use JosefTraxler\LaravelEnumTranslator\Contracts\Translator as TranslatorInterface;
use UnitEnum;

class Translator implements TranslatorInterface
{
    public function __construct(
        private readonly LaravelTranslator $laravelTranslator,
    ) {
    }

    public function trans(UnitEnum $enum, ?string $locale = null): string
    {
        return $this->transByAttribute($enum)
            ?? $this->transByTranslator($enum, $locale)
            ?? $this->humanReadableValue($enum);
    }

    public function transByAttribute(UnitEnum $enum): ?string
    {
        $ref = new \ReflectionEnumUnitCase($enum, $enum->name);
        $attributes = $ref->getAttributes(Attributes\Trans::class);

        if (! isset($attributes[0])) {
            return null;
        }

        return $attributes[0]->newInstance()->label;
    }

    public function transByTranslator(
        UnitEnum $enum,
        ?string $locale = null,
    ): ?string {
        $ref = new \ReflectionEnum($enum);
        $attributes = $ref->getAttributes(Attributes\TranslatorNamespace::class);

        $namespace = isset($attributes[0])
            ? $attributes[0]->newInstance()->path
            : 'enums.' . $enum::class;

        $key = rtrim($namespace, '.') . '.' . $this->getEnumValue($enum);

        $candidate = $this->laravelTranslator->get($key, locale: $locale);

        if ($candidate === $key || ! is_string($candidate)) {
            return null;
        }

        return $candidate;
    }

    public function humanReadableValue(UnitEnum $enum): string
    {
        $value = $this->getEnumValue($enum);

        if (strtoupper($value) === $value) {
            return $value;
        }

        $value = str_replace(['_', '-'], ' ', $value);
        $value = (string) preg_replace('/(?<!^)(?<![A-Z])([A-Z])/', ' $1', $value);
        $value = trim($value);
        $value = mb_ucfirst($value);

        return $value;
    }

    private function getEnumValue(UnitEnum $enum): string
    {
        if ($enum instanceof \BackedEnum) {
            return (string) $enum->value;
        }
        return $enum->name;
    }
}
