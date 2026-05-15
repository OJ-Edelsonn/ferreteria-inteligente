<?php

declare(strict_types=1);

function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function isActive(string $current, string $expected): string
{
    return $current === $expected ? 'active' : '';
}

