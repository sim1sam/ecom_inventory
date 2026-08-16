@include('admin.header')
<div id="app">
    <section class="section">
        <div class="auth-section-wrapper">
            <div class="login-thumb">
                <img class="img" src="{{ asset($setting->admin_login_page) }}" alt="login-thumb"/>
            </div>
            <div class="form-area-wrapper">
                <div class="form-content-wrapper">
                    <div class="logo">
                        <img src="{{ asset($setting->logo) }}" alt="logo"/>
                    </div>
                    <div class="card card-primary card-wrapper-auth">
                        <div class="card-body">
                            <div class="tex-content">
                                <h1>{{__('admin.Seller Dashboard')}}</h1>
                                <p class="des">{{__('admin.Login Your  fashion shopping Seller Dashboard')}} </p>
                            </div>
                            
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            
                            <form class="needs-validation" novalidate="" id="adminLoginForm">
                                @csrf

                                <div class="form-group">
                                    <label for="email">{{__('admin.Email')}}<sup>*</sup></label>
                                    <input id="email exampleInputEmail" type="email" class="form-control" name="email" tabindex="1" autofocus value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">{{__('admin.Password')}}<sup>*</sup></label>
                                        <div class="float-right">
                                            <a href="{{ route('seller.forget.password') }}" class="text-small">
                                                {{__('admin.Forgot Password?')}}
                                            </a>
                                        </div>
                                    </div>
                                    <input id="password exampleInputPassword" type="password" class="form-control" name="password" tabindex="2">
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="remember">{{__('admin.Remember Me')}}</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button id="adminLoginBtn" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        {{__('admin.Login')}}
                                    </button>
                                </div>
                                
                                <div class="form-group text-center">
                                    <p class="mb-0">Don't have an account? <a href="{{ route('seller.register') }}" class="text-primary">Register as Seller</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="simple-footer">
                        {{ $setting->copyright }}
                    </div>
                </div>
            </div>
            <div class="simple-footer">
                {{ $setting->copyright }}
            </div>
        </div>
    </section>
 </div>


<script>
    (function($) {
    "use strict";
    $(document).ready(function () {
        $("#adminLoginBtn").on('click',function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('seller.login') }}",
                type:"post",
                data:$('#adminLoginForm').serialize(),
                success:function(response){
                    if(response.success){
                        window.location.href = "{{ route('seller.dashboard')}}";
                        toastr.success(response.success)
                    }
                    if(response.error){
                        toastr.error(response.error)
                    }
                },
                error:function(response){
                    console.log(response);
                    if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                    if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])
                }

            });


        })

        $(document).on('keyup', '#exampleInputEmail, #exampleInputPassword', function (e) {
            if(e.keyCode == 13){
                e.preventDefault();

                $.ajax({
                    url: "{{ route('seller.login') }}",
                    type:"post",
                    data:$('#adminLoginForm').serialize(),
                    success:function(response){
                        if(response.success){
                            window.location.href = "{{ route('seller.dashboard')}}";
                            toastr.success(response.success)
                        }
                        if(response.error){
                            toastr.error(response.error)

                        }
                    },
                    error:function(response){
                        if(response.responseJSON.errors.email)toastr.error(response.responseJSON.errors.email[0])
                        if(response.responseJSON.errors.password)toastr.error(response.responseJSON.errors.password[0])

                    }

                });

            }

        })
    });

    })(jQuery);
</script>

@include('admin.footer')


