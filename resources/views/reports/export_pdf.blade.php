<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>City Government of Malaybalay - Financial Report</title>
    <style>
        @page {
            margin: 0.5in 0.5in;
        }
        body {
            font-family: "Helvetica", "Arial", sans-serif;
            margin: 0;
            font-size: 12px;
            background-color: #ffffff;
            color: #000000;
        }
        
        /* Print button styling */
        .print-button {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            z-index: 9999;
        }
        .print-button:hover {
            background: #1d4ed8;
        }
        
        .header {
            text-align: center;
            position: relative;
            margin-bottom: 20px;
        }
        .header img {
            width: 80px;
            height: 80px;
            position: absolute;
            top: -15px;
        }
        .logo-left { left: 0; }
        .logo-right { right: 0; }
        
        .header-text { margin: 0 90px; }
        .header-text h2 { margin: 2px 0; font-weight: normal; font-size: 16px; }
        .header-text h1 { margin: 2px 0; font-size: 18px; font-weight: bold; }
        .header-text p { margin: 2px 0; font-size: 14px; }
        .header-text .date-range { font-size: 11px; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px; 
        }
        th, td {
            border: 1px solid black;
            color: #000000; /* Ensure text is black */
            padding: 6px 4px;
        }
        th {
            background-color: #f3f4f6;
            font-size: 10px;
            text-align: center;
            font-weight: bold;
            text-transform: none;
        }
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .totals-row td {
            font-weight: bold;
            border-top: 2px solid black;
        }
        .footer-section {
            margin-top: 50px;
            width: 100%;
        }
        .signature-block {
            display: inline-block;
            width: 45%;
            text-align: center;
        }
        .signature-line {
            border-bottom: 1px solid black;
            margin: 30px auto 5px;
            width: 80%;
        }
        .name { font-weight: bold; text-transform: uppercase; margin: 0; }
        .position { font-size: 10px; margin: 0; }

        @media print {
            .print-button { display: none; }
            .footer-section { page-break-inside: avoid; }
            body { margin: 0; }
        }
    </style>
    
    <script>
        window.onload = function() {
            setTimeout(function() {
                var btn = document.getElementById('printBtn');
                if(btn) btn.style.display = 'block';
            }, 500);
        };
        
        function printNow() {
            window.print();
        }
    </script>
</head>
<body>
    <!-- Print Button -->
    <button id="printBtn" class="print-button" style="display:none;" onclick="printNow()">🖨️ Print</button>
    
    <div class="header">
        <img src="{{ public_path('image/logo1.png') }}" class="logo-left" alt="Logo">
        
        <div class="header-text">
            <h2>Province of Bukidnon</h2>
            <h1>City Government of Malaybalay</h1>
            <p>For the month of {{ isset($filters['start_date']) ? \Carbon\Carbon::parse($filters['start_date'])->format('F') : '________________' }}, {{ isset($filters['start_date']) ? \Carbon\Carbon::parse($filters['start_date'])->format('Y') : '____' }}</p>
            @if(isset($filters['start_date']) && isset($filters['end_date']))
                <p class="date-range">Date Range: {{ \Carbon\Carbon::parse($filters['start_date'])->format('M d, Y') }} - {{ \Carbon\Carbon::parse($filters['end_date'])->format('M d, Y') }}</p>
            @endif
            @if(isset($filters['check_no']) && $filters['check_no'] != '')
                <p>Check No: {{ $filters['check_no'] }}</p>
            @endif
        </div>

        <img src="{{ public_path('image/logo.png') }}" class="logo-right" alt="Logo">
    </div>

    <table>
        <thead>
            <tr>
                <th>Check No</th>
                <th>Office</th>
                <th>Payee</th>
                <th>Nature of Payment</th>
                <th>Amount Issued</th>
                <th>Account Code</th>
                <th>Specific Fund</th>
                <th>Category</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $trx)
            <tr>
                <td class="text-center">{{ $trx->check_no ?? '-' }}</td>
                <td class="text-left">{{ $trx->office ?? '-' }}</td>
                <td class="text-left">{{ $trx->payee }}</td>
                <td class="text-left">{{ $trx->nature_of_payment ?? '' }}</td>
                <td class="text-right">{{ number_format($trx->amount_issued > 0 ? $trx->amount_issued : $trx->amount, 2) }}</td>
                <td class="text-center">{{ $trx->account_code ?? '-' }}</td>
                <td class="text-left">{{ $trx->specific_fund ? \Illuminate\Support\Str::title($trx->specific_fund) : '-' }}</td>
                <td class="text-center">{{ $trx->current_prior ?? 'Current' }}</td>
                <td class="text-center">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d-M-y') }}</td>
            </tr>
            @endforeach

            @php $totalAmount = $transactions->sum(fn($t) => $t->amount_issued > 0 ? $t->amount_issued : $t->amount); @endphp
            <tr class="totals-row">
                <td colspan="4" class="text-right">TOTAL AMOUNT</td>
                <td class="text-right">{{ number_format($totalAmount, 2) }}</td>
                <td colspan="4"></td>
            </tr>
        </tbody>
    </table>

    <div class="footer-section">
        <div class="signature-block">
            <p>Prepared by:</p>
            <div class="signature-line"></div>
            <p class="name">{{ $signatories['prepared_by_name'] ?? auth()->user()->name }}</p>
            <p class="position">{{ $signatories['prepared_by_position'] ?? 'Staff/Accountant' }}</p>
        </div>
        <div style="display: inline-block; width: 8%;"></div>
        <div class="signature-block">
            <p>Approved by:</p>
            <div class="signature-line"></div>
            <p class="name">{{ $signatories['approved_by_name'] ?? 'Supervisor Name' }}</p>
            <p class="position">{{ $signatories['approved_by_position'] ?? 'City Treasurer' }}</p>
        </div>
    </div>
</body>
</html>
