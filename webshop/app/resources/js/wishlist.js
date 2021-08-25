function addToWishlist(product_id) {
    $.ajax({
        url: "../controllers/WishlistController.php",
        type: "POST",
        data: {
            'product_id': product_id,
            'add_to_wishlist': 1
        },
        success: function (response) {
            console.log(response);
            let responseData = JSON.parse(response);
            let aclass = (responseData.status == 200) ? "success" : "danger";
            let element = `<div class="alert alert-${aclass} alert-dismissible text-center fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                    <strong>${responseData.message}</strong>
                </div>`
            $("#alertPlaceholder").append(element);
        },
        error: function(response){
            console.log(response);

            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-danger alert-dismissible text-center fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                    <strong>${responseData.message}</strong>
                </div>`
            $("#alertPlaceholder").append(element);
        }
    })
}

function removeFromWishlist(product_id) {
    $.ajax({
        url: "../controllers/WishlistController.php",
        type : "POST",
        data:{
            'product_id' : product_id,
            'remove_from_wishlist' : 1
        },
        success: function (response) {
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                    <strong>${responseData.message}</strong>
                </div>`
            $("#alertPlaceholder").append(element);
        },
        error: function(response){
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
                    <strong>${responseData.message}</strong>
                </div>`
            $("#alertPlaceholder").append(element);
        }
    })
}