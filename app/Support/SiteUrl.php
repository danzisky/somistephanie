<?php

namespace App\Support;

class SiteUrl
{
    public function base(): string
    {
        $url = trim((string) config('app.url'));

        if ($url === '') {
            return request()->getSchemeAndHttpHost();
        }

        if (! preg_match('~^https?://~i', $url)) {
            $scheme = app()->environment(['local', 'testing'])
                ? request()->getScheme()
                : 'https';

            $url = $scheme.'://'.ltrim($url, '/');
        }

        $parts = parse_url($url);

        if (! is_array($parts) || empty($parts['host'])) {
            return request()->getSchemeAndHttpHost();
        }

        $origin = ($parts['scheme'] ?? 'https').'://'.$parts['host'];

        if (isset($parts['port'])) {
            $origin .= ':'.$parts['port'];
        }

        return $origin;
    }

    public function absolute(string $path = '/'): string
    {
        return $this->base().'/'.ltrim($path, '/');
    }
}