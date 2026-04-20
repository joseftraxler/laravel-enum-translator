<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Illuminate\Contracts\Translation\Translator;

final class FakeTranslator implements Translator
{
    private array $lines = [];

    public function addLine(string $key, string $value): self
    {
        $this->lines[$key] = $value;
        return $this;
    }

    public function get($key, array $replace = [], $locale = null)
    {
        return $this->lines[$key] ?? $key;
    }

    public function choice($key, $number, array $replace = [], $locale = null)
    {
        return $this->get($key);
    }

    public function getLocale()
    {
        return \Illuminate\Support\Facades\App::getLocale();
    }

    public function setLocale($locale)
    {
        return \Illuminate\Support\Facades\App::setLocale($locale);
    }
}
