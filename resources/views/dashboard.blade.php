<style>
    body {
        font-size: 10pt !important;
    }

    label {
        margin-bottom: 0px !important;
        padding-bottom: 2px !important;
    }
</style>

<x-app-layout>

    <div class="wrapper">
        @include('layouts.sidebar')
        <div id="content">

            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <button type="button" id="sidebarCollapse" class="btn btn-info">
                    <i class="fas fa-align-left"></i>
                    <span>Toggle Menu</span>
                </button>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                        aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                        <li class="nav-item active">
                            <a class="nav-link" href="#">New <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Cancel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Draft Save</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Save</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Query</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Report</a>
                        </li>
                    </ul>
                    <form class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                    </form>
                </div>
            </nav>
            {{--            <div class="bg-white shadow-xl sm:rounded-lg">--}}

            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <strong>Warning!</strong>
                    @foreach ($errors->all() as $error)
                        <br>{{ $error }}
                    @endforeach
                </div>
            @endif
            @if(session()->has('message'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                    </button>
                    <strong>Success!</strong>
                    {{ session()->get('message') }}
                </div>
            @endif
            @yield('content')
            {{--            </div>--}}
        </div>
    </div>

</x-app-layout>


