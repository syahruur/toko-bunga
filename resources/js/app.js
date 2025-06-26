import Swal from 'sweetalert2';
import Chart from 'chart.js/auto';
import './chart-dashboard.js';
window.Swal = Swal;
window.Chart = Chart;

document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('swal:confirm', function (event) {
        const data = event.detail;
        Swal.fire({
            title: data.title || 'Yakin?',
            text: data.text || '',
            icon: data.type || 'warning',
            showCancelButton: true,
            confirmButtonText: data.confirmButtonText || 'Hapus',
            cancelButtonText: data.cancelButtonText || 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                // Panggil method Livewire langsung pada komponen aktif
                if (window.Livewire && window.Livewire.findAll) {
                    // Livewire v3: panggil method di semua komponen aktif (umumnya hanya satu)
                    window.Livewire.findAll().forEach(c => c.call(data.method));
                } else if (window.Livewire && window.Livewire.emit) {
                    // fallback Livewire v2
                    window.Livewire.emit(data.method);
                } else if (window.livewire) {
                    window.livewire.emit(data.method);
                }
            }
        });
    });
});