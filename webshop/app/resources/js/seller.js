$(document).ready(function () {
    $.ajax({
        url: "../controllers/CategoryController.php",
        type: "GET",
        data: {
            'get_categories': 1
        },
        success: function (response) {
            let categories = JSON.parse(response).response
            console.log(categories)
            categories.forEach(category => {
                console.log(category)
                let element = `<option value = ${category.id}>${category.title}</option>`
                $("#category").append(element);
            });
        },
        error: function (response) {
            console.log(response)
        }
    })
})
$("#addImage").click(function () {
    let inputs = $(".image-input")
    console.log(inputs.length)
    if (inputs.length >= 5) {
        alert("Dozvoljeno je maksimalno 5 slika po proizvodu")
        return;
    }
    let inputIndex = inputs.length + 1
    console.log(inputIndex)
    let element = `
        <div class = "image-input m-1">
        <input onchange = "changeFileLabel()" id = "image-input-${inputIndex}" class="d-none finput" required="required" type="file" name="product_images[]" id="productImage" accept="image/png, image/gif, image/jpeg, image/webp" aria-describedby="inputGroupFileAddon01">
                            <label class="neumorphic-file-label" for="image-input-${inputIndex}">Odaberi sliku</label>
        </div>
                            `
    $("#imageInputs").append(element)
})

function prepareDelete(product_id) {
    $("#delete_id").val(product_id)
}

function confirmDelete() {
    let deleteID = $("#delete_id").val()

    $.ajax({
        url: "../controllers/ProductController.php",
        type: "POST",
        data: {
            'product_id': deleteID,
            'delete_product': 1
        },
        success: function (response) {
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${responseData.message}</strong>.
            </div>`
            $("#alertPlaceholder").append(element)
            setTimeout(() => {
                location.reload();
            }, 2500);
        },
        error: function (response) {
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${responseData.message}</strong>.
            </div>`
            $("#alertPlaceholder").append(element)
            setTimeout(() => {
                location.reload();
            }, 2500);
        }
    })
}

function changeFileLabel() {
    console.log(event.target.id)
    let label = $("label[for='" + event.target.id + "'")
    $(label).text($(event.target).val().replace(/C:\\fakepath\\/i, ''))
}

function getProductDetails(product_id) {
    $.ajax({
        url: "../controllers/ProductController.php",
        dataType: "json",
        type: "POST",
        data: {
            "product_id": product_id,
            "find_product": 1
        },
        success: function (response) {
            let product = response.response;
            console.log(product)
            $("#edit_product_id").val(product.id);
            $("#edit_product_name").val(product.product_name);
            $("#edit_category").val(product.category_id).change();
            $("#edit_product_stock").val(product.stock)
            $("#edit_product_price").val(product.price)
            $("#edit_description").val(product.product_description)

        },
        error: function (response) {
            let element = `<div class="alert alert-primary alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${response.response}</strong>
            </div>`
            $("#alertPlaceholder").append(element)

        }
    })
}

function editSubmit() {
    let product_id = $("#edit_product_id").val();
    let product_name = $("#edit_product_name").val();
    let product_category = $("#edit_category").val();
    let product_stock = $("#edit_product_stock").val()
    let product_price = $("#edit_product_price").val()
    let description = $("#edit_description").val();
    $.ajax({
        url: "../controllers/ProductController.php",
        type: "POST",
        dataType: "json",
        data: {
            "id": product_id,
            "product_name": product_name,
            "category_id": product_category,
            "stock": product_stock,
            "price": product_price,
            "product_description": description,
            "edit_product": 1
        },
        success: function (response) {
            let product = response.response;
            let element = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${response.message}</strong>
            </div>`
            $("#alertPlaceholder").append(element)
            setTimeout(() => {
                location.reload()
            }, 1000);

        },
        error: function (response) {
            console.log(response)
            let element = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${response.message}</strong>
            </div>`
            $("#alertPlaceholder").append(element)

        }
    })
}

function display(id) {
    $("#" + id).slideToggle();
}

function showDetails(ref_no) {
    if (event.target.tagName == "DIV") {
        $(event.target).find("i").toggleClass("fa-sort-down")
        $(event.target).find("i").toggleClass("fa-sort-up")
    }
    $("#" + ref_no).slideToggle();
}

function displayReviews() {
    let trigger = $(event.target);
    let parent = $(trigger).parent().parent().parent().parent();
    $(parent).find(".product-reviews").slideToggle();
}

function cancelOrder(ref_no) {
    $.ajax({
        url: "../controllers/CheckoutController.php",
        type: "POST",
        data: {
            'ref_no': ref_no,
            'disable_order': 1
        },
        success: function (response) {
            console.log(response);
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-success text-alert alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${responseData.message}</strong>
            </div>`
            $("#alertPlaceholder").append(element)
            setTimeout(() => {
                location.reload();
            }, 2500);
        },
        error: function (response) {
            console.log(response);

            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${responseData.message}</strong>
            </div>`
            $("#alertPlaceholder").append(element)
            setTimeout(() => {
                location.reload();
            }, 2500);
        }
    })
}
function processOrder(ref_no){
$.ajax({
        url: "../controllers/CheckoutController.php",
        type: "POST",
        data: {
            'ref_no': ref_no,
            'allow_order': 1
        },
        success: function (response) {
            console.log(response);
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-success text-alert alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${responseData.message}</strong>
            </div>`
            $("#alertPlaceholder").append(element)
            setTimeout(() => {
                location.reload();
            }, 2500);
        },
        error: function (response) {
            console.log(response);

            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                <strong>${responseData.message}</strong>
            </div>`
            $("#alertPlaceholder").append(element)
            setTimeout(() => {
                location.reload();
            }, 2500);
        }
    })
}