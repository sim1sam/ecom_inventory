@extends('frontend.layouts.app')

@section('title', 'Verify')

@section('frontend-content')
<style>
    .verify-card .card-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-purple) 100%);
        color: #fff;
        border-bottom: none;
    }
    .verify-card .alert-success {
        border-left: 4px solid var(--primary-color);
    }
    .verify-link {
        color: var(--primary-color) !important;
        text-decoration: none;
    }
    .verify-link:hover {
        color: var(--dark-purple) !important;
        text-decoration: underline;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card verify-card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link verify-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection