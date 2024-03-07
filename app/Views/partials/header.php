<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IPA Serhat Capan</title>
    <link rel="stylesheet" href="<?= base_url() ?>/less/style.css"/>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- UIkit -->
    <script src="<?= base_url() ?>/js/uikit.min.js"></script>
    <script src="<?= base_url() ?>/js/uikit-icons.min.js"></script>
</head>
<body>



<!-- forms to test the CRUD functions before design -->
<h2>Costcenter</h2>
<p>Create costcenter</p>
<form action="/costcenter/create" method="post">
    <input type="text" name="name">
    <input type="submit">
</form>

<p>Read Costcenter</p>
<?php
$from_date = '2024-03-04';
$to_date = '2024-03-05';
?>
<p>http://ipa.local/costcenter/read?id=2&from_date=<?= $from_date ?>&to_date<?= $to_date ?></p>

<p>Update costcenter</p>
<form action="/costcenter/update" method="post">
    <input type="text" name="name">
    <input type="submit">
</form>

<p>Delete User with id:</p>
<form action="/costcenter/delete" method="post">
    <input type="text" name="id">
    <input type="submit">
</form>


<br>
<br>


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

