$(document).ready(function() {
    $('#form_reg').validate(
        {
            rules: {
                name:{
                    required: true,
                    minlength: 4,
                    maxlength: 35
                },
                password:{
                    required: true,
                    minlength: 5,
                    maxlength: 15
                },
                phone:{
                    required: true,
                    minlength: 7,
                    maxlength: 15
                }
            },

            messages: {
                name:{
                    required: "Давайте знакомиться! Как Вас зовут?",
                    minlength: "От 4 до 35 символов!",
                    maxlength: "От 7 до 35 символов!"
                },
                password:{
                    required: "Пароль необходим! Безопасность превыше всего, гвоздь нам в кеды!!",
                    minlength: "От 5 до 15 символов!",
                    maxlength: "От 5 до 15 символов!"
                },
                phone:{
                    required: "И телефон, пожалуйста!",
                    minlength: "От 7 до 15 символов!",
                    maxlength: "От 7 до 15 символов!"
                }
            }
        },
        {
        submitHandler: function(form) {
            $(form).ajaxSubmit();
        }}
    );

    $('#auth_button').click(function () {

        var auth_name = $("#auth_name").val();
        var auth_password = $("#auth_password").val();


        if ( !(auth_name == '') && !(auth_password == '') ) {
            $.ajax({
                type: "POST",
                url: "include/auth.php",
                data: "login="+auth_name+"&pass="+auth_password,
                cache: false,
                success: function (data) {
                    if (data == 'yes_auth') {
                        window.location.href = 'index.php';
                    } else  {
                        window.location.href = 'error_auth.html';
                    }
                }
            })
        } else {
                alert("Заполните, пожалуйста, все поля!!!");
        }
    })

    $('#exit-btn').click(function () {

        $.ajax({
            type: "POST",
            url: "include/unauth.php",
        })
    })
});



