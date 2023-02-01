jQuery(function ($) {

    if ($('#new_role').length > 0) {

        $(document).on("change", "#custom_permissions", function (e) {
            if ($(this).val() == "0") {
                $('#permission_list_create').hide();
            } else {
                $('#permission_list_create').show();
            }
        });

        $('#create_new_role_form').parsley(default_error).on('form:validated', function () {
            $('#insertModal').modal('toggle');
        });

        $('#permission_list_create').jstree({
            "plugins": ["checkbox", "types"],
            "types": {
                "default": {
                    "icon": "fa fa-folder text-primary"
                },
                "file": {
                    "icon": "fa fa-file  text-primary"
                }
            },
        }).on('changed.jstree', function (e, data) {
            var i, j, r = [];
            for (i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).id);

            }
            $('#create_role_permissions').val(r.join(','));
        });
    }

    if ($('#update_role').length > 0) {
        $(document).on("change", "#custom_permissions", function (e) {
            if ($(this).val() == "0") {
                $('#permission_list').hide();
                $("#permission_list").jstree("check_all");
            } else {
                $('#permission_list').show();
            }
        });

        $('#edit_role_form').parsley(default_error).on('form:validated', function () {
            $('#insertModal').modal('toggle');
        });

        $('#permission_list').jstree({
            "plugins": ["checkbox", "types"],
            "types": {
                "default": {
                    "icon": "fa fa-folder text-primary"
                },
                "file": {
                    "icon": "fa fa-file  text-primary"
                }
            },
        }).on('changed.jstree', function (e, data) {
            var i, j, r = [];
            for (i = 0, j = data.selected.length; i < j; i++) {
                r.push(data.instance.get_node(data.selected[i]).id);

            }
            $('#update_role_permissions').val(r.join(','));
        });
    }

    if ($('#userRoleTable').length > 0) {

        var userRoleTable = $('#userRoleTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [[10, 25, 50, 10000], [10, 25, 50, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": HOST_URL + "user-role/list/ajax",
                "type": "POST",
                data: function (d) {
                    d._token = $('meta[name="csrf-token"]').attr('content');
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                { "targets": ['actions'], "orderable": false, },
                { "width": "50px", "targets": ['id'] },
                { "width": "50%", "targets": ['role'] },
                { "className": "dt-center", "width": "10%", "targets": ['status'] },
                { "className": "dt-center", "width": "12%", "targets": ['actions'] },

            ],
            buttons: [
                'print',
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5',
            ],
        });

        initTableExport(userRoleTable);

        $('body').on('click', '.delete-btn', function (event) {
            event.preventDefault();
            let id = $(this).data('id');
            if (!isNaN(id)) {
                themeSwal.fire({
                    title: 'Are you sure you want to delete this user role?',
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
                                url: HOST_URL + 'user-role/delete',
                                data: { r_id: id },
                                success: function (response) {
                                    KTApp.unblockPage();
                                    if (response['status']) {
                                        themeSwal.fire('Success', response['message'], 'success');
                                        userRoleTable.ajax.reload();
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
