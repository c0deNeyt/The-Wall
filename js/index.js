
$("a.signIn[name='out']").click(function (e) {
    e.preventDefault();
    $('input.sentReq').click();
});

async function alert() {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-right',
        iconColor: 'white',
        customClass: {
            popup: 'colored-toast'
        },
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true
    })
    await Toast.fire({
        icon: 'success',
        title: 'Password reset success! Your new password is [village88]'
    }).then(function() {
        window.location.href = "signIn.php";
    });
};
$("a.resetPass").click(function () {
    Swal.fire({
        title: 'Please provide your registered email address.',
        html: `<input type="text" name="emailAddress" id="emailAddress" class="customInput" placeholder="Registered Email">`,
        confirmButtonText: 'Reset Password!',
        focusConfirm: false,
        preConfirm: () => {
            return new Promise(function (resolve) {
                const email = Swal.getPopup().querySelector('#emailAddress').value;
                var emailAd = $.trim(email);
                $.ajax({
                    type: 'POST',
                    url: 'process.php',
                    data: {emailAddress: emailAd, request: 1},
                    dataType: 'json',
                    success: function (response) {
                        if(response == true){
                            alert();
                        }else{
                            Swal.showValidationMessage(`Can't find email address!`);
                        }
                    },
                    error: function () {
                        // ERROR HANDLING
                        Swal.showValidationMessage(`Something went wrong!`);
                    }
                });
                setTimeout(function () {
                    resolve();
                }, 250);
            });
        }
    });
});


