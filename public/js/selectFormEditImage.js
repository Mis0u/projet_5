$(document).ready(function(){

    $('#image_allTags').select2({
        tags: true,
        tokenSeparators: [',', ' ']
    });

    $('form').on('submit', function(){
        let getTags = $('#image_allTags').select2('data').map(function(tag){
            return tag.text
        }).join(",");

        $('#edit_image_tags').val(getTags);         
    })

})

