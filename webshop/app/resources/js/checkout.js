function showCardForm() {
    let passed = true;
    $("#contact-form input[type='text']").each(function () {
        let input = $(this).val();
        if (input == "" || input == undefined || input == null) {
            passed = false;
        }

    });
    if (passed) {
        $("#card-form input[type='text']").each(function () {
            $(this).attr("required","required")
        });
        $("#card-form").fadeIn();
        $("#option-2").prop('checked', true)

        console.log($("#option-2").prop('checked'))

    } else {
        $("#option-2").prop('checked', false)
        console.log($("#option-2").prop('checked'))

        let element = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <strong>Prvo popunite sve podatke u kontakt formi da biste popunili podatke o kartici</strong> 
        </div>
`
        $("#alertPlaceholder").append(element)
        setTimeout(() => {
            $("#alertPlaceholder").empty()
        }, 3000);
    }
}

function hideCardForm() {
    $("#card-form input[type='text']").each(function () {
            $(this).removeAttr("required","required")
        });
    $("#card-form").fadeOut();

}