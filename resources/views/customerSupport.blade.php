@extends('layouts.app')
@section('content')

<div class="container" style="display: flex; flex-direction: column; align-items: center;">
    <div class="strip" style="width: 80%; display: flex; flex-direction: column; align-items: center;">
            <h1 style="font-size: 72px; width: max-content; margin-bottom: 15px; color: #281A39;">Customer Support</h1>
        <p style="text-align: center; width: 55%; margin-bottom: 65px; font-size: 15px;">At Grabbit India, we are passionate about providing the best possible experience for our customers. Our team is dedicated to delivering exceptional customer service and building long-lasting relationships with our customers.</p>
        <div class="big-box-1">
            <img src="images/customerSupport.jpg" alt="Customer support image here" style="border: 1px solid black; width: 100%;">
            <div class="form-container" style="display: flex; flex-direction: column; align-items: center;">
                <h2 style="font-size: 33px; color: #281A39; margin-top: 50px;">We're here to help!</h2>
                <h3 style="width: 90%; color: #281A39;">Fill out the form with any query on your mind and we'll get back to you as soon as possible</h3>
                <form action="/queries" style="width: 90%; margin-bottom: 35px;" method="POST">
                    @csrf
                    <div class="user-data-form-container">
                        <div class="user-data-input-field">
                            <div>
                                <label for="">First Name</label><br>
                                <input type="text" name="firstname">
                            </div>
                        </div>
                        <div class="user-data-input-field">
                            <div>
                                <label for="">Last Name</label><br>
                                <input type="text" name="lastname">
                            </div>
                        </div>
                        <div  class="user-data-input-field">
                            <div>
                                <label for="">Email*</label><br>
                                <input type="text" name="email" required>
                            </div>
                        </div>
                        <div  class="user-data-input-field">
                            <div>
                                <label for="">Phone</label><br>
                                <input type="text" name="phone">
                            </div>
                        </div>
                    </div>
                    <label for="">Leave a message</label>
                    <textarea name="message" id="messagearea" cols="30" rows="10" style="width: 93.5%; margin-bottom: 20px;" required></textarea>
                    <button type="submit" class="light-square-button" style="margin-right: 10px;">Submit</button>
                </form>
                <div class="chatbox" style="margin-left: 2px; background-color: lightgray; width: 92.5%; height: 262px; padding: 20px;">
                    <h3 style="color: #281A39;">Chat with Our Support Team</h3>
                    <p>We love hearing from our customers and always welcome feedback and suggestions to help us improve our business.</p>
                    <button type="submit" class="dark-square-button" style="margin-right: 10px;" onclick="{document.getElementById('messagearea').focus()}">Message Us</button>
                </div>
            </div>
        </div>

        <div class="locations" style="margin-bottom: 100px;" id="locations">
            <h2 style="font-size: 33px; color: #281A39;">
                We deliver in these locations</h2>
            <p>We're sorry if your area isn't in here. But don't worry, we will soon expand to more areas.</p>
            <div class="locations-grid">
                <div class="location" style="display: flex; flex-direction: column; align-items: center;">
                    <img src="images/Icons/location.png" alt="" style="width: 40px">
                    <h4 style="margin-bottom: 5px;">Baner</h4>
                    <p style="text-align: center;">Pune<br>
                    Maharashtra, IN<br></p>
                </div>
                <div class="location" style="display: flex; flex-direction: column; align-items: center;">
                    <img src="images/Icons/location.png" alt="" style="width: 40px">
                    <h4 style="margin-bottom: 5px;">Pashan</h4>
                    <p style="text-align: center;">Pune<br>
                    Maharashtra, IN<br></p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection