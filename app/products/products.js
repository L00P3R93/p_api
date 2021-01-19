function readProductsTemplate(data, keywords){
    var read_products_html = `
        <form id='search-product-form' action="#" method="post">
            <div class="input-group mb-3 w-30-pct">
                <input type="text" class="form-control product-search-keywords" name="keywords" value="${keywords}" placeholder="Search Products ...">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="submit"><i class="bi-search"></i></button>
                </div>
            </div>
        </form>
        <div id="create-product" class="btn btn-primary m-b-15px create-product-button">
            <i class="bi-plus-circle"></i> Create Product
        </div>
        <table class="table table-striped table-hover" id="products_">
            <thead>
                <tr>
                    <th class="w-25-pct">Name</th>
                    <th class="w-10-pct">Price</th>
                    <th class="w-15-pct">Category</th>
                    <th class="w-25-pct text-align-center">Action</th>
                </tr>
            </thead>
            <tbody>`;
    $.each(data.records, function (key, val) {
        read_products_html +=`
                <tr>
                    <td>${val.name}</td>
                    <td>${val.price}</td>
                    <td>${val.category_name}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary read-one-product-button" data-id="${val.id}"><i class="bi-eye"></i></button>
                            <button type="button" class="btn btn-info update-product-button" data-id="${val.id}"><i class="bi-pencil-square"></i></button>
                            <button type="button" class="btn btn-danger delete-product-button" data-id="${val.id}"><i class="bi-trash"></i></button>
                        </div>
                    </td>
                </tr>
        `;
    })
    read_products_html += `
            </tbody>
            <tfoot>
                <tr>
                    <th class="w-25-pct">Name</th>
                    <th class="w-10-pct">Price</th>
                    <th class="w-15-pct">Category</th>
                    <th class="w-25-pct text-align-center">Action</th>
                </tr>
            </tfoot>
        </table>`;
    if(data.paging){
        read_products_html += `
            <nav aria-label="Page navigation example">
                <ul class="pagination">`
        if(data.paging.first !== ""){
            read_products_html +=`
                <li class="page-item">
                    <a class="page-link" data-page="${data.paging.first}">First Page</a>
                </li>`
        }

        $.each(data.paging.pages, function (key, val) {
            var active_page = val.current_page === "yes" ? "active" : "";
            if(val.page - 0 > 0 && val.page - 0 <= data.paging.all - 0){
                read_products_html +=`
                <li class="page-item ${active_page}"><a class="page-link" data-page="${val.url}">${val.page}</a></li>`
            }
        })

        if(data.paging.last !== ""){
            read_products_html +=`     
                <li class="page-item">
                    <a class="page-link" data-page="${data.paging.last}">
                        Last Page
                    </a>
                </li>`
        }
        read_products_html +=`
                </ul>
            </nav>`
    }
    $("#page-content").html(read_products_html);
}