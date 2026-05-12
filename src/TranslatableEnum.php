<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator;

/**
 * @phpstan-require-implements \UnitEnum
 */
trait TranslatableEnum
{
    /**
     * @param non-empty-string|null $locale
     */
    public function trans(?string $locale = null): string
    {
        return Facades\Translator::trans($this, $locale);
    }

    /**
     * @param non-empty-string|null $locale
     *
     * @phpstan-return array<(self is \BackedEnum ? value-of<self> : key-of<self>),string>
     */
    public static function selectOptions(?string $locale = null): array
    {
        $result = [];
        // @phpstan-ignore-next-line
        $propName = is_subclass_of(self::class, \BackedEnum::class)
            ? 'value'
            : 'name';
        foreach (self::cases() as $case) {
            $result[$case->{$propName}] = $case->trans($locale);
        }
        return $result;
    }

    public function toHtml(): string
    {
        return $this->trans();
    }
}
