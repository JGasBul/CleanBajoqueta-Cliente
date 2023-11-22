<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Registro</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
    </head>

    <header>
        <?php include("../template/cabecera.php"); ?>
    </header>

    <body>
        <br>
        <div class="container-sm">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Ozono(O3)</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Monóxido de carbono(CO)</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Dióxido de Azufre (SO2)</button>
                </li>
            </ul>

           
            <div class="tab-content" id="myTabContent">

                <!-- Ozono -->
                <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                    <div class="card text-start">
                        <div class="card-header bg-info  text-md-center text-dark border-0 fs-3">
                            <h4>Ozono (O3)<h4>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title text-dark">Descripción</h5>
                            <p class="card-text">El ozono es un gas incoloro que se encuentra en el aire que respiramos. Puede ser bueno o malo, dependiendo de donde se encuentre.El ozono "bueno" se encuentra en la naturaleza a aproximadamente 10 a 30 millas sobre la superficie terrestre. Nos protege de los rayos ultravioleta del sol. El ozono "malo" se encuentra al nivel del suelo. Se forma cuando los contaminantes de los automóviles, las fábricas y otras fuentes reaccionan químicamente con la luz del sol. Suele ser peor en verano.</p>
                            <h5 class="card-title text-dark">Efectos</h5>
                            <p class="card-text">El gas ozono (O3) tiene un efecto positivo en la estratosfera (a unos 10-50 km de la superficie terrestre), ya que protege de la radiación ultravioleta.Sin embargo, a cotas inferiores, en la troposfera (la capa de la atmósfera en contacto con la tierra), se convierte en un contaminante que actúa como un potente y agresivo agente oxidante.La exposición a elevados niveles de este origina problemas respiratorios sobre la salud humana (irritación, inflamación, insuficiencias respiratorias, asma) y puede contribuir a incrementar la mortalidad prematura; también puede dañar la vegetación, afectar al crecimiento de cultivos y bosques, reducir la absorción de CO por las plantas, alterar la estructura de los ecosistemas y reducir la biodiversidad. Además, es un gas de efecto invernadero, que contribuye al calentamiento de la atmósfera.</p>
                            <h5 class="card-title text-dark">Valores recomendados por la OMS</h5>
                            <img src="../assets/ozonograf.png" class="img-responsive" alt="Image">
                        </div>
                        <div class="card-footer text-body-secondary"></div>  
                    </div>
                </div>

                <!-- Monóxido de Carbono (CO) -->
                <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                    <div class="card text-start">
                            <div class="card-header bg-info  text-md-center text-dark border-0 fs-3">
                                <h4>Monóxido de Carbono (CO)<h4>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-dark">Descripción</h5>
                                <p class="card-text">El monóxido de carbono (CO) es un gas sin color ni olor emitido como consecuencia de la combustión incompleta de carburantes fósiles y de biocombustibles.</p>
                                <h5 class="card-title text-dark">Efectos</h5>
                                <p class="card-text">El CO penetra en el organismo a través de los pulmones, y puede provocar una disminución de la capacidad de transporte de oxígeno de la sangre, con el consecuente detrimento de oxigenación de órganos y tejidos, así como disfunciones cardiacas, daños en el sistema nervioso, dolor de cabeza, mareos y fatiga; estos efectos pueden producirse tanto sobre el ser humano como sobre la fauna silvestre.También posee consecuencias sobre el clima, ya quecontribuye a la formación de gases de efecto invernadero: su vida media en la atmósfera es de unos tres meses, lo que permite su lenta oxidación para formar CO2, proceso durante el cual también se genera O3.</p>
                                <h5 class="card-title text-dark">Valores recomendados por la OMS</h5>
                                <img src="../assets/carbonograf.png" class="img-responsive" alt="Image">
                            </div>
                        <div class="card-footer text-body-secondary"></div>  
                    </div>
                </div>

                <!-- Dióxido de Azufre (SO2) -->
                <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                    <div class="card text-start">
                            <div class="card-header bg-info  text-md-center text-dark border-0 fs-3">
                                <h4>Dióxido de Azufre (SO2)<h4>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-dark">Descripción</h5>
                                <p class="card-text">Es un gas que se origina sobre todo durante la combustión decarburantes fósiles que contienen azufre (petróleo, combustibles sólidos) llevada a cabo sobre todo en los procesos industriales de alta temperatura y de generación eléctrica.</p>
                                <h5 class="card-title text-dark">Efectos</h5>
                                <p class="card-text">Este contaminante puede producir, incluso a grandesdistancias del foco emisor, efectos adversos sobre la salud (tales comoirritación e inflamación del sistema respiratorio, afecciones e insuficiencias pulmonares, alteración del metabolismo de las proteínas, dolor de cabeza oansiedad), sobre la biodiversidad, los suelos y los ecosistemas acuáticos y forestales (puede ocasionar daños a la vegetación, degradación de la clorofila, reducción de la fotosíntesis y la consiguiente pérdida de especies) e incluso sobre las edificaciones, a través de procesos de acidificación, pues una vez emitido, reacciona con el vapor de agua y con otros elementos presentes en la atmósfera, de modo que su oxidación en el aire da lugar a la formación de ácido sulfúrico. Además, también actúa como precursor de la formación de sulfato amónico, lo que incrementa los niveles de PM10 y PM2,5, con graves consecuencias igualmente sobre la salud.</p>
                                <h5 class="card-title text-dark">Valores recomendados por la OMS</h5>
                                <img src="../assets/azufregraf.png" class="img-responsive" alt="Image">
                            </div>
                        <div class="card-footer text-body-secondary"></div>  
                    </div>
                </div>
               
            </div>
        </div>     
    </body>
    <?php include("../template/pie.php"); ?>
</html>
