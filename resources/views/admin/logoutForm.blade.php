<!-- resources/views/login.blade.php -->
<form method="POST" action="{{ route('admin.logout') }}">
    @csrf
<div class="wrapper fadeInDown" >
    <input type="submit" class="fadeIn fourth" value="Log out" >
</div>
</form>

<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<style>
    body {
        background-color: #a8f8f8;
        margin: 0;
        padding: 0;
        font-family: sans-serif;
    }
    .wrapper {
        text-align: center;
    }
    .wrapper input[type="submit"] {
        background: #07bdce;
        color: #100f0f;
        border: 1px solid #ccc;
        padding: 8px 10px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
    }
</style>
