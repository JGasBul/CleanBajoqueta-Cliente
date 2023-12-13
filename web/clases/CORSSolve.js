
async function CORSSolve(ubicacion) {
    
    console.log("Ubicación: "+ubicacion);
    
    url = new URL('http://localhost:8080/mediciones/mediciones_zona')
    var result = "Error";
    var params = { latitud: ubicacion[1], longitud: ubicacion[0] }

    url.search = new URLSearchParams(params).toString();

    //console.log(url);

    /*
    await fetch(url)
    .then(response =>{
        response.json()
        //result = response;
    })
    */
   
    /*
    fetch(url)
        .then((response) => {
            response.json();
            
            console.log("Response.json CorsSolve:")
            console.log(response)

            return response;
        })
        .then((res => {
            console.log("2º Response")
            console.log(res);
            
            console.log("2º Response CorsSolve:")
            console.log(response)
            
           result = res;
        }))

    */

    result = await fetch(url)

    return await result.json();
    //return result;
}