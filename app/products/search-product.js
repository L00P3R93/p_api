$(document).ready(function(){
    function changePageTitle(page_title){
        $("#page-title").html(page_title)
        document.title=page_title;
    }
    $(document).on('keyup',".product-search-keywords", function () {
        var keywords = $(this).val();
        if(keywords.length > 3){
            $.getJSON(`http://localhost/api/product/search.php?s=${keywords}`, function (data) {
                readProductsTemplate(data, keywords)
                changePageTitle("Search Products: "+ keywords)
            })
        }
    })
    $(document).on('submit', '#search-product-form', function(){
        var keywords = $(this).find(":input[name='keywords']").val();
        $.getJSON(`http://localhost/api/product/search.php?s=${keywords}`, function (data) {
            readProductsTemplate(data, keywords)
            changePageTitle("Search Products: "+ keywords)
        })
        return false
    })

})