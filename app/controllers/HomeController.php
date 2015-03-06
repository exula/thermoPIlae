<?php

class HomeController extends BaseController {

	public function index() {


        return View::make('main.index');
    }

    public function currentLocal() {

        if(is_file('/tmp/currentReading')) {

            $data = file_get_contents('/tmp/currentReading');

            preg_match("/Humidity = (.*) % Temperature = (.*) \*C/",$data,$matches);

            $humidity = (float) $matches[1];
            $temperature = (float) ($matches[2]*1.8)+32; // Convert to Farenheiht

            return Response::json(array("humidity" => $humidity,"temperature"=>$temperature));
        } else {
            return Reponse::json(array("error" => "No data"));
        }
    }

    public function currentSetPoint()
    {
        //Default temperature
        $default = 60;

        $max = 80;
        $min = 60;

        if(Cache::has('currentSetPoint')) {
             $point = Cache::get('currentSetPoint');
        } else {
            Cache::put('currentSetPoint',$default,0);
            $point = $default;

        }

        if($point > $max) {
            $point = $max;
        }

        if($point < $min) {
            $point = $min;
        }

        return Response::json(array('currentSetPoint' => $point));

    }

    public function updateSetPoint($temperature)
    {
        Cache::put('currentSetPoint',$temperature,0);
    }


	public function showWelcome()
	{
		return View::make('hello');
	}

}
