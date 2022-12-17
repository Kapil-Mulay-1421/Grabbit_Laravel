let errors = [];
let showingStores = false;

window.cartItems = [];
window.total;
window.subTotal;
window.appliedCoupon = false;

let xhr = new XMLHttpRequest();
xhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        window.cartItems = JSON.parse(this.responseText)[0]
        window.total = JSON.parse(this.responseText)[1]
        window.subTotal = JSON.parse(this.responseText)[2]
        window.appliedCoupon = JSON.parse(this.responseText)[3]
    }
}

xhr.open('GET', '/cart/json', false);
xhr.send();


let shipping = 0; // For now. Update this according to distance.
window.total = window.total + shipping;

let productIds = [];
cartItems.forEach(cartItem => {
    productIds.push(cartItem['product_id']);
})

let storeNamesLists = []
let storeIdsLists = []
let onlyNames = [] // contains only the names, not the quantity or current list price. Makes easier to loop through.
let storeXhr = new XMLHttpRequest();
storeXhr.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        storeNamesLists = JSON.parse(this.responseText)[1];
        storeIdsLists = JSON.parse(this.responseText)[0];
        if (storeNamesLists.length != cartItems.length) {
            window.location.href = "/cart";
            return;
        }
        Array.from(dropdownContentDivs).forEach((dropdownContentDiv, index) => {
            prepareStores(storeNamesLists, index)
        });
        storeNamesLists.forEach((storeList, index) => {
            onlyNames.push([])
            storeList.forEach(storeArray => {
                onlyNames[index].push(storeArray[0])
            })
        })
    }
}
storeXhr.open("GET", "/stores/sellers", true);
storeXhr.send();

const cartItemsWrapper = document.getElementById('cartItemsWrapper');
cartItemsWrapper.innerHTML = "";
function showCartItems() {
    cartItems.forEach((cartItem, index) => {
        var output = '<div class="cart-item-wrapper">' +
                        '<div class="cart-product" style="display: flex; justify-content: space-between;">'+
                            '<div class="cart-item-info" style="display: flex;">'+
                                '<img src="'+ cartItem['product_image'] +'" alt="" style="border: 1px solid black; width: 100px;">'+
                                '<div class="product-information" style="margin-left: 20px;">'+
                                    '<p style="margin-top:0; margin-bottom:0; margin-right: 30px; font-weight: bold;">'+cartItem['product_name']+'</p>' + '<br>'+
                                    '<div class="dropdown-wrapper">' +
                                        '<div class="store-holder" style="display: none;"><p style="cursor: pointer; user-select: none; margin-top: 0; font-weight: bold; font-size: 14px">demo store</p></div>' +
                                        '<div class="dropdown-content-cart">' +
                                            // stores rendered through another function here
                                        '</div>' +
                                    '</div><br>' +
                                    '<p style="margin:0px;">'+cartItem['current_list_price']+'</p>' + '<br>'+
                                    '<input type="number" onchange="updateItemTotal(event)" name="quantity" value="' + cartItem['quantity'] + '"style="width: 48%; height: 20px;" data-internal-id="'+index+'"> <br>'+
                                '</div>'+
                            '</div>'+
                            '<div class="cart-item-right">'+
                                '<p style="margin: 0px;">' + (cartItem['current_list_price'] * cartItem['quantity']).toFixed(2) + '</p>'+
                                '<form action = "/cart/'+cartItem['id']+'/delete" method="GET">' +
                                    '<button type="submit" style="border: none; background-color: white; cursor: pointer;">⛌</button>' +
                                '</form>'+
                            '</div>'+
                        '</div>'+
                        '<hr>'+
                    '</div>';
        cartItemsWrapper.innerHTML += output;
    });
    cartItemsWrapper.innerHTML += '<ul style="list-style-type: none; padding-inline-start: 0px; line-height: 2.5em;">' +
                                    '<li style="cursor: pointer; user-select: none;">Enter a Promo Code</li>' +
                                    '<li style="cursor: pointer; user-select: none;">' +
                                    '<p style="margin: 0; width: max-content; height: max-content;" onclick="showNote()">Add a Note</p>'+
                                    '<input type="text" id="note" placeholder="Take a note">'
                                    '</li>' +
                                '</ul>';
}

function setTotal() {
    document.getElementById('subtotal-element').innerHTML = window.subTotal.toFixed(2);
    document.getElementById('total-element').innerHTML = window.total.toFixed(2); // Total will be total + shipping. Yet to calculate shipping.
}

function setCouponVisibility() {
    if (appliedCoupon){
        document.getElementById('coupon').parentNode.style.display = 'flex';
    }
}

showCartItems();
setTotal();
setCouponVisibility();


window.updateItemTotal = function(e) {
    let newQuantity = e.target.value;
    if(newQuantity < 1) {
        alert("We only deliver 1 or more products");
        e.target.value = 1;
        newQuantity = e.target.value;
    }
    if(newQuantity % 1 != 0) {
        alert("Please select whole number quantities.");
        e.target.value = (newQuantity*1).toFixed(0);
        newQuantity = e.target.value;
    }
    const index = e.target.getAttribute('data-internal-id')*1;
    const oldItemTotal = cartItems[index]['quantity'] * cartItems[index]['current_list_price'];
    const newItemTotal = newQuantity * cartItems[index]['current_list_price'];
    const difference = newItemTotal - oldItemTotal;
    cartItems[index]['quantity'] = newQuantity;
    prepareStores(storeNamesLists, index);
    const correspondingItemTotal = e.target.parentNode.parentNode.parentNode.childNodes[1].childNodes[0];
    correspondingItemTotal.innerHTML = (newItemTotal).toFixed(2);

    appliedCoupon ? total += difference*80/100 : total += difference;
    window.subTotal = window.subTotal + difference;
    setTotal();
}

const dropdownContentDivs = document.getElementsByClassName('dropdown-content-cart');

function prepareStores(storeNamesLists, index) {
    console.log(storeNamesLists);
    let passedStoreIds = []
    dropdownContentDivs[index].innerHTML = '';
    storeNamesLists[index].forEach(storeArray => {
        if (storeArray[1] >= cartItems[index]['quantity']) {
        // 0th element of storeArray is store name. 1st is available quantity.
        dropdownContentDivs[index].innerHTML += '<a href="" onclick="setStore(event)" data-internal-store-id="'+storeArray[3]+'" data-internal-id="'+index+'" id='+index+'>'+storeArray[0]+'</a>';
        passedStoreIds.push(storeArray[3]) // pushing the id of the added store
        }
    });

    if (Array.from(dropdownContentDivs[index].children).length == 0) {
        dropdownContentDivs[index].parentNode.parentNode.parentNode.parentNode.style.backgroundColor = '#ffc9c9'
        console.log(errors)
        if (! errors.includes([index, "No store currently has the set quantity of this product available."])){ // fix this, the if statement has no effect.
            errors.push([index, "No store currently has the set quantity of this product available."]);
        }
        alert("No store currently has the set quantity of this product available.")
        return;
    } else {
        dropdownContentDivs[index].parentNode.parentNode.parentNode.parentNode.style.backgroundColor = 'white'
        errors = errors.filter(errorObj => errorObj[0] != index || errorObj[1] != "No store currently has the set quantity of this product available.")
    }

    if (! passedStoreIds.includes(cartItems[index]['store_id']*1)) {
        dropdownContentDivs[index].parentNode.parentNode.parentNode.parentNode.style.backgroundColor = '#ffc9c9'
        // same for this one.
        if (! errors.includes([index, "The selected store does not seem to have the required quantity of the highlighted product. You can either order from a different store, or wait until the store stocks up on the item. We regret any inconvenience."])){
            errors.push([index, "The selected store does not seem to have the required quantity of the highlighted product. You can either order from a different store, or wait until the store stocks up on the item. We regret any inconvenience."])
        }
        alert("The selected store does not seem to have the required quantity of the highlighted product. You can either order from a different store, or wait until the store stocks up on the item. We regret any inconvenience.")
        return;
    } else {
        dropdownContentDivs[index].parentNode.parentNode.parentNode.parentNode.style.backgroundColor = 'white'
        errors = errors.filter(errorObj => errorObj[0] != index || errorObj[1] != "The selected store does not seem to have the required quantity of the highlighted product. You can either order from a different store, or wait until the store stocks up on the item. We regret any inconvenience.")
    }
}

window.setStore = function(e) {
    e.preventDefault();
    console.log(cartItems)
    let index = e.target.getAttribute('data-internal-id');
    const quantity = cartItems[index]['quantity']
    const oldPrice = cartItems[index]['current_list_price']*1;
    const oldItemTotal = oldPrice * quantity;

    const store = e.target.parentNode.previousSibling;
    cartItems[index]['store_id'] = storeIdsLists[index][onlyNames[index].indexOf(e.target.innerHTML)].toString(); // just gets the storeId of the selected store.
    cartItems[index]['current_list_price'] = storeNamesLists[index][storeIdsLists[index].indexOf(e.target.getAttribute('data-internal-store-id')*1)][2].toString(); // current list price.

    const newPrice = cartItems[index]['current_list_price']*1;
    const newItemTotal = newPrice * quantity;
    const difference = newItemTotal - oldItemTotal;

    store.innerHTML = '<p style="cursor: pointer; user-select: none; margin-top: 0; font-weight: bold; font-size: 14px">'+e.target.innerHTML+'</p>'; 
    e.target.parentNode.parentNode.nextSibling.nextSibling.innerHTML = cartItems[index]['current_list_price']
    e.target.parentNode.parentNode.parentNode.parentNode.nextSibling.children[0].innerHTML = (cartItems[index]['current_list_price']*1*cartItems[index]['quantity']).toFixed(2)
    e.target.parentNode.parentNode.parentNode.parentNode.parentNode.style.backgroundColor = 'white'
    appliedCoupon ? total += difference*80/100 : total += difference;
    window.subTotal += difference;
    setTotal();
    errors = errors.filter(errorObj => errorObj[0] != [index]*1 || errorObj[1] != "The selected store does not seem to have the required quantity of the highlighted product. You can either order from a different store, or wait until the store stocks up on the item. We regret any inconvenience.")
    console.log(cartItems)
}

function removeItem(e) {
    let response = ''
    const index = e.target.getAttribute('data-delete-button-id')*1;
    const itemTotal = cartItems[index]['current_list_price'] * cartItems[index]['quantity'];
    const id = cartItems[index]['id']
    cartItems.splice(index, 1);
    cartItemsWrapper.innerHTML = "";
    showCartItems();
    request = new XMLHttpRequest();
    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            appliedCoupon ? total -= itemTotal*80/100 : total -= itemTotal;
            subTotal -= itemTotal;
            setTotal();
        }
    }
    request.open("POST", "includes/deleteCartItem.php", false);
    request.send(JSON.stringify(id));
}

window.showStores = function() {
    if (! showingStores) {
        const storeHolders = document.getElementsByClassName("store-holder")
        Array.from(storeHolders).forEach((storeHolder, index) => {
            let storeIndex = storeIdsLists[index].indexOf(cartItems[index]['store_id']*1);
            console.log(storeHolder.children)
            storeHolder.children[0].innerHTML = storeNamesLists[index][storeIndex][0];
            storeHolder.style.display = 'block';
            showingStores = true;
        })
    } else {
        const storeHolders = document.getElementsByClassName("store-holder")
        Array.from(storeHolders).forEach((storeHolder, index) => {
            storeHolder.style.display = 'none';
            showingStores = false;
        })
    }
}

window.showNote = function() {
    const noteInput = document.getElementById('note');
    noteInput.style.display != 'block' ? noteInput.style.display = 'block' : noteInput.style.display = 'none';
}

window.checkout = function() {
    if (errors.length != 0) {
        for (let i = 0; i < errors.length; i++) {
            alert(cartItems[errors[i][0]]['product_name'] + ": " + errors[i][1])
            break;
        }
        return;
    } else {

        // variable initialization:
        let note = '';

        // setting the variables:
        note = document.getElementById('note').value;

        // setting form data (because apparently it isn't possible to send post data through window.location.href):
        document.getElementById('cartItemsInput').value = JSON.stringify(cartItems);
        document.getElementById('orderNoteInput').value = note;
        document.getElementById('checkoutForm').submit();

    }
}