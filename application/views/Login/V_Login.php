<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login V15</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <link rel="stylesheet" href="<?= base_url() ?>dist/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>dist/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?= base_url() ?>dist/Ionicons/css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/util.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/css/main.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>dist/<?= SWEETALERT_CSS ?>">
    </head>
    <style>
          a{
            font-size: 27px;
            text-decoration: underline;
            text-decoration-color: lightgrey;
          }
    </style>
    <body>

        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-form-title" style="background-image: url(<?= base_url() ?>dist/img/bg-01.jpg);">
                        <span class="login100-form-title-1">
                            Sign In
                        </span>
                    </div>

                    <div class="login100-form " >
                        <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                            <span class="label-input100">Username</span>
                            <input class="input100" type="text" id="usr" placeholder="Enter username" autocomplete="new-name" >
                            <span class="focus-input100"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-18" data-validate = "Password is required">
                            <span class="label-input100">Password</span>
                            <input class="input100" type="password" id="psw" placeholder="Enter password" autocomplete="new-password">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-18" >
                            <span class="label-input100">Password</span>
                            <select class="input100 select100" id="company" >
                                <option value="MILESTONE">Milestone</option>
                                <option value="NORVENTAS">Norventas</option>
                            </select>
                                
                            <span class="focus-input100"></span>
                        </div>

                        <div class="flex-sb-m w-full p-b-30">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                <label class="label-checkbox100" for="ckb1">
                                    Remember me
                                </label>
                            </div>

                            <div>
                                <a href="#" class="txt1">
                                    Forgot Password?
                                </a>
                            </div>
                        </div>

                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn btn-log">
                                <i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Login
                            </button>
                        </div>
                        <div class="container-login100-form-btn">
                            <button class="login100-form-btn btn-google">
                                <i class="fa fa-google-plus"></i>&nbsp;&nbsp;&nbsp;Google
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <script src="<?= base_url() ?>dist/jquery/jquery.js"></script>
        <script src="<?= base_url() ?>dist/js/function.js"></script>
        <script src="<?= base_url() ?>dist/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?= base_url() ?>dist/<?= SWEETALERT_JS ?>"></script>
        <script src="<?= base_url() ?>dist/md5/js/md5.js"></script>
        <script>

            var input = $('.validate-input .input100');

            $(function () {
                $(document).keypress(function (e) {
                    if (e.which == 13) {
                        Send();
                        return false;
                    }
                });
                $(".btn-log").click(function () {
                    Send();
                });

                $(".btn-google").click(function(){
                    var url = "<?=$login_url; ?>";
                    $(location).attr('href', url);
                });
                
                
                $('.input100').each(function () {
                    $(this).on('blur', function () {
                        if ($(this).val().trim() != "") {
                            $(this).addClass('has-val');
                        } else {
                            $(this).removeClass('has-val');
                        }
                    })
                })

            });

            function Send() {
                $('.input100').each(function () {
                    $(this).focus(function () {
                        hideValidate(this);
                    });
                });

                var check = true;

                for (var i = 0; i < input.length; i++) {
                    if (validate(input[i]) == false) {
                        showValidate(input[i]);
                        check = false;
                    }
                }

                if (check) {
                    var ckb1 = document.getElementById("ckb1").checked;
                    $.post("<?= base_url() ?>C_Main/Login", {usr: $("#usr").val(), psw: md5($("#psw").val()), company: $("#company").val(), ckb1: ckb1}, function (data) {
                        if (data.res == "OK") {
                            location.href = "C_Panel";
                        } else if (data.res == "ERROR") {
                            swal({title: 'Error!', text: "Usuario o password incorrecto", type: 'error'});
                        } else {
                            swal({title: 'Error!', text: data, type: 'error'});
                        }
                    }, 'json').fail(function (error) {
                        swal({title: 'La url solicitada no existe para ingresar haz click en el enlace <a href="<?=URL_PROJETC?>">VisionCenter</a>!', text: error.responseText, type: 'error'});
                    });
                }
            }

            function validate(input) {
                if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
                    if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                        return false;
                    }
                } else {
                    if ($(input).val().trim() == '') {
                        return false;
                    }
                }
            }

            function showValidate(input) {
                var thisAlert = $(input).parent();

                $(thisAlert).addClass('alert-validate');
            }

            function hideValidate(input) {
                var thisAlert = $(input).parent();

                $(thisAlert).removeClass('alert-validate');
            }


        </script>
    </body>
</html>
