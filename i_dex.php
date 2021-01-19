<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>API | Auth</title>
        <link href="semantic-ui/semantic.min.css" rel="stylesheet"/>
    </head>
    <body>
        <div class="ui attached stackable menu">
            <div class="ui container">
                <a class="item" id="home"><i class="home icon"></i> Home</a>
                <a class="item" id="update_account"><i class="grid layout icon"></i> Account</a>
                <a class="item" id="sign_up"><i class="edit icon"></i> Sign Up</a>
                <a class="item" id="sign_in"><i class="globe icon"></i> Sign In</a>
                <a class="item" id="sign_out"><i class="settings icon"></i> Sign Out</a>
                <div class="right item">
                    <div class="ui input"><input type="text" placeholder="Search..."></div>
                </div>
            </div>
        </div>

        <div id="content"></div>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="semantic-ui/semantic.min.js" type="text/javascript"></script>
    <script>
        $('.message .close').on('click', function(){
            $(this).closest('.message').transition('fade');
        })
        $(document).on('click', "#sign_up", function(){
            var html = `
                <div class="ui raised very padded text container segment">
                    <h2 class="ui header">Sign Up</h2>
                    <div id="response"></div>
                    <form class="ui form" id='sign_up_form'>
                        <div class="field">
                            <label>First Name</label>
                            <input type="text" name="firstname" placeholder="First Name" autocomplete="off">
                        </div>
                        <div class="field">
                            <label>Last Name</label>
                            <input type="text" name="lastname" placeholder="Last Name" autocomplete="off">
                        </div>
                        <div class="field">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Email" autocomplete="off">
                        </div>
                        <div class="field">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Password" autocomplete="off">
                        </div>
                        <div class="field">
                            <div class="ui checkbox">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label>I agree to the Terms and Conditions</label>
                            </div>
                        </div>
                        <button class="ui button" type="submit">Sign Up</button>
                    </form>
                </div>
            `;
            clearResponse();
            $("#content").html(html);
        })

        $(document).on('submit', '#sign_up_form', function(){
            var sign_up_form = $(this);
            var form_data = JSON.stringify(sign_up_form.serializeObject());
            $.ajax({
                url: "auth/create_user.php",
                type: "POST",
                contentType: 'application/json',
                data: form_data,
                success: function(result){
                    $('#response').html("<div class=\"ui message\">\n" +
                            "                <i class=\"close icon\"></i>\n" +
                            "                <div class=\"header\">\n" +
                            "                    Sign Up Successful!\n" +
                            "                </div>\n" +
                            "                <p>Please Sign In.</p>\n" +
                            "            </div>");
                    $("#sign_up_form").find('input').val('');
                },
                error: function(xhr, resp, text){
                    $('#response').html("<div class=\"ui message\">\n" +
                        "                <i class=\"close icon\"></i>\n" +
                        "                <div class=\"header\">\n" +
                        "                    Unable to Sign Up!\n" +
                        "                </div>\n" +
                        "                <p>Please Contact your Admin.</p>\n" +
                        "            </div>")
                }
            });
            return false;
        })
        function clearResponse(){
            $("#response").html('');
        }
        $.fn.serializeObject = function () {
            var o = {}
            var a  = this.serializeArray()
            $.each(a, function(){
                if(o[this.name] !== undefined){
                    if(!o[this.name].push){
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '')
                }else{
                    o[this.name] = this.value || ''
                }
            });
            return o
        };
        $(document).on('click', '#sign_in', function(){
            showLoginPage();
        })
        function showLoginPage() {
            setCookie("jwt","",1);
            var html = `
                <div class="ui raised very padded text container segment">
                    <h2 class="ui header">Sign Up</h2>
                    <div id="response"></div>
                    <form class="ui form" id='sign_in_form'>
                        <div class="field">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="Email" autocomplete="off">
                        </div>
                        <div class="field">
                            <label>Password</label>
                            <input type="password" name="password" placeholder="Password" autocomplete="off">
                        </div>
                        <div class="field">
                            <div class="ui checkbox">
                                <input type="checkbox" tabindex="0" class="hidden">
                                <label>I agree to the Terms and Conditions</label>
                            </div>
                        </div>
                        <button class="ui button" type="submit">Sign In</button>
                    </form>
                </div>
            `;
            $("#content").html(html)
            clearResponse();
            showLoggedOutMenu();
        }

        function setCookie(cname, cvalue, exdays){
            var d = new Date();
            d.setTime(d.getTime() + (exdays*24*60*60*1000));
            var expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/"
        }

        function showLoggedOutMenu(){
            $("#sign_in, #sign_up").show();
            $("#sign_out").hide();
        }

        $(document).on('submit', '#sign_in_form', function () {
            var login_form = $(this);
            var form_data = JSON.stringify(login_form.serializeObject());
            $.ajax({
                url: "auth/login.php",
                type: "POST",
                contentType: 'application/json',
                data: form_data,
                success: function (result) {
                    setCookie("jwt", result.jwt, 1);
                    showHomePage();
                    $('#response').html("<div class=\"ui message\">\n" +
                            "                <i class=\"close icon\"></i>\n" +
                            "                <div class=\"header\">\n" +
                            "                    Successfully Signed In!\n" +
                            "                </div>\n" +
                            "                <p>Welcome!</p>\n" +
                            "            </div>")
                },
                error: function (xhr, resp, text) {
                    $("#response").html("<div class=\"ui message\">\n" +
                        "                <i class=\"close icon\"></i>\n" +
                        "                <div class=\"header\">\n" +
                        "                    Sign In Failed!\n" +
                        "                </div>\n" +
                        "                <p>Email or Password Incorrect.</p>\n" +
                        "            </div>");
                    login_form.find('input').val('')
                }
            })
            return false
        })
        function showHomePage() {
            var jwt = getCookie('jwt');
            $.post("auth/validate_token.php", JSON.stringify({jwt:jwt})).done(function (result) {
                var html = `
                    <div class="ui raised very padded text container segment">
                        <h2 class="ui header">Welcome Home</h2>
                        <p>You are Logged in.</p>
                        <p>You won't be able to access the home and account pages if you are not logged in.</p>
                    </div>
                `;
                $("#content").html(html);
                showLoggedInMenu();
            }).fail(function (result) {
                showLoginPage();
                $("#response").html("<div class=\"ui message\">\n" +
                        "                <i class=\"close icon\"></i>\n" +
                        "                <div class=\"header\">\n" +
                        "                   Oops!\n" +
                        "                </div>\n" +
                        "                <p>Please login to access the home page.</p>\n" +
                        "            </div>")
            })
        }
        function getCookie(cname) {
            var name = cname + "=";
            var decodedCookie = decodeURIComponent(document.cookie);
            var ca = decodedCookie.split(';')
            for(var i=0; i < ca.length; i++){
                var c = ca[i];
                while(c.charAt(0) === ' '){
                    c = c.substring(1);
                }
                if(c.indexOf(name) === 0){
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        $(document).on('click',"#home", function () {
            showHomePage();
            clearResponse();
        })

        function showLoggedInMenu() {
            $('#sign_in, #sign_up').hide();
            $("#logout").show();
        }

        $(document).on('click','#update_account', function () {
            showUpdateAccountForm();
        })
        function showUpdateAccountForm(){
            var jwt = getCookie('jwt');
            $.post('auth/validate_token.php',JSON.stringify({jwt:jwt})).done(function (result) {
                var html = `
                    <div class="ui raised very padded text container segment">
                        <h2 class="ui header">Account Info</h2>
                        <div id="response"></div>
                        <form class="ui form" id='update_account_form'>
                            <div class="field">
                                <label>First Name</label>
                                <input type="text" name="firstname" placeholder="First Name" autocomplete="off">
                            </div>
                            <div class="field">
                                <label>Last Name</label>
                                <input type="text" name="lastname" placeholder="Last Name" autocomplete="off">
                            </div>
                            <div class="field">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Email" autocomplete="off">
                            </div>
                            <div class="field">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Password" autocomplete="off">
                            </div>
                            <div class="field">
                                <div class="ui checkbox">
                                    <input type="checkbox" tabindex="0" class="hidden">
                                    <label>I agree to the Terms and Conditions</label>
                                </div>
                            </div>
                            <button class="ui button" type="submit">Sign Up</button>
                        </form>
                    </div>
                `;
                clearResponse()
                $("#content").html(html);
            }).fail(function (result) {
                showLoginPage()
                $("#response").html("<div class=\"ui message\">\n" +
                        "                <i class=\"close icon\"></i>\n" +
                        "                <div class=\"header\">\n" +
                        "                   Oops!\n" +
                        "                </div>\n" +
                        "                <p>Please login to access the home page.</p>\n" +
                        "            </div>")
            })
        }

        $(document).on('submit',"#update_account_form", function () {
            var update_account_form = $(this);
            var jwt = getCookie('jwt')
            var update_account_form_obj = update_account_form.serializeObject()
            update_account_form_obj.jwt = jwt
            var form_data = JSON.stringify(update_account_form_obj);
            $.ajax({
                url: "auth/update_user.php",
                type: "POST",
                contentType: 'application/json',
                data: form_data,
                success: function(result){
                    $("#response").html("<div class=\"ui message\">\n" +
                            "                <i class=\"close icon\"></i>\n" +
                            "                <div class=\"header\">\n" +
                            "                    Success!\n" +
                            "                </div>\n" +
                            "                <p>Account Updated Successfully.</p>\n" +
                            "            </div>");
                    setCookie("jwt",result.jwt, 1)
                },
                error: function (xhr, resp, txt) {
                    if(xhr.responseJSON.message === "Unable to update user."){
                        $("#response").html("<div class=\"ui message\">\n" +
                                "                <i class=\"close icon\"></i>\n" +
                                "                <div class=\"header\">\n" +
                                "                    Error!\n" +
                                "                </div>\n" +
                                "                <p>Unable to update Account.</p>\n" +
                                "            </div>")
                    }else if(xhr.responseJSON.message === "Access denied"){
                        showLoginPage()
                        $("#response").html("<div class=\"ui message\">\n" +
                                "                <i class=\"close icon\"></i>\n" +
                                "                <div class=\"header\">\n" +
                                "                    Error!\n" +
                                "                </div>\n" +
                                "                <p>Access Denied.</p>\n" +
                                "            </div>")
                    }
                }
            })

            return false;
        })

        $(document).on('click', '#sign_out', function () {
            showLoginPage()
            $('#response').html("<div class=\"ui message\">\n" +
                    "                <i class=\"close icon\"></i>\n" +
                    "                <div class=\"header\">\n" +
                    "                    Success!\n" +
                    "                </div>\n" +
                    "                <p>You are Logged out.</p>\n" +
                    "            </div>")
        })
    </script>
    </body>
</html>