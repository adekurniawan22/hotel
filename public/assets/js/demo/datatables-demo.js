// Call the dataTables jQuery plugin
$(document).ready(function () {
    $("#dataTable").DataTable();
});

$(document).ready(function () {
    $("#reservasiDataTable").DataTable({
        order: [[0, "desc"]], // Sorting by the first column in descending order
        columnDefs: [
            { visible: false, targets: 0 }, // Hiding the first column (ID Reservasi)
        ],
    });
});
