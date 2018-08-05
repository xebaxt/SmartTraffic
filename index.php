

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Traffic Smart</title>
    <header name = "Access-Control-Allow-Origin" value = "*" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  </head>
  <body>

      <button onClick="actualizar()">Consultar Trafico</button><br><br>

    <form action = "conexion.php" method="post">
      Via 1: <input id = "calle_a" readonly></input> Indice de congestión: <input id = "indice_a" name = "vel_a" readonly></input><br>
      Via 2: <input id = "calle_b" readonly></input> Indice de congestión: <input id = "indice_b" name = "vel_b" readonly></input><br>
      <br><button type= "submit">Enviar</button>
    </form>
 
<script type="text/javascript">
function actualizar(){
  jQuery.when(
      jQuery.getJSON('https://traffic.cit.api.here.com/traffic/6.1/flow.json?prox=51.5072%2C-0.1275%2C1&app_id=eHZJwXpAC3JGwECHj1p5&app_code=mWplzG-JAvlGHew4neMbkg')
  ).done( function(json) {
      var calle_a = 'SOHO';
      var calle_b = 'TRAFALGAR SQUARE';
      var indice_congestion_a = 0;
      var indice_congestion_b = 0;
      var array = json.RWS[0].RW;
      for (var i = 0; i < array.length; i++){
        var tramo =  array[i].FIS[0].FI;
        if (tramo[0].TMC.DE == calle_a){
          indice_congestion_a = tramo[0].CF[0].JF;
        }
        if (tramo[0].TMC.DE == calle_b){
          indice_congestion_b = tramo[0].CF[0].JF;
        }
      }
      /*
      if (indice_congestion_a > indice_congestion_b){
        indice_congestion_a = 90;
        indice_congestion_b = 60;
      }else{
        indice_congestion_a = 60;
        indice_congestion_b = 90;
      }*/
      document.getElementById("calle_a").value = calle_a;
      document.getElementById("indice_a").value = indice_congestion_a;
      document.getElementById("calle_b").value = calle_b;
      document.getElementById("indice_b").value = indice_congestion_b;
  });
}



</script>




  </body>
</html>