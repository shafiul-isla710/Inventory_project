<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title></title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/x-icon" href="{{asset('/favicon.ico')}}" />
    <link href="{{asset('assets/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/animate.min.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/fontawesome.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/toastify.min.css')}}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="{{asset('assets/css/jquery.dataTables.min.css')}}" rel="stylesheet" />

    @stack('style')

</head>

<body>

<div id="loader" class="LoadingOverlay d-none">
    <div class="Line-Progress">
        <div class="indeterminate"></div>
    </div>
</div>

<nav class="navbar fixed-top px-0 shadow-sm bg-white">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <span class="icon-nav m-0 h5" onclick="MenuBarClickHandler()">
                <img class="nav-logo-sm mx-2"  src="{{asset('assets/images/menu.svg')}}" alt="logo"/>
            </span>
            <img class="nav-logo  mx-2"  src="{{asset('assets/images/logo.png')}}" alt="logo"/>
        </a>

        <div class="float-right h-auto d-flex">
           
            <div class="user-dropdown">
               
                <img id="navImage" class="icon-nav-img" src="{{asset('assets/images/user.webp')}}" alt=""/>
                <div class="user-dropdown-content ">
                    <div class="mt-4 text-center">
                        <img id="profileImage" class="icon-nav-img" src="{{asset('assets/images/user.webp')}}" alt=""/>
                        <h6 id="userName">User Name</h6>
                        <p class="text-danger" id='userRole'>User Role</p>
                        <hr class="user-dropdown-divider  p-0"/>
                    </div>
                    <a href="{{ route('profile.page')}}" class="side-bar-item">
                        <span class="side-bar-item-caption">Profile</span>
                    </a>
                    <a onclick="logout()" class="side-bar-item">
                        <span class="side-bar-item-caption">Logout</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>

<div id="adminSideNav" class="side-nav-open" style="display: none;">
    <a href="{{ route("dashboard.page")}}" class="side-bar-item {{ request()->routeIs('dashboard') ? 'side-bar-item-active' : '' }}">
        <i class="bi bi-graph-up"></i>
        <span class="side-bar-item-caption">Dashboard</span>
    </a>

    <a href="{{ route("admin.orders.list")}}" class="side-bar-item">
        <i class="bi bi-people"></i>
        <span class="side-bar-item-caption">Customer Orders</span>
    </a>

    <a href="{{url("/categoryPage")}}" class="side-bar-item {{ request()->routeIs('categoryPage') ? 'side-bar-item-active' : '' }}">
        <i class="bi bi-list-nested"></i>
        <span class="side-bar-item-caption">Category</span>
    </a>

    <a href="{{ route('admin.products.list') }}" class="side-bar-item">
        <i class="bi bi-bag"></i>
        <span class="side-bar-item-caption">Product</span>
    </a>

    <a href="{{url('/salePage')}}" class="side-bar-item">
        <i class="bi bi-currency-dollar"></i>
        <span class="side-bar-item-caption">Create Sale</span>
    </a>

    <a href="{{url('/invoicePage')}}" class="side-bar-item">
        <i class="bi bi-receipt"></i>
        <span class="side-bar-item-caption">Invoice</span>
    </a>

    <a href="{{url('/reportPage')}}" class="side-bar-item">
        <i class="bi bi-file-earmark-bar-graph"></i>
        <span class="side-bar-item-caption">Report</span>
    </a>

</div>

<div id="customerSideNav" class="side-nav-open" style="display: none;">
    <a href="{{ route("dashboard.page")}}" class="side-bar-item {{ request()->routeIs('dashboard') ? 'side-bar-item-active' : '' }}">
        <i class="bi bi-graph-up"></i>
        <span class="side-bar-item-caption">Dashboard</span>
    </a>

    <a href="{{ route('customer.product.list') }}" class="side-bar-item">
        <i class="bi bi-people"></i>
        <span class="side-bar-item-caption">Orders</span>
    </a>

    <a href="{{ route('customer.products') }}" class="side-bar-item">
        <i class="bi bi-bag"></i>
        <span class="side-bar-item-caption">Products</span>
    </a>

    <a href="" class="side-bar-item">
        <i class="bi bi-receipt"></i>
        <span class="side-bar-item-caption">Invoice</span>
    </a>
</div>


<div id="contentRef" class="content">
    @yield('content')
</div>


<script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>


<script src="{{asset('assets/js/toastify-js.js')}}"></script>
{{-- <script src="{{asset('js/axios.min.js')}}"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.3/axios.min.js"></script>
<script src="{{asset('assets/js/config.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.js')}}"></script>


<script>
    function MenuBarClickHandler() {
        let sideNav = document.getElementById('sideNavRef');
        let content = document.getElementById('contentRef');
        if (sideNav.classList.contains("side-nav-open")) {
            sideNav.classList.add("side-nav-close");
            sideNav.classList.remove("side-nav-open");
            content.classList.add("content-expand");
            content.classList.remove("content");
        } else {
            sideNav.classList.remove("side-nav-close");
            sideNav.classList.add("side-nav-open");
            content.classList.remove("content-expand");
            content.classList.add("content");
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        
        let loginUser = JSON.parse(localStorage.getItem("user"));
        let profileImage = document.getElementById("profileImage");
        let navImage = document.getElementById("navImage");
        document.getElementById("userName").innerHTML = loginUser.name;

        if(loginUser && loginUser.avatar){
            profileImage.src = loginUser.avatar;
            navImage.src = loginUser.avatar;
        }
    })
    let loginUser = JSON.parse(localStorage.getItem("user"));
    if(loginUser && loginUser.role==="admin"){
        document.getElementById("adminSideNav").style.display = "block";
    }
    else{
        document.getElementById("customerSideNav").style.display = "block";
    }

    //user role
    if(loginUser && loginUser.role === 'admin'){
        document.getElementById("userRole").innerHTML = "Admin";
    }
    else if(loginUser && loginUser.role === 'customer'){
        document.getElementById("userRole").innerHTML = "Customer";
    }
    else if(loginUser && loginUser.role === 'staff'){
        document.getElementById("userRole").innerHTML = "Staff";
    }
    else{
        document.getElementById("userRole").innerHTML = "";
    }

    async function logout(){
        showLoader();
        let res = await axios.get("/backend/logout")
        hideLoader();

        if(res.status===200){
            successToast(res.data['message'])
            setTimeout(() => {
                window.location.href = "/login";
            },2000)
        }
        else{
            errorToast(res.data['message'])
        }
    }

</script>

@stack('script')
</body>
</html>
