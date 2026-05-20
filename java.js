
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            // "profileDisplay" ID'li resmin src'sini seçilen dosya ile değiştirir
            document.getElementById('profileDisplay').src = e.target.result;
        }

        reader.readAsDataURL(input.files[0]);
    }
}
// Sayfa yüklendiğinde mevcut (orijinal) resmi bir değişkende saklayalım
const originalImageSrc = "uploads/<?php echo $user_photo; ?>";

function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profileDisplay').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}


function showToast(message, type = "success") {
    var toast = document.getElementById("toast");
    toast.innerText = message; 
    
    // Eğer hata mesajıysa rengi değiştirebiliriz
    if(type === "error") {  //type = parametre
        toast.style.borderColor = "#f38ba8";
        toast.style.color = "#f38ba8";
    } else {
        toast.style.borderColor = "#89b4fa";
        toast.style.color = "#89b4fa";
    }

    toast.className = "toast show";
    
    // 3 saniye sonra gizle
    //setTimeout fonksiyondur
    setTimeout(function(){ 
        toast.className = toast.className.replace("show", ""); 
    }, 3000);
}
