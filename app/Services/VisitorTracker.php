<?php

namespace App\Services;

use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VisitorTracker
{
    /**
     * Record a visitor hit from request
     */
    public static function track(Request $request): ?VisitorLog
    {
        try {
            $ip = $request->ip();
            $url = $request->fullUrl();
            $path = '/' . ltrim($request->path(), '/');
            $userAgent = $request->userAgent() ?? '';
            $sessionId = $request->hasSession() ? $request->session()->getId() : md5($ip . $userAgent);

            // Debounce: prevent duplicate log if same session accessed same URL within last 45 seconds
            $recent = VisitorLog::where('session_id', $sessionId)
                ->where('url', $url)
                ->where('created_at', '>=', now()->subSeconds(45))
                ->first();

            if ($recent) {
                return $recent;
            }

            $isBot = self::isBot($userAgent);
            $device = self::detectDevice($userAgent, $isBot);
            $platform = self::detectPlatform($userAgent);
            $browser = self::detectBrowser($userAgent);
            $referrer = $request->header('referer');
            $referrerHost = self::parseReferrerHost($referrer);
            $pageName = self::resolvePageName($path);

            return VisitorLog::create([
                'ip_address'    => $ip,
                'url'           => Str::limit($url, 490),
                'page_name'     => $pageName,
                'method'        => $request->method(),
                'referrer'      => $referrer ? Str::limit($referrer, 490) : null,
                'referrer_host' => $referrerHost,
                'user_agent'    => Str::limit($userAgent, 1000),
                'device'        => $device,
                'platform'      => $platform,
                'browser'       => $browser,
                'session_id'    => $sessionId,
                'is_bot'        => $isBot,
            ]);
        } catch (\Throwable $e) {
            // Silently fail so visitor experience is never broken
            return null;
        }
    }

    public static function isBot(string $ua): bool
    {
        $bots = [
            'googlebot', 'bingbot', 'slurp', 'duckduckbot', 'baiduspider',
            'yandexbot', 'sogou', 'exabot', 'facebot', 'facebookexternalhit',
            'twitterbot', 'linkedinbot', 'whatsapp', 'telegrambot', 'applebot',
            'petalbot', 'semrushbot', 'ahrefsbot', 'dotbot', 'mj12bot',
            'curl', 'wget', 'python', 'postman', 'headlesschrome', 'lighthouse'
        ];
        $lower = strtolower($ua);
        foreach ($bots as $bot) {
            if (str_contains($lower, $bot)) {
                return true;
            }
        }
        return false;
    }

    public static function detectDevice(string $ua, bool $isBot): string
    {
        if ($isBot) {
            return 'bot';
        }
        $lower = strtolower($ua);
        if (str_contains($lower, 'ipad') || str_contains($lower, 'tablet') || str_contains($lower, 'playbook') || str_contains($lower, 'silk')) {
            return 'tablet';
        }
        if (str_contains($lower, 'mobi') || str_contains($lower, 'android') || str_contains($lower, 'iphone') || str_contains($lower, 'ipod')) {
            return 'mobile';
        }
        return 'desktop';
    }

    public static function detectPlatform(string $ua): string
    {
        $lower = strtolower($ua);
        if (str_contains($lower, 'android')) return 'Android';
        if (str_contains($lower, 'iphone')) return 'iOS (iPhone)';
        if (str_contains($lower, 'ipad')) return 'iOS (iPad)';
        if (str_contains($lower, 'windows nt 10.0')) return 'Windows 10/11';
        if (str_contains($lower, 'windows nt 6.3')) return 'Windows 8.1';
        if (str_contains($lower, 'windows nt 6.1')) return 'Windows 7';
        if (str_contains($lower, 'windows')) return 'Windows';
        if (str_contains($lower, 'macintosh') || str_contains($lower, 'mac os x')) return 'macOS';
        if (str_contains($lower, 'linux')) return 'Linux';
        if (str_contains($lower, 'cros')) return 'Chrome OS';
        return 'Other';
    }

    public static function detectBrowser(string $ua): string
    {
        $lower = strtolower($ua);
        if (str_contains($lower, 'edg/') || str_contains($lower, 'edge/')) return 'Microsoft Edge';
        if (str_contains($lower, 'opr/') || str_contains($lower, 'opera')) return 'Opera';
        if (str_contains($lower, 'samsungbrowser')) return 'Samsung Internet';
        if (str_contains($lower, 'ucbrowser')) return 'UC Browser';
        if (str_contains($lower, 'chrome') || str_contains($lower, 'crios')) return 'Google Chrome';
        if (str_contains($lower, 'firefox') || str_contains($lower, 'fxios')) return 'Mozilla Firefox';
        if (str_contains($lower, 'safari') && !str_contains($lower, 'chrome')) return 'Apple Safari';
        return 'Browser Lainnya';
    }

    public static function parseReferrerHost(?string $referrer): ?string
    {
        if (!$referrer) {
            return 'Direct (Langsung)';
        }
        $host = parse_url($referrer, PHP_URL_HOST);
        if (!$host) {
            return 'Direct (Langsung)';
        }
        $host = strtolower($host);

        // Friendly name for popular search & social referrers
        if (str_contains($host, 'google.')) return 'Google Search';
        if (str_contains($host, 'bing.')) return 'Bing Search';
        if (str_contains($host, 'yahoo.')) return 'Yahoo Search';
        if (str_contains($host, 'whatsapp')) return 'WhatsApp';
        if (str_contains($host, 'instagram')) return 'Instagram';
        if (str_contains($host, 'facebook') || str_contains($host, 'fb.com')) return 'Facebook';
        if (str_contains($host, 'twitter') || str_contains($host, 't.co') || str_contains($host, 'x.com')) return 'Twitter / X';
        if (str_contains($host, 'tiktok')) return 'TikTok';
        if (str_contains($host, 'amiktaruna')) return 'Internal Kampus';

        return Str::limit($host, 45);
    }

    public static function resolvePageName(string $path): string
    {
        $cleanPath = trim($path, '/');
        if (empty($cleanPath) || $cleanPath === '') {
            return 'Beranda Utama';
        }

        $segments = explode('/', $cleanPath);
        $first = $segments[0];

        return match ($first) {
            'berita'          => isset($segments[1]) ? 'Berita: ' . Str::title(str_replace('-', ' ', $segments[1])) : 'Daftar Berita Kampus',
            'pmb'             => 'Pendaftaran Mahasiswa Baru (PMB)',
            'tentang'         => 'Profil & Struktur Kampus',
            'akademik'        => 'Program Studi & Kurikulum',
            'mahasiswa'       => 'Pelayanan Mahasiswa & SIAKAD',
            'dokumen-kampus'  => 'Dokumen Resmi Kampus',
            'ppm'             => 'Penjaminan Mutu (PPM / SPMI)',
            'lppm'            => 'Lembaga Penelitian (LPPM)',
            'halaman'         => isset($segments[1]) ? 'Halaman: ' . Str::title(str_replace('-', ' ', $segments[1])) : 'Halaman Informasi',
            'kontak'          => 'Hubungi Kami',
            'alumni'          => 'Tracer Study & Alumni',
            'kalender-akademik' => 'Kalender Akademik',
            'jadwal-kuliah'   => 'Jadwal Perkuliahan',
            default           => Str::title(str_replace(['-', '_'], ' ', $first)),
        };
    }
}
