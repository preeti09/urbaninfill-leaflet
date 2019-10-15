<?php

namespace App\Http\Controllers;
use App\User;
use App\Properties;
use Auth;
use Illuminate\Http\Request;
use DateTime;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {   
        
        if ($request->user()->authorizeRoles(['user'])) {
            $Currentuser = User::find($request->user()->id);
            $TimediffFormated = null;

            if(!$Currentuser->IsHistoricRest) {

                $date1 = new DateTime("now");
                $getTime = strtotime($Currentuser->HistoricFirstDate . " + " . $request->user()->Historicresttime . " days");
                $time = date("Y-m-d H:i:s", $getTime);
                $date2 = new DateTime($time);
                $interval = date_diff($date1, $date2);
                $TimediffFormated = $interval->format('%a days %h hours %i Mins %s Sec remaining');
                if($date1 > $date2)
                {
                    $Currentuser->HistoricFirstDate = null;
                    $Currentuser->IsHistoricRest = true;
                    $Currentuser->Historicsavedcount =$Currentuser->HistoricTotalSaveCount;
                    $Currentuser->save();
                    $Currentuser = User::find($request->user()->id);
                }
            }

            return view('Lot')->with("Rcout",$Currentuser->Historicsavedcount)->with('timeExceed',$TimediffFormated);
        }else
            return redirect('/logout');
    }

    //Added by Bhavana
    public function NewApi(){
        // dd("hello");
       return view('new_api_leaflet');
        
    }

    //(Bhavana )testing function
    public function test(){
        $curl = curl_init(); 
        $lat = 30.6434221;
        $long = -81.53879419999998;
        $postalcode = 97217; //32097;
        $geo_key = "SB0000078833";
        $polys = [];
        $attomId = "158655748";
        /*curl_setopt_array($curl, array( 
            // CURLOPT_URL => "https://api.gateway.attomdata.com/areaapi/v2.0.0/boundary/detail?AreaId=".$geo_key,
            // CURLOPT_URL => "https://api.gateway.attomdata.com/areaapi/v2.0.0/hierarchy/lookup?latitude=" . $lat . "&longitude=" . $long,
            // CURLOPT_URL => "https://api.gateway.attomdata.com/propertyapi/v1.0.0/assessment/detail?postalcode=" . $postalcode,
            CURLOPT_URL => "https://api.gateway.attomdata.com/propertyapi/v1.0.0/property/detail?attomId=" .$attomId,
            // CURLOPT_URL => "https://api.gateway.attomdata.com/propertyapi/v1.0.0/property/snapshot?postalcode=".$postalcode,
            // CURLOPT_URL => "https://api.gateway.attomdata.com/propertyapi/v1.0.0/property/detail?address=Portland%2C%20OR%2097217%2C%20USA",
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => "", 
            CURLOPT_MAXREDIRS => 10, 
            CURLOPT_TIMEOUT => 30, 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => array( 
                "accept: application/json", 
                "apikey: e702e26e93b183f8d1dfd7ba9dc05390", 
            ), 
        )); 
        $response = curl_exec($curl); 
        dd($response);
        $err = curl_error($curl); 
        curl_close($curl); 
        if ($err) { 
            dd("cURL Error #:" . $err); 
        } else { */
            // $lat = -71.577620;
            /*$longi = 41.66895;
            $data = json_decode($response);
            if(isset($data->response)){
                $polys = $data->response->result->package->item;
            }else{
                $polys = array();
            }*/
            // $polys = $data->property[0]->location;
              
            /*$lat = $polys->latitude;
            $long = $polys->longitude;
            $geoId = $polys->geoid;
            $polys = $data->response->result->package->item; */
            return view('test_area',compact('lat','long','polys','geoId'));
        // }
        
    }

    //(Bhavana )testing function
    public function getGeoKey(Request $request){
        $geo_key = array();
        $geo_key= explode(',', $request->input('geoId'));
        // dd($geo_key);
        $wkt = array();
        foreach($geo_key as $areaid){
            $curl = curl_init(); 
            curl_setopt_array($curl, array( 
                CURLOPT_URL => "https://api.gateway.attomdata.com/areaapi/v2.0.0/boundary/detail?AreaId=" . $areaid . "&debug=True",
                CURLOPT_RETURNTRANSFER => true, 
                CURLOPT_ENCODING => "", 
                CURLOPT_MAXREDIRS => 10, 
                CURLOPT_TIMEOUT => 30, 
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
                CURLOPT_CUSTOMREQUEST => "GET", 
                CURLOPT_HTTPHEADER => array( 
                    "accept: application/json", 
                    "apikey: 736f1130096aa92549d800921bca8e8c", 
                ), 
            )); 
            $responseee = curl_exec($curl); 
            $data = json_decode($responseee);
            // dd($data->response->result->package->item[0]->boundary);
            $err = curl_error($curl); 
            curl_close($curl); 
            if ($err) { 
                echo "cURL Error #:" . $err; 
            } else { 
                // var_dump($data);
                if($data != null)
                    $wkt[] = $data->response->result->package->item[0]->boundary;
                
                
            }
            }
            // dd("ddd");
            return response($wkt); 
       
    }
    //(Bhavana )testing function
    public function responseAjax(){
        $curl = curl_init(); 
        
        curl_setopt_array($curl, array( 
            CURLOPT_URL => "https://api.gateway.attomdata.com/areaapi/v2.0.0/hierarchy/lookup?latitude=39.296864&longitude=-75.613574",
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => "", 
            CURLOPT_MAXREDIRS => 10, 
            CURLOPT_TIMEOUT => 30, 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => array( 
                "accept: application/json", 
                "apikey: 736f1130096aa92549d800921bca8e8c", 
            ), 
        )); 
        $response = curl_exec($curl); 
       
        $err = curl_error($curl); 
        curl_close($curl); 
        if ($err) { 
            echo "cURL Error #:" . $err; 
        } else { 
            $lat = -71.577620;
            $longi = 41.66895;
            $data = json_decode($response);
            $geoARRAY = array();
            $geoValName = array();
            // dd($data->response->result->package->item);
            $areaHiracy = $data->response->result->package->item;
            foreach ($areaHiracy as $key => $area) {
                $geoARRAY[] = $area->geo_key;
                $geoValName[$area->geo_key] = $area->name;
            }
            $boundary = $this->getAreadBound($geoARRAY[0]);
            return response($boundary['response']['result']['package']['item'][0]['boundary']); 
            
        }
    }

    //(Bhavana )testing function
    public function getAreadBound($areaid){
        $curl = curl_init(); 
        
        curl_setopt_array($curl, array( 
            CURLOPT_URL => "https://api.gateway.attomdata.com/areaapi/v2.0.0/boundary/detail?AreaId=" . $areaid . '&debug=True',
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_ENCODING => "", 
            CURLOPT_MAXREDIRS => 10, 
            CURLOPT_TIMEOUT => 30, 
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1, 
            CURLOPT_CUSTOMREQUEST => "GET", 
            CURLOPT_HTTPHEADER => array( 
                "accept: application/json", 
                "apikey: 736f1130096aa92549d800921bca8e8c", 
            ), 
        )); 
        $response = curl_exec($curl); 
       
        $err = curl_error($curl); 
        curl_close($curl); 
        if ($err) { 
            echo "cURL Error #:" . $err; 
        }else{
            return json_decode($response,200);
        }
        
    }

    public function home(Request $request)
    {
        if ($request->user()->authorizeRoles(['user'])) {
            $Currentuser = User::find($request->user()->id);
            $TimediffFormated = null;
            // dd(!$Currentuser->IsHistoricRest);
            if($Currentuser->IsHistoricRest) {
                $date1 = new DateTime("now");
                $getTime = strtotime($Currentuser->HistoricFirstDate . " + " . $request->user()->Historicresttime . " days");
                $time = date("Y-m-d H:i:s", $getTime);
                $date2 = new DateTime($time);
                $interval = date_diff($date1, $date2);
                $TimediffFormated = $interval->format('%a days %h hours %i Mins %s Sec remaining');
               
                if($date1 > $date2)
                {
                    $Currentuser->HistoricFirstDate = null;
                    $Currentuser->IsHistoricRest = true;
                    $Currentuser->Historicsavedcount =$Currentuser->HistoricTotalSaveCount;
                    $Currentuser->save();
                    $Currentuser = User::find($request->user()->id);
                }
            }


            return view('Lot')->with("Rcout",$Currentuser->Historicsavedcount)->with('timeExceed',$TimediffFormated);
        }else
            return redirect('/logout');
    }

    //(Bhavana )testing function
    public function myTest(Request $request)
    {
        if ($request->user()->authorizeRoles(['user'])) {
            $Currentuser = User::find($request->user()->id);
            $TimediffFormated = null;
            // dd(!$Currentuser->IsHistoricRest);
            if($Currentuser->IsHistoricRest) {
                $date1 = new DateTime("now");
                $getTime = strtotime($Currentuser->HistoricFirstDate . " + " . $request->user()->Historicresttime . " days");
                $time = date("Y-m-d H:i:s", $getTime);
                $date2 = new DateTime($time);
                $interval = date_diff($date1, $date2);
                $TimediffFormated = $interval->format('%a days %h hours %i Mins %s Sec remaining');
               
                if($date1 > $date2)
                {
                    $Currentuser->HistoricFirstDate = null;
                    $Currentuser->IsHistoricRest = true;
                    $Currentuser->Historicsavedcount =$Currentuser->HistoricTotalSaveCount;
                    $Currentuser->save();
                    $Currentuser = User::find($request->user()->id);
                }
            }


            return view('demo')->with("Rcout",$Currentuser->Historicsavedcount)->with('timeExceed',$TimediffFormated);
        }else
            return redirect('/logout');
    }

    public function homehpl2(Request $request)
    {
        if ($request->user()->authorizeRoles(['user'])) {
            $Currentuser = User::find($request->user()->id);
            $TimediffFormated = null;
            if(!$Currentuser->IsHistoricRest) {
                $date1 = new DateTime("now");
                $getTime = strtotime($Currentuser->HistoricFirstDate . " + " . $request->user()->Historicresttime . " days");
                $time = date("Y-m-d H:i:s", $getTime);
                $date2 = new DateTime($time);
                $interval = date_diff($date1, $date2);
                $TimediffFormated = $interval->format('%a days %h hours %i Mins %s Sec remaining');
                if($date1 > $date2)
                {
                    $Currentuser->HistoricFirstDate = null;
                    $Currentuser->IsHistoricRest = true;
                    $Currentuser->Historicsavedcount =$Currentuser->HistoricTotalSaveCount;
                    $Currentuser->save();
                    $Currentuser = User::find($request->user()->id);
                }
            }


            return view('Lothpl2')->with("Rcout",$Currentuser->Historicsavedcount)->with('timeExceed',$TimediffFormated);
        }else
            return redirect('/logout');
    }

    public function location(Request $request)
    {

        if ($request->user()->authorizeRoles(['user'])) {

            $Currentuser = User::find($request->user()->id);
            $TimediffFormated = null;
            if(!$Currentuser->IsAddressRest) {
                $date1 = new DateTime("now");
                $getTime = strtotime($Currentuser->AddressFirstDate . " + " . $request->user()->Addressresttime . " days");
                $time = date("Y-m-d H:i:s", $getTime);
                $date2 = new DateTime($time);
                $interval = date_diff($date1, $date2);
                $TimediffFormated = $interval->format('%a days %h hours %i Mins %s Sec remaining');
                if($date1 > $date2)
                {
                    $Currentuser->AddressFirstDate = null;
                    $Currentuser->IsAddressRest = true;
                    $Currentuser->Addresssavedcount =$Currentuser->AddressTotalSaveCount;
                    $Currentuser->save();
                    $Currentuser = User::find($request->user()->id);
                }
            }
            return view('location')->with("Rcout",$Currentuser->Addresssavedcount)->with('timeExceed',$TimediffFormated);
        }else
            return  redirect('/logout');
    }

    public function VacantProperties(Request $request)
    {
        if ($request->user()->authorizeRoles(['user'])) {

            $Currentuser = User::find($request->user()->id);
            $TimediffFormated = null;
            if(!$Currentuser->IsVacantRest) {
                $date1 = new DateTime("now");
                $getTime = strtotime($Currentuser->VacantFirstDate . " + " . $request->user()->Vacantresttime . " days");
                $time = date("Y-m-d H:i:s", $getTime);
                $date2 = new DateTime($time);
                $interval = date_diff($date1, $date2);
                $TimediffFormated = $interval->format('%a days %h hours %i Mins %s Sec remaining');
                if($date1 > $date2)
                {
                    $Currentuser->VacantFirstDate = null;
                    $Currentuser->IsVacantRest = true;
                    $Currentuser->Vacantsavedcount =$Currentuser->VacantTotalSaveCount;
                    $Currentuser->save();
                    $Currentuser = User::find($request->user()->id);
                }
            }
            return view('VacantProperties')->with("Rcout",$Currentuser->Vacantsavedcount)->with('timeExceed',$TimediffFormated);
        }else
            return redirect('/logout');
    }
    public function ShowSave(Request $request)
    {
        if ($request->user()->authorizeRoles(['user'])) {

            $Currentuser = User::find($request->user()->id);
            $TimediffFormated = null;
            if(!$Currentuser->IsSavedPropertyRest) {
                $date1 = new DateTime("now");
                $getTime = strtotime($Currentuser->SavedPropertyFirstDate . " + " . $request->user()->resttime . " days");
                $time = date("Y-m-d H:i:s", $getTime);
                $date2 = new DateTime($time);
                $interval = date_diff($date1, $date2);
                $TimediffFormated = $interval->format('%a days %h hours %i Mins %s Sec remaining');

                if ($date1 > $date2) {
                    $Currentuser->SavedPropertyFirstDate = null;
                    $Currentuser->IsSavedPropertyRest = true;
                    $Currentuser->savedcount = $Currentuser->TotalSaveCount;
                    $Currentuser->save();
                    $Currentuser = User::find($request->user()->id);
                }
            }
            $propertiesList = $Currentuser->properties->sortByDesc(function($col)
            {
                return $col;
            })->values()->all();
            return view('SaveProperties')->with('propertiesList',$propertiesList)->with("Rcout",$Currentuser->savedcount)->with('timeExceed',$TimediffFormated);
        }
        else
            return redirect('/logout');
    }
    public function person(Request $request)
    {
        if ($request->user()->authorizeRoles(['user'])) {
            return view('personsearch');
        }
        else
            return redirect('/logout');
    }
    public function deletesaveproperty(Request $request,$id)
    {
        if ($request->user()->authorizeRoles(['user'])) {
            $property = Properties::find($id);
            $property->delete();
            return redirect('/savedproperties');
        }
        else
            return redirect('/logout');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

}
