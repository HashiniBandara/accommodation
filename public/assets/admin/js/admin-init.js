/**
 *
 * @param {*} element           HTML Element
 * @param {2} maxFileSize       Max File Size (MB)
 * @param {*} uploadPath        Upload Path
 * @param {1} maxFiles          Max File Count
 * @param {"image/*"} acceptedFiles     Accepted File Types
 */
function init_dropzone(element, maxFileSize = 2, uploadPath = "", maxFiles = 1, acceptedFiles = "image/*") {

    $(element).each(function (index, el) {
        var settings_dropzone = new Dropzone(el, {
            url: HOST_URL + 'store-image',
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: maxFileSize, // MB
            addRemoveLinks: true,
            maxFiles: maxFiles,
            uploadMultiple: false,
            acceptedFiles: acceptedFiles,
            parallelUploads: maxFiles,
            params: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                destinationPath: uploadPath
            },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    formData.append("uploadPath", uploadPath);
                    formData.append("maxFileSize", maxFileSize);
                });
                this.on("success", function (file, data) {

                    if (data.status) {
                        if (acceptedFiles != 'video/mp4') {
                            $(this.element).parent().find('.dropzone-image').html('<img src="' + data.full_path + '" alt="" class="img-preview"/><a href="#" data-rmid="' + element.substring(1) + '" class="image-remove remove-upload-image">X</a>');
                        }
                        $(this.element).parent().find('.dropzone-value').val(data.full_path);
                        $(this.element).addClass('d-none');
                        $(this.element).parent().find('.dropzone-image').removeClass('d-none');
                        settings_dropzone.removeAllFiles();
                    }
                });
            },
        });

    });
}

/**
 *
 * @param {*} element           HTML Element
 * @param {*} maxFileSize       Max File Size
 * @param {*} uploadPath        Upload Path
 * @param {*} maxFiles          Max File Count
 * @param {*} inputGroupname    HTML input group name
 * @param {*} acceptedFiles     Accepted File Types
 */
function init_multiple_dropzone(element, maxFileSize = 2, uploadPath = "", maxFiles = 1, inputGroupname = 'upload_fiels', acceptedFiles = "image/*") {

    $(element).each(function (index, el) {
        var multipleDropzone = new Dropzone(el, {
            url: HOST_URL + 'store-image',
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: maxFileSize, // MB
            addRemoveLinks: true,
            maxFiles: maxFiles,
            uploadMultiple: false,
            acceptedFiles: acceptedFiles,
            parallelUploads: maxFiles,
            params: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                destinationPath: uploadPath
            },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    formData.append("uploadPath", uploadPath);
                    formData.append("maxFileSize", maxFileSize);
                });
                this.on("success", function (file, data) {

                    if (data.status) {
                        if (acceptedFiles == 'image/*') {
                            $(this.element).parent().find('.dropzone-files').append('<div class="col-sm-12 col-md-4 col-lg-3 mt-5"><div class="dropzone-image">' +
                                '<img src="' + data.full_path + '" alt="" class="img-preview"/><a href="#" class="image-remove remove-upload-image-multiple">X</a>' +
                                '<input type="hidden" name="' + inputGroupname + '[]" class="dropzone-value" value="' + data.full_path + '" />' +
                                '</div><p class="form-text text-muted text-center">' + data.file_name + '</p></div></div>'
                            );
                        } else {
                            $(this.element).parent().find('.dropzone-files').append('<div class="col-sm-12 col-md-4 col-lg-3 mt-5"><div class="dropzone-image"><div class="dropzone-image-inner"><i class="fas fa-file"></i>' +
                                '<a href="#" class="image-remove remove-upload-doc">X</a>' +
                                '<input type="hidden" name="' + inputGroupname + '[]" class="dropzone-value" value="' + data.full_path + '" />' +
                                '</div><p class="form-text text-muted text-center">' + data.file_name + '</p></div></div>'
                            );
                            $(this.element).parent().find('.dropzone-image').html('<img src="' + data.full_path + '" alt="" class="img-preview"/><a href="#" class="image-remove remove-upload-image-multiple">X</a>');
                        }
                    }
                });
                this.on("complete", function (file) {
                    multipleDropzone.removeFile(file);
                });
            },
        });

    });
}

$('body').on('click', '.remove-upload-image', function (e) {
    e.preventDefault();
    let image = $(this).parents().eq(2).find('.dropzone-value').val();
    $('#removedFiles').append('<input type="hidden" name="remove[]" value="' + image + '" />');
    $(this).parents().eq(2).find('.dropzone-value').val(null);
    $(this).parents().eq(2).find('.dropzone-image').addClass('d-none');
    $(this).parents().eq(2).find('.dropzone').removeClass('d-none');
    $(this).parents().eq(2).find('.dropzone-image').html('');
});

$('body').on('click', '.remove-upload-image-multiple', function (e) {
    e.preventDefault();
    $(this).parents().eq(1).remove();

});

var default_error = {
    errorTemplate: '<li class="alert alert-danger"></li>',
    errorsWrapper: '<ul class="parsley-errors-list px-0 mt-3"></ul>',
};

jQuery(document).ready(function ($) {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    tinymce.init({
        selector: '.tinymce-editor',
        toolbar1: 'formatselect | fontsizeselect bold italic strikethrough | forecolor backcolor | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | code | removeformat',
        extended_valid_elements: 'span[style]',
        height: '400',
        plugins: 'code lists advlist',
        inline_styles: true,
    });

    if ($('.select-2').length) {
        $('.select-2').each(function () {
            let options = {};
            if ($(this).attr('placeholder')) {
                options['placeholder'] = $(this).attr('placeholder');
            }
            $(this).select2(options);
        });
    }

    if ($('.date-range-picker').length > 0) {
        $('.date-range-picker').daterangepicker({
            minDate: new Date(),
            drops: 'auto',
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    }

    if ($('.time-picker').length > 0) {
        $('.time-picker').timepicker();
    }

    if ($('.date-picker').length > 0) {
        $('.date-picker').daterangepicker({
            drops: 'auto',
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    }

    $('.menu-link').each(function () {
        let curURL = window.location.href;
        if (curURL == $(this).attr('href')) {
            $(this).parent().addClass('menu-item-active');
            $(this).parent().closest('.menu-item-submenu').addClass('menu-item-open');
        }
    });

    // Compile Assets Toggle
    $('#compileAssets').on('change', function () {
        let compileAssets = ($(this).is(':checked')) ? 1 : 0;
        let inputName = $(this).attr('name');
        var data = { 'module_key': THEME_STTEINGS_KEY };
        data[inputName] = compileAssets;
        $.ajax({
            type: "POST",
            url: HOST_URL + 'settings/save/config',
            data: data,
            success: function (response) {
                console.log(response);
                if (!response['status']) {
                    $('#compileAssets').prop('checked', false);
                }
            }
        });
    });

    if($('.max-length-input').length){
        $('.max-length-input').maxlength({
            warningClass: "label label-warning label-rounded label-inline",
            limitReachedClass: "label label-success label-rounded label-inline"
        });
    }

});



function initTableExport(table) {

    $('#export_print').on('click', function (e) {
        e.preventDefault();
        table.button(0).trigger();
    });

    $('#export_copy').on('click', function (e) {
        e.preventDefault();
        table.button(1).trigger();
    });

    $('#export_excel').on('click', function (e) {
        e.preventDefault();
        table.button(2).trigger();
    });

    $('#export_csv').on('click', function (e) {
        e.preventDefault();
        table.button(3).trigger();
    });

    $('#export_pdf').on('click', function (e) {
        e.preventDefault();
        table.button(4).trigger();
    });

}

function createSlug(inputElement, outputElement) {

    $(inputElement).on('input focusout', function () {
        $(outputElement).val(getSlug($(inputElement).val()));
    });

    $(outputElement + ',' + inputElement).on('focusout', function () {
        if ($(this).val() == '') {
            $(outputElement).val(getSlug($(inputElement).val()));
        }
    });

}

function getSlug(value) {
    value = value.trim();
    return value.toLowerCase().replace(/ +/g, '-').replace(/[^a-z0-9-_]/g, '').trim();
}

function thousands_separators(num) {
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}

const themeSwal = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary btn-lg',
        cancelButton: 'btn btn-secondary btn-lg'
    },
    buttonsStyling: false
})

const BLOK_PAGE_DEFAULTS = {
    overlayColor: '#000000',
    state: 'primary',
    message: 'Processing...'
};
