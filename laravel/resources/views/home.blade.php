<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=h1, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div style ="border: 3px solid black; padding: 10px">
        <h2>Register</h2>
        <form action = "/register" method="POST">  
            @csrf      
            <input name="name" type="text" placeholder="name">
            <input name="email" type="text" placeholder="email">
            <input name="password" type="password" placeholder="password">
            
            <button>Register</button>
            <br>
        </form>
    </div>
</body>
</html>