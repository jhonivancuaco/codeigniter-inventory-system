$(document).ready(function () {

    // GLOBAL SCRIPTS =============================================================================================
    // Add an eye icon to password inputs, which toggles the type of the input between password and text when clicked.
    $('.password-control').each(function (index, wrapper) {

        // Get the input element.
        let input = $('input', wrapper).get(0);

        // Add an eye icon to the input.
        let icon = $('<i>').addClass('fa fa-eye');
        $(wrapper).append(icon);

        // Toggle the type of the input between password and text when the icon is clicked.
        $(icon).click(function () {
            if (input.type === 'password') {
                input.type = 'text';
                $(icon).removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.type = 'password';
                $(icon).removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });

    // VIEWS: Settings.php =============================================================================================
    // Confirm that the user wants to change their password before submitting the form.
    $('form#change-password').submit(function (e) {
        e.preventDefault();

        // Ask the user if they are sure they want to change their password.
        if (confirm('Are you sure you want to change your password?')) {
            // If the user is sure, submit the form.
            $(this).unbind('submit').submit();
        }
    });


    // Confirm that the user wants to update their profile before submitting the form.
    $('form#update-profile').submit(function (e) {
        e.preventDefault();

        // Ask the user if they are sure they want to update their profile.
        if (confirm('Are you sure you want to update your profile?')) {
            // If the user is sure, submit the form.
            $(this).unbind('submit').submit();
        }
    });

    // VIEWS: Settings.php =============================================================================================

})

