function showDetails(ref_no){
    if(event.target.tagName == "DIV"){
        $(event.target).find("i").toggleClass("fa-sort-down")
        $(event.target).find("i").toggleClass("fa-sort-up")
    }
    $("#"+ref_no).slideToggle();
}
function cancelOrder(ref_no){
    $.ajax({
        url:"../controllers/CheckoutController.php",
        type: "POST",
        data:{
            'ref_no' : ref_no,
            'cancel_order': 1
        },
        success:function(response){
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
        error:function(response){
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