@include('admin.header')
<div id="app">
    <section class="section">
        <div class="auth-section-wrapper">
            <div class="login-thumb">
                <img class="img" src="{{ asset($setting->admin_login_page) }}" alt="forget-thumb"/>
            </div>
            <div class="form-area-wrapper">
                <div class="form-content-wrapper">
                    <div class="logo">
                        <img src="{{ asset($setting->logo) }}" alt="logo"/>
                    </div>
                    <div class="card card-primary card-wrapper-auth">
                        <div class="card-body">
                            <div class="tex-content">
                                <h1>{{__('admin.Forgot Password')}}</h1>
                                <p class="des">{{__('admin.Enter your email to reset your password')}} </p>
                            </div>
                            <form class="needs-validation" novalidate="" id="sellerForgetForm">
                                @csrf

                                <div class="form-group">
                                    <label for="email">{{__('admin.Email')}}<sup>*</sup></label>
                                    <input id="email" type="email" class="form-control" name="email" tabindex="1" autofocus value="{{ old('email') }}">
                                </div>

                                <div class="form-group">
                                    <button id="sellerForgetBtn" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="2">
                                        {{__('admin.Send Reset Link')}}
                                    </button>
                                </div>
                                
                                <div class="form-group text-center">
                                    <p class="mb-0">Remember your password? <a href="{{ route('seller.login') }}" class="text-primary">Back to Login</a></p>
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
        $("#sellerForgetBtn").on('click',function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('seller.send.forget.password.mail') }}",
                type:"post",
                data:$('#sellerForgetForm').serialize(),
                success:function(response){
                    if(response.success){
                        toastr.success(response.success)
                        $('#sellerForgetForm')[0].reset();
                    }
                    if(response.error){
                        toastr.error(response.error)
                    }
                },
                error:function(response){
                    console.log(response);
                    if(response.responseJSON.errors){
                        $.each(response.responseJSON.errors, function(key, value){
                            toastr.error(value[0]);
                        });
                    }
                }
            });
        });
    });
})(jQuery);
</script>

@include('admin.footer')