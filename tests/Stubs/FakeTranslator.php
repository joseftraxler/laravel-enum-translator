<?php

declare(strict_types=1);

namespace Tests\Stubs;

use Illuminate\Contracts\Translation\Translator;

final class FakeTranslator implements Translator
{
    /** @var array<string, string> */
    private array $lines = [];

    public function addLine(string $key, string $value): self
    {
        $this->lines[$key] = $value;
        return $this;
    }

    /**
     * @param string $key
     * @param array<string,string> $replace
     *
     * @return string
     */
    public function get($key, array $replace = [], $locale = null)
    {
        return $this->lines[$key] ?? $key;
    }

    /**
     * @param int $number
     * @param array<string,string> $replace
     */
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
        \Illuminate\Support\Facades\App::setLocale($locale);
    }
}
