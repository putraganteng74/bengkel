function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(angka);
}

function updateHarga(select) {
    const harga = parseFloat(select.options[select.selectedIndex].dataset.harga || 0);
    const row = select.closest('tr');
    row.querySelector('.harga').value = formatRupiah(harga);
    row.querySelector('.harga').setAttribute("data-value", harga); // simpan angka asli
    updateSubtotal(select);
}

function updateSubtotal(element) {
    const row = element.closest('tr');
    const harga = parseFloat(row.querySelector('.harga').getAttribute("data-value") || 0);
    const jumlah = parseInt(row.querySelector('.jumlah').value || 1);
    const subtotal = harga * jumlah;

    row.querySelector('.subtotal').value = formatRupiah(subtotal);
    row.querySelector('.subtotal').setAttribute("data-value", subtotal);
    updateTotal();
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal').forEach(input => {
        total += parseFloat(input.getAttribute("data-value") || 0);
    });

    document.getElementById('total_display').value = formatRupiah(total);
    document.getElementById('total').value = total; // angka asli untuk backend
}

function tambahBarang() {
    const row = document.querySelector('#tabel-barang tbody tr');
    const newRow = row.cloneNode(true);

    newRow.querySelectorAll('input').forEach(input => {
        input.value = '';
        input.removeAttribute("data-value");
    });

    newRow.querySelector('.barang-select').selectedIndex = 0;

    document.querySelector('#tabel-barang tbody').appendChild(newRow);
}

function hapusBaris(button) {
    // Cari tr terdekat lalu hapus
    let row = button.closest('tr');
    row.remove();

    // Update total setelah hapus
    updateTotal();
}

