<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>resetpassword</title>
</head>
<body>
    <form action="" method="post">
        @csrf
        <form action="" method="post">
            @csrf
            @if ($errors->any())
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            
        
            
        </ul>
            @endif
        <input type="hidden" name="id" value="{{$user->id}}">
        <label for="">Enter new password</label>

        <input type="password" name="password">
        <label for="">Enter conformed</label>

        <input type="password" name="password_confirmation">
        <input type="submit"  value="Change Password">
    </form>
    
</body>
</html>