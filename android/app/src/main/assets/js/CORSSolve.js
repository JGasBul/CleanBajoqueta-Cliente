
async function CORSSolve(ubicacion) {
    try {
        console.log("Ubicación: " + ubicacion);

        const url = new URL('http://192.168.1.106:8080/mediciones/mediciones_zona');
        const params = { latitud: ubicacion[1], longitud: ubicacion[0] };
        url.search = new URLSearchParams(params).toString();

        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        return await response.json();
    } catch (error) {
        console.error('Error in CORSSolve:', error);
        return null;  // O lanza un error dependiendo de tu caso de uso
    }
}
