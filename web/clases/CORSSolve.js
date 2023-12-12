
async function CORSSolve(url) {
    /*
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("data").innerHTML = xhttp.responseText;
        }
    };

    //header.Add("Access-Control-Allow-Origin", "*")
    //header.Add("Access-Control-Allow-Methods", "DELETE, POST, GET, OPTIONS")
    //header.Add("Access-Control-Allow-Headers", "Content-Type, Authorization, X-Requested-With")

    xhttp.open("GET", url);
    xhttp.setRequestHeader('Access-Control-Allow-Origin', 'http://localhost');
    xhttp.setRequestHeader('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, DELETE, OPTIONS');
    xhttp.setRequestHeader('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token, Authorization, X-Requested-With');

    xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhttp.setRequestHeader('Access-Control-Allow-Origin', '*');
    xhttp.send();
    */
    url = new URL('http://localhost:8080/mediciones/mediciones_zona')
var result = null;
    var params = {latitud:38.995593, longitud:-0.167132}
    
    url.search = new URLSearchParams(params).toString();

    console.log(url);
    
    await fetch(url)
    .then(res =>{
        res.json()
        result = res;
    })

    return result;
}