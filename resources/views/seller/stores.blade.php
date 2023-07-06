@extends('layouts.app')

@section('content')
  <div class="main-stores-container">
    <h1>My Stores</h1>
    <div class="stores-grid">
      @foreach($stores as $store)
        <div class="store-container">
              <img style="cursor: pointer;" onclick="window.location.href='/stores/{{$store->store_id}}'" src="{{asset($store->image)}}" alt="random store img">
              <div class="store-name">{{$store->store_name}}</div>
              <div class="button-container" style="display: flex; flex-direction: column; align-items: center; margin-top: 30px;">
                <button class="dark-square-button" onclick="window.location.href='/my-stores/{{$store->store_id}}/edit'">
                  Edit
                </button><br>
                <button class="light-square-button" onclick="window.location.href='/my-stores/{{$store->store_id}}/products'">
                  View Products
                </button>
              </div>
        </div>
      @endforeach
    </div>
    <div style="display: flex; justify-content: center;">
      <button class="light-square-button" style="margin-top: 50px" onclick="window.location.href='/my-stores/create'">Add a Store</button>
    </div>
  </div>
@endsection