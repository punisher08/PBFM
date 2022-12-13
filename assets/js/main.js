jQuery(document).ready(function($) {
    $('.download-file').on('click',function(e){
        e.preventDefault()
        var url = $(this).find('a').attr('href');
        window.location.href  =  url
        // $.ajax({
        //     type : "post",
        //     url : pbfm_localize_script.pbfilemanagement_ajax,
        //     data : {
        //         action: "pbfm_ajax_call", 
        //         test : 'testing',
        //         security : pbfm_localize_script.pbfilemanagement_nonce
        //     },
        //     success: function(response) {
        //         console.log(response);
        //     }
        // });

    })
});