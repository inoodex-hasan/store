<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">

                <!-- Simple Language Switcher -->
                <li class="language-switcher text-center mb-3 p-2 border-bottom">
                    <button onclick="switchLanguage('en')" class="btn btn-sm btn-primary">EN</button>
                    <button onclick="switchLanguage('bn')" class="btn btn-sm btn-secondary">BN</button>
                </li>

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('index') }}">
                        <i class="fe fe-grid"></i>
                        <span>
                            <span class="lang-en">Dashboard</span>
                            <span class="lang-bn" style="display:none">ড্যাশবোর্ড</span>
                        </span>
                    </a>
                </li>

                <!-- Product Management -->
                @can('Product Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Product Management</span>
                            <span class="lang-bn" style="display:none">প্রোডাক্ট ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li class="">
                        <a href="{{ route('category.index') }}"
                            class="{{ Route::currentRouteName() == 'category.index' ? 'active' : '' }}">
                            <i class="fe fe-folder"></i>
                            <span>
                                <span class="lang-en">Category</span>
                                <span class="lang-bn" style="display:none">ক্যাটাগরি</span>
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('brands.index') }}"
                            class="{{ Route::currentRouteName() == 'brand.index' ? 'active' : '' }}">
                            <i class="fe fe-tag"></i>
                            <span>
                                <span class="lang-en">Brand List</span>
                                <span class="lang-bn" style="display:none">ব্র্যান্ড লিস্ট</span>
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('products.index') }}"
                            class="{{ Route::currentRouteName() == 'products.index' ? 'active' : '' }}">
                            <i class="fe fe-box"></i>
                            <span>
                                <span class="lang-en">Product List</span>
                                <span class="lang-bn" style="display:none">প্রোডাক্ট লিস্ট</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Sales Management -->
                @can('Sales Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Sales Management</span>
                            <span class="lang-bn" style="display:none">সেলস ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li class="">
                        <a href="{{ route('sales.create') }}"
                            class="{{ Route::currentRouteName() == 'sales.create' ? 'active' : '' }}">
                            <i class="fe fe-plus-circle"></i>
                            <span>
                                <span class="lang-en">Add Sales</span>
                                <span class="lang-bn" style="display:none">বিক্রয় যোগ</span>
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('sales.index') }}"
                            class="{{ Route::currentRouteName() == 'sales.index' ? 'active' : '' }}">
                            <i class="fe fe-list"></i>
                            <span>
                                <span class="lang-en">Sales List</span>
                                <span class="lang-bn" style="display:none">বিক্রয় লিস্ট</span>
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('returns.index') }}"
                            class="{{ Route::currentRouteName() == 'returns.index' ? 'active' : '' }}">
                            <i class="fe fe-rotate-ccw"></i>
                            <span>
                                <span class="lang-en">Product Returns</span>
                                <span class="lang-bn" style="display:none">প্রোডাক্ট রিটার্ন</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Customer Management -->
                @can('Customer Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Customer Management</span>
                            <span class="lang-bn" style="display:none">কাস্টমার ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li class="">
                        <a href="{{ route('customers.create') }}"
                            class="{{ Route::currentRouteName() == 'customers.create' ? 'active' : '' }}">
                            <i class="fe fe-user-plus"></i>
                            <span>
                                <span class="lang-en">Add Customer</span>
                                <span class="lang-bn" style="display:none">কাস্টমার যোগ</span>
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('customers.index') }}"
                            class="{{ Route::currentRouteName() == 'customers.index' ? 'active' : '' }}">
                            <i class="fe fe-users"></i>
                            <span>
                                <span class="lang-en">Customer List</span>
                                <span class="lang-bn" style="display:none">কাস্টমার লিস্ট</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Vendor Management -->
                @can('Vendor Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Vendor Management</span>
                            <span class="lang-bn" style="display:none">ভেন্ডর ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li class="">
                        <a href="{{ route('vendors.create') }}"
                            class="{{ Route::currentRouteName() == 'vendors.create' ? 'active' : '' }}">
                            <i class="fe fe-truck"></i>
                            <span>
                                <span class="lang-en">Add Vendor</span>
                                <span class="lang-bn" style="display:none">ভেন্ডর যোগ</span>
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('vendors.index') }}"
                            class="{{ Route::currentRouteName() == 'vendors.index' ? 'active' : '' }}">
                            <i class="fe fe-truck"></i>
                            <span>
                                <span class="lang-en">Vendor List</span>
                                <span class="lang-bn" style="display:none">ভেন্ডর লিস্ট</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Purchase Management -->
                @can('Purchase Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Purchase Management</span>
                            <span class="lang-bn" style="display:none">ক্রয় ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li class="">
                        <a href="{{ route('purchase.index') }}"
                            class="{{ Route::currentRouteName() == 'purchase.index' ? 'active' : '' }}">
                            <i class="fe fe-shopping-cart"></i>
                            <span>
                                <span class="lang-en">Purchase List</span>
                                <span class="lang-bn" style="display:none">ক্রয় লিস্ট</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Stock Management -->
                @can('Inventory Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Stock Management</span>
                            <span class="lang-bn" style="display:none">স্টক ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li class="">
                        <a href="{{ route('stock.index') }}"
                            class="{{ Route::currentRouteName() == 'stock.index' ? 'active' : '' }}">
                            <i class="fe fe-layers"></i>
                            <span>
                                <span class="lang-en">Stock List</span>
                                <span class="lang-bn" style="display:none">স্টক লিস্ট</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Transfer Stock Management -->
                @can('Sales Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Transfer Stock Management</span>
                            <span class="lang-bn" style="display:none">স্টক ট্রান্সফার ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li class="">
                        <a href="{{ route('transfer_stock.index') }}"
                            class="{{ Route::currentRouteName() == 'transfer_stock.index' ? 'active' : '' }}">
                            <i class="fe fe-shuffle"></i>
                            <span>
                                <span class="lang-en">Transfer Stock</span>
                                <span class="lang-bn" style="display:none">স্টক ট্রান্সফার</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Expense Management -->
                @can('Expense Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Expense Management</span>
                            <span class="lang-bn" style="display:none">খরচ ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li>
                        <a href="{{ route('expense-categories.index') }}"
                            class="{{ Route::currentRouteName() == 'expense-categories.index' ? 'active' : '' }}">
                            <i class="fe fe-folder-plus"></i>
                            <span>
                                <span class="lang-en">Expense Category</span>
                                <span class="lang-bn" style="display:none">খরচ ক্যাটাগরি</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('dailyExpenses.index') }}"
                            class="{{ Route::currentRouteName() == 'dailyExpenses.index' ? 'active' : '' }}">
                            <i class="fe fe-dollar-sign"></i>
                            <span>
                                <span class="lang-en">Expense List</span>
                                <span class="lang-bn" style="display:none">খরচ লিস্ট</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Report Management -->
                @can('Report Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Report Management</span>
                            <span class="lang-bn" style="display:none">রিপোর্ট ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li class="">
                        <a href="{{ route('purchase.report') }}"
                            class="{{ Route::currentRouteName() == 'purchase.report' ? 'active' : '' }}">
                            <i class="fe fe-bar-chart-2"></i>
                            <span>
                                <span class="lang-en">Purchase Report</span>
                                <span class="lang-bn" style="display:none">ক্রয় রিপোর্ট</span>
                            </span>
                        </a>
                    </li>
                    <li class="">
                        <a href="{{ route('sales.report') }}"
                            class="{{ Route::currentRouteName() == 'sales.report' ? 'active' : '' }}">
                            <i class="fe fe-bar-chart"></i>
                            <span>
                                <span class="lang-en">Sales Report</span>
                                <span class="lang-bn" style="display:none">বিক্রয় রিপোর্ট</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Payment Management -->
                @can('Sales Management')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Payment Management</span>
                            <span class="lang-bn" style="display:none">পেমেন্ট ম্যানেজমেন্ট</span>
                        </span>
                    </li>
                    <li>
                        <a href="{{ route('payments.create') }}"
                            class="{{ Route::currentRouteName() == 'payments.create' ? 'active' : '' }}">
                            <i class="fe fe-credit-card"></i>
                            <span>
                                <span class="lang-en">Add Payment</span>
                                <span class="lang-bn" style="display:none">পেমেন্ট যোগ</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payments.index') }}"
                            class="{{ Route::currentRouteName() == 'payments.index' ? 'active' : '' }}">
                            <i class="fe fe-dollar-sign"></i>
                            <span>
                                <span class="lang-en">Payment List</span>
                                <span class="lang-bn" style="display:none">পেমেন্ট লিস্ট</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('account-receivable.index') }}"
                            class="{{ Route::currentRouteName() == 'account-receivable.index' ? 'active' : '' }}">
                            <i class="fe fe-alert-circle"></i>
                            <span>
                                <span class="lang-en">Due Payment List</span>
                                <span class="lang-bn" style="display:none">বকেয়া পেমেন্ট লিস্ট</span>
                            </span>
                        </a>
                    </li>
                @endcan

                <!-- Authorization -->
                @can('Administration')
                    <li class="menu-title">
                        <span>
                            <span class="lang-en">Authorization</span>
                            <span class="lang-bn" style="display:none">অথোরাইজেশন</span>
                        </span>
                    </li>

                    <li>
                        <a href="{{ route('setting.index') }}"
                            class="{{ Route::currentRouteName() == 'setting.index' ? 'active' : '' }}">
                            <i class="fe fe-settings"></i>
                            <span>
                                <span class="lang-en">Settings</span>
                                <span class="lang-bn" style="display:none">সেটিংস</span>
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('Shop-warehouse.index') }}"
                            class="{{ Route::currentRouteName() == 'Shop-warehouse.index' ? 'active' : '' }}">
                            <i class="fe fe-home"></i>
                            <span>
                                <span class="lang-en">Shop & Warehouse</span>
                                <span class="lang-bn" style="display:none">শপ ও ওয়্যারহাউজ</span>
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('user-manage.index') }}"
                            class="{{ Route::currentRouteName() == 'user-manage.index' ? 'active' : '' }}">
                            <i class="fe fe-users"></i>
                            <span>
                                <span class="lang-en">User Manage</span>
                                <span class="lang-bn" style="display:none">ইউজার ম্যানেজমেন্ট</span>
                            </span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('permission.index') }}"
                            class="{{ Route::currentRouteName() == 'permission.index' ? 'active' : '' }}">
                            <i class="fe fe-lock"></i>
                            <span>
                                <span class="lang-en">Permissions</span>
                                <span class="lang-bn" style="display:none">পারমিশনস</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('role.index') }}"
                            class="{{ Route::currentRouteName() == 'role.index' ? 'active' : '' }}">
                            <i class="fe fe-shield"></i>
                            <span>
                                <span class="lang-en">Roles</span>
                                <span class="lang-bn" style="display:none">রোলস</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}"
                            class="{{ Route::currentRouteName() == 'users.index' ? 'active' : '' }}">
                            <i class="fe fe-users"></i>
                            <span>
                                <span class="lang-en">Users</span>
                                <span class="lang-bn" style="display:none">ইউজারস</span>
                            </span>
                        </a>
                    </li>
                @endcan

            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->

<!-- Simple JavaScript -->
<script>
    function switchLanguage(lang) {
        console.log('Switching to:', lang);

        if (lang === 'en') {
            // Show English, hide Bengali
            document.querySelectorAll('.lang-en').forEach(el => el.style.display = 'inline');
            document.querySelectorAll('.lang-bn').forEach(el => el.style.display = 'none');

            // Update button styles
            document.querySelector('[onclick="switchLanguage(\'en\')"]').classList.add('btn-primary');
            document.querySelector('[onclick="switchLanguage(\'en\')"]').classList.remove('btn-secondary');
            document.querySelector('[onclick="switchLanguage(\'bn\')"]').classList.add('btn-secondary');
            document.querySelector('[onclick="switchLanguage(\'bn\')"]').classList.remove('btn-primary');
        } else {
            // Show Bengali, hide English
            document.querySelectorAll('.lang-en').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.lang-bn').forEach(el => el.style.display = 'inline');

            // Update button styles
            document.querySelector('[onclick="switchLanguage(\'bn\')"]').classList.add('btn-primary');
            document.querySelector('[onclick="switchLanguage(\'bn\')"]').classList.remove('btn-secondary');
            document.querySelector('[onclick="switchLanguage(\'en\')"]').classList.add('btn-secondary');
            document.querySelector('[onclick="switchLanguage(\'en\')"]').classList.remove('btn-primary');
        }

        localStorage.setItem('menuLanguage', lang);
    }

    // Load saved language when page loads
    document.addEventListener('DOMContentLoaded', function() {
        const savedLang = localStorage.getItem('menuLanguage') || 'en';
        switchLanguage(savedLang);
    });
</script>

<style>
    .language-switcher {
        background: #f8f9fa;
        border-radius: 5px;
        margin: 10px;
    }

    .language-switcher .btn {
        margin: 0 2px;
        padding: 5px 15px;
        font-weight: bold;
    }

    .lang-bn {
        font-family: 'Kalpurush', 'SolaimanLipi', 'Arial', sans-serif;
    }
</style>
