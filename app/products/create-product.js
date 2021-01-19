$(document).ready(function(){
    function changePageTitle(page_title){
        $("#page-title").html(page_title)
        document.title=page_title;
    }
    $(document).on('click', '.create-product-button', function () {
        $.getJSON("http://localhost/api/category/read.php", function (data) {
            var categories_options_html = `<select name="category_id" class="form-control">`
            categories_options_html +=          `<option>Select Category</option>`
            $.each(data.records, function (key, val) {
                categories_options_html += `<option value="${val.id}">${val.name}</option>`
            })
            categories_options_html += `</select>`;
            var create_product_html = `
                <div id="read-products" class="btn btn-primary float-right m-b-15px read-products-button">
                    <i class="bi-list"></i> Read Products
                </div>
                <form id="create-product-form" action="#" method="post">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="price" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="price" name="price" min="1" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-10">
                            <textarea type="number" class="form-control" id="description" name="description"  required></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="category_id" class="col-sm-2 col-form-label">Categories</label>
                        <div class="col-sm-10">
                            ${categories_options_html}
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi-plus-circle"></i> Create Product</button>
                </form>
            `;
            $("#page-content").html(create_product_html);
            changePageTitle("Create Product");
        })
    })

    $(document).on('submit', '#create-product-form', function () {
        var form_data = JSON.stringify($(this).serializeObject());
        $.ajax({
            url: "http://localhost/api/product/create.php",
            type: "POST",
            contentType: 'application/json',
            data: form_data,
            success: function(result){
                showProducts();
            },
            error: function (xhr, resp, text) {
                console.log(xhr, resp, text)
            }
        })
        return false;
    })
})