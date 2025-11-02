<!-- resources/views/auth/login.blade.php -->

@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Welcome Back 👋</h2>

    @if (session('status'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
            <label for="email" class="block text-sm text-gray-600">Email Address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-indigo-200">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm text-gray-600">Password</label>
            <input id="password" type="password" name="password" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-indigo-200">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-between items-center mb-6">
            <label class="flex items-center text-sm">
                <input type="checkbox" name="remember" class="mr-2"> Remember Me
            </label>
            <a href="{{ route('password.request') }}" class="text-indigo-500 text-sm hover:underline">Forgot?</a>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
            Log In
        </button>
    </form>

    <p class="text-center text-gray-500 text-sm mt-6">
        Don’t have an account?
        <a href="{{ route('register') }}" class="text-indigo-500 hover:underline">Register</a>
    </p>
  </div>
</div>
@endsection
