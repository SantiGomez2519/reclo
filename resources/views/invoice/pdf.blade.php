<!-- Author: Pablo Cabrejos -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $viewData['invoice_number'] }}</title>
    <style>
        {!! $viewData['css'] !!}
    </style>
</head>
<body>
    <div class="invoice-header">
        <div class="company-info">
            <div class="company-name">{{ $viewData['company']['name'] }}</div>
            <div class="company-details">
                {{ $viewData['company']['address'] }}<br>
                {{ $viewData['company']['city'] }}<br>
                Phone: {{ $viewData['company']['phone'] }}<br>
                Email: {{ $viewData['company']['email'] }}<br>
                Website: {{ $viewData['company']['website'] }}
            </div>
        </div>
        <div class="invoice-details">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-meta">
                <strong>Invoice #:</strong> {{ $viewData['invoice_number'] }}<br>
                <strong>Date:</strong> {{ $viewData['invoice_date'] }}<br>
                <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($viewData['order']->getOrderDate())->format('Y-m-d') }}
            </div>
        </div>
    </div>

    <div class="billing-section">
        <div class="billing-info">
            <div class="billing-title">Bill To:</div>
            <strong>{{ $viewData['order']->getBuyer()->getName() }}</strong><br>
            Email: {{ $viewData['order']->getBuyer()->getEmail() }}<br>
            Phone: {{ $viewData['order']->getBuyer()->getPhone() }}<br>
            Payment Method: {{ $viewData['order']->getBuyer()->getPaymentMethod() }}
        </div>
        <div class="billing-info">
            <div class="billing-title">Order Information:</div>
            <strong>Order ID:</strong> #{{ $viewData['order']->getId() }}<br>
            <strong>Status:</strong> {{ ucfirst($viewData['order']->getStatus()) }}<br>
            <strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $viewData['order']->getPaymentMethod())) }}
        </div>
    </div>

    <div class="payment-method">
        <strong>Payment Method Used:</strong> {{ ucfirst(str_replace('_', ' ', $viewData['order']->getPaymentMethod())) }}
    </div>

    <table class="products-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Seller</th>
                <th>Category</th>
                <th>Condition</th>
                <th class="text-right">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($viewData['order']->getProducts() as $product)
            <tr>
                <td>
                    <strong>{{ $product->getTitle() }}</strong><br>
                    <small>{{ Str::limit($product->getDescription(), 50) }}</small>
                </td>
                <td>{{ $product->getSeller()->getName() }}</td>
                <td>{{ ucfirst($product->getCategory()) }}</td>
                <td>{{ ucfirst($product->getCondition()) }}</td>
                <td class="text-right">${{ number_format($product->getPrice(), 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total-section">
        <div class="total-row">
            <div class="total-label">Subtotal:</div>
            <div class="total-amount">${{ number_format($viewData['order']->getTotalPrice(), 2) }}</div>
        </div>
        <div class="total-row">
            <div class="total-label">Tax (0%):</div>
            <div class="total-amount">$0.00</div>
        </div>
        <div class="total-row grand-total">
            <div class="total-label">Total:</div>
            <div class="total-amount">${{ number_format($viewData['order']->getTotalPrice(), 2) }}</div>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for your business with {{ $viewData['company']['name'] }}!</p>
        <p>This is a computer-generated invoice. No signature required.</p>
        <p>For any questions regarding this invoice, please contact us at {{ $viewData['company']['email'] }} or {{ $viewData['company']['phone'] }}</p>
    </div>
</body>
</html>
