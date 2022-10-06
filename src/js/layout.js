
        if (login == 'in' && document.getElementById("login_button") != null) {
            document.getElementById("login_button").style.display = "none";
            document.getElementById("register_button").style.display = "none";
        }
        var logoutButtonFind = document.getElementById("logout_button");
        if (login == 'out' && document.getElementById("logout_button")) {
            document.getElementById("logout_button").style.display = "none";
        }

        if (singlePost == 'yes' && document.getElementById("list_of_posts") != null) {
            document.getElementById("list_of_posts").style.display = "none";
        }

console.log("login")
console.log(login)
console.log("token")
console.log(token)
console.log("singlePost")
console.log(singlePost)