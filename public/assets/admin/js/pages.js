jQuery(document).ready(function ($) {

    /* Start: Home Page Settings */

    // if ($('.image-dropzone').length) {
    //     init_dropzone('.image-dropzone', 2, uploadUrl);
    // }

    if ($('.banner-dropzone').length) {
        var bannerDropzone = new Dropzone('.banner-dropzone', {
            url: HOST_URL + 'store-image',
            paramName: "file", // The name that will be used to transfer the file
            maxFilesize: 2, // MB
            addRemoveLinks: true,
            uploadMultiple: false,
            acceptedFiles: 'image/*',
            parallelUploads: 1,
            params: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                destinationPath: 'home/banner'
            },
            init: function () {
                this.on("sending", function (file, xhr, formData) {
                    formData.append("uploadPath", 'home/banner');
                    formData.append("maxFileSize", 2);
                });
                this.on("success", function (file, data) {
                    let bannerCount = $('.banner-item').length;
                    if (data.status) {
                        let html = '<div class="col-sm-12 col-lg-4 mt-10 banner-item draggable">' +
                            '<div class="draggable-handle">' +
                            '<div class="mb-5">' +
                            '<img src="' + data.full_path + '" class="w-100">' +
                            '<input type="hidden" name="' + SETTINGS_SEPARATOR + 'home_banners[' + bannerCount + '][image]" value="' + data.full_path + '">' +
                            '</div>' +
                            '<div class="d-block">' +
                            '<input type="text" name="' + SETTINGS_SEPARATOR + 'home_banners[' + bannerCount + '][subheading]" class="form-control" placeholder="Sub Heading">' +
                            '<input type="text" name="' + SETTINGS_SEPARATOR + 'home_banners[' + bannerCount + '][heading]" class="form-control mt-3" placeholder="Heading">' +
                            '<button type="button" class="btn btn-danger mt-3">Remove</button>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        $('.banner-images').append(html);
                    }
                });
                this.on("queuecomplete", function (file, data) {
                    bannerDropzone.removeAllFiles();
                });
            },
        });

        $('body').on('click', '.banner-item .btn', function (event) {
            event.preventDefault();
            themeSwal.fire({
                title: 'Are you sure you want to delete this banner?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes! Delete',
                denyButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).parents().eq(2).remove();
                }
            });
        });

    }

    if ($('#kt_repeater_1').length) {
        KTFormRepeater.init();
    }

    var swappable;
    /* End : Home Page Settings */

    if ($('#pointsRepeater').length) {
        KTPointsRepeater.init();
    }

    if ($('#teamRepeater').length) {
        KTTeamRepeater.init();
    }
    
    if ($('.draggable-zone').length) {
        KTCardDraggable.init();
    }

});

var KTCardDraggable = function () {
    return {
        //main function to initiate the module
        init: function () {
            var containers = document.querySelectorAll('.draggable-zone');

            if (containers.length === 0) {
                return false;
            }

            swappable = new Sortable.default(containers, {
                draggable: '.draggable',
                handle: '.draggable .draggable-handle',
                mirror: {
                    appendTo: 'body',
                    constrainDimensions: true
                }
            });
        }
    };
}();

// Services Repeater
var KTFormRepeater = function () {

    var servicesRepeater;

    // Private functions
    var demo1 = function () {
        servicesRepeater = $('#kt_repeater_1').repeater({
            initEmpty: true,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
                if ($(this).find('.dropzone').length) {
                    let tempID = 'dz' + (new Date()).getTime();
                    $(this).find('.dropzone').attr('id', tempID);
                    init_dropzone('#' + tempID, '2MB', 'pages/home', 1, 'image/*');
                    tempID = 'te' + (new Date()).getTime();
                    $(this).find('.tm-editor').attr('id', tempID);
                    tinymce.init({
                        selector: '#' + tempID,
                        toolbar1: 'formatselect | fontsizeselect bold italic strikethrough | forecolor backcolor | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | code | removeformat',
                        extended_valid_elements: 'span[style]',
                        height: '400',
                        plugins: 'code lists advlist',
                        inline_styles: true,
                    });
                }

                if($('.max-length-input').length){
                    $('.max-length-input').maxlength({
                        warningClass: "label label-warning label-rounded label-inline",
                        limitReachedClass: "label label-success label-rounded label-inline"
                    });
                }
            },

            hide: function (deleteElement) {
                themeSwal.fire({
                    title: 'Are you sure you want to remove this service?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes! Remove',
                    denyButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).slideUp(deleteElement);
                    }
                });
            },
            ready: function (setIndexes) {
                setTimeout(() => {
                    $('.service-image').each(function () {
                        if ($(this).val()) {
                            $(this).parent().find('.dropzone').addClass('d-none');
                            $(this).parent().find('.dropzone-image').html('<img src="' + $(this).val() + '" alt="" class="img-preview"><a href="#" class="image-remove remove-upload-image">X</a>');
                        }
                    });
                }, 1000);
            },
        });
    }

    return {
        // public functions
        init: function () {
            demo1();
            servicesRepeater.setList(services);
        }
    };
}();

// Points Repeater
var KTPointsRepeater = function () {

    var pointsRepeater;

    // Private functions
    var demo1 = function () {
        pointsRepeater = $('#pointsRepeater').repeater({
            initEmpty: true,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
                if ($(this).find('.dropzone').length) {
                    let tempID = 'dz' + (new Date()).getTime();
                    $(this).find('.dropzone').attr('id', tempID);
                    init_dropzone('#' + tempID, '2MB', 'pages/about', 1, 'image/*');
                    tempID = 'te' + (new Date()).getTime();
                    $(this).find('.tm-editor').attr('id', tempID);
                    tinymce.init({
                        selector: '#' + tempID,
                        toolbar1: 'formatselect | fontsizeselect bold italic strikethrough | forecolor backcolor | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | code | removeformat',
                        extended_valid_elements: 'span[style]',
                        height: '400',
                        plugins: 'code lists advlist',
                        inline_styles: true,
                    });
                }

                if($('.max-length-input').length){
                    $('.max-length-input').maxlength({
                        warningClass: "label label-warning label-rounded label-inline",
                        limitReachedClass: "label label-success label-rounded label-inline"
                    });
                }
            },

            hide: function (deleteElement) {
                themeSwal.fire({
                    title: 'Are you sure you want to remove this item?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes! Remove',
                    denyButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).slideUp(deleteElement);
                    }
                });
            },
            ready: function (setIndexes) {
                setTimeout(() => {
                    $('.point-image').each(function () {
                        if ($(this).val()) {
                            $(this).parent().find('.dropzone').addClass('d-none');
                            $(this).parent().find('.dropzone-image').html('<img src="' + $(this).val() + '" alt="" class="img-preview"><a href="#" class="image-remove remove-upload-image">X</a>');
                        }
                    });
                }, 1000);
            },
        });
    }

    return {
        // public functions
        init: function () {
            demo1();
            pointsRepeater.setList(points);
        }
    };
}();

// Team Repeater
var KTTeamRepeater = function () {

    var teamRepeater;

    // Private functions
    var demo1 = function () {
        teamRepeater = $('#teamRepeater').repeater({
            initEmpty: true,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function () {
                $(this).slideDown();
                if ($(this).find('.dropzone').length) {
                    let tempID = 'dz' + (new Date()).getTime();
                    $(this).find('.dropzone').attr('id', tempID);
                    init_dropzone('#' + tempID, '2MB', 'pages/about', 1, 'image/*');
                    tempID = 'te' + (new Date()).getTime();
                    $(this).find('.tm-editor').attr('id', tempID);
                    tinymce.init({
                        selector: '#' + tempID,
                        toolbar1: 'formatselect | fontsizeselect bold italic strikethrough | forecolor backcolor | link image | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | code | removeformat',
                        extended_valid_elements: 'span[style]',
                        height: '400',
                        plugins: 'code lists advlist',
                        inline_styles: true,
                    });
                }
            },

            hide: function (deleteElement) {
                themeSwal.fire({
                    title: 'Are you sure you want to remove this item?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes! Remove',
                    denyButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).slideUp(deleteElement);
                    }
                });
            },
            ready: function (setIndexes) {
                setTimeout(() => {
                    $('.team-image').each(function () {
                        if ($(this).val()) {
                            $(this).parent().find('.dropzone').addClass('d-none');
                            $(this).parent().find('.dropzone-image').html('<img src="' + $(this).val() + '" alt="" class="img-preview"><a href="#" class="image-remove remove-upload-image">X</a>');
                        }
                    });
                }, 1000);
            },
        });
    }

    return {
        // public functions
        init: function () {
            demo1();
            teamRepeater.setList(team);
        }
    };
}();