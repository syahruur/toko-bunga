document.addEventListener('DOMContentLoaded', renderCharts);
document.addEventListener('livewire:navigated', renderCharts);

function renderCharts() {
    if (typeof window.Chart === 'undefined') return;

    // Helper to destroy old chart instance if exists
    function createOrUpdateChart(canvas, config) {
        if (canvas._chartInstance) {
            canvas._chartInstance.destroy();
        }
        canvas._chartInstance = new window.Chart(canvas.getContext('2d'), config);
    }

    // Admin: Penjualan & Pendapatan per Bulan
    const adminOrders = document.getElementById('admin-orders-chart');
    if (adminOrders) {
        const chartData = JSON.parse(adminOrders.dataset.chart);
        createOrUpdateChart(adminOrders, {
            type: 'bar',
            data: chartData,
            options: {
                responsive: true,
                plugins: { legend: { display: true } },
                scales: {
                    y: { beginAtZero: true },
                    y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } }
                }
            }
        });
    }
    // Admin: Produk Terlaris
    const adminTopProducts = document.getElementById('admin-top-products-chart');
    if (adminTopProducts) {
        const chartData = JSON.parse(adminTopProducts.dataset.chart);
        createOrUpdateChart(adminTopProducts, {
            type: 'bar',
            data: chartData,
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    }
    // Admin: Status Pesanan
    const adminStatus = document.getElementById('admin-status-chart');
    if (adminStatus) {
        const chartData = JSON.parse(adminStatus.dataset.chart);
        createOrUpdateChart(adminStatus, {
            type: 'pie',
            data: chartData,
            options: { responsive: true, plugins: { legend: { display: true } } }
        });
    }
    // Admin: User Baru per Bulan
    const adminUsers = document.getElementById('admin-users-chart');
    if (adminUsers) {
        const chartData = JSON.parse(adminUsers.dataset.chart);
        createOrUpdateChart(adminUsers, {
            type: 'line',
            data: chartData,
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    }
    // Customer: Pengeluaran per Bulan
    const customerSpending = document.getElementById('customer-spending-chart');
    if (customerSpending) {
        const chartData = JSON.parse(customerSpending.dataset.chart);
        createOrUpdateChart(customerSpending, {
            type: 'line',
            data: chartData,
            options: { responsive: true, plugins: { legend: { display: false } } }
        });
    }
    // Customer: Status Pesanan
    const customerStatus = document.getElementById('customer-status-chart');
    if (customerStatus) {
        const chartData = JSON.parse(customerStatus.dataset.chart);
        createOrUpdateChart(customerStatus, {
            type: 'pie',
            data: chartData,
            options: { responsive: true, plugins: { legend: { display: true } } }
        });
    }
}
