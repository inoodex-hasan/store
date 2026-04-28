@extends('frontend.layouts.app')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        /* Default: Columns stack vertically */
        .custom-col-xl-2 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        /* Media Query for XL screens (≥1200px) */
        @media (min-width: 1200px) {
            .custom-col-xl-2 {
                flex: 0 0 20%;
                /* Equivalent to col-xl-2 (2/12 = 16.67%) */
                max-width: 20%;
            }
        }

        .page-wrapper .content {
            padding: 14px !important;
        }

        .card-border {
            border: 1px solid #eee;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            border-left: 4px solid #000;
            /* border-right: 2px solid #000; */
        }


        .card-border p {
            /* color: #2f3e46; */
            color: #6c757d;
        }

        .card-border .icon {
            font-size: 50px;
        }

        .card-border p {
            font-size: 40px;
            font-weight: medium;
        }

        .sky-text {
            color: #74C0FC;
        }

        .sky-b {
            border-left-color: #74C0FC
        }

        .green-text {
            color: #63E6BE;
        }

        .green-b {
            border-left-color: #63E6BE
        }

        .orange-text {
            color: #f48c06;
        }

        .orange-b {
            border-left-color: #f48c06
        }

        .blue-text {
            color: #00509d;
        }

        .blue-b {
            border-left-color: #00509d
        }

        .avg-title {
            color: #000000b3 !important;
            margin-bottom: 20px !important;
        }
    </style>

    <div class="content container-fluid">

        <h3 class="card-title avg-title mb-2 fw-bold">Sales </h3>
        <div class="row g-8">

            <div class="col-sm-6 col-lg-4 col-xl-4">
                <div class="card card-border sky-b">
                    <div class="content">

                        <h6 class="mb-1" style="color: #6c757d;">Today's Sales</h6>
                        <p class="fw-bold mb-0">
                            {{ $todaysSalesRevenue }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-between sky-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class=" fa-solid fa-money-bill-1-wave"></i>
                    </div>

                </div>
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-4">
                <div class="card card-border green-b">
                    <div class="content">
                        <h6 class="mb-1" style="color: #6c757d;">This Week Sales</h6>
                        <p class="fw-bold mb-0">
                            {{ $thisWeeksSalesRevenue }}
                        </p>

                    </div>
                    <div class="icon d-flex align-items-center justify-content-center green-text"
                        style=" padding: 15px; border-radius: 8px; ">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-4">
                <div class="card card-border orange-b ">
                    <div class="content">
                        <h6 class="mb-1" style="color: #6c757d;">This Month Sales</h6>
                        <p class="fw-bold mb-0">

                            {{ $thisMonthsSalesRevenue }}
                        </p>

                    </div>
                    <div class="icon d-flex align-items-center justify-content-center orange-text"
                        style=" padding: 15px; border-radius: 8px; ">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>
            </div>
            {{-- 

            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card card-border orange-b " style="border-left-color:#00509d">
                    <div class="content">
                        <h6 class="mb-1" style="color: #6c757d;">This Year Revenue</h6>
                        <p class="fw-bold mb-0">
                            {{ $thisYearsSalesRevenue }}
                        </p>

                    </div>
                    <div class="icon d-flex align-items-center justify-content-center orange-text"
                        style=" padding: 15px; border-radius: 8px; color:#00509d">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>
            </div> --}}
        </div>

        <h3 class="card-title avg-title mb-2 fw-bold">Purchase</h3>

        <div class="row g-8">
            <div class=" col-sm-6 col-lg-4 col-xl-3">
                <div class="card card-border blue-b ">
                    <div class="content">
                        <h6 class="mb-1  " style="color: #6c757d;">Today's Purchase</h6>
                        <p class="fw-bold mb-0">
                            {{ $todaysPurchaseRevenue }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-center blue-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card card-border orange-b">
                    <div class="content">
                        <h6 class="mb-1" style="color: #6c757d;">This Week Purchase</h6>
                        <p class="fw-bold mb-0">
                            {{ $thisWeeksPurchaseRevenue }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-center orange-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card card-border green-b">
                    <div class="content">
                        <h6 class="mb-1" style="color: #6c757d;">This Month Purchase</h6>
                        <p class="fw-bold mb-0">
                            {{ $thisMonthsPurchaseRevenue }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-center green-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">

                <div class="card card-border sky-b">
                    <div class="content">
                        <h6 class="mb-1" style="color: #6c757d;">This Year Purchase</h6>
                        <p class="fw-bold mb-0">
                            {{ $thisYearsPurchaseRevenue }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-center sky-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>

            </div>

        </div>

        <h3 class="card-title avg-title mb-2 fw-bold">Expense</h3>
        <div class="row g-8">
            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card card-border orange-b">
                    <div class="content">
                        <h6 class="mb-1" style="color: #6c757d;">Today's Expense</h6>
                        <p class="fw-bold mb-0">
                            {{ $todaysExpense }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-center orange-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class=" fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>


            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">

                <div class="card card-border green-b">
                    <div class="content">
                        <h6 class="mb-1 " style="color: #6c757d;">This Week Expense</h6>
                        <p class="fw-bold mb-0">
                            {{ $thisWeeksExpense }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-center green-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card card-border sky-b">
                    <div class="content">
                        <h6 class="mb-1 " style="color: #6c757d;">This Month Expense</h6>
                        <p class="fw-bold mb-0">
                            {{ $thisMonthsExpense }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-center sky-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-4 col-xl-3">
                <div class="card card-border blue-b">
                    <div class="content">
                        <h6 class="mb-1 " style="color: #6c757d;">This Year Expense</h6>
                        <p class="fw-bold mb-0">
                            {{ $thisYearsExpense }}
                        </p>
                    </div>
                    <div class="icon d-flex align-items-center justify-content-center blue-text"
                        style=" padding: 15px; border-radius: 8px;">
                        <i class="fa-solid fa-money-bill-1-wave"></i>
                    </div>
                </div>
            </div>

        </div>




        <div class="row">
            <div class="col-xl-7 d-flex">
                <div class="card shadow flex-fill">
                    <div class="card-header cat-head">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-medium">Monthly Service Report</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="sales_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 d-flex">
                <div class="card shadow flex-fill">
                    <div class="card-header cat-head">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-medium">Yearly Service Report</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="sales_chart_yearly"></div>

                    </div>
                </div>
            </div>
        </div>

    </div>



    <script>
        // Embed PHP data as a JavaScript object
        window.chartData = {
            monthlyRevenue: '', // Passing the PHP array to JavaScript @ json($monthlyRevenue)
            yearlyRevenue: '' // Similarly, for yearly revenue @ json($yearlyRevenue)
        };
    </script>
@endsection
