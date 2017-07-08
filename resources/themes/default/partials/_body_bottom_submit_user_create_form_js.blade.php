
<script type="text/javascript">
    // @cpnwaugha: c-e
    $("#btn-submit-edit").on("click", function () {
        var roles=[], id;
        // Collect all IDs from first column.
        $('#tbl-roles tr').each(function() {
            id = $(this).find("td:first").html();
            if (id) {
                roles.push(id);
            }
        });
        // Join all roles from array to hidden field separated by a comma.
        $('#selected_roles').val(roles.join(','));
        // Post form.
        $("#form_edit_user").submit();
    });

    // @cpnwaugha: c-e
    $("#cpn-email-field").val('@hallowgate.com'); // initial value is domain name;
    $("#cpn-email-field").on("blur",function(){

        var email_regex = /^[\w]+(\.[\w]+)*@([\w]+\.)+[a-z]{2,7}$/i;
        var domain_regex = /^[\w]+(\.[\w]+)*(@hallowgate\.com)+$/i;
        if (email_regex.test($("#cpn-email-field").val())){

            if (domain_regex.test($("#cpn-email-field").val())){

                //console.log($("#cpn-email-field").val().match(email_regex));
                $.toast({
                    heading: 'Success',
                    text: 'User email is valid',
                    icon: 'success',
                    showHideTransition: 'slide',
                    loader: false,        // Change it to false to disable loader
                    loaderBg: '#9EC600'  // To change the background
                });
                return true;
            }
            else{
                //console.log("email domain must end with @hallowgate.com");
                $("#cpn-email-field").val("@hallowgate.com");
                $("#cpn-email-field").focus();
                $.toast({
                    heading: 'Error',
                    text: 'email domain must end with @hallowgate.com',
                    icon: 'error',
                    showHideTransition: 'slide',
                    loader: false,       // Change it to false to disable loader
                    hideAfter: 7000,
                    stack: 3
                });
                return;
            }
        }
        else{
            //console.log("Invalid email. Ensure the email is a valid email.");
            $("#cpn-email-field").val("@hallowgate.com");
            $("#cpn-email-field").focus();
            $.toast({
                heading: 'Error',
                text: 'Invalid email. Ensure the email is a valid email.',
                icon: 'error',
                showHideTransition: 'slide',
                loader: false,      // Change it to false to disable loader
                hideAfter: 7000,
                stack: 3
            });
            return;
        }
        return false;
    });

    // set default values for password and password confirmation fields
    $("#cpn-pwd-field").val('123456');
    $("#cpn-pwdcf-field").val('123456');

</script>

