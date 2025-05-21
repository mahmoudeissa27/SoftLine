function formValidate() {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var error = document.getElementById("error");

    function formValidate() {
        var username = document.getElementById("username").value;
        var email = document.getElementById("email").value;
        var password = document.getElementById("password").value;
    
        if (username.length < 3 || email.indexOf("@") === -1 || password.length < 6) {
            return false; // توقف الإرسال عند خطأ
        }
        return true; // السماح بالإرسال
    }
    
}
