@extends('layouts.profile')
@section('substance')
    <h2>My Addresses</h2>
    <p>Add and manage the addresses you use often.</p>
    <hr>
    <div class="addresses-grid" id="addressGrid">
        @foreach($allAddresses as $address)
            <div class="address-container">
                <h3>Address {{$loop->index +1}}</h3>
                @if ($address->address_id == $activeAddress->address_id) 
                    <h4 style="margin: 0;">(Active)</h4>
                @else
                    {!! Form::open(['action' => ['App\Http\Controllers\CustomerAddressController@setActive', $address->address_id], 'method' => 'put'])!!}
                    <div class="shop-now-dark" style="display: flex; justify-content: space-around; width: 100%;">
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::submit('Activate', ['style' => 'padding:8px 2.4em'])}}
                    </div>
                    {!! Form::close() !!}
                @endif
                <p style='margin: 20px;'>{{$address->address}}, {{$address->city}}, {{$address->state}}, {{$address->country}}</p>
                <div class="shop-now-dark" style="display: flex; justify-content: space-around; width: 100%;">
                    <button style="padding:8px 2.4em" onclick="handleEditAddress(address['address_id']+')">Edit</button>
                    @if($address->address_id != $activeAddress->address_id)
                        <button style="padding:8px 2.4em" onclick="handleDeleteAddress(address->address_id)">Delete</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div style="display: flex; justify-content: center;">
        <button class="light-square-button" style="margin-top: 50px" onclick="handleAddAddress()">Add an Address</button>
    </div>
@endsection