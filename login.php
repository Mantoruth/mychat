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
            width: 103%;
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
            color: white; 
            display: none;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div id="wrapper">
        <div id="header">
            My Chat
            <div style="font-size: 20px; margin: 20px;">Login</div>
            <div id="error"></div> <!-- Error message display -->
        </div>
        
        <form id="myform"> 
            <input type="text" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <input type="button" value="Login" id="login_button"><br>

            <br>
            <a href="signup.php" style="display: block;text-align: center;text-decoration: none;">
                Dont have an Account? Signup here
            </a>
        </form>
    </div>

    <script type="text/javascript">
        function _(element) {
            return document.getElementById(element);
        }

        var login_button = _("login_button");
        login_button.addEventListener("click", collect_data);

        function collect_data() {
            login_button.disabled = true;
            login_button.value = "Loading...Please wait..";

            var myform = _("myform");
            var inputs = myform.getElementsByTagName("INPUT");
            var data = {};

            for (var i = inputs.length - 1; i >= 0; i--) {
                var key = inputs[i].name;
                if (key) {
                    data[key] = inputs[i].value; // Collect input values dynamically
                }
            }
            console.log("Data being sent:", data); // Log the data
            send_data(data, "login");
        }

        function send_data(data, type) {
            var xml = new XMLHttpRequest();
            xml.onload = function() {
                if (xml.status == 200) {
                    handle_results(xml.responseText);
                    login_button.disabled = false;
                    login_button.value = "Login";
                } else {
                    console.error("Request failed with status:", xml.status);
                }
            };

            data.data_type = type;
            var data_string = JSON.stringify(data);

            xml.open("POST", "api.php", true);
            xml.setRequestHeader("Content-Type", "application/json"); // Set content type
            xml.send(data_string);
        }

        function handle_results(results) {
            var data = JSON.parse(results);
            var error = _("error"); // Get the error display element

            if (data.data_type === "info") {
                window.location.href = "index.php";
            } else {
                error.innerHTML = data.message;
                error.style.display = "block"; // Show the error message
            }
        }
    </script>
</body>
</html>
