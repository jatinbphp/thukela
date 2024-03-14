<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);

        //$url = 'https://akim.pnpscada.com:441/getMemH.jsp?LOGIN='.$request['username'].'&PWD='.$request['password'];
        $url = 'https://thukela-kadesh.pnpscada.com/getMemH.jsp?LOGIN=thukela.'.$request['username'].'&PWD='.$request['password'];
        $result = $this->getCurl($url);
        $apiResponse = json_decode($result['response']);

        if(!empty($apiResponse) && $apiResponse[0] != 'error'){
                $data['username'] = $request['username'];
                $data['password'] = Crypt::encryptString($request['password']);     //encoded password
                $data['memh'] = $apiResponse[0];
                $data['roleid'] = $apiResponse[1];
                $data['rolename'] = $apiResponse[2];
                $data['fullogin'] = $apiResponse[3];
                $data['organizationname'] = $apiResponse[4];
                Session::put('loginData',$data);
                return redirect(route('user.provisionalbill'));
        }else{
            \Session::flash('danger','Username or Password are incorrect. Please try again!');
            return redirect()->back();
        }
    }

    public function dashboard(){
        if(Session::has('loginData')){
            $data['menu'] = 'Dashboard';
            $data['loginData'] = Session::get('loginData');
            $password = Crypt::decryptString($data['loginData']['password']);

            $url = 'https://akim.pnpscada.com:441/getEntitiesDetails.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password;
            //$url = 'https://thukela-kadesh.pnpscada.com/getEntitiesDetails.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password;
            $result = $this->getCurl($url,'xml');
            $xmlArray = simplexml_load_string($result['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $jsonData = json_encode($xmlArray);
            $arrayData = json_decode($jsonData, true);
            $key1 = $arrayData['entity']['meters']['meter']['key1'];
            $data['name'] = !empty($arrayData['entity']['name']) ? $arrayData['entity']['name'] : '';
            $data['ledger'] = $data['loginData']['rolename'];
            $beneficiary = !empty($arrayData['entity'][1]['name']) ? explode(';', $arrayData['entity'][1]['name']) : [];
            $data['beneficiary'] = $beneficiary[1];
            $data['balance'] = $arrayData['entity'][1]['balance'] > 0 ? $arrayData['entity'][1]['balance'] / 100000 : 0;
            return view('dashboard',$data);
        }else{
            return redirect(route('user.signIn'));
        }
    }

    public function transactions(Request $request){
        if(Session::has('loginData')){
            $data['menu'] = 'Transactions';
            $data['loginData'] = Session::get('loginData');
            $password = Crypt::decryptString($data['loginData']['password']);
            //$url = 'https://akim.pnpscada.com:441/getEntitiesDetails.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password;
            $url = 'https://thukela-kadesh.pnpscada.com/getEntitiesDetails.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password;
            $result = $this->getCurl($url,'xml');
            $xmlArray = simplexml_load_string($result['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $jsonData = json_encode($xmlArray);
            $arrayData = json_decode($jsonData, true);
            //$eId = $arrayData['entity'][1]['eid'];
            $eId = $arrayData['entity']['id'];

            $sDate = isset($request['startDate']) && !empty($request['startDate']) ? $request['startDate'] : Carbon::now()->subDay(34)->format('Y-m-d');
            $eDate = isset($request['endDate']) && !empty($request['endDate']) ? $request['endDate'] : Carbon::now()->addDay(1)->format('Y-m-d');

            //$url1 = 'https://akim.pnpscada.com:441/getLedger.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&eid='.$eId.'&startdate='.$sDate.'&enddate='.$eDate;
            $url1 = 'https://thukela-kadesh.pnpscada.com/getLedger.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&eid='.$eId.'&startdate='.$sDate.'&enddate='.$eDate;
            $result1 = $this->getCurl($url1,'xml');
            $transactionsArray = simplexml_load_string($result1['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $jsonTransactions = json_encode($transactionsArray);
            $data['transactionsData'] = json_decode($jsonTransactions, true);
            $data['transactions'] = [];
            if(!empty($data['transactionsData']['transactions']['transactionlog']['transaction']) && count($data['transactionsData']['transactions']['transactionlog']['transaction']) > 0){
                $data['transactions'] = array_reverse($data['transactionsData']['transactions']['transactionlog']['transaction']);
            }
            $data['startDate'] = $request['startDate'];
            $data['endDate'] = $request['endDate'];
            return view('transactions',$data);
        }else{
            return redirect(route('user.signIn'));
        }
    }

    public function notifications(){
        if(Session::has('loginData')){
            $data['menu'] = 'Notifications';
            $url = 'http://ronmarkapp.co.za/admin/notifications.php';
            $result = $this->getCurl($url,'json');
            $notifications = json_decode($result['response']);
            $data['notifications'] = $notifications->data;
            return view('notifications',$data);
        }else{
            return redirect(route('user.signIn'));
        }
    }

    public function contactUs(){
        if(Session::has('loginData')){
            $data['menu'] = 'Contact Us';
            return view('contactUs',$data);
        }else{
            return redirect(route('user.signIn'));
        }
    }

    public function  sendContactUs(Request $request){
        $url = 'http://ronmarkapp.co.za/admin/contactus.php';
        $data = [
            'buildingname' => $request['buildingname'],
            'flatnumber' => $request['flatnumber'],
            'phonenumber' => $request['phonenumber'],
            'message' => $request['message'],
        ];
        $result = $this->postCurl($url,$data);
        $result = json_decode($result['response']);
        if($result->status == 1){
            \Session::flash('success','Message send successfully.');
        }else{
            \Session::flash('danger','Something is wrong. Please try again!');
        }
        return redirect()->back();
    }

    public function provisionalBill_new(){
        if(Session::has('loginData')){
            $data['menu'] = 'Provisional Bill';
            $data['loginData'] = Session::get('loginData');
            $password = Crypt::decryptString($data['loginData']['password']);
            $userName = $data['loginData']['username'];
            $roleEid = $data['loginData']['roleid'];

            //$url = 'https://akim.pnpscada.com:441/getEntitiesDetails.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password;
            $url = 'https://thukela-kadesh.pnpscada.com/getEntitiesDetails.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password;
            $result = $this->getCurl($url,'xml');
            $xmlArray = simplexml_load_string($result['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $jsonData = json_encode($xmlArray);
            $arrayData = json_decode($jsonData, true);
            /*$eId = $arrayData['entity'][0]['id'];
            $mEId = $arrayData['entity'][0]['meters']['meter']['key1'];*/
            $eId = $arrayData['entity']['id'];
            $mEId = $arrayData['entity']['meters']['meter']['key1'];

            $sDate = Carbon::now()->subDay(7)->format('Y-m-d');
            $eDate = Carbon::now()->addDay(1)->format('Y-m-d');

            //$url2 = 'https://akim.pnpscada.com:441/getProvisionalBill.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&key1='.$eId.'&startdate='.$sDate.'&enddate='.$eDate;
            $url2 = 'https://thukela-kadesh.pnpscada.com/getProvisionalBill.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&key1='.$eId.'&startdate='.$sDate.'&enddate='.$eDate;
            $result2 = $this->getCurl($url2,'xml');
            $xmlArray2 = simplexml_load_string($result2['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $jsonData2 = json_encode($xmlArray2);
            $data['provisionalBill'] = json_decode($jsonData2, true);

            //$chartEId = $arrayData['entity'][0]['eid'];
            $chartEId = $arrayData['entity']['eid'];
            //$chartUrl = 'https://akim.pnpscada.com:441/getMeterAccountProfile.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&eid='.$chartEId.'&start='.$sDate.'&end='.$eDate;
            $chartUrl = 'https://thukela-kadesh.pnpscada.com/getMeterAccountProfile.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&eid='.$chartEId.'&start='.$sDate.'&end='.$eDate;

            $chartResult = $this->getCurl($chartUrl,'xml');
            $chartXmlArray = simplexml_load_string($chartResult['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $chartjsonData = json_encode($chartXmlArray);
            $chartData = json_decode($chartjsonData, true);
            $readingArr = $chartData['meter_account']['profile']['sample'];

            $dateArr = [];
            $period = CarbonPeriod::create($sDate, $eDate);
            foreach ($period as $date) {
                $dateArr[] =  $date->format('D').' '.$date->format( 'd/m/Y');
            }

            array_pop($dateArr);
            $weekDate = json_encode($dateArr);

            $chartTime = [];
            $readingData = [];
            $mainData = [];

            for($i=0; $i<=23; $i++){
                $time = $i.':00';
                array_push($chartTime,date('H:i',strtotime($time)));
                $time = $i.':30';
                array_push($chartTime,date('H:i',strtotime($time)));
            }

            if(count($data['provisionalBill']['bill']['li']) > 0){
                foreach ($data['provisionalBill']['bill']['li'] as $key => $proBill){
                    $readingData[] = [
                        'label' => $proBill['tname'],
                        'backgroundColor' => '#7F7F05',
                        'borderColor' => '#7F7F05',
                        'borderWidth' => 1,
                        'borderSkipped' => true,
                        'barThickness' => 15,
                        'maxBarThickness' => 20,
                        'minBarLength' => 2,
                        'data' => [],
                    ];
                }
            }

            //return $readingArr;
            $allDates = json_decode($weekDate);

            if(count($readingData) > 0){
                foreach ($allDates as $wDate){
                    foreach ($readingData as $key => $val){
                        $dArr = explode(' ',$wDate);
                        $carbonDate = Carbon::createFromFormat('d/m/Y', $dArr[1]);
                        $nDate = $carbonDate->format('Y-m-d');
                        if(count($readingArr) > 0) {
                            $rData = [];
                            foreach ($readingArr as $list) {
                                $readingDate = explode(' ',$list['date']);
                                $time = date('H:i', strtotime($readingDate[1]));
                                //return $nDate.'--------------'.$readingDate[0];
                                if($nDate == $readingDate[0]){
//                                    echo '<pre>';
//                                    echo number_format($list['P1'],2);
                                    array_push($readingData[$key]['data'],number_format($list['P1'],2));
                                }
                            }
                        }
                    }
                }
            }

            //return $readingData;

            $data['readingData'] = json_encode($readingData);
            $data['chartDates'] = $weekDate;
            return view ('provisionalbill',$data);
        }else{
            return redirect(route('user.signIn'));
        }
    }

    public function provisionalBill(Request $request){
        if(Session::has('loginData')){
            $data['menu'] = 'Provisional Bill';
            $data['loginData'] = Session::get('loginData');
            $password = Crypt::decryptString($data['loginData']['password']);
            $userName = $data['loginData']['username'];
            $roleEid = $data['loginData']['roleid'];

            //$url = 'https://akim.pnpscada.com:441/getEntitiesDetails.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password;
            $url = 'https://thukela-kadesh.pnpscada.com/getEntitiesDetails.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password;
            $result = $this->getCurl($url,'xml');
            $xmlArray = simplexml_load_string($result['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $jsonData = json_encode($xmlArray);
            $arrayData = json_decode($jsonData, true);
            /*$eId = $arrayData['entity'][0]['id'];
            $mEId = $arrayData['entity'][0]['meters']['meter']['key1'];*/
            $eId = $arrayData['entity']['id'];
            $mEId = $arrayData['entity']['meters']['meter']['key1'];

            $sDate = isset($request['sDate']) && !empty($request['sDate']) ? $request['sDate'] : Carbon::now()->subDay(7)->format('Y-m-d');
            $eDate = isset($request['eDate']) && !empty($request['eDate']) ? $request['eDate'] : Carbon::now()->addDay(1)->format('Y-m-d');

            //$url2 = 'https://akim.pnpscada.com:441/getProvisionalBill.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&key1='.$eId.'&startdate='.$sDate.'&enddate='.$eDate;
            $url2 = 'https://thukela-kadesh.pnpscada.com/getProvisionalBill.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&key1='.$eId.'&startdate='.$sDate.'&enddate='.$eDate;
            $result2 = $this->getCurl($url2,'xml');
            $xmlArray2 = simplexml_load_string($result2['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $jsonData2 = json_encode($xmlArray2);
            $data['provisionalBill'] = json_decode($jsonData2, true);

            //$chartEId = $arrayData['entity'][0]['eid'];
            $chartEId = $arrayData['entity']['eid'];
            //$chartUrl = 'https://akim.pnpscada.com:441/getMeterAccountProfile.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&eid='.$chartEId.'&start='.$sDate.'&end='.$eDate;
            $chartUrl = 'https://thukela-kadesh.pnpscada.com/getMeterAccountProfile.jsp?LOGIN='.$data['loginData']['fullogin'].'&PWD='.$password.'&eid='.$chartEId.'&start='.$sDate.'&end='.$eDate;

            $chartResult = $this->getCurl($chartUrl,'xml');
            $chartXmlArray = simplexml_load_string($chartResult['response'], 'SimpleXMLElement', LIBXML_NOCDATA);
            $chartjsonData = json_encode($chartXmlArray);
            $chartData = json_decode($chartjsonData, true);
            $readingArr = $chartData['meter_account']['profile']['sample'];

            $dateArr = [];
            $period = CarbonPeriod::create($sDate, $eDate);
            foreach ($period as $date) {
                $dateArr[] =  $date->format('D').' '.$date->format('d/m/Y');
            }

            $chartTime = [];
            $readingData = [];

            for($i=0; $i<=23; $i++){
                $time = $i.':00';
                array_push($chartTime,date('H:i',strtotime($time)));
                $time = $i.':30';
                array_push($chartTime,date('H:i',strtotime($time)));
            }

            if(count($chartTime) > 0){
                foreach ($chartTime as $tList){
                    $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    $readingData[] = [
                        'label' => $tList,
                        /*'backgroundColor' => '#7F7F05',
                        'borderColor' => '#7F7F05',*/
                        'backgroundColor' => '#ffffff',
                        'borderColor' => '#ffffff',
                    ];
                }
            }

            if(count($readingData) > 0){
                foreach ($readingData as $key => $val){
                    if(count($readingArr) > 0){
                        $rData = [];
                        foreach ($readingArr as $list){
                            $readingDate = explode(' ',$list['date']);
                            $readingTime = date('i',strtotime($readingDate[1]));
                            $time = date('H:i', strtotime($readingDate[1]));
                            if($time == $val['label']){
                                array_push($rData,number_format($list['P1'],2));
                            }
                        }
                        $readingData[$key]['data'] = $rData;
                    }
                }
            }

            array_pop($dateArr);
            $data['readingData'] = json_encode($readingData);
            $data['chartDates'] = json_encode($dateArr);
            return view ('provisionalbill',$data);
        }else{
            return redirect(route('user.signIn'));
        }
    }

    public function logout(){
        Session::flash('loginData');
        return redirect(route('user.signIn'));
    }
}
