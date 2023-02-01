jQuery(function ($) {

    if($('#new_accommodationDetail').length > 0){

        $('#create_new_accommodationDetail_form').parsley(default_error).on('form:validated', function() {
            $('#insertModal').modal('toggle');
        });
        //        $('#create_new_accommodationDetail_form').parsley(default_error).on('form:validated', function() {
    }

    if($('#update_accommodationDetail').length > 0){
        init_dropzone('.image-dropzone-profile', 2, "accommodationDetail_image");

        // $('#edit_accommodationDetail_form').parsley(default_error).on('form:validated', function() {
        //     $('#insertModal').modal('toggle');
        // });

    }

    if ($('#accommodationDetailTable').length > 0) {

        var accommodationDetailTable = $('#accommodationDetailTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [ [10, 25, 50, 10000], [10, 25, 50, "All"] ],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": HOST_URL + "accommodation/accommodation_detail_list/ajax",
                "type": "POST",
                data: function (d) {
                    d._token =  $('meta[name="csrf-token"]').attr('content');
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": ['actions'], "orderable": false, "className": "dt-center" ,"width": "12%" },
                { "width": "50px", "targets": ['id'] },
                { "className": "dt-center", "width": "10%", "targets": ['status'] },

            ],
            buttons: [
                'print',
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
            ],
        });

        initTableExport(accommodationDetailTable);

        $('body').on('click', '.delete-btn', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            if (!isNaN(id)) {
                themeSwal.fire({
                    title: 'Are you sure you want to delete this accommodation Detail?',
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
                                url: HOST_URL + 'accommodation/delete',
                                data: { id: id },
                                success: function (response) {
                                    KTApp.unblockPage();
                                    if (response['status']) {
                                        themeSwal.fire('Success', response['message'], 'success');
                                        accommodationDetailTable.ajax.reload();
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
