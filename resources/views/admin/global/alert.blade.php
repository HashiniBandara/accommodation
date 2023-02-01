<?php
$status = session()->get('status');
$message = session()->get('message');
?>

@if ($status && $message)
    <div class="alert alert-success">{{ $message }}</div>
@elseif (!$status && $message)
    <div class="alert alert-danger">{{$message}}</div>
@elseif ($errors->any())
    <div class="alert alert-danger">Validation error occured.</div>
@endif
