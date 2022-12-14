@extends('layouts.app')
@section('content')

<div class="container" style="display: flex; flex-direction: column; align-items: center;">
    <div class="strip" style="width: 80%; display: flex; flex-direction: column; align-items: center;">
            <h1 style="font-size: 72px; width: max-content; margin-bottom: 15px; color: #281A39;">Manage Addresses</h1>
                <h4 style="width: 90%; color: #281A39; text-align: center; margin-block: 40px;">Add an address, so we can recommend to you the best products from your area.</h3>
                <form action="/profile/addresses" style="width: 90%; margin-bottom: 35px;" method="POST" name="addressForm">
                    @csrf
                    <div class="user-data-form-container">
                        <div class="user-data-input-field">
                            <div>
                                <label for="">Address</label><br>
                                <input type="text" name="address" required>
                            </div>
                        </div>
                        <div class="user-data-input-field">
                            <div>
                                <label for="">City</label><br>
                                <input type="text" name="city" required>
                            </div>
                        </div>
                        <div  class="user-data-input-field">
                            <div>
                                <label for="">State</label><br>
                                <input type="text" name="state" required>
                            </div>
                        </div>
                        <div  class="user-data-input-field">
                            <div>
                                <label for="">Country</label><br>
                                <input type="text" name="country" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="light-square-button" style="margin-right: 10px;">Submit</button>
                </form>

            </div>

    </div>
</div>

@endsection