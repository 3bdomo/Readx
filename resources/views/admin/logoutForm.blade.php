<!-- resources/views/login.blade.php -->
<form method="POST" action="{{ route('admin.logout') }}">
    @csrf



    <input type="submit" class="fadeIn fourth" value="Log out" align="center">
</form>
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
