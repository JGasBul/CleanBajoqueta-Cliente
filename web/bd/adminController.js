//---------------------------------------------------------------------------------------------------------
// Autor: Arnau Soler Tomás
// Fichero: adminController.js
// Descripción: Fichero JS con funciones para controlar la página del administrador
//---------------------------------------------------------------------------------------------------------
//Variables Globales
/*
const dataTest = [
  {
    "id": 1,
    "name": "Leanne Graham",
    "email": "Sincere@april.biz",
    "activo": "false"
  },
  {
    "id": 2,
    "name": "Hola admin",
    "email": "hola@admin.biz",
    "activo": "true"
  },
  {
    "id": 3,
    "name": "Test Guy",
    "email": "test@guy.biz",
    "activo": "false"
  }
];
*/
var data = null;                  // Data recibida de la BBDD
var consttableContainer = null;   // Contenedor donde reside la tabla
var modalWrap = null;             // Contenedor del PopUp de Eliminar Usuario
//---------------------------------------------------------------------------------------------------------
// data --> generateTable() --> table
//---------------------------------------------------------------------------------------------------------
async function generateTable(data) {
  console.log("generateTable()")
  console.log(data);
  try {

    /*
    const response = await fetch('https://jsonplaceholder.typicode.com/users');
    const data = await response.json();
    */

    let table = '<table>';
    table += '<tr><th>Nº</th><th>Perfil</th><th>Email</th><th>Telefono</th><th>Activo</th><th>Ult.Medición</th><th></th></tr>';

    let btnEliminar = '<button type="button" onClick="eliminar(this.parentNode.parentNode)">Eliminar</button>';

    var index = 1;

    data.forEach(item => {

      if (item.rol != 1 && item.verificado != 0) {
        table += `<tr><td>${index}</td><td>${item.nombreApellido}</td><td>${item.email}</td><td>${item.telefono}</td><td>${estado(item.activo)}</td><td>${item.ultimoNodo}</td><td>${btnEliminar}</td></tr>`;
        index++;
      }
    });
    table += '</table>';
    consttableContainer = document.getElementById('table-container');
    consttableContainer.innerHTML = table;
  } catch (error) {
    console.error(error);
  }
  actualizarTabla();
}
//---------------------------------------------------------------------------------------------------------
// getUsers() --> data:JSON
// Descripción: Recoge los datos de la tabla Usuarios de la BBDD
//---------------------------------------------------------------------------------------------------------
async function getUsers() {
  var response = await fetch('http://localhost:8080/user/getAllUsers');
  data = await response.json();

  //console.log(data);
}
//---------------------------------------------------------------------------------------------------------
// status:boolean --> estado() --> cuadrado:div
// Descripción: Recoge los datos de la tabla Usuarios de la BBDD
//---------------------------------------------------------------------------------------------------------
function estado(status) {
  let cuadrado = '<div class="estadoCuadrado';

  if (status == 'true') {
    console.log(status)
    cuadrado += ' activo"';
  }
  else {
    console.log('false')
    cuadrado += ' inactivo"';
  }

  cuadrado += '></div>';
  return cuadrado;
}
//---------------------------------------------------------------------------------------------------------
// input:String --> getUserByName()
// Descripción: Actualiza la tabla para mostrar solo aquella fila que cumpla la condición del input
//---------------------------------------------------------------------------------------------------------
function getUserByName() {
  var input, filter, table, tr, td, txtValue;

  input = document.getElementById("adminInputSearch");
  filter = input.value.toUpperCase();
  table = consttableContainer;
  tr = table.getElementsByTagName("tr");

  for (var i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[2];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
//---------------------------------------------------------------------------------------------------------
// actualizarTabla() --> getUserByName() --> actualizarTabla()
// Descripción: Esta función sirve para actualizar la tabla en base al filtrador. Dicha actualización
// se ejecuta cada 1 segundo
//---------------------------------------------------------------------------------------------------------
function actualizarTabla() {
  getUserByName()
  setTimeout(() => {
    //console.log("1 Segundo esperado")
    actualizarTabla();
  }, 1000);
}
//---------------------------------------------------------------------------------------------------------
// title, description:Txt; callback:function --> popUp() --> popUp
// Descripción: Función que crea un popUp con un titulo y descripción en concreto.
// Si no se especifican los labels de Si y No, se crearán por defecto con los valores "Aceptar" y "Cancelar"
//---------------------------------------------------------------------------------------------------------
function popUp(title, description, callback, yesBtnLabel = 'Aceptar', noBtnLabel = 'Cancelar') {
  if (modalWrap !== null) {
    modalWrap.remove();
  }

  modalWrap = document.createElement('div');
  modalWrap.innerHTML = `
    <div class="modal fade" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-light">
            <h5 class="modal-title">${title}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p>${description}</p>
          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${noBtnLabel}</button>
            <button type="button" class="btn btn-primary modal-success-btn" data-bs-dismiss="modal">${yesBtnLabel}</button>
          </div>
        </div>
      </div>
    </div>
  `;

  modalWrap.querySelector('.modal-success-btn').onclick = callback;

  document.body.append(modalWrap);

  var modal = new bootstrap.Modal(modalWrap.querySelector('.modal'));
  modal.show();
}

async function obtenerUltima(email) {
  console.log("Obteniendo el email:", email);
  try {
      const response = await fetch('../bd/ultimoNodo.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify({ email: email })
      });
      const data = await response.json();
      if (data.error) {
          console.error('Error:', data.error);
          return null;
      } else {
          console.log("Datos obtenidos para el email:", email, data);
          return data;
      }
  } catch (error) {
      console.error('Error al realizar la solicitud:', error);
      return null;
  }
}




//---------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------
// Al empezar
//---------------------------------------------------------------------------------------------------------
async function main() {
 
  await getUsers();
  
  

  obtenerUltima("testMediciones@email.com")

  generateTable(data);
}
main()

