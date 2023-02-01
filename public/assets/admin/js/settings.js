jQuery(document).ready(function ($) {

    if ($('.image-dropzone').length) {
        init_dropzone('.image-dropzone', 2, uploadUrl);
    }

    $('#footerMenu1Addbtn').on('click', function (event) {
        event.preventDefault();
        let title = $('#footerMenu1Title').val();
        let link = $('#footerMenu1Link').val();

        if (!title || !link) {
            Swal.fire(
                'Error',
                'Title and link cannot be empty',
                'error'
            );
            return;
        }
        let itemKey = $('#footerMenu1Items .row').length + 1;
        $('#footerMenu1Items').append('<div class="row mt-5">' +
            '<div class="col-sm-12 col-lg-4">' +
            '<button type="button" class="btn btn-danger btn-xs mr-5 btn-icon footer-menu-remove" id="footerMenu1Addbtn">' +
            '<i class="fas fa-trash-alt"></i></button>' +
            '<input type="hidden" name="' + SETTINGS_SEPARATOR + 'footer_menu_1[' + itemKey + '][title]" value="' + title + '">' + title +
            '</div>' +
            '<div class="col-sm-12 col-lg-8"><input type="hidden" name="' + SETTINGS_SEPARATOR + 'footer_menu_1[' + itemKey + '][link]" value="' + link + '">' + link +
            '</div>' +
            '</div>');

        $('#footerMenu1Title').val('');
        $('#footerMenu1Link').val('');
    });

    $('#footerMenu2Addbtn').on('click', function (event) {
        event.preventDefault();
        let title = $('#footerMenu2Title').val();
        let link = $('#footerMenu2Link').val();
    
        if (!title || !link) {
            Swal.fire(
                'Error',
                'Title and link cannot be empty',
                'error'
            );
            return;
        }
        let itemKey = $('#footerMenu2Items .row').length + 1;
        $('#footerMenu2Items').append('<div class="row mt-5">' +
            '<div class="col-sm-12 col-lg-4">' +
            '<button type="button" class="btn btn-danger btn-xs mr-5 btn-icon footer-menu-remove" id="footerMenu2Addbtn">' +
            '<i class="fas fa-trash-alt"></i></button>' +
            '<input type="hidden" name="' + SETTINGS_SEPARATOR + 'footer_menu_2[' + itemKey + '][title]" value="' + title + '">' + title +
            '</div>' +
            '<div class="col-sm-12 col-lg-8"><input type="hidden" name="' + SETTINGS_SEPARATOR + 'footer_menu_2[' + itemKey + '][link]" value="' + link + '">' + link +
            '</div>' +
            '</div>');
    
        $('#footerMenu2Title').val('');
        $('#footerMenu2Link').val('');
    });

    $('body').on('click', '#footerMenu1Items .footer-menu-remove', function (event) {
        event.preventDefault();
        $(this).parents().eq(1).remove();
        if(!$('#footerMenu1Items .row').length){
            $('#footerMenu1Items').html('<input type="hidden" name="' + SETTINGS_SEPARATOR + 'footer_menu_1" value="">');
        }
    });

    $('body').on('click', '#footerMenu2Items .footer-menu-remove', function (event) {
        event.preventDefault();
        $(this).parents().eq(1).remove();
        if(!$('#footerMenu2Items .row').length){
            $('#footerMenu2Items').html('<input type="hidden" name="' + SETTINGS_SEPARATOR + 'footer_menu_2" value="">');
        }
    });

});