<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=h1, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    @auth
    <p>Congrats!! You are Loggedin</p>
    <form action="/logout" method="post">
        @csrf
        <button>Log Out</button>
    </form>
    <div style ="border: 3px solid black; padding: 10px">
        <h2>Create a new post</h2>
        <form action="/create-post" method="post">
            @csrf
            <input type="text" name="title" id="" placeholder="post title">
            <textarea name="body" placeholder="body content..."></textarea>
            <button>Save Post</button>
        </form>
    </div>
    <div style ="border: 3px solid black; padding: 10px">
        <h2>All Posts</h2>
        @foreach ($posts as $post)
        <div style="background-color: gray">
            <h3>{{$post['title']}} by {{$post->user->name}}</h3> 
            <h3>{{$post['body']}}</h3>
            <p><a href="/edit-post/{{$post->id}}">Edit</a></p>
            <form action="/delete-post/{{$post->id}}" method="post">
                @csrf
                @method('DELETE')
                <button>Delete</button>           
            </form>
        </div>
            
        @endforeach
        
    </div>
 
    @else
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

    <div style ="border: 3px solid black; padding: 10px">
        <h2>Log In</h2>
        <form action = "/login" method="POST">  
            @csrf      
            <input name="loginname" type="text" placeholder="name">
            <input name="loginpassword" type="password" placeholder="password">            
            <button>Login</button>
            <br>
        </form>
    </div>
        
    @endauth
    
</body>
</html>