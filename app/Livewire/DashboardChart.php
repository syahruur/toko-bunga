<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;

class DashboardChart extends Component
{
    public $adminData = [];
    public $customerData = [];

    public function mount()
    {
        if (Auth::user()->isAdmin()) {
            // Penjualan bulanan (jumlah pesanan & total pendapatan)
            $ordersByMonth = Order::selectRaw('strftime("%m-%Y", created_at) as month_year, count(*) as total_orders, sum(total_amount) as total_income')
                ->groupBy('month_year')
                ->orderBy('month_year')
                ->get();
            $orderMonths = $ordersByMonth->pluck('month_year')->toArray();
            $orderCounts = $ordersByMonth->pluck('total_orders')->toArray();
            $orderIncomes = $ordersByMonth->pluck('total_income')->toArray();

            // Produk terlaris
            $topProducts = \App\Models\Product::select('products.name')
                ->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->selectRaw('sum(order_items.quantity) as sold')
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('sold')
                ->limit(5)
                ->get();

            // Status pesanan
            $statusCounts = Order::selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')->toArray();

            // User baru per bulan
            $usersByMonth = User::selectRaw('strftime("%m-%Y", created_at) as month_year, count(*) as total')
                ->groupBy('month_year')
                ->orderBy('month_year')
                ->get();
            $userMonths = $usersByMonth->pluck('month_year')->toArray();
            $userCounts = $usersByMonth->pluck('total')->toArray();

            $this->adminData = [
                'orders' => [
                    'labels' => $orderMonths,
                    'data' => $orderCounts,
                    'income' => $orderIncomes,
                ],
                'top_products' => [
                    'labels' => $topProducts->pluck('name')->toArray(),
                    'data' => $topProducts->pluck('sold')->toArray(),
                ],
                'status' => $statusCounts,
                'users' => [
                    'labels' => $userMonths,
                    'data' => $userCounts,
                ],
            ];
        } else {
            $user = Auth::user();
            // Pengeluaran bulanan
            $spendingByMonth = $user->orders()
                ->selectRaw('strftime("%m-%Y", created_at) as month_year, sum(total_amount) as total')
                ->groupBy('month_year')
                ->orderBy('month_year')
                ->get();
            $spendingMonths = $spendingByMonth->pluck('month_year')->toArray();
            $spendingTotals = $spendingByMonth->pluck('total')->toArray();
            // Status pesanan
            $statusCounts = $user->orders()->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status')->toArray();
            $this->customerData = [
                'spending' => [
                    'labels' => $spendingMonths,
                    'data' => $spendingTotals,
                ],
                'status' => $statusCounts,
            ];
        }
    }

    public function render()
    {
        return view('livewire.dashboard-chart');
    }
}
