jQuery(document).ready(function($) {
    $('.pbfm-cat-link').on('click',function(){
        var term_id = $(this).attr('term-id');
        var all = $('.pbfm-container').find(`.download-file`)
        var datas = $('.pbfm-container').find(`.download-file.${term_id}`)
        if(term_id === 'all'){
             $(all).show()
             $('#pagination-container').show()
        }else{
            $('.ajax-modal').css('display','block')
            setTimeout(() => {
                $(all).hide()
                $(datas).show()
                $('.ajax-modal').css('display','none')
            }, 1000);
            $('#pagination-container').hide()
        }
    })
    function AjaxCall(type,action,data){
        $.ajax({
            type : type,
            url : pbfm_localize_script.pbfilemanagement_ajax,
            data : {
                action: action, 
                data : data,
                security : pbfm_localize_script.pbfilemanagement_nonce
            },
            success: function(response) {
                console.log(response);
            }
        });
    }


});