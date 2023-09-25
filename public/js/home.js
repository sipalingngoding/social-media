const photos = document.getElementById('photos');

const btn = document.getElementById('select');

const xmlHTTP = new XMLHttpRequest();

btn.addEventListener('click',function (e){
    e.preventDefault();
    if (this.value === 'Select') return;
    xmlHTTP.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            photos.innerHTML = this.responseText;
        }
    };
    xmlHTTP.open("GET", "/photoUser?value="+this.value, true);
    xmlHTTP.send();
})
