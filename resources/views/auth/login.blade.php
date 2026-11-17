<h1>Login here</h1>
@error('email')
    <p>{{ $message }}</p>
@enderror

<form method="POST" action="{{route('login.store')}}">
    <label>Email: <input type="email" name="email">
    <label>Password: <input type="password" name="password">
    <input type="submit" name="submit">
</form>