@php
    // ADMIN CHART DATA
    $orderChart = [
        'labels' => $adminData['orders']['labels'] ?? [],
        'datasets' => [
            [
                'label' => 'Jumlah Pesanan',
                'data' => $adminData['orders']['data'] ?? [],
                'backgroundColor' => 'rgba(236, 72, 153, 0.7)',
                'yAxisID' => 'y',
            ],
            [
                'label' => 'Total Pendapatan',
                'data' => $adminData['orders']['income'] ?? [],
                'backgroundColor' => 'rgba(34,197,94,0.5)',
                'borderColor' => 'rgba(34,197,94,1)',
                'type' => 'line',
                'yAxisID' => 'y1',
            ]
        ]
    ];
    $topProductsChart = [
        'labels' => $adminData['top_products']['labels'] ?? [],
        'datasets' => [[
            'label' => 'Produk Terlaris',
            'data' => $adminData['top_products']['data'] ?? [],
            'backgroundColor' => 'rgba(59,130,246,0.7)',
        ]]
    ];
    $statusChart = [
        'labels' => array_keys($adminData['status'] ?? []),
        'datasets' => [[
            'label' => 'Status Pesanan',
            'data' => array_values($adminData['status'] ?? []),
            'backgroundColor' => [
                'rgba(236,72,153,0.7)', 'rgba(59,130,246,0.7)', 'rgba(34,197,94,0.7)', 'rgba(251,191,36,0.7)'
            ],
        ]]
    ];
    $userChart = [
        'labels' => $adminData['users']['labels'] ?? [],
        'datasets' => [[
            'label' => 'User Baru',
            'data' => $adminData['users']['data'] ?? [],
            'backgroundColor' => 'rgba(251,191,36,0.7)',
        ]]
    ];
    // CUSTOMER CHART DATA
    $spendingChart = [
        'labels' => $customerData['spending']['labels'] ?? [],
        'datasets' => [[
            'label' => 'Pengeluaran',
            'data' => $customerData['spending']['data'] ?? [],
            'backgroundColor' => 'rgba(236, 72, 153, 0.5)',
            'borderColor' => 'rgba(236, 72, 153, 1)',
            'fill' => true,
        ]]
    ];
    $custStatusChart = [
        'labels' => array_keys($customerData['status'] ?? []),
        'datasets' => [[
            'label' => 'Status Pesanan',
            'data' => array_values($customerData['status'] ?? []),
            'backgroundColor' => [
                'rgba(236,72,153,0.7)', 'rgba(59,130,246,0.7)', 'rgba(34,197,94,0.7)', 'rgba(251,191,36,0.7)'
            ],
        ]]
    ];
@endphp
<div>
    @if(auth()->user()->isAdmin())
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow mb-6">
                <h2 class="text-lg font-bold text-zinc-100 mb-4">Penjualan & Pendapatan per Bulan</h2>
                @if(empty(array_filter($orderChart['labels'])) || empty(array_filter($orderChart['datasets'][0]['data'])))
                    <div class="text-zinc-400 text-center py-8">Tidak ada data penjualan.</div>
                @else
                    <canvas id="admin-orders-chart" height="100" data-chart='@json($orderChart)'></canvas>
                @endif
            </div>
            <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow mb-6">
                <h2 class="text-lg font-bold text-zinc-100 mb-4">Produk Terlaris</h2>
                @if(empty(array_filter($topProductsChart['labels'])) || empty(array_filter($topProductsChart['datasets'][0]['data'])))
                    <div class="text-zinc-400 text-center py-8">Tidak ada data produk terlaris.</div>
                @else
                    <canvas id="admin-top-products-chart" height="100" data-chart='@json($topProductsChart)'></canvas>
                @endif
            </div>
            <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow mb-6">
                <h2 class="text-lg font-bold text-zinc-100 mb-4">Status Pesanan</h2>
                @if(empty(array_filter($statusChart['labels'])) || empty(array_filter($statusChart['datasets'][0]['data'])))
                    <div class="text-zinc-400 text-center py-8">Tidak ada data status pesanan.</div>
                @else
                    <canvas id="admin-status-chart" height="100" data-chart='@json($statusChart)'></canvas>
                @endif
            </div>
            <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow mb-6">
                <h2 class="text-lg font-bold text-zinc-100 mb-4">User Baru per Bulan</h2>
                @if(empty(array_filter($userChart['labels'])) || empty(array_filter($userChart['datasets'][0]['data'])))
                    <div class="text-zinc-400 text-center py-8">Tidak ada data user baru.</div>
                @else
                    <canvas id="admin-users-chart" height="100" data-chart='@json($userChart)'></canvas>
                @endif
            </div>
        </div>
    @else
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow mb-6">
                <h2 class="text-lg font-bold text-zinc-100 mb-4">Pengeluaran per Bulan</h2>
                @if(empty(array_filter($spendingChart['labels'])) || empty(array_filter($spendingChart['datasets'][0]['data'])))
                    <div class="text-zinc-400 text-center py-8">Tidak ada data pengeluaran.</div>
                @else
                    <canvas id="customer-spending-chart" height="100" data-chart='@json($spendingChart)'></canvas>
                @endif
            </div>
            <div class="bg-zinc-900 border border-zinc-700 rounded-xl p-6 shadow mb-6">
                <h2 class="text-lg font-bold text-zinc-100 mb-4">Status Pesanan</h2>
                @if(empty(array_filter($custStatusChart['labels'])) || empty(array_filter($custStatusChart['datasets'][0]['data'])))
                    <div class="text-zinc-400 text-center py-8">Tidak ada data status pesanan.</div>
                @else
                    <canvas id="customer-status-chart" height="100" data-chart='@json($custStatusChart)'></canvas>
                @endif
            </div>
        </div>
    @endif
</div>
