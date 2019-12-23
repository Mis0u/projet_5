$(document).ready(function(){

    $('#image_tags').select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });
})