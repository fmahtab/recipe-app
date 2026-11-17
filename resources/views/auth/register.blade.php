<h1>Create account</h1>

@error('name')
    <p>{{ $message }}</p>
@enderror
@error('email')
    <p>{{ $message }}</p>
@enderror
@error('password')
    <p>{{ $message }}</p>
@enderror

<form method="POST" action="{{route('register.store')}}">
    @csrf

    <p><label>Name<br><input name="name" type="text"></label></p>
    <p><label>Email<br><input name="email" type="email"></label></p>
    <p><label>Password<br><input name="password" type="password"></label></p>
    <p><label>Re-enter Password<br><input name="password_confirmation" type="password"></label></p>
    <input type="submit" name="submit">

 
</form>