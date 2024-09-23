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
            display: flex;
            margin: auto;
            color: white;
            font-size: 13px;
        }
        #left_pannel {
            min-height: 500px;
            background-color: #27344b;
            flex: 1;
            text-align: center;
        }
        #profile_image {
            width: 50%;
            border: solid thin white;
            border-radius: 50%;
            margin: 10px;
        }
        #left_pannel label {
            width: 100%;
            height: 20px;
            display: block;
            background-color: #404b56;
            border-bottom: solid thin #ffffff55;
            cursor: pointer;
            padding: 5px;
            transition: all 1s ease;
        }
        #left_pannel label:hover {
            background-color: #778593;
        }
        #left_pannel label img {
            float: right;
            width: 25px;
        }
        #right_pannel {
            min-height: 500px;
            flex: 4;
            text-align: center;
        }
        #header {
            background-color: #485b6c;
            height: 70px;
            font-size: 40px;
            text-align: center;
        }
        #inner_left_pannel {
            background-color: #383e48;
            flex: 1;
            min-height: 430px;
        }
        #inner_right_pannel {
            background-color: #f2f7f8;
            flex: 2;
            min-height: 430px;
            transition: all 2s ease;
        }
        #radio_contacts:checked ~ #inner_right_pannel {
            flex: 0;
        }
        #radio_settings:checked ~ #inner_right_pannel {
            flex: 0;
        }

        #contact{
           width: 150px;
           height: 170px;
           margin: 10px;
           display: inline-block;
           vertical-align: top;
           overflow: hidden;
        }

        #contact img{
           width: 100%;
        }
    </style>
</head>
<body>
    <div id="wrapper">
        <div id="left_pannel">
            <div id="user_info" style="padding: 10px;">
                <img id="profile_image" src="ui/images/user_female.png" alt="">
                <br>
                <span id="username">Username</span>
                <br>
                <span id="email" style="font-size: 12px; opacity: 0.5;">email@gmail.com</span>
                <br><br><br>
                <div>
                    <label id="label_chat" for="radio_chat">Chat <img src="ui/icons/chat.png.jpg"></label>
                    <label id="label_contacts" for="radio_contacts">Contacts <img src="ui/icons/contacts.png.jpg"></label>
                    <label id="label_settings" for="radio_settings">Settings <img src="ui/icons/settings.png.jpg"></label>
                    <label id="logout" for="radio_logout">Logout <img src="ui/icons/logout.png.jpg"></label>
                </div>
            </div>
        </div>
        <div id="right_pannel">
            <div id="header">My Chat</div>
            <div id="container" style="display:flex;">

                <div id="inner_left_pannel">
                    
                </div>

                <input type="radio" id="radio_chat" name="myradio" style="display: none;" checked>
                <input type="radio" id="radio_contacts" name="myradio" style="display: none;">
                <input type="radio" id="radio_settings" name="myradio" style="display: none;">
                <div id="inner_right_pannel"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function _(element) {
            return document.getElementById(element);
        }
        var label_contacts = _("label_contacts");
        label_contacts.addEventListener("click",get_contacts);

        var label_chat= _("label_chat");
        label_chat.addEventListener("click",get_chat);

        var label_settings = _("label_settings");
        label_settings.addEventListener("click",get_settings);

        var logoutButton = _("logout");
        logoutButton.addEventListener("click",logout_user);
        function get_data(find, type) {
            var xml = new XMLHttpRequest();
            xml.onload = function() {
                if (xml.readyState === 4) {
                    if (xml.status === 200) {
                        handle_result(xml.responseText, type);
                    } else {
                        console.error('Request failed with status:', xml.status);
                    }
                }
            };
            var data = { find: find, data_type: type };
            xml.open("POST", "api.php", true);
            xml.setRequestHeader("Content-Type", "application/json");
            xml.send(JSON.stringify(data));
        }

        function handle_result(result, type) {

            if (result.trim() !== "") {
                var obj;
                try {
                    obj = JSON.parse(result);
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                    return; 
                }

                console.log(obj);

                if (typeof obj.logged_in !== "undefined" && !obj.logged_in) {
                    window.location = "login.php";
                    return; 
                }
                switch (obj.data_type) {
                    case "user_info":
                        var username = document.getElementById("username");
                        var email = document.getElementById("email");
                        if (username) {
                            username.innerHTML = obj.username;
                            email.innerHTML = obj.email;
                        }
                        break;
                    case "logout":
                        window.location = "login.php";
                        break;
                    case "contacts":
                        var inner_left_pannel = _("inner_left_pannel");
                        
                        inner_left_pannel.innerHTML = obj.message;
                
                        break;
                        case "chat":
                        var inner_left_pannel = _("inner_left_pannel");
                        
                        inner_left_pannel.innerHTML = obj.message;
                
                        break;
                        case "settings":
                        var inner_left_pannel = _("inner_left_pannel");
                        
                        inner_left_pannel.innerHTML = obj.message;
                
                        break;

                    default:
                        console.warn("Unknown data type:", obj.data_type);
                }
            }
        }

        // Attach event listeners for radio buttons
        document.getElementById('radio_chat').addEventListener('change', function() {
            document.getElementById('inner_right_pannel').style.display = 'block';
            // Load chat data if necessary
        });

        document.getElementById('radio_contacts').addEventListener('change', function() {
            document.getElementById('inner_right_pannel').style.display = 'block';
            // Load contacts data if necessary
        });

        document.getElementById('radio_settings').addEventListener('change', function() {
            document.getElementById('inner_right_pannel').style.display = 'block';
            // Load settings data if necessary
        });
     function logout_user()
     {
        var answer = confirm("Are you sure want to log out??");
        if(answer){
            get_data({},"logout");
        }
        
     }

        get_data({}, "user_info");

        function get_contacts(e)
        {
          get_data({}, "contacts");
        }

        function get_chat(e)
        {
          get_data({}, "chat");
        }

        function get_settings(e)
        {
          get_data({}, "settings");
        }

    </script>
</body>
</html>
