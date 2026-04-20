<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Support\Facades\App;

/**
 * @phpstan-require-implements \UnitEnum
 */
trait TranslatableEnum
{
    public function trans(): string
    {
        return $this->transByAttribute()
            ?? $this->transByTranslator()
            ?? $this->humanReadableValue();
    }

    public static function selectOptions(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->{self::getTransPropName()}] = $case->trans();
        }
        return $result;
    }

    #[\ReturnTypeWillChange]
    public function toHtml(): string
    {
        return $this->trans();
    }

    /**
     * @return "value"|"name"
     *
     * @phpstan-return (self is \BackedEnum ? 'value' : 'name')
     */
    private static function getTransPropName(): string
    {
        static $propName;
        return $propName ??= (is_subclass_of(self::class, \BackedEnum::class) ? 'value' : 'name');
    }

    private function transByAttribute(): ?string
    {
        $ref = new \ReflectionEnumUnitCase(self::class, $this->name);
        $attributes = $ref->getAttributes(Attributes\Trans::class);

        if (! isset($attributes[0])) {
            return null;
        }

        return $attributes[0]->newInstance()->label;
    }

    private function transByTranslator(): ?string
    {
        $key = static::translatorNamespace() . '.' . $this->{self::getTransPropName()};

        $candidate = self::getTranslatorInstance()->get($key);

        if ($candidate === $key || ! is_string($candidate)) {
            return null;
        }

        return $candidate;
    }

    private static function getTranslatorInstance(): Translator
    {
        /** @var Translator */
        return App::make('translator');
    }

    private function humanReadableValue(): string
    {
        $value = $this->{self::getTransPropName()};

        if (strtoupper($value) === $value) {
            return $value;
        }

        $value =  str_replace(['_', '-'], ' ', $value);
        $value = preg_replace('/(?<!^)([A-Z])/', ' $1', $value);
        $value = trim($value);
        $value = mb_ucfirst($value);

        return $value;
    }

    private static function translatorNamespace(): string
    {
        return 'enums.' . static::class;
    }
}
