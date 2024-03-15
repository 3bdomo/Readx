<div class="wrapper fadeInDown">
    <div id="formContent">
        <!-- Tabs Titles -->
        <h2 class="active"> Sign In </h2>


        <!-- Icon -->
        <div class="fadeIn first">
            <img src="{{ asset('/logo.png') }}" id="icon" alt="User Icon"  />        </div>

        <!-- Login Form -->
        <form method="post" action="{{route('admin.login')}}">

            @csrf
            <input type="text" name="username" class="fadeIn second"  placeholder="user name">
            @error('username')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror

            <input type="password" name="password" class="fadeIn third" placeholder="password">
            @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="submit" class="fadeIn fourth" value="Log In">
        </form>



    </div>
</div>

<link href="{{ asset('css/style.css') }}" rel="stylesheet">
