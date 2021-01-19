$(document).ready(function () {
    function changePageTitle(page_title){
        $("#page-title").html(page_title)
        document.title=page_title;
    }
    $(document).on('click','.read-one-product-button', function(){
        var id = $(this).attr('data-id');
        $.getJSON("http://localhost/api/product/read_one.php?id="+id, function (data) {
            var read_one_product_html = `
                <div id="read-products" class="btn btn-primary right m-b-15px read-products-button">
                    <i class="bi-view-list"></i> Read Products
                </div>
                <div class="table-responsive-md">
                    <table class="table table-striped table-hover">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>${data.name}</td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td>${data.price}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>${data.description}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>${data.category_name}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `;
            $("#page-content").html(read_one_product_html);
            changePageTitle("View Product");
        })
    })
})