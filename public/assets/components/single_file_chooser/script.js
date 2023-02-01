function removeFileDisplaySingle(ele, dropzoneId){
    $(ele.parentNode).remove();
    console.log($('#'+dropzoneId));
    $('#'+dropzoneId).show();
}

/**
 *
 * @param {*} element           HTML Element
 * @param {2} maxFileSize       Max File Size (MB)
 * @param {*} uploadPath        Upload Path
 * @param {string} acceptedFiles     Accepted File Types
 */
function init_single_dropzone(element, maxFileSize = 2, uploadPath = "", acceptedFiles = "image/*") {

    var dropzone_el = document.getElementById(element+'-dropzone');
    var display_area_el = document.getElementById(element+'-display-area');

    var options = {
        url: HOST_URL + 'store-image',
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: maxFileSize, // MB
        addRemoveLinks: true,
        uploadMultiple: false,
        maxFiles: 1,
        acceptedFiles: acceptedFiles,
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
                if(data.status) {
                    if(display_area_el.getAttribute('data-type')==='img'){
                        let smallImageClass = (data.small_image) ? 'small' : '';
                        var new_box = $('<div class="file-display-single img '+smallImageClass+'">\n' +
                            '                    <input type="hidden" name="'+element+'" value="'+data.full_path+'">\n' +
                            '                    <img src="'+data.full_path+'">\n' +
                            '                    <span onclick="removeFileDisplaySingle(this, \''+element+'-dropzone\')">x</span>\n' +
                            '                </div>');
                        $(display_area_el).append(new_box);
                    } else{
                        var new_box = $('<div class="file-display-single vid">\n' +
                            '                    <input type="hidden" name="'+element+'" value="'+data.full_path+'">\n' +
                            '                    <video controls>'+
                            '                        <source src="'+data.full_path+'">'+
                            '                    </video>' +
                            '                    <span onclick="removeFileDisplaySingle(this, \''+element+'-dropzone\')">x</span>\n' +
                            '                </div>');
                        $(display_area_el).append(new_box);
                    }
                }
            });
            this.on("queuecomplete", function (file, data) {
                if(display_area_el.children.length>0){
                    $(dropzone_el).hide();
                }
                dropzone.removeAllFiles();
            });
        },
    };

    var dropzone = new Dropzone(dropzone_el, options);
}
