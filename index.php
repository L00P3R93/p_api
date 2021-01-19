<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Read Products</title>
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="bootstrap-icons/bootstrap-icons.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" />
        <link rel="stylesheet" href="app/assets/css/style.css" />
        <style>

        </style>
    </head>
    <body>

        <div id="app"></div>
        <script src="app/assets/js/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

        <script src="app/assets/js/bootbox.min.js"></script>
        <script src="app/app.js"></script>

        <script src="app/products/products.js"></script>
        <script src="app/products/read-products.js"></script>
        <script src="app/products/create-product.js"></script>
        <script src="app/products/read-one-product.js"></script>
        <script src="app/products/update-product.js"></script>
        <script src="app/products/delete-product.js"></script>
        <script src="app/products/search-product.js"></script>
        <script>
            $('#products_').DataTable({
                pageLength: "10"
            });
        </script>
    </body>
</html>