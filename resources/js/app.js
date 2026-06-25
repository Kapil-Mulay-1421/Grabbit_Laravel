/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createApp } from 'vue';

/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

const app = createApp({});

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');


// Sticky header: 

var sticky = {
    sticky_after: 200,
    previousScroll: 999999999,
    init: function() {
      this.header = document.getElementsByTagName("header")[0];
      this.clone = this.header.cloneNode(true);
      this.clone.classList.add("clone");
      this.header.insertBefore(this.clone, null);
      this.scroll();
      this.events();
    },
  
    scroll: function() {
      if(window.scrollY > this.sticky_after && window.scrollY < this.previousScroll) {
        document.body.classList.add("down");
        this.previousScroll = window.scrollY;
      }
      else {
        document.body.classList.remove("down");
        this.previousScroll = window.scrollY;
      }
    },
  
    events: function() {
      window.addEventListener("scroll", this.scroll.bind(this));
    }
  };
  
  document.addEventListener("DOMContentLoaded", sticky.init.bind(sticky));

  
var hamburgerMenuLinks = document.getElementById("hamburgerMenuLinks");
var hamburger = document.getElementById("hamburger")
window.toggleHamburgerMenu = function() {
    

    if (hamburgerMenuLinks.style.display === "flex") {
        hamburgerMenuLinks.style.display = "none";
    } else {
        hamburgerMenuLinks.style.display = "flex";
        hamburgerMenuLinks.style.flexDirection = "column";
        document.body.addEventListener("click", function(event){
            if(!hamburgerMenuLinks.contains(event.target)) {
                if(!hamburger.contains(event.target)) {
                    hamburgerMenuLinks.style.display = "none";
                }
                
            }
        })
    }
}

let cartItems = []
let cartShowing = false

function showCart() {
    document.getElementById('cartItemsWrapper').innerHTML = "";
    cartItems.forEach((cartItem, index) => {
                let output = '<div class="cart-item-wrapper">' +
                                '<div class="cart-product" style="display: flex; justify-content: space-between;">'+
                                    '<div class="cart-item-info" style="display: flex;">'+
                                        '<img src="'+ cartItem['product_image'] +'" alt="" style="border: 1px solid black; width: 100px;">'+
                                        '<div class="product-information" style="margin-left: 20px;">'+
                                            '<p style="margin-top:0; margin-bottom:0; margin-right: 30px; font-weight: bold;">'+cartItem['product_name']+'</p>' + '<br>'+
                                            cartItem['current_list_price'] + 
                                            '<p style="font-size: 12px;">QTY: ' + cartItem['quantity'] + '</p>'+ '<br><br>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                                '<hr>'+
                            '</div>';
                            document.getElementById('cartItemsWrapper').innerHTML += output;
            })
}

window.triggerCart = function() {
    if(! cartShowing) {
        let slideCartXhr = new XMLHttpRequest();
        slideCartXhr.open("GET", "/cart/json")
        slideCartXhr.send();
        slideCartXhr.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {
                cartItems = JSON.parse(this.responseText)[0];
                showCart()
                document.getElementById('shadowLayer').classList.add('is-visible')
                document.getElementById('slidingCart').classList.add('slide-in')
                cartShowing = true
            } else if(this.readyState == 4 && this.status == 401) {
                window.location.href = "/login"
            }
        }
    } else {
        document.getElementById('slidingCart').classList.remove('slide-in')
        document.getElementById('shadowLayer').classList.remove('is-visible')
        cartShowing = false
    }
}

window.addToCart = function(e) {
  e.preventDefault();

    let inputQ = e.target.previousElementSibling.value;
    
    if (inputQ < 0) {
        e.target.previousElementSibling.value = 1;
        alert("Sorry, we do not deliver negative products.")
        return;
    } 

    if (inputQ < 1) {
        e.target.previousElementSibling.value = 1;
        alert("Sorry, we do not deliver less than one product.")
        return;
    } 

    if (inputQ > 255) {
        e.target.previousElementSibling.value = 255;
        alert("Max limit on the product was exceeded.")
        return;
    }

    if(inputQ % 1 != 0) {
        e.target.previousElementSibling.value = (inputQ*1).toFixed(0);
        alert("Please select whole number quantities.");
        return;
    }

    const productId = e.target.parentNode.elements['productId'].value;
    const storeId = e.target.parentNode.elements['storeId'].value;
    const quantity = e.target.previousElementSibling.value;

    let params = new FormData(e.target.parentNode);

    let data = {
        "productId": productId, 
        "storeId": storeId, 
        "quantity": quantity
    };

    const httprequest = new XMLHttpRequest();
    httprequest.onreadystatechange = function() {
        if (this.readyState == 4) {
            if (this.responseURL && new URL(this.responseURL).pathname === '/login') {
                window.location.href = "/login";
            } else if (this.status == 200) {
                triggerCart();
            }
        }
    };
    httprequest.open("POST", "/cart", false);
    httprequest.send(params);
}