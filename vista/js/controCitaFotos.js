
$("#fileInput").change(function () {
    var fileLength = this.files.length;
    var match = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
    var i;

    for (i = 0; i < fileLength; i++) {
        var file = this.files[i];
        var imagefile = file.type;
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]) || (imagefile == match[3]))) {
            alert('Por favor selecciona una imgen valida (JPEG/JPG/PNG/GIF).');
            $("#fileInput").val('');
            return false;
        }
    }

});

