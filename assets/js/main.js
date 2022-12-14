jQuery(document).ready(function($) {
    $('.download-file').on('click',function(e){

    })
    $('.pbfm-cat-link').on('click',function(){
        var term_id = $(this).attr('term-id');
        var all = $('.pbfm-container').find(`.download-file`)
        var datas = $('.pbfm-container').find(`.download-file.${term_id}`)
        if(term_id === 'all'){
            location.reload()
        }else{
            $('.ajax-modal').css('display','block')
            setTimeout(() => {
                $(all).hide()
                $(datas).show()
                $('.ajax-modal').css('display','none')
            }, 3000);
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

// Simple Pagination
var items = $(".pbfm-row .download-file");
    var numItems = items.length;
    var perPage = 4;

    items.slice(perPage).hide();

    $('#pagination-container').pagination({
        items: numItems,
        itemsOnPage: perPage,
        prevText: "&laquo;",
        nextText: "&raquo;",
        onPageClick: function (pageNumber) {
            var showFrom = perPage * (pageNumber - 1);
            var showTo = showFrom + perPage;
            items.hide().slice(showFrom, showTo).show();
        }
    });
});