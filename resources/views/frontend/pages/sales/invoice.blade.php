<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inoodex Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            color: black !important;
            background: #fff;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                width: 210mm;
                height: 297mm;
                margin: 0;
            }
            .fk-print {
                width: 100%;
                height: 100%;
                padding: 15mm;
                box-sizing: border-box;
            }
            .d-print-none {
                display: none !important;
            }
            .no-cut {
                page-break-after: avoid;
            }
        }

        .fk-print {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm;
            box-sizing: border-box;
            background: #fff;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-12 {
            width: 100%;
        }

        .text-center {
            text-align: center;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .fk-print-text--bold {
            font-weight: bold;
        }

        .xxsm-text {
            font-size: 14px;
        }

        .xsm-text {
            font-size: 12px;
        }

        .sm-text {
            font-size: 10px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            font-size: 14px;
        }

        .table-borderless {
            border: none;
        }

        .dashed-border {
            border-bottom: 1px dashed #000;
            margin: 8px 0;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .ml-4 {
            margin-left: 1.5rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .mb-2 {
            margin-bottom: 0.5rem;
        }

        .pa {
            position: relative;
            min-height: 297mm;
        }
    </style>
</head>
<body>
    <div class="pa">
        <div class="ml-4 mt-4 d-print-none">
            <button onclick="window.location.href='{{ route('sales.index') }}'" class="btn btn-sm btn-success">
                Sales List
            </button>
        </div>

        <div class="fk-print">
            <div style="display: flex; justify-content: center;">
                <div id="preview" style="width: 100%;">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="d-block fk-print-text fk-print-text--bold text-uppercase fk-print__title text-center mb-2">Inoodex</span>
                            <p class="mb-0 xsm-text fk-print-text text-center text-capitalize">Invoice</p>
                            <p class="mb-0 xsm-text fk-print-text text-center text-capitalize">Pallobi, Dhaka</p>
                            <p class="mb-0 xsm-text fk-print-text text-center text-capitalize">01751094262</p>
                            <div class="dashed-border"></div>
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="dashed-border">
                                        <th scope="col" class="fk-print-text fk-print-text--bold xxsm-text text-capitalize">Customer Info:</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fk-print-text xxsm-text text-capitalize">
                                            <span class="d-block">Name: {{ $customer->name }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fk-print-text xxsm-text text-capitalize">
                                            <span class="d-block">Phone: {{ $customer->phone }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fk-print-text xxsm-text text-capitalize">
                                            <span class="d-block">Address: {{ $customer->address }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr class="dashed-border">
                                        <th scope="col" class="fk-print-text fk-print-text--bold xxsm-text text-capitalize" colspan="4">Sales Info:</th>
                                    </tr>
                                    <tr>
                                        <th class="fk-print-text xxsm-text text-capitalize">Product</th>
                                        <th class="fk-print-text xxsm-text text-capitalize">Price</th>
                                        <th class="fk-print-text xxsm-text text-capitalize">Qty</th>
                                        <th class="fk-print-text xxsm-text text-capitalize">Total</th>
                                    </tr>
                                    @foreach ($items as $item)
                                        <tr>
                                            <td class="fk-print-text xxsm-text text-capitalize">{{ $item->name }} ({{ $item->model }})</td>
                                            <td class="fk-print-text xxsm-text text-capitalize">{{ number_format($item->unit_price, 2) }}</td>
                                            <td class="fk-print-text xxsm-text text-capitalize">{{ $item->qty }}</td>
                                            <td class="fk-print-text xxsm-text text-capitalize">{{ number_format($item->total_price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="3" class="fk-print-text xxsm-text text-capitalize">Sub Total</td>
                                        <td class="fk-print-text xxsm-text text-capitalize">{{ number_format($sales->bill, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="fk-print-text xxsm-text text-capitalize">Discount</td>
                                        <td class="fk-print-text xxsm-text text-capitalize">{{ number_format($sales->discount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="fk-print-text xxsm-text text-capitalize">Grand Total</td>
                                        <td class="fk-print-text xxsm-text text-capitalize">{{ number_format($sales->payble, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="dashed-border"></div>
                            <span class="fk-print-text fk-print-text--bold xsm-text text-capitalize" id="datePlaceholder">Date: {{ $sales->created_at->format('m-d-Y g:i A') }}</span>
                            <br>
                            <span class="fk-print-text fk-print-text--bold xsm-text text-capitalize text-center d-block">Generated By: {{ auth()->user()->name }}</span>
                            <div class="dashed-border"></div>
                            <p class="mb-0 sm-text fk-print-text--bold text-center text-capitalize">Thank You. Please come again</p>
                            <div class="dashed-border"></div>
                            <div class="dashed-border"></div>
                            <div class="no-cut">&nbsp;</div>
                            <div class="no-cut">&nbsp;</div>
                            <div class="no-cut">&nbsp;</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-print-none" style="display: flex; justify-content: center; gap: 10px; margin-top: 10px;">
                <button onclick="printPage()" class="btn btn-primary">Print</button>
                <button onclick="downloadPDF()" class="btn btn-secondary">Download Invoice</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        function printPage() {
            window.print();
        }

        async function downloadPDF() {
            const { jsPDF } = window.jspdf;
            const invoice = document.querySelector('.fk-print');
            const buttons = document.querySelector('.d-print-none');

            buttons.style.display = 'none';

            const canvas = await html2canvas(invoice, { 
                scale: 2,
                useCORS: true,
                width: invoice.offsetWidth,
                height: invoice.offsetHeight
            });

            buttons.style.display = 'flex';

            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF({
                orientation: 'portrait',
                unit: 'mm',
                format: 'a4'
            });
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;

            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save('invoice.pdf');
        }
    </script>
</body>
</html>