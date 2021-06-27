<?php
class TaskException extends Exception{}

class Task{
    public $address;
    public $url;
    public $ch;
    public $curl;
    public $response;
    public $response_a;
    public $osmData = array();
    public $googleData = array();
   
    /**
     * Class constructor.
     */
    public function __construct($address)
    {
        $this->setAddress($address);
    }

    public function setAddress($address){
       if(($address==null)){
           throw new TaskException("Address cant be empty");
       }
       $this->address = $address;
    }
    public function getAddres(){
         return $this->address;
    }
    
    public function setOsmLat($lat, $lon){
         $this->osmData['lat'] = $lat;
         $this->osmData['lon'] = $lon;
    }

    public function getOsmLat(){
        return $this->osmData;
    }

    public function setGoogleData($lat,$lng)
    {   
      
        $this->googleData['lat'] = $lat;
        $this->googleData['lon'] = $lng;
    }

    public function getGoogleData(){
        return $this->googleData;
    }

    public function findOSMLatLongs(){
                /**
                 * OSM 
                 */
                $address = $this->getAddres();
                $this->url = "https://nominatim.openstreetmap.org/search?q={$address}&format=json&polygon=1&addressdetails=1";
                $this->userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2';
                $this->ch = curl_init();
                curl_setopt($this->ch, CURLOPT_USERAGENT,  $this->userAgent  );
                curl_setopt($this->ch, CURLOPT_REFERER, 'http://localhost/');
                curl_setopt($this->ch, CURLOPT_URL, $this->url);
                curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
                $this->response = curl_exec($this->ch);
                curl_close($this->ch);
                if ($this->response === false) 
                $this->response = curl_error($this->ch);
                stripslashes($this->response);
                $this->response_a = json_decode($this->response,true);
                if(!empty($this->response_a)){
                    foreach($this->response_a as $row){
                        $this->setOsmLat($row['lat'], $row['lon']);
                        break;
                    }
                }
    }

    public function findGoogleLatLongs(){
            /** Google Map */
            $address = $this->getAddres();
            $place=urlencode($address);

            $apiKey = 'AIzaSyCxswYL92ynAAjXwoe6Odqh-l81Er9CO4U';
            $url="https://maps.googleapis.com/maps/api/geocode/json?address={$place}&sensor=false&key={$apiKey}";
            $this->ch=curl_init();//initiating curl
            curl_setopt($this->ch,CURLOPT_URL,$url);// CALLING THE URL
            curl_setopt($this->ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($this->ch,CURLOPT_PROXYPORT,3128);
            curl_setopt($this->ch,CURLOPT_SSL_VERIFYHOST,0);
            curl_setopt($this->ch,CURLOPT_SSL_VERIFYPEER,0);
             $this->response=curl_exec($this->ch);
             $this->response=json_decode( $this->response);
            
            if(!empty( $this->response->results[0]->geometry->location->lat)){
              
                 $lat= $this->response->results[0]->geometry->location->lat;
                 $lng= $this->response->results[0]->geometry->location->lng; 
                $this->setGoogleData($lat,$lng);
            }
            
     }

    public function retrunOSMArray()
    {
        $this->findOSMLatLongs();
        $task = !empty($this->getOsmLat()) ? $this->getOsmLat(): null;
        return $task;
    }

    public function retrunGoogleArray()
    {
        $this->findGoogleLatLongs();
           $google = !empty($this->getGoogleData()) ? $this->getGoogleData(): null;
        return $google;
        ;
    }

}