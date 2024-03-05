<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


<h2>User</h2>
<p>Create User</p>
<form action="/user/create" method="post">
    <input type="text" name="name">
    <input type="submit">
</form>

<p>Delete User with id:</p>
<form action="/user/delete" method="post">
    <input type="text" name="id">
    <input type="submit">
</form>

