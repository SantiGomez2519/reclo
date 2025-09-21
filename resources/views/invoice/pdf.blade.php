<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $viewData['invoice_number'] }}</title>
    <style>
        /* Invoice PDF Styles - Inline for PDF generation */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        .invoice-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .company-info {
            flex: 1;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }
        .company-details {
            font-size: 12px;
            color: #666;
        }
        .invoice-details {
            text-align: right;
            flex: 1;
        }
        .invoice-title {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }
        .invoice-meta {
            font-size: 14px;
        }
        .billing-section {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
        }
        .billing-info {
            flex: 1;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            margin-right: 20px;
        }
        .billing-info:last-child {
            margin-right: 0;
        }
        .billing-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 10px;
            color: #007bff;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        .products-table th,
        .products-table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
        }
        .products-table th {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .products-table tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        .text-right {
            text-align: right;
        }
        .total-section {
            margin-top: 30px;
            text-align: right;
        }
        .total-row {
            display: flex;
            justify-content: flex-end;
            margin: 10px 0;
            font-size: 16px;
        }
        .total-label {
            font-weight: bold;
            margin-right: 20px;
            min-width: 100px;
        }
        .total-amount {
            min-width: 100px;
            text-align: right;
        }
        .grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            border-top: 2px solid #007bff;
            padding-top: 10px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .payment-method {
            background-color: #e7f3ff;
            padding: 10px;
            border-radius: 5px;
            margin: 20px 0;
        }
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
