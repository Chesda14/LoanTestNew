<!DOCTYPE html>
<html lang="en">

<head>
    @include('include.head')

    <link rel="stylesheet" href="{{ asset('vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/materialdesignicons.min.css') }}">
</head>

<body>
    <div class="container-scroller d-flex">
        <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
            <div class="content-wrapper d-flex align-items-center auth px-0" style="background: rgba(34,62,156,255)">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light ">
                            <img class="" style="width:12rem" src="../../images/logo4.jpg" alt="logo">
                            <div class="brand-logo text-left  px-sm-5">

                                <h4>Hello! let's get started</h4>
                                <h6 class="font-weight-light">Sign in to continue.</h6>
                            </div>
                            <div class=" text-left py-3 px-sm-5">
                                <form class="" action="/updateUser" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="userid" value="{{ $users->userid }}">
                                    <!-- Ensure the correct user ID -->
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" name="username"
                                            id="exampleInputUsername1" value="{{ $users->username }}"
                                            placeholder="Username">
                                        @if ($errors->has('username'))
                                            <span class="text-danger">
                                                {{ $errors->first('username') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-lg" name="email"
                                            id="exampleInputEmail1" value="{{ $users->email }}" placeholder="Email">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">
                                                {{ $errors->first('email') }}
                                            </span>
                                        @endif
                                    </div>


                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-lg" name="password"
                                            id="exampleInputPassword1" value="{{ $users->password }}"
                                            placeholder="Password">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">
                                                {{ $errors->first('password') }}
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mb-4">
                                        <div class="form-check">
                                            <label class="form-check-label text-muted">
                                                <input type="checkbox" class="form-check-input">
                                                I agree to all Terms & Conditions
                                            </label>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <button
                                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                            type="submit">
                                            SIGN UP
                                        </button>

                                    </div>
                                    <div class="text-center mt-4 font-weight-light">
                                        Already have an account? <a href="/user" class="text-primary">Return</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- page-body-wrapper ends -->
        </div>
        <!-- container-scroller -->
        <!-- base:js -->
        <script src="{{ asset('vendors/js/vendor.bundle.base.js') }}"></script>
        <!-- endinject -->
        <!-- inject:js -->
        <script src="{{ asset('js/off-canvas.js') }}"></script>
        <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
        <script src="{{ asset('js/template.js') }}"></script>
        <!-- endinject -->
</body>

</html>
