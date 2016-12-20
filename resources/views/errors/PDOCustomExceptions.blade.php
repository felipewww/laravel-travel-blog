<!DOCTYPE html>
<html>
<head>
    <title>QueryException</title>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">{{ $message }}</div>
        <div onclick="window.history.back();">VOLTAR</div>
        <div class="dd_exception" style="display: none;"><?php dd($exception) ?></div>
    </div>
</div>
</body>
</html>
<?php
/**
 * Created by PhpStorm.
 * User: felipe
 * Date: 19/12/16
 * Time: 10:40
 */