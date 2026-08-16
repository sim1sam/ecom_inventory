@include('admin.header')
<div id="app">
    <section class="section">
        <div class="auth-section-wrapper">
            <div class="login-thumb">
                <img class="img" src="{{ asset($setting->admin_login_page) }}" alt="reset-thumb"/>
            </div>
            <div class="form-area-wrapper">
                <div class="form-content-wrapper">
                    <div class="logo">
                        <img src="{{ asset($setting->logo) }}" alt="logo"/>
                    </div>
                    <div class="card card-primary card-wrapper-auth">
                        <div class="card-body">
                            <div class="tex-content">
                                <h1>{{__('admin.Reset Password')}}</h1>
                                <p class="des">{{__('admin.Enter your new password')}} </p>
                            </div>
                            <form class="needs-validation" novalidate="" id="sellerResetForm">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $seller->email }}">

                                <div class="form-group">
                                    <label for="email_display">{{__('admin.Email')}}</label>
                                    <input id="email_display" type="email" class="form-control" value="{{ $seller->email }}" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="password">{{__('admin.New Password')}}<sup>*</sup></label>
                                    <input id="password" type="password" class="form-control" name="password" tabindex="1" autofocus>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">{{__('admin.Confirm Password')}}<sup>*</sup></label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" tabindex="2">
                                </div>

                                <div class="form-group">
                                    <button id="sellerResetBtn" type="submit" class="btn btn-primary btn-lg btn-block" tabindex="3">
                                        {{__('admin.Reset Password')}}
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
        $("#sellerResetBtn").on('click',function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('seller.password.store', $token) }}",
                type:"post",
                data:$('#sellerResetForm').serialize(),
                success:function(response){
                    if(response.success){
                        toastr.success(response.success)
                        window.location.href = "{{ route('seller.login') }}";
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