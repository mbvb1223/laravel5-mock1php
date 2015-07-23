@extends('layouts.front.master')

@section('content')
<div class="container">
    <div class="col-md-12 col-sm-12">
        <h1>Contact</h1>
        <div class="content-page">
            <iframe width="100%" height="400" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=SmartOSC%2C%20%C4%90%E1%BB%99i%20C%E1%BA%A5n%2C%20H%C3%A0%20Noi%2C%20H%C3%A0%20N%E1%BB%99i%2C%20Vi%E1%BB%87t%20Nam&key=AIzaSyDTrcNX7lqBN-ekEeiKXNjxyCdei0jIiJE" allowfullscreen></iframe>

            <h2>Contact Form</h2>
            <p>Lorem ipsum dolor sit amet, Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat consectetuer adipiscing elit, sed diam nonummy nibh euismod tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>

            <!-- BEGIN FORM-->
            <form action="#" class="default-form" role="form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name">
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="require">*</span></label>
                    <input type="text" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea class="form-control" rows="8" id="message"></textarea>
                </div>
                <div class="padding-top-20">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
            <!-- END FORM-->
        </div>
    </div>
</div>

@stop