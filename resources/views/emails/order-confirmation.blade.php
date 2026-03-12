<h2>Order Confirmation</h2>

<p>Hello {{ $order->user->name }},</p>

<p>Your order has been placed successfully.</p>

<p><strong>Order ID:</strong> {{ $order->id }}</p>
<p><strong>Total Items:</strong> {{ $order->total_items }}</p>
<p><strong>Total Amount:</strong> ₹{{ $order->total_amount }}</p>

<p>Thank you for shopping with us.</p>