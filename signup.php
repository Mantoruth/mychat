<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Chat</title>
    <style type="text/css">
        #wrapper {
            max-width: 900px;
            min-height: 500px;
            margin: auto;
            color: grey;
            font-size: 13px;
        }
        form {
            margin: auto;
            padding: 10px;
            width: 100%;
            max-width: 400px;
        }
        input[type=text], input[type=password], input[type=button] {
            padding: 10px;
            margin: 10px;
            width: 98%;
            border-radius: 5px;
            border: solid 1px grey;
        }
        input[type=button] {
            width: 100%;
            cursor: pointer;
            background-color: #2b5488;
            color: white;
        }
        input[type=radio] {
            transform: scale(1.2);
            cursor: pointer;
        }
        #header {
            background-color: #485b6c;
            font-size: 40px;
            text-align: center;
            width: 100%;
            color: white;
        }
        #error {
            text-align: center;
            padding: 0.5rem;
            background-color: #ecaf91;
            color: black;
            display: none;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="header">
            My Chat
            <div style="font-size: 20px; margin: 20px;">Signup</div>
            <div id="error"></div>
    </div>
        <form id="myform"> 
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="text" name="email" placeholder="Email" required><br>
            <div style="padding: 10px;">
                <br>Gender:<br>
                <input type="radio" value="Male" name="gender" required> Male <br>
                <input type="radio" value="Female" name="gender"> Female <br>
            </div>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="password" name="password2" placeholder="Retype Password" required><br>
            <input type="button" value="Sign Up" id="signup_button"><br>

            <br>
            <a href="login.php" style="display: block;text-align: center;text-decoration: none;">
                Already have an Account? Login here
            </a>
        </form>
    </div>

    <script type="text/javascript">
        function _(element) {
            return document.getElementById(element);
        }

        var signup_button = _("signup_button");
        signup_button.addEventListener("click", collect_data);

        function collect_data() {
            signup_button.disabled = true;
            signup_button.value = "Loading... Please Wait...";

            var myform = _("myform");
            var inputs = myform.getElementsByTagName("INPUT");

            var data = {};
            for (var i = 0; i < inputs.length; i++) {
                var key = inputs[i].name;
                if (key) {
                    if (key === "gender") {
                        if (inputs[i].checked) {
                            data.gender = inputs[i].value;
                        }
                    } else {
                        data[key] = inputs[i].value;
                    }
                }
            }

            send_data(data, "signup");
        }

        function send_data(data, type) {
            var xml = new XMLHttpRequest();

            xml.onload = function() {
                if (xml.readyState == 4 && xml.status == 200) {
                    handle_result(xml.responseText);
                    signup_button.disabled = false;
                    signup_button.value = "Sign Up";
                }
            };

            data.data_type = type;
            var data_string = JSON.stringify(data);

            xml.open("POST", "api.php", true);
            xml.setRequestHeader("Content-Type", "application/json"); // Set content type
            xml.send(data_string);
        }

        function handle_result(result) {
            var data = JSON.parse(result);
            if (data.data_type === "info") {
                window.location = "index.php"; // Redirect on successful signup
            } else {
                var error = _("error");
                error.innerHTML = data.message;
                error.style.display = "block"; // Show error message
            }
        }
    </script>
</body>
</html>
