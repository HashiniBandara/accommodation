function removeFileDisplayBox(ele){
    $(ele.parentNode).remove();
}

/**
 *
 * @param {*} element           HTML Element
 * @param {2} maxFileSize       Max File Size (MB)
 * @param {*} uploadPath        Upload Path
 * @param {1} maxFiles          Max File Count
 * @param {string} acceptedFiles     Accepted File Types
 */
function init_multi_dropzone(element, maxFileSize = 2, uploadPath = "", maxFiles = null, acceptedFiles = "image/*") {

    var dropzone_el = document.getElementById(element+'-dropzone');
    var display_area_el = document.getElementById(element+'-display-area');

    var options = {
        url: HOST_URL + 'store-image',
        paramName: "file", // The name that will be used to transfer the file
        maxFilesize: maxFileSize, // MB
        addRemoveLinks: true,
        uploadMultiple: false,
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
                    var new_box = $('<div class="file-display-box">\n' +
                        '                    <input type="hidden" name="'+element+'[]" value="'+data.full_path+'">\n' +
                        '                    <img src="'+data.full_path+'">\n' +
                        '                    <span onclick="removeFileDisplayBox(this)">x</span>\n' +
                        '                </div>');

                    $(display_area_el).append(new_box);
                }
            });
            this.on("queuecomplete", function (file, data) {
                dropzone.removeAllFiles();
            });
        },
    };

    if(maxFiles!=null) {
        options.maxFiles = maxFiles;
        options.parallelUploads = maxFiles;
    }

    var dropzone = new Dropzone(dropzone_el, options);
}
