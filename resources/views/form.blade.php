<!-- input name, description, image -->
@extends('layout')
@section('title', 'Add Product')
@section('content')
<form action="" method="post">
    <label for="">
        name
    </label>
    <input type="text" name="name" id="name" >
    <label for="">description</label>
    <input type="text" name="description" id="description">
    <label for="">image</label>
    <input type="file" name="image" id="image">
</form>
