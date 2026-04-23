<?php

declare(strict_types=1);

namespace JosefTraxler\LaravelEnumTranslator;

/**
 * @phpstan-require-implements \UnitEnum
 */
trait TranslatableEnum
{
    public function trans(): string
    {
        return Facades\Translator::trans($this);
    }

    /**
     * @phpstan-return array<(self is \BackedEnum ? value-of<self> : key-of<self>),string>
     */
    public static function selectOptions(): array
    {
        $result = [];
        // @phpstan-ignore-next-line
        $propName = is_subclass_of(self::class, \BackedEnum::class)
            ? 'value'
            : 'name';
        foreach (self::cases() as $case) {
            $result[$case->{$propName}] = $case->trans();
        }
        return $result;
    }

    #[\ReturnTypeWillChange]
    public function toHtml(): string
    {
        return $this->trans();
    }
}
