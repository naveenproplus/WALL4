@extends('layouts.email')
@section('content')
<style>
    .full-right{
        float:right;
    }
</style>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <table>
        <tr>
            <td><b>Name</b></td>
            <td></td>
        </tr>
        <tr>
            <td><b>E-Mail</b></td>
            <td></td>
        </tr>
        <tr>
            <td><b>Mobile Number</b></td>
            <td></td>
        </tr>
        <tr>
            <td><b>Subject</b></td>
            <td></td>
        </tr>
        <tr>
            <td><b>Message</b></td>
            <td></td>
        </tr>
    </table>
@endsection
