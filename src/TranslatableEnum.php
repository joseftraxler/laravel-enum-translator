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

    /**
     * @phpstan-return array<(self is \BackedEnum ? value-of<self> : key-of<self>),string>
     */
    public static function selectOptions(): array
    {
        $result = [];
        foreach (self::cases() as $case) {
            $result[$case->{$case->getTransPropName()}] = $case->trans();
        }
        return $result;
    }

    #[\ReturnTypeWillChange]
    public function toHtml(): string
    {
        return $this->trans();
    }

    /**
     * @return ($this is \BackedEnum ? "value" : "name")
     */
    private function getTransPropName(): string
    {
        static $propName;
        /** @var ($this is \BackedEnum ? "value" : "name") */
        return $propName ??= ($this instanceof \BackedEnum) ? 'value' : 'name';
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
        $key = static::translatorNamespace() . '.' . $this->{$this->getTransPropName()};

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
        $value = $this->{$this->getTransPropName()};

        if (strtoupper($value) === $value) {// @phpstan-ignore identical.alwaysFalse
            return $value;
        }

        $value =  str_replace(['_', '-'], ' ', $value);
        $value = (string) preg_replace('/(?<!^)([A-Z])/', ' $1', $value);
        $value = trim($value);
        $value = mb_ucfirst($value);

        return $value;
    }

    private static function translatorNamespace(): string
    {
        return 'enums.' . static::class;
    }
}
