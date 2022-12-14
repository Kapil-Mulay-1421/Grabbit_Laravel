@extends('layouts.profile')
@section('substance')

<h2 style="font-weight:100;">My Account</h2>
<p style="font-size:14px;">View and edit your personal info below.</p>
<hr>
<br>
<p style="font-size: 20px;">Account</p>
<p style="font-size:14px;">Update & Edit the information you share with the community</p>
<p style="font-size:14px; margin-top: 40px;">Login Email:<br>
kapilmulay06@gmail.com<br>
Your Login email can't be changed</p>
<br><br>
<form action="/profile/account/edit" method="POST">
    @csrf
    <div class="user-data-form-container">
        <div class="user-data-input-field">
            <div>
                <label for="">First Name</label><br>
                <input type="text" name="firstname" value="{{$customer->first_name}}">
            </div>
        </div>
        <div class="user-data-input-field">
            <div>
                <label for="">Last Name</label><br>
                <input type="text" name="lastname" value="{{$customer->last_name}}">
            </div>
        </div>
        <div  class="user-data-input-field">
            <div>
                <label for="">Email</label><br>
                <input type="text" name="email" value="{{$customer->email}}" readonly>
            </div>
        </div>
        <div  class="user-data-input-field">
            <div>
                <label for="">Phone</label><br>
                <input type="text" name="phone" value="{{$customer->phone}}">
            </div>
        </div>
    </div>
    <div style="display: flex; justify-content: flex-end;">
        <button class="light-square-button" style="margin-left: 10px;">Update Info</button>
    </div>
</form>

@endsection