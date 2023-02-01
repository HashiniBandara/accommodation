jQuery(document).ready(function ($) {

    var options = {
        // maxLevels: 5,
        insertZonePlus: true,
        opener: {
            active: true,
            as: 'html',  // or "class"
            close: '-',
            open: '+',
            openerCss: {
                'display': 'inline-block', // Default value
                'float': 'left', // Default value
                'width': '18px',
                'height': '18px',
                'margin-left': '-35px',
                'margin-right': '5px',
                'background-position': 'center center', // Default value
                'background-repeat': 'no-repeat',
                'color': '#5e49aa',
                'font-size': '25px',
                'line-height': '1',
                'position': 'absolute'
            },
        },
        ignoreClass: 'clickable',
        isAllowed: function (currEl, hint, target) {

            if ($(currEl).hasClass('sub-menu')) {
                if (hint.parentsUntil('.draggableMenu').filter('ul').length != 1) {
                    hint.css('background-color', '#ff9999');
                    return false;
                } else {
                    hint.css('background-color', '#eee');
                    return true;
                }
            }
            if ($(currEl).hasClass('image-menu')) {
                if (hint.parentsUntil('.draggableMenu').filter('ul').length != 1) {
                    hint.css('background-color', '#ff9999');
                    return false;
                } else {
                    hint.css('background-color', '#eee');
                    return true;
                }
            }
            if (hint.parentsUntil('.draggableMenu').filter('ul').length > 1) {
                hint.css('background-color', '#ff9999');
                return false;
            } else {
                hint.css('background-color', '#eee');
                return true;
            }
        }
    }
    $('.draggableMenu').sortableLists(options);

    //KTCardDraggable.init();

    var menuID = ($('.menu-items .menu-item').length) ?? 1;

    $('#addNavCustom').on('click', function (event) {
        event.preventDefault();
        let title = $('#navCustomLinkTitle').val();
        title = title.replace(/\'/g, "&apos;");
        let link = $('#navCustomLinkUrl').val();
        let target = $('#navCustomLinkTarget').val();
        if (!title || !link || !target) {
            Swal.fire(
                'Error',
                'Title, link or target cannot be empty',
                'error'
            );
            return;
        }
        let value = { type: 'custom', title: title, link: link, target: target };
        $('.menu-items').append("<li class='menu-item' id='" + menuID++ + "' data-value='" + JSON.stringify(value) + "'>" +
            '<div class="btn btn btn-outline-primary w-100 mb-2"><span class="title">' + title + '</span>' +
            '<div>' +
            '<a href="#" data-parent="' + menuID + '" class="edit clickable btn btn-xs btn-icon bg-light mr-5"><i class="fas fa-pen text-info clickable"></i></a>' +
            '<a href="#" class="remove clickable btn btn-xs btn-icon bg-light"><i class="fas fa-trash text-danger clickable"></i></a></div>' +
            '</div>'+
            '</li>');
        $('#navCustomLinkTitle').val('');
        $('#navCustomLinkUrl').val('');
    });

    $('.nav-add-btn').on('click', function (event) {
        event.preventDefault();
        let valueElem = $(this).parent().parent().find('select').get(0);
        let type = $(valueElem).data('type');
        let name = $(valueElem).data('name');
        let value = $(valueElem).val();
        let title = $(valueElem).find('option:selected').html().trim();
        title = title.replace(/\'/g, "&apos;");

        if (!type || !value || !title) {
            themeSwal.fire(
                'Error',
                'Please Select ' + name + 'To Continue',
                'error'
            );
            return;
        }

        let MenuValue = { type: type, title: title, value: value };
        $('.menu-items').append("<li class='menu-item' id='" + menuID++ + "' data-value='" + JSON.stringify(MenuValue) + "'>" +
            '<div class="btn btn btn-outline-primary w-100 mb-2">' +
            '<span class="title">' + name + ' : <span class="edit-title">' + title + '</span></span>' +
            '<div>' +
            '<a href="#" data-parent="' + menuID + '" class="edit clickable btn btn-xs btn-icon bg-light mr-5"><i class="fas fa-pen text-info clickable"></i></a>' +
            '<a href="#" class="remove clickable btn btn-xs btn-icon bg-light"><i class="fas fa-trash text-danger clickable"></i></a>' +
            '</div>' +
            '</div>' +
            '</li>');
        $(valueElem).val('');
        $(valueElem).trigger('change');
    });

});

$('.draggableMenu').on('click', '.remove', function (event) {
    event.preventDefault();
    let parentLevel1 = $(this).parents().eq(2);
    let parentLevel2 = $(this).parents().eq(3);
    if ($(parentLevel2).hasClass('draggableMenu')) {
        let children = $(parentLevel1).find('ul').html();
        $(parentLevel1).parent().append(children);
        $(parentLevel1).remove();
    } else {
        let children = $(parentLevel1).find('ul').html();
        $(parentLevel2).parent().append(children);
        $(parentLevel1).remove();
        if ($(parentLevel2).find('li').length == 0) {
            $(parentLevel2).parent().removeClass('s-l-open');
            $(parentLevel2).parent().find('.s-l-opener').remove();
        }
    }
});

var editParent;

$('.draggableMenu').on('click', '.edit', function (event) {
    event.preventDefault();
    editParent = $(this).parents().eq(2);
    let values = $(editParent).data('value');
    $('#editNavTitle').val(values.title);
    $('#navEditModal').modal('show');
});

$('#editNavTitleBtn').on('click', function (event) {
    event.preventDefault();
    let value = $('#editNavTitle').val();
    if (!value) {
        themeSwal.fire(
            'Error',
            'Title cannot be empty',
            'error'
        );
        return;
    }
    $(editParent).find('.edit-title').html(value);
    let values = $(editParent).data('value');
    values.title = value;
    $(editParent).data('value', values);
    $('#navEditModal').modal('hide');
});

$('#navigationForm').on('submit', function (event) {
    event.preventDefault();

    let navData = $('#draggableMenu').sortableListsToHierarchy();

    if (!navData.length) {
        navData = [""];
    }

    console.log(navData);
    
    $.ajax({
        url: $(this).attr('action'),
        method: 'POST',
        data: { 'st_navigation': navData, 'module_key' : moduleKey },
        success: function (response) {
            if (response['status']) {
                themeSwal.fire(
                    'Success',
                    "Navigation Saved Successfully",
                    'success'
                );
            } else {
                themeSwal.fire(
                    'Error',
                    response['message'],
                    'error'
                );
            }
        }
    });
});