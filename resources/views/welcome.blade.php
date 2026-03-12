<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Management</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background: #f5f6fa;
        }

        .product-card {
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: #198754;
        }

        .stock {
            font-size: 14px;
            color: #6c757d;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand text-warning" href="/">Order System</a>

            <div>

                @auth

                    <span class="text-white me-3">
                        Welcome, {{ auth()->user()->name }}
                    </span>

                    <a href="/orders" class="btn btn-warning me-2">
                        My Orders
                    </a>

                    <form method="POST" action="/logout" style="display:inline;">
                        @csrf
                        <button class="btn btn-danger">Logout</button>
                    </form>

                @else

                    <a href="/login" class="btn btn-outline-light">Login</a>
                    <a href="/register" class="btn btn-warning">Register</a>

                @endauth

            </div>

        </div>
    </nav>


    <div class="container mt-5">

        <h3 class="mb-4">Available Products</h3>

        <div class="row" id="productContainer">

        </div>

        <div class="text-center mt-4">

            <button id="placeOrderBtn" class="btn btn-primary btn-lg">
                Place Order
            </button>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>

        let selectedProducts = [];

        $(document).ready(function () {

            loadProducts();

        });

        function loadProducts() {

            $.ajax({

                url: '/products',

                method: 'GET',

                success: function (products) {

                    let html = '';

                    products.forEach(p => {

                        html += `
                            <div class="col-md-4 mb-4">

                            <div class="card product-card">

                            <div class="card-body">

                            <h5 class="card-title">${p.name}</h5>

                            <p class="price">₹ ${p.price}</p>

                            <p class="stock">Stock: ${p.stock}</p>

                            <input type="number"
                            min="0"
                            max="${p.stock}"
                            class="form-control qty"
                            data-id="${p.id}"
                            placeholder="Enter quantity">

                            </div>

                            </div>

                            </div>
                        `;

                    });

                    $("#productContainer").html(html);

                }

            });

        }


        $("#placeOrderBtn").click(function () {

            let products = [];

            $('.qty').each(function () {

                let qty = $(this).val();

                if (qty > 0) {

                    products.push({

                        product_id: $(this).data('id'),
                        qty: qty

                    });

                }

            });

            if (products.length === 0) {

                Swal.fire({
                    icon: 'warning',
                    title: 'No products selected',
                    text: 'Please select at least one product quantity'
                });

                return;

            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({

                url: '/orders',

                method: 'POST',

                data: { products: products },

                beforeSend: function () {
                    $("#placeOrderBtn")
                    .prop('disabled', true)
                    .text('Placing Order...');

                    Swal.fire({
                        title: 'Placing Order...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                },

                success: function (res) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Order Placed!',
                        text: res.message,
                        confirmButtonColor: '#ffc107'
                    }).then(() => {
                        location.reload();
                    });

                },

                error: function (err) {

                    if (err.status === 401) {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Login Required',
                            text: 'You must login to place an order',
                            confirmButtonColor: '#ffc107'
                        }).then(() => {

                            window.location.href = "/login";

                        });

                        return;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Order Failed',
                        text: err.responseJSON?.message || 'Something went wrong',
                        confirmButtonColor: '#ffc107'
                    });

                },

                complete: function () {

                    $("#placeOrderBtn")
                    .prop('disabled', false)
                    .text('Place Order');

                }

            });

        });

    </script>

</body>

</html>