<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use Auth;
use voku\helper\HtmlDomParser;

use App\Models\EspData;


class EspController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        dd($request->input());

        $api_key_value = "4TOc7~@b";
        $api_key= $SensorData = $LocationData = $value1 = $value2 = $value3 = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $api_key = test_input($_POST["api_key"]);
            if($api_key == $api_key_value) {
                $SensorData = test_input($_POST["SensorData"]);
                $LocationData = test_input($_POST["LocationData"]);
                $value1 = test_input($_POST["value1"]);
                $value2 = test_input($_POST["value2"]);
                $value3 = test_input($_POST["value3"]);
                
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                
                $sql = "INSERT INTO esp_data (SensorData, LocationData, value1, value2, value3)
                VALUES ('" . $SensorData . "', '" . $LocationData . "', '" . $value1 . "', '" . $value2 . "', '" . $value3 . "')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            
                $conn->close();
            }
            else {
                echo "Wrong API Key";
            }

        }
        else {
            echo "No data posted HTTP POST.";
        }

        $espDataObj = EspData::all();

        //dd($espDataObj);
        return view('espData.index',compact(
                                        'espDataObj'
                                        ));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $api_key_value = "4TOc7~@b";
        $api_key= $SensorData = $LocationData = $value1 = $value2 = $value3 = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $api_key = test_input($_POST["api_key"]);
            if($api_key == $api_key_value) {
                $SensorData = test_input($_POST["SensorData"]);
                $LocationData = test_input($_POST["LocationData"]);
                $value1 = test_input($_POST["value1"]);
                $value2 = test_input($_POST["value2"]);
                $value3 = test_input($_POST["value3"]);
                
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                } 
                
                $sql = "INSERT INTO esp_data (SensorData, LocationData, value1, value2, value3)
                VALUES ('" . $SensorData . "', '" . $LocationData . "', '" . $value1 . "', '" . $value2 . "', '" . $value3 . "')";
                
                if ($conn->query($sql) === TRUE) {
                    echo "New record created successfully";
                } 
                else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            
                $conn->close();
            }
            else {
                echo "Wrong API Key";
            }

        }
        else {
            echo "No data posted HTTP POST.";
        }

        return view('espData.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
