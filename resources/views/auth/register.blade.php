@extends('layouts.frontend')
@section('content')
    <section class="py-5 pt-0">
        <div class="container-fluid">

            <div class="bg-secondary py-5 my-5 rounded-5 pt-0"
                style="background: url('{{ asset('fe/images/bg-leaves-img-pattern.png') }}') no-repeat;">
                <div class="container my-5">
                    <div class="row">
                        <div class="col-md-6 p-5 d-flex flex-column justify-content-center align-items-center text-center">
                            <div class="section-header">
                                <h2 class="section-title display-4">{{ config('app.name') }}</h2>
                            </div>
                            <p>{{ config('services.company_address') }}</p>
                        </div>

                        <div class="col-md-6 p-5">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text"
                                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        name="name" id="name" placeholder="Nama" required autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="whatsapp" class="form-label">No Whatsapp</label>
                                    <input type="phone"
                                        class="form-control form-control-lg @error('whatsapp') is-invalid @enderror"
                                        name="whatsapp" id="whatsapp" placeholder="6282xx" required>
                                    @error('whatsapp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        name="password" id="password" placeholder="Password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password </label>
                                    <input type="password"
                                        class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" id="password_confirmation"
                                        placeholder="Konfirmasi Password" required>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-dark btn-lg">Register</button>
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Back to Login</a>
                                </div>
                            </form>

                        </div>

                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
