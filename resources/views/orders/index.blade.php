<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>My Orders</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            background: #f5f6fa;
        }

        .table-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }

        .status-badge {
            font-size: 13px;
            padding: 6px 10px;
        }
    </style>

</head>

<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">

            <a class="navbar-brand text-warning" href="/">Order System</a>

            <div>

                <span class="text-white me-3">
                    Welcome, {{ auth()->user()->name }}
                </span>

                <a href="/" class="btn btn-warning me-2">
                    Products
                </a>

                <form method="POST" action="/logout" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger">Logout</button>
                </form>

            </div>

        </div>
    </nav>

    <div class="container mt-5">

        <div class="table-card">

            <h3 class="mb-4">My Order History</h3>

            <table class="table table-bordered align-middle">

                <thead class="table-dark">

                    <tr>
                        <th>Order ID</th>
                        <th>Total Items</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody id="ordersTable"></tbody>

            </table>

        </div>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        $(document).ready(function () {

            loadOrders();

        });

        function loadOrders() {

            $.ajax({

                url: '/my-orders',

                method: 'GET',

                success: function (orders) {

                    let html = '';

                    if (orders.length === 0) {

                        html = `
                            <tr>
                            <td colspan="6" class="text-center">
                            No orders found
                            </td>
                            </tr>
                        `;

                    } else {

                        orders.forEach(o => {

                            html += `
                                <tr>

                                <td>#${o.id}</td>

                                <td>${o.total_items}</td>

                                <td>₹${o.total_amount}</td>

                                <td>
                                <span class="badge bg-success status-badge">
                                ${o.status}
                                </span>
                                </td>

                                <td>${new Date(o.created_at).toLocaleDateString()}</td>

                                <td>
                                <button class="btn btn-sm btn-warning viewOrder"
                                data-id="${o.id}">
                                View
                                </button>
                                </td>

                                </tr>
                            `;

                        });

                    }

                    $("#ordersTable").html(html);

                },

                error: function (err) {

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Unable to load orders'
                    });

                }

            });

        }

        $(document).on('click', '.viewOrder', function () {

            let orderId = $(this).data('id');

            $.ajax({

                url: '/orders/' + orderId,
                method: 'GET',

                success: function (order) {

                    let rows = '';

                    order.items.forEach(item => {

                        rows += `
                            <tr>
                            <td>${item.product.name}</td>
                            <td>${item.quantity}</td>
                            <td>₹${item.price}</td>
                            <td>₹${item.total}</td>
                            </tr>
                        `;

                    });

                    let table = `
                        <table class="table table-bordered">

                        <thead class="table-dark">
                        <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        </tr>
                        </thead>

                        <tbody>
                        ${rows}
                        </tbody>

                        </table>
                    `;

                    Swal.fire({

                        title: 'Order #' + order.id,
                        html: table,
                        width: 700,
                        confirmButtonColor: '#ffc107'

                    });

                }

            });

        });

    </script>

</body>

</html>