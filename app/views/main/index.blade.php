@extends('layouts.master')

@section('content')
<style>
.container {
padding-top: 10px;
}
.btn-xl {
    padding: 18px 28px;
    font-size: 40px; //change this to your desired size
    line-height: normal;
    -webkit-border-radius: 8px;
       -moz-border-radius: 8px;
            border-radius: 8px;
}

}
</style>
<div class="row">
    <div class="col-xs-3">
        <div class="row">
            <div class="col-md-12">
                <a href="#" class="btn btn-primary btn-xl" onClick="incrementSetPoint(); return false;"><i class="glyphicon glyphicon-arrow-up"></i></a>
            </div>
        </div>
         <div class="row">
             <div class="col-md-12">
                <h2><i id="currentSetPoint"></i>&deg; F</h2>
                <br/>
             </div>
         </div>
          <div class="row">
            <div class="col-md-12">
                <a href="#" class="btn btn-primary btn-xl" onClick="decrementSetPoint(); return false;"><i class="glyphicon glyphicon-arrow-down"></i></a>
            </div>
        </div>
    </div>
    <div class="col-xs-9">
        <div class="row">
            <div class="col-xs-10">
                <h4>Current Conditions</h4>

                <table class="table table-condensed">
                    <tr>
                        <td>Outside Temp:</td>
                        <td><span id="currentTemp"></span>&deg;</td>
                    </tr>
                    <tr>
                        <td> Chance of Precipitation:</td>
                        <td><span id="currentPrecip"></span>%</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong id="currentConditions"></strong></td>
                    </tr>
                </table>
            </div>

            <div class="col-xs-2">
                <canvas id="icon1" width="64" height="64" class="pull-right"></canvas>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <h4>Temperature</h4>
                <h2 id="houseTemp"><i id="localTemp"></i> &deg;</h2>
            </div>
            <div class="col-xs-6">
                <h4>Humidty</h4>
                <h2><i id="localHumidity"></i> %</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                Heating <i class="glyphicon glyphicon-fire"></i>
            </div>
        </div>
    </div>

</div>


<script>

var temperature;

    function getForecast() {

        $.getJSON('/forecast', function(data) {

            console.log(data);
            $("#currentTemp").html(data.currently.temperature);
            $("#currentPrecip").html(data.currently.precipProbability);
            $("#currentConditions").html(data.hourly.summary);

            var skycons = new Skycons({"color": "black"});
                  // on Android, a nasty hack is needed: {"resizeClear": true}
                  // ...or by the canvas DOM element itself.
                  skycons.add(document.getElementById("icon1"), data.currently.icon);

                  // if you're using the Forecast API, you can also supply
                  // strings: "partly-cloudy-day" or "rain".

                  // start animation!
                  skycons.play();

                  // you can also halt animation with skycons.pause()

        });
    }


    function currentSetPoint() {
        $.getJSON("/currentSetPoint", function(data) {
            temperature = data.currentSetPoint;

            $('#currentSetPoint').html(temperature);

        });

        $.getJSON('/currentLocal', function(data) {
            $('#localTemp').html(data.temperature);
            $('#localHumidity').html(data.humidity);
        });
    }

    function incrementSetPoint() {
        temperature++;
        $('#currentSetPoint').html(temperature);
        $.getJSON("/updateSetPoint/"+temperature);

        currentSetPoint();

    }

    function decrementSetPoint() {
        temperature--;
        $('#currentSetPoint').html(temperature);
        $.getJSON("/updateSetPoint/"+temperature );

        currentSetPoint();

    }

  $( document ).ready(function() {

        currentSetPoint();
        getForecast();
        window.setInterval(currentSetPoint, 15000);
        window.setInterval(getForecast, 10000);

  });



</script>

@stop