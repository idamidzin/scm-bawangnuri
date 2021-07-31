<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Sidebar configuration
    |--------------------------------------------------------------------------
    |
    | Use this configuration format for a static sidebar menu by adding or
    | removing items. This config is loaded from
    | Http\ViewComposers\SidebarViewComposer.php
    | In that file you can change how to get the sidebar menu configuration,
    | instead of using a static file, you can use a Model to obtain the
    | menu items dinamically from database applying own business logic.
    |
    */
    [
        'text' => 'Menu Utama',
        'heading' => true,
        'translate' => 'sidebar.heading.HEADER'
    ],
    [
        'id' => 'dashboard',
        'role' => [1,2,3,4],
        'text' => 'Dashboard',
        'route' => 'dashboard',
        'icon' => 'icon-speedometer',
        'alert' => '3'
    ],
    [
        'id' => 'bahan-baku',
        'role' => [2],
        'text' => 'Bahan Baku',
        'route' => 'supplier/bahan',
        'icon' => 'fas fa-list-alt',
        'alert' => '3'
    ],
    [
        'id' => 'pesanan',
        'role' => [2],
        'text' => 'Pesanan',
        'route' => 'supplier/pesanan',
        'icon' => 'fas fa-hand-holding-usd',
        'alert' => '3'
    ],
    [
        'id' => 'pengguna',
        'role' => [1],
        'text' => 'Pengguna',
        'route' => 'admin/pengguna',
        'icon' => 'fas fa-user',
        'alert' => '30'
    ],
    [
        'id' => 'produk',
        'role' => [1],
        'text' => 'Produk',
        'route' => 'admin/produk',
        'icon' => 'fas fa-shopping-bag',
        'alert' => '3'
    ],
    [
        'id' => 'pesanan-produk',
        'role' => [1],
        'text' => 'Pesanan Produk',
        'route' => 'admin/pesanan-produk',
        'icon' => 'fas fa-shopping-cart',
        'alert' => '3'
    ],
    [
        'id' => 'order-bahan-baku',
        'role' => [1],
        'text' => 'Order Bahan Baku',
        'route' => 'admin/order',
        'icon' => 'fas fa-list-alt',
        'alert' => '3'
    ],
    [
        'id' => 'order-produk',
        'role' => [3],
        'text' => 'Order Produk',
        'route' => 'distributor/order',
        'icon' => 'fas fa-list-alt',
        'alert' => '3'
    ],
    // [
    //     'role' => [1],
    //     'text' => 'Pengaturan Stok',
    //     'route' => 'admin/pengaturan',
    //     'icon' => 'icon-settings',
    //     'alert' => '3'
    // ],
    [
        'id' => 'laporan',
        'role' => [1,2,3,4],
        'text' => 'Laporan',
        'route' => 'laporan',
        'icon' => 'fas fa-book',
        'alert' => '30',
        'submenu' => [
            [
                'id' => 'transaksi-order',
                'role' => [3],
                'text' => 'Transaksi Order',
                'route' => 'distributor/laporan-transaksi-order'
            ],
            [
                'id' => 'pengeluaran-bahan-baku',
                'role' => [1,4],
                'text' => 'Pengeluaran (Bahan Baku)',
                'route' => 'admin/laporan-transaksi-bahan-baku'
            ],
            [
                'role' => [1,4],
                'text' => 'Pendapatan (Produk Jadi)',
                'route' => 'admin/laporan-transaksi-produk-jadi'
            ]
        ]
    ],
    [
        'text' => 'Pengaturan',
        'heading' => true,
        'translate' => 'sidebar.heading.HEADER'
    ],
    [
        'id' => 'profile',
        'role' => [1,4],
        'text' => 'Profile',
        'route' => 'admin/profile',
        'icon' => 'icon-settings',
        'alert' => '3'
    ],
    [
        'id' => 'profile',
        'role' => [2],
        'text' => 'Profile',
        'route' => 'supplier/profile',
        'icon' => 'icon-settings',
        'alert' => '3'
    ],
    [
        'id' => 'profile',
        'role' => [3],
        'text' => 'Profile',
        'route' => 'distributor/profile',
        'icon' => 'icon-settings',
        'alert' => '3'
    ]
];
