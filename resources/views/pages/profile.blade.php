@extends('layouts.app2')

@section('title', 'Etalase Barang')

@section('content')
    <section class="py-5 bg-light bg-opacity-25">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-12">
                    <div class="card border-0 shadow rounded-4">
                        @if (session('success'))
                            <div class="alert alert-success shadow-sm rounded-pill px-4">{{ session('success') }}</div>
                        @elseif (session('error'))
                            <div class="alert alert-danger shadow-sm rounded-pill px-4">{{ session('error') }}</div>
                        @endif
                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf

                            <div
                                class="card-header bg-white border-bottom-0 d-flex justify-content-between align-items-center rounded-top-4 p-4">
                                <h5 class="mb-0 fw-semibold text-primary">👤 Edit Profile</h5>
                                <button type="submit" class="btn btn-primary px-4">Save</button>
                            </div>

                            <div class="card-body p-4">
                                <div class="row g-4">
                                    {{-- Left Column: User Info --}}
                                    <div class="col-md-6">
                                        <h6 class="text-uppercase text-muted fw-bold mb-3">User Information</h6>
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Username"
                                                        value="{{ old('username', auth()->user()->username) }}">
                                                    <label for="username">Username</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control" id="email" name="email"
                                                        placeholder="Email"
                                                        value="{{ old('email', auth()->user()->email) }}">
                                                    <label for="email">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="firstname"
                                                        name="firstname" placeholder="First name"
                                                        value="{{ old('firstname', auth()->user()->firstname) }}">
                                                    <label for="firstname">First Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="lastname"
                                                        name="lastname" placeholder="Last name"
                                                        value="{{ old('lastname', auth()->user()->lastname) }}">
                                                    <label for="lastname">Last Name</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Right Column: Contact Info --}}
                                    <div class="col-md-6">
                                        <h6 class="text-uppercase text-muted fw-bold mb-3">Contact Information</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="address" name="address"
                                                        placeholder="Address"
                                                        value="{{ old('address', auth()->user()->address) }}">
                                                    <label for="address">Address</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="city" name="city"
                                                        placeholder="City" value="{{ old('city', auth()->user()->city) }}">
                                                    <label for="city">City</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="country" name="country"
                                                        placeholder="Country"
                                                        value="{{ old('country', auth()->user()->country) }}">
                                                    <label for="country">Country</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="postal" name="postal"
                                                        placeholder="Postal Code"
                                                        value="{{ old('postal', auth()->user()->postal) }}">
                                                    <label for="postal">Postal Code</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">

                                {{-- About Me --}}
                                <h6 class="text-uppercase text-muted fw-bold mb-3">About Me</h6>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="About you" id="about" name="about" style="height: 120px">{{ old('about', auth()->user()->about) }}</textarea>
                                    <label for="about">Write something about yourself...</label>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
