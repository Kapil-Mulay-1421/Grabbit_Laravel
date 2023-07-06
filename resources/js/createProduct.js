window.product;

window.prefill = function(id) {
    let xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            window.product = JSON.parse(this.responseText)
        }
    }
    
    xhr.open('GET', '/products/'+id+'/json', false);
    xhr.send();

    if(window.product != null) {
        let form = document.forms.namedItem("productInfoForm");

        let nameInput = form.name;
        nameInput.value = window.product.product_name;
        nameInput.disabled = true;

        let descriptionInput = form.description;
        console.log(form.elements)
        descriptionInput.value = window.product.description;
        descriptionInput.disabled = true;

        form.productId.value = window.product.product_id;

        form.category.value = document.getElementById(window.product.category_id).value;
        form.category.disabled = true;

        form.image.disabled = true;

        document.getElementById('image-input-prompt').innerHTML = window.product.product_name+" Image";
    }
}

