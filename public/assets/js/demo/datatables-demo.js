// Call the dataTables jQuery plugin
$(document).ready(function () {
    $("#dataTable").DataTable();
});

$(document).ready(function () {
    var tableSelector = "#reservasiDataTable";

    // Cek jika DataTable sudah diinisialisasi pada elemen dengan id 'reservasiDataTable'
    if (!$.fn.DataTable.isDataTable(tableSelector)) {
        // Jika belum diinisialisasi, lakukan inisialisasi
        $(tableSelector).DataTable({
            order: [[0, "desc"]], // Sorting by the first column in descending order
            columnDefs: [
                { visible: false, targets: 0 }, // Hiding the first column (ID Reservasi)
            ],
        });
    }
});

$(document).ready(function () {
    $("#kamarReservasiTable").DataTable({
        pageLength: 5, // Menampilkan 5 data per halaman
        lengthChange: false, // Menonaktifkan opsi perubahan jumlah entri yang ditampilkan
        lengthMenu: [5], // Mengatur hanya opsi 5 entri per halaman
    });
});
