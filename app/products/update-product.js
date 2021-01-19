$(document).ready(function(){
    function changePageTitle(page_title){
        $("#page-title").html(page_title)
        document.title=page_title;
    }
    $(document).on('click', '.update-product-button', function () {
        var id = $(this).attr('data-id');
        $.getJSON(`http://localhost/api/product/read_one.php?id=${id}`, function (data) {
            var name = data.name
            var price = data.price
            var description = data.description
            var category_id = data.categpry_id;
            var category_name = data.category_name;

            $.getJSON(`http://localhost/api/category/read.php`, function(data){
                var categories_options_html = `<select name="category_id" class="form-control">`
                $.each(data.records, function (key,val) {
                    if(val.id===category_id){
                        categories_options_html += `<option value="${val.id}" selected>${val.name}</option>`
                    }else{
                        categories_options_html += `<option value="${val.id}">${val.name}</option>`
                    }
                })
                categories_options_html += `</select>`;
                var update_product_html = `
                    <div id="read-products" class="btn btn-primary m-b-15px read-products-button">
                        <i class="bi-view-list"></i> View Products
                    </div>
                    <form id="update-product-form" action="#" method="post">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="${name}" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="price" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="price" name="price" value="${price}" min="1" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea type="number" class="form-control" id="description" name="description" required>${description}</textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="category_id" class="col-sm-2 col-form-label">Categories</label>
                        <div class="col-sm-10">
                            ${categories_options_html}
                        </div>
                    </div>
                    <input value="${id}" name="id" type="hidden" />
                    <button type="submit" class="btn btn-primary"><i class="bi-pencil-square"></i> Update Product</button>
                </form>
                `;
                $("#page-content").html(update_product_html);
                changePageTitle("Update Product")

                $(document).on('submit', "#update-product-form", function(){
                    var form_data = JSON.stringify($(this).serializeObject());
                    $.ajax({
                        url: "http://localhost/api/product/update.php",
                        type: "POST",
                        contentType: "application/json",
                        data: form_data,
                        success: function(result){
                            showProducts();
                        },
                        error: function(xhr, resp, text){
                            console.log(xhr, resp, text);
                        }
                    })
                    return false
                })
            })
        })
    })
})