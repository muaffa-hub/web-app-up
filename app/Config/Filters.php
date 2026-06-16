<?php

namespace Config;

use App\Filters\AdminOnlyFilter;
use App\Filters\AuthFilter;
use App\Filters\MaintenanceFilter;
use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,
        'auth'          => AuthFilter::class,
        'adminonly'     => AdminOnlyFilter::class,
        'maintenance'   => MaintenanceFilter::class,
    ];

    public array $required = [
        'before' => [
            // 'forcehttps', // Aktifkan di production
            'pagecache',
        ],
        'after' => [
            'pagecache',
            'performance',
            'toolbar',
        ],
    ];

    public array $globals = [
        'before' => [
            'csrf' => ['except' => ['api/*']],
        ],
        'after' => [],
    ];

    public array $methods = [];

    public array $filters = [
        'auth:petugas' => [
            'before' => ['admin/*'],
        ],
        'adminonly' => [
            'before' => [
                'admin', 'admin/dashboard',
                'admin/categories', 'admin/categories/*',
                'admin/products', 'admin/products/*',
                'admin/coupons', 'admin/coupons/*',
                'admin/print-pricing', 'admin/print-pricing/*',
                'admin/reports', 'admin/reports/*',
                'admin/store-info', 'admin/store-info/*',
                'admin/maintenance', 'admin/maintenance/*',
                'admin/petugas', 'admin/petugas/*',
            ],
        ],
        'auth:customer' => [
            'before' => ['customer/*'],
        ],
        'maintenance:website' => [
            'before' => ['/', 'catalog', 'catalog/*', 'product/*', 'info', 'order/*', 'customer/*'],
        ],
        'maintenance:produk' => [
            'before' => ['catalog', 'catalog/*', 'product/*', 'customer/cart', 'customer/cart/*', 'customer/checkout', 'customer/checkout/*', 'customer/wishlist', 'customer/wishlist/*'],
        ],
        'maintenance:print' => [
            'before' => ['customer/print', 'customer/print/*'],
        ],
    ];
}
