const xmlHTTP = new XMLHttpRequest();
document.getElementById('search').addEventListener('keyup',function (){
    xmlHTTP.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("todolist").innerHTML = this.responseText;
        }
    };
    xmlHTTP.open("GET", "search.php?keyword=" + this.value, true);
    xmlHTTP.send();
})

document.getElementById('select').addEventListener('click',function (){
    console.log(this.value)
    xmlHTTP.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("todolist").innerHTML = this.responseText;
        }
    };
    xmlHTTP.open("GET", "filter.php?status=" + this.value, true);
    xmlHTTP.send();
})

console.log('Ok')
