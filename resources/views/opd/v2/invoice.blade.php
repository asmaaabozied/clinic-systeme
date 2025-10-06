
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            .thermal-receipt {
                width: 80mm !important;
                max-width: 80mm !important;
                margin: 0 !important;
                padding: 5mm !important;
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            body {
                margin: 0 !important;
                padding: 0 !important;
            }

            @page {
                size: 80mm auto;
                margin: 0;
            }
        }

        .thermal-receipt {
            width: 80mm;
            max-width: 80mm;
            margin: 0 auto;
            padding: 5mm;
            font-family: 'Courier New', monospace;
            background: white;
            color: black;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-white">

<div class="no-print mb-4 text-center">
    <button onclick="window.print()" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
        Print Invoice
    </button>
</div>

<div class="thermal-receipt text-black font-mono text-xs leading-tight">

    <!-- Header -->
    <div class="text-center mb-3 border-b-2 border-dashed border-gray-400 pb-3">
        <div class="text-lg font-bold mb-1">
            <img src="{{ $invoice['company']['logo'] }}" height="80" width="80" alt="{{ $invoice['company']['name'] }}" class="mx-auto mb-2">
        </div>
        <div class="text-xs mb-1">{{ $invoice['company']['name'] }}</div>
        <div class="text-xs mb-1">Tel: {{ $invoice['company']['phone'] }}</div>
        <div class="text-xs mb-1 leading-relaxed">{{ $invoice['company']['address'] }}</div>
        <div class="text-xs">VAT: {{ $invoice['company']['vatNumber'] }}</div>
    </div>

    <!-- Invoice Type -->
    <div class="text-center text-sm font-bold mb-3 border-b border-dashed border-gray-400 pb-2">
        {{ $invoice['invoiceDetails']['type'] }}
    </div>

    <!-- Invoice Details -->
    <div class="mb-3 text-xs border-b border-dashed border-gray-400 pb-3">
        <div class="flex justify-between mb-1">
            <span>Invoice No:</span>
            <span class="font-bold">{{ $invoice['invoiceDetails']['invoiceNo'] }}</span>
        </div>
        <div class="flex justify-between mb-1">
            <span>Date:</span>
            <span>{{ $invoice['invoiceDetails']['issueDate'] }}</span>
        </div>
        <div class="flex justify-between mb-1">
            <span>Time:</span>
            <span>{{ $invoice['invoiceDetails']['time'] }}</span>
        </div>
        <div class="flex justify-between mb-1">
            <span>File #:</span>
            <span>{{ $invoice['invoiceDetails']['fileNo'] }}</span>
        </div>
        <div class="flex justify-between mb-1">
            <span>Doctor:</span>
            <span>Hydrafacial</span>
        </div>
    </div>

    <!-- Patient Details -->
    <div class="mb-3 text-xs border-b border-dashed border-gray-400 pb-3">
        <div class="font-bold mb-1">PATIENT DETAILS:</div>
        <div class="mb-1">Name: {{ $invoice['invoiceDetails']['patientName'] }}</div>
        <div class="flex justify-between mb-1">
            <span>Nationality: {{ $invoice['invoiceDetails']['nationality'] }}</span>
            <span>DOB: {{ $invoice['invoiceDetails']['date_of_birth'] }}</span>
        </div>
        <div class="flex justify-between">
            <span>Gender: {{ $invoice['invoiceDetails']['gender'] }}</span>
            <span>Room: {{ $invoice['invoiceDetails']['roomNo'] }}</span>
        </div>
    </div>

    <!-- Items -->
    <div class="text-xs font-bold mb-2 border-b border-solid border-gray-600 pb-1">
        SERVICES
    </div>
    <ul class="mb-3 text-xs space-y-2">
        @foreach ($invoice['items'] as $item)
            <li class="flex justify-between border-b border-dashed pb-1">
                <span>{{ $item['description'] }}</span>
                <span>{{ number_format($item['amount'], 2) }}</span>
            </li>
        @endforeach
    </ul>

    <!-- Totals -->
    <div class="mb-3 text-xs border-t-2 border-solid border-gray-600 pt-2">
        <div class="flex justify-between mb-1">
            <span>Gross Total:</span>
            <span class="font-bold">{{ number_format($invoice['totals']['grossTotal'], 2) }}</span>
        </div>
        <div class="flex justify-between mb-1">
            <span>Discount:</span>
            <span>{{ number_format($invoice['totals']['discount'], 2) }}</span>
        </div>
        <div class="flex justify-between mb-1">
            <span>After Discount:</span>
            <span>{{ number_format($invoice['totals']['totalAfterDiscount'], 2) }}</span>
        </div>
        <div class="flex justify-between mb-1">
            <span>VAT (15%):</span>
            <span>{{ number_format($invoice['totals']['vatTotal'], 2) }}</span>
        </div>
        <div class="flex justify-between text-sm font-bold border-t border-solid border-gray-600 pt-1">
            <span>NET TOTAL:</span>
            <span>{{ number_format($invoice['totals']['netAmount'], 2) }} {{ $invoice['company']['currency'] }}</span>
        </div>
    </div>

    <!-- Payment -->
    <div class="mb-3 text-xs border-t border-dashed border-gray-400 pt-2">
        <div class="font-bold mb-1">PAYMENT:</div>
        <div class="flex justify-between">
            <span>Cash:</span>
            <span>{{ number_format($invoice['payment']['cash'], 2) }}</span>
        </div>
    </div>

    <!-- Policies -->
    <div class="mb-3 text-xs border-t border-dashed border-gray-400 pt-2">
        <div class="font-bold mb-1">POLICIES:</div>
        <div class="text-xs leading-relaxed space-y-1">
            <div>• سعر الكشفية لا يسترجع سواء بدفع نقدي أو بطاقه</div>
            <div>• المراجعة خلال 14 يوم من تاريخ الكشف</div>
            <div>• استرجاع لاي فاتورة خدمة خلال 10 أيام من تاريخ الفاتورة</div>
            <div>• فترة استخدام الفاتورة خلال 4 اشهر من تاريخ اصدار الفاتورة</div>
            <div>• فترة استخدام باقات (البكتجات) خلال 9 شهور من تاريخ اصدار الفاتورة</div>
        </div>
    </div>

    <!-- Room and Token -->
    <div class="flex justify-between text-xs mb-3 border-t border-dashed border-gray-400 pt-2">
        <div>
            <div>Room No: {{ $invoice['invoiceDetails']['roomNo'] }}</div>
            <div>Token No: {{ $invoice['invoiceDetails']['tokenNo'] }}</div>
        </div>
        <div class="text-right">
            <div>رقم العياده</div>
            <div>رقم الحجز</div>
        </div>
    </div>

    <!-- QR Code -->
    <div class="text-center mb-3 border-t border-dashed border-gray-400 pt-2">
        <div class="text-xs mb-1">QR Code</div>
        <div class="bg-gray-200 w-16 h-16 mx-auto flex items-center justify-center text-xs">
            QR
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center text-xs border-t-2 border-dashed border-gray-400 pt-2">
        <div>© 2023 Plump. All rights reserved.</div>
        <div class="mt-1">Thank you for your visit!</div>
    </div>

</div>

</body>
</html>
