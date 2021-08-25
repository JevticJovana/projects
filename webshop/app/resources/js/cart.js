function removeFromCart(product_id){
    $.ajax({
        url:"../controllers/CartController.php",
        type:"POST",
        data:{
            "product_id":product_id,
            'remove_from_cart': 1
        },
        success:function(response){
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>${responseData.message}</strong> 
                            </div>`
            $("#alertPlaceholder").append(element)
            $("#cartCount").html(responseData.response);
            setTimeout(location.reload(), 2500);
        },
        error:function(response){
            let responseData = JSON.parse(response);
           let element = `<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>${responseData.message}</strong> 
                            </div>`
            $("#alertPlaceholder").append(element)
            $("#cartCount").html(responseData.response);
            setTimeout(location.reload(), 2500);
        }
    })
}
function emptyCart(){
    $.ajax({
        url:"../controllers/CartController.php",
        type:"POST",
        data:{
            'empty_cart': 1
        },
        success:function(response){
            let responseData = JSON.parse(response);
            let element = `<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>${responseData.message}</strong> 
                            </div>`
            $("#alertPlaceholder").append(element)
            $("#cartCount").html(0);
            $(".cart-items").empty()
            setTimeout(() => {
                location.reload();
            }, 2500);
        },
        error:function(response){
            let responseData = JSON.parse(response);
           let element = `<div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                                <strong>${responseData.message}</strong> 
                            </div>`
            $("#alertPlaceholder").append(element)
            // $("#cartCount").html(responseData.response);
            setTimeout(location.reload(), 2500);
        }
    })
}

