<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Orchestra\Parser\Xml\Facade as XmlParser;

if (file_exists('/home/ubuntu/application/app/Http/Controllers/sample.xml')) {
    $xml = simplexml_load_file('/home/ubuntu/application/app/Http/Controllers/sample.xml');
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
 
    //print_r($xml);
} else {
    exit('Failed to open sample.xml.');
}



class dummyAPI extends Controller
{
    //private $xml = simplexml_load_file('/');
    //private $json = json_encode($xml);
    //private 

    protected $xml;
    protected $json;
    protected $obj;
    protected $array;

    public function __construct()
    {
        $this->xml = file_get_contents('/home/ubuntu/application/app/Http/Controllers/sample.xml');   
        $this->obj = simplexml_load_string($this->xml);
        $this->json = json_encode($this->obj);
        $this->array = json_decode($this->json,TRUE);
            
    }
    
    public function getData()
    {
       return ["name"=>"iulia"];
    }
    
    public function postAllData() 
    {
        /*
        $xml = XmlParser::load('/home/ubuntu/application/app/Http/Controllers/sample.xml');
        $people = array();
        $person = $xml->parse([
            'id' => ['uses' => 'Person.id'],
            'Name' => ['uses' => 'Person.Name'],
            'Age' => ['uses' => 'Person.Age'],
            'Country' => ['uses' => 'Person.Country']
        ]);
        */
        
    
        // return $person;
        
        return $this->array['Person'];

        
    }

    function getAllData()
    {
        return $this->array['Person'];
    }

    function getSomeData($id)
    {
       
        return $this->array['Person'][$id-1];
    }

    function getByNumberPlate($noPlate)
    {   
        $len = count($this->array['Person']);
        $ok = false;

        //echo $noPlate;  

        //echo array_key_first($this->array['Person'][0]['Car']);   
        for($var = 0; $var < $len; $var++){

            
            if(array_key_exists('Car',$this->array['Person'][$var]))
            {   
                
                if(array_key_first($this->array['Person'][$var]['Car'])=="0")
                {
                    $lenCar = count($this->array['Person'][$var]['Car']);
                
                    if($lenCar>0)
                    {
                        for($i = 0; $i<$lenCar; $i++){

                            if($this->array['Person'][$var]['Car'][$i]['NumberPlate'] == $noPlate) {
                                $ok = true;
                                $searchedObj = new \stdClass();
                                $searchedObj->Color = $this->array['Person'][$var]['Car'][$i]['Color'];
                                $searchedObj->Type = $this->array['Person'][$var]['Car'][$i]['Type'];
                                $JSONObj = json_encode($searchedObj);
                                return $JSONObj;    
                            }
                        }
                    }

                }
                else {
                    if($this->array['Person'][$var]['Car']['NumberPlate'] == $noPlate) {
                        $ok = true;
                        $searchedObj = new \stdClass();
                        $searchedObj->Color = $this->array['Person'][$var]['Car']['Color'];
                        $searchedObj->Type = $this->array['Person'][$var]['Car']['Type'];
                        $JSONObj = json_encode($searchedObj);
                        return $JSONObj;    
                    }
                }
                    
            }
            
        }
       if($ok == false){
        abort(404, 'Car Not Found');
       }
        
        //return $result;

    }

    function getCarsByID($id)
    {   
        $len = count($this->array['Person']);
        $ok = 0;
        
        for($var = 0; $var < $len; $var++){
            if($var+1 == $id) {

                if(array_key_exists('Car',$this->array['Person'][$var]))
                {
                    if(array_key_first($this->array['Person'][$var]['Car'])=="0")
                    {
                        $lenCar = count($this->array['Person'][$var]['Car']);
                        if($lenCar>0)
                        {
                            $searchedCar = array();
                            for($i = 0; $i<$lenCar; $i++){
        
                                $searchedObj = new \stdClass();
                                $searchedObj->Color = $this->array['Person'][$var]['Car'][$i]['Color'];
                                $searchedObj->Type = $this->array['Person'][$var]['Car'][$i]['Type'];
                                
                                $searchedCar[] = $searchedObj;
                                
                            }
        
                            $JSONObj = json_encode($searchedCar);
                            return $JSONObj;   
                        }
                    }
                    else{
                        $searchedObj = new \stdClass();
                        $searchedObj->Color = $this->array['Person'][$var]['Car']['Color'];
                        $searchedObj->Type = $this->array['Person'][$var]['Car']['Type'];
                        $JSONObj = json_encode($searchedObj);
                        return $JSONObj;

                    }

                }
                else{

                    abort(404, 'Page Not Found');
                }

            }
               
        }

    }

    function getPersonByCar(){

        // We assume that the color is entered as follows: "green", not green -> so we delete the " "
        $color = request('color');
        $color = substr($color, 1); 
        $color = substr($color,0, -1); 
        $color = ucwords($color);

        $len = count($this->array['Person']);

        $searchedPeople = array();

        for($var = 0; $var < $len; $var++){

           
        
                if(array_key_exists('Car',$this->array['Person'][$var]))
                {
                    if(array_key_first($this->array['Person'][$var]['Car'])=="0")
                    {

                        $lenCar = count($this->array['Person'][$var]['Car']);
                        if($lenCar>0)
                        {
                            for($i = 0; $i<$lenCar; $i++){
                                
                                if($this->array['Person'][$var]['Car'][$i]['Color'] == $color)
                                {
                                    $searchedPeople[] = $this->array['Person'][$var]['Name'];
                                }
                                
                            }
          
                        }
                    }
                    else
                    {
        
                        if($this->array['Person'][$var]['Car']['Color'] == $color)
                        {
                            $searchedPeople[] = $this->array['Person'][$var]['Name'];
                        }  

                    }

                }
        }
        
        if(empty($searchedPeople))
        {
            abort(404, 'Page Not Found');
        }
        else 
        {
            $JSONObj = json_encode($searchedPeople);
            return $JSONObj;

        }     
               
    }  
    
    function getPersonsOlderThan()
    {
        $age = request('age');

        $len = count($this->array['Person']);

        $searchedPeople = array();

        for($var = 0; $var < $len; $var++){
            
            //echo $this->array['Person'][$var]['Age'];
            if($this->array['Person'][$var]['Age'] >= $age)
            {
                $searchedPeople[] = $this->array['Person'][$var]['Name'];
            }
        }
        
        if(empty($searchedPeople))
        {
            abort(404, 'Page Not Found');
        }
        else 
        {
            $JSONObj = json_encode($searchedPeople);
            return $JSONObj;

        }     

    }

    function getPersonsWithInsurance()
    {

        $len = count($this->array['Person']);

        $searchedPeople = array();

        for($var = 0; $var < $len; $var++)
        {

           
        
            if(array_key_exists('Car',$this->array['Person'][$var]))
            {
                if(array_key_first($this->array['Person'][$var]['Car'])=="0")
                {
                    $insuredcars = 0;
                    $lenCar = count($this->array['Person'][$var]['Car']);
                    if($lenCar>0)
                    {
                        for($i = 0; $i<$lenCar; $i++){
                            
                            if(array_key_exists('Insurance',$this->array['Person'][$var]['Car'][$i]))
                            {
                                $insuredcars++;
                            }
                            
                        }
      
                    }
                    if($insuredcars > 0)
                    {
                        $searchedPeople[] = $this->array['Person'][$var]['Name'];
                    }
                }
                else
                {
    
                    if(array_key_exists('Insurance',$this->array['Person'][$var]['Car']))
                    {
                        $searchedPeople[] = $this->array['Person'][$var]['Name'];   
                    }

                }

            }
        }
        
        if(empty($searchedPeople))
        {
            abort(404, 'Page Not Found');
        }
        else 
        {
            $JSONObj = json_encode($searchedPeople);
            return $JSONObj;

        }     



    }
        
        
}