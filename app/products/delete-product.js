$(document).ready(function(){
    $(document).on('click', '.delete-product-button', function () {
        var product_id = $(this).attr("data-id")
        bootbox.confirm({
            message: "<h4>Confirm you want to Delete?</h4>",
            buttons: {
                confirm: {
                    label: '<i class="bi-check-circle"></i> Yes',
                    className: 'btn-danger'
                },
                cancel: {
                    label: '<i class="bi-x-circle"></i> No',
                    className: 'btn-primary'
                }
            },
            callback: function (result) {
                if(result === true){
                    $.ajax({
                        url: "http://localhost/api/product/delete.php",
                        type: "POST",
                        dataType: 'json',
                        data: JSON.stringify({id: product_id}),
                        success: function(result){
                            showProducts()
                        },
                        error: function(xhr, resp, text){
                            console.log(xhr, resp, text)
                        }
                    })
                }
            }
        })
    })
})