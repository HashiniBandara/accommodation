$(document).ready(function ($) {

    if ($('#cardsTable').length > 0) {

        var cardsTable = $('#cardsTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": HOST_URL + "cards/list/ajax",
                "type": "POST",
                data: function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": [1, 5], "orderable": false },
                { "targets": [0], "width": "50px" },
                { "targets": [3,4,5], "className": "dt-center", "width": "150px" },
            ],
            buttons: [
                'print',
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
            ],
        });

        initTableExport(cardsTable);

        $('body').on('click', '.delete-btn', function (event) {
            event.preventDefault();
            let categoryID = $(this).data('id');
            if (!isNaN(categoryID)) {
                themeSwal.fire({
                    title: 'Are you sure you want to delete this card?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                    denyButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        KTApp.blockPage(BLOK_PAGE_DEFAULTS);
                        setTimeout(function () {
                            $.ajax({
                                type: "POST",
                                url: HOST_URL + 'cards/destroy',
                                data: { id: categoryID },
                                success: function (response) {
                                    KTApp.unblockPage();
                                    if (response['status']) {
                                        themeSwal.fire('Success', response['message'], 'success');
                                        cardsTable.ajax.reload();
                                    } else {
                                        themeSwal.fire('Error', response['message'], 'error');
                                    }
                                }
                            });
                        }, 50);
                    }
                })
            }
        });
    }

});
