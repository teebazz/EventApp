
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            @auth
                <a class="nav-link" href="{{route('dashboard')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a> 
                <a class="nav-link" href="{{route('attendees')}}">
                    <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                    Attendees
                </a>
                {{-- <a class="nav-link" href="index.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                    Settings
                </a> --}}
            @endauth
            <a class="nav-link" href="{{route('/')}}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Home
            </a> 
        </div>
    </div>
    @auth
        <div class="sb-sidenav-footer">
            
            <div class="small">Logged in as:</div>
            {{auth()->user()->name }}
            
        </div>
    @endauth
</nav>