<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login Page</title>
<style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: Arial, sans-serif;
    }
    .container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }
    form {
        background-color: #f2f2f2;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }
    label {
        margin-bottom: 10px;
        display: block;
        font-weight: bold;
    }
    

</style>
</head>
<body>

<div class="container">
    <form>
        <h1>Login</h1>
        <label>Username: </label>
        <input type="text" placeholder="Enter Username" name="username" required>
        <label>Password: </label>
        <input type="password" placeholder="Enter Password" name="password" required>
        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
