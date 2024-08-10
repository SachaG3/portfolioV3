@include('/includes/header')
<div class=" flex items-center justify-center h-screen" style="min-height: 85svh">
    <form action="{{ route('login') }}" method="POST" class="bg-base-200 p-6 rounded-lg shadow-md max-w-sm">
        @csrf
        <h2 class="text-2xl font-bold mb-5 text-center">Login</h2>
        <div class="mb-4">
            <label for="username" class="block text-sm font-medium">Username:</label>
            <input type="text" id="username" name="username" class="input input-bordered w-full" required>
        </div>
        <div class="mb-6">
            <label for="password" class="block text-sm font-medium ">Password:</label>
            <input type="password" id="password" name="password" class="input input-bordered w-full" required>
        </div>
        <button type="submit" class="btn btn-primary w-full">Login</button>
        @if($errors->any())
            <div class="mt-4 text-red-500 text-sm">
                <strong>{{ $errors->first() }}</strong>
            </div>
        @endif
    </form>
</div>
@include('/includes/footer')
