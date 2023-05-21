$("#addCompanyButton").click(function(e) {
    e.preventDefault()
    var button = $(this)
    button.prop('disabled', true);
    button.text("Loading..")
    var companyName = $('#companyName').val();
    var companyPin = $('#companyPin').val();

    $.ajax({
        type: 'POST',
        url: 'middleware.php',
        data: {
            "addCompany": true,
            companyName,
            companyPin
        },
        success: function(response) {
            var response = JSON.parse(response)
            if (response.status == "success") {
                alert("Success")
            } else {
                button.text("Submit")
                alert(response.message)
            }
        }
    });
})