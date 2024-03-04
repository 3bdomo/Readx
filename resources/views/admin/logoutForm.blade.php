<!-- resources/views/login.blade.php -->
<form method="POST" action="{{ route('admin.logout') }}">
    @csrf



    <button type="submit">Login</button>
</form>
