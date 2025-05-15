function updateHarga(select) {
        const harga = parseFloat(select.options[select.selectedIndex].dataset.harga || 0);
        const row = select.closest('tr');
        row.querySelector('.harga').value = harga;
        updateSubtotal(select);
    }

    function updateSubtotal(element) {
        const row = element.closest('tr');
        const harga = parseFloat(row.querySelector('.harga').value || 0);
        const jumlah = parseInt(row.querySelector('.jumlah').value || 1);
        const subtotal = harga * jumlah;
        row.querySelector('.subtotal').value = subtotal.toFixed(2);
        updateTotal();
    }

    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.subtotal').forEach(input => {
            total += parseFloat(input.value || 0);
        });

        const formatted = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR'
        }).format(total);

        document.getElementById('total').value = formatted;
    }

    function tambahBarang() {
        const row = document.querySelector('#tabel-barang tbody tr');
        const newRow = row.cloneNode(true);

        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
        });

        newRow.querySelector('.barang-select').selectedIndex = 0;

        document.querySelector('#tabel-barang tbody').appendChild(newRow);
    }

    function hapusBaris(btn) {
        const tbody = document.querySelector('#tabel-barang tbody');
        if (tbody.rows.length > 1) {
            btn.closest('tr').remove();
            updateTotal();
        }
    }

    document.addEventListener('DOMContentLoaded', () => updateTotal());