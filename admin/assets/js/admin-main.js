jQuery(document).ready(function($) {
    $('.pbfm-btn #wp_custom_attachment').click(function(e) {
        // e.preventDefault()
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        window.send_to_editor = function(html) {
        if($(html).attr('href')){
            fileurl = $(html).attr('href');
        }else{
            fileurl = $(html).attr('src');
        }
           $('#pbfm_uploaded_file').val(fileurl);
           tb_remove();
        }
        return false;
    });

});