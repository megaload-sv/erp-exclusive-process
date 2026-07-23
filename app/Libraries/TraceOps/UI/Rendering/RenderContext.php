<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI\Rendering;

final class RenderContext
{
    /**
     * @param array<string, mixed> $attributes
     */
    public function __construct(
        private readonly string $theme = 'default',
        private readonly string $locale = 'es',
        private readonly ?string $tenant = null,
        private readonly array $attributes = [],
    ) {
    }

    public function theme(): string
    {
        return $this->theme;
    }

    public function locale(): string
    {
        return $this->locale;
    }

    public function tenant(): ?string
    {
        return $this->tenant;
    }

    /**
     * @return array<string, mixed>
     */
    public function attributes(): array
    {
        return $this->attributes;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'theme' => $this->theme,
            'locale' => $this->locale,
            'tenant' => $this->tenant,
            'attributes' => $this->attributes,
        ];
    }
}
