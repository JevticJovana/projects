function addToCart(product_id) {
    $.ajax({
        url: "../controllers/CartController.php",
        type: "POST",
        data: {
            'product_id': product_id,
            'add_to_cart': 1
        },
        success: function (response) {
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>${responseData.message}</strong> 
                            </div>`
            $("#alertPlaceholder").append(element)
            $("#cartCount").html(responseData.response)

        },
        error: function (response){
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>${responseData.message}</strong> 
                            </div>`
            $("#alertPlaceholder").append(element)
        }
    })
}
function setActive(){
    let img = $(event.target).attr("src");
    console.log(img);
    $("#mainImage").attr("src",img);
}
