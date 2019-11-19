<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: POST, GET");

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';


class Auth extends REST_Controller
{
    public function __construct() { 
        parent::__construct();
		$this->load->model('Ws/M_Ws');
    }
	
    public function login_post()
    {
		//$pswd=md5($this->input->post("psw"));
		$message="Unauthorised";//+$pswd;
		
		$data = $this->M_Ws->Validar_User();
		
		if($data['res'] == 'OK'){
			$tokenData = array();
			$tokenData['id'] = $data['id_user'];//DATO PARA ARMAR UN TOKEN
			$output['token'] = AUTHORIZATION::generateToken($tokenData);
			$output['responsedata'] = $data;
			$output['res'] = $data['res'];
			$this->set_response($output, REST_Controller::HTTP_OK);
		}else{
			
			$this->set_response(array('res'=>$message), REST_Controller::HTTP_UNAUTHORIZED);
		}
       //,'password'=>$data['Password'] 
    }

    public function orders_post()
    {
        $headers = $this->input->request_headers();
       
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
		
            if ($decodedToken != false) {
				$response = (object) array('status'=>'OK');
				$response->data = $this->M_Ws->GetOrders();
                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            }
        }

        $this->set_response(array('res'=>"Unauthorised"), REST_Controller::HTTP_UNAUTHORIZED);
    }

    public function frequestscustomers_post()
    {
        $headers = $this->input->request_headers();
       

        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);

            if ($decodedToken != false) {
             $message                =''; 
             $trasaction_err         ='OK';
             $statusmessage          =true;
             $idorder                ="";
             $client                 ='*';
             $id_request             ='*';
             $idfurniture            =""; 

             $arr_db                 = (object) array();
             $arr_transation         = (object) array();
             $response               = (object) array();
            
             $arr_data               = (object) array();
             $arr_items              = (object) array();
             $arr_error              = (object) array();
            
             $arr_request            = array();
             $arr_customer           = array();
             $arr_order              = array();
            
             $arr_transation->status = $trasaction_err;
             $response ->Trasactions = $arr_transation;

             $arr_db->data           = $this->M_Ws->GetRequestCustomer();

             $arr_error->message          = $message;
             $arr_error->message_type     = $message_type;
             $arr_error->Last_Packet_Read ='Last_Packet_Read';
             $arr_error->statusmessage    = false;

             
             $client                 ='*';
             $id_request             ='*';

             foreach( $arr_db->data as $object){
                if ($id_request!==$object->id_request_sd) {

                    $id_request= $object->id_request_sd;
                   
                   // $arr_request[] =  array('id_request_sd'=>$object->id_request_sd);

                    if ($client!==$object->client){
                        
                       

                        $arr_customer[] = array('name'=>$object->client,
                                                'projects'=>$object->project,
                                                'orders'=>$arr_order); 
                        
                        $arr_request[] =  array('id_request_sd'=>$object->id_request_sd,
                                                                 'Customers'=>$arr_customer);

                    $client=$object->client;  
                    }
                    
                }
                else
                {
                    //$arr_request->id_request_sd = $object->id_request_sd;
                   // $arr_request->Customers=$arr_customer;
                }

                $arr_data=$arr_request;
     
               
            }
            $response->data =$arr_data;
            // $arr_customer;
            // 
                                  
             $response->Warnig =  $arr_error;
             $this->set_response($arr_db , REST_Controller::HTTP_OK);
             $this->set_response($response, REST_Controller::HTTP_OK);
             

            return;
            }
        }

        $this->set_response(array('res'=>"Unauthorised"), REST_Controller::HTTP_UNAUTHORIZED);
    }


    public function frequests_post()
    {
        $headers = $this->input->request_headers();
       
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
        
            if ($decodedToken != false) {
                $message                =''; 
                $trasaction_err         ='OK';  
                $statusmessage          =true;

               


                $statusmessage=true;
                $arr_db                 = (object) array();
                $arr_transation         = (object) array();
                $response               = (object) array();
                $arr_data               = (object) array();
                $arr_error              = (object) array();
                $arr_api                = (object) array();


                
                $arr_transation->status_token = $trasaction_err;
                $response ->trasactions = $arr_transation;
   
                $arr_db           = $this->M_Ws->GetRequest();
                $arr_msg_db       = $this->M_Ws->Getws_message_movil();

                if (count($arr_msg_db )>0){
                    $arr_error->client_message                  = $arr_msg_db->client_message;
                    $arr_error->client_message_type             = $arr_msg_db->client_message_type; 
                    $arr_error->client_status_message           = ($arr_msg_db->client_message_view==1) ? true : false;
                    $arr_error->client_last_read_barcode        = $arr_msg_db->last_read_bar_qr;
                }
                else{
                    $arr_error->client_message                  = '';
                    $arr_error->client_status_message           = '';
                    $arr_error->client_message_type             = '';
                    $arr_error->client_last_read_barcode        = '';
                }
            //    print_r( $arr_msg_db);
                $msg_error = (count($arr_db )>0) ? 'DataFound' : 'DataNotFound';
                
               
                
                $arr_error->database_msg                    =(count($arr_db )>0) ? 'DataFound' : 'DataNotFound';
                
                foreach ($arr_db as $key => $value) {
                    $get_data_detail = $this->M_Ws->get_data_detail($value->id_request_sd);
                    $value->Document = array();
                    foreach ($get_data_detail as $key => $value2) {

                        $value->Document[] = $value2->order." - ".$value2->client;
                    }
                    
                }
                $response->data                             = $arr_db ;
                //$response->data['Document']                 = 'order - client';
                                      
                 $response->Warning =  $arr_error;
                
               $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            }
        }

        $this->set_response(array('res'=>"Unauthorised"), REST_Controller::HTTP_UNAUTHORIZED);
    }
	
    public function frequestsdetails_post()
    {
        $headers = $this->input->request_headers();
       
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
        
            if ($decodedToken != false) {
                $message                =''; 
                $trasaction_err         ='OK';  
                $statusmessage          =true;

               


                $statusmessage=true;
                $arr_db                 = (object) array();
                $arr_transation         = (object) array();
                $response               = (object) array();
                $arr_data               = (object) array();
                $arr_error              = (object) array();
                $arr_api                = (object) array();


                
                $arr_transation->status_token = $trasaction_err;
                $response ->trasactions = $arr_transation;
   
                $arr_db           = $this->M_Ws->GetRequestDetails();

                $msg_error = (count($arr_db )>0) ? 'DataFind' : 'DataNotFind';
                $arr_error->client_message                  = $message;
                $arr_error->client_status_message           = false;
                $arr_error->client_last_read_barcode        ='Last_Packet_Read';
                
                $arr_error->database_msg                    =$msg_error;
                
                $response->data                             = $arr_db ;
                
                                      
                 $response->Warning =  $arr_error;
               
               
                

                $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            }
        }

        $this->set_response(array('res'=>"Unauthorised"), REST_Controller::HTTP_UNAUTHORIZED);
    }
   
    public function ftotalrequests_post()
    {
        $headers = $this->input->request_headers();
        
                                                
        if (array_key_exists('Authorization', $headers) && !empty($headers['Authorization'])) {
            $decodedToken = AUTHORIZATION::validateToken($headers['Authorization']);
        
            if ($decodedToken != false) {
                $message                =''; 
                $trasaction_err         ='OK';  
                $statusmessage          =true;

                $statusmessage=true;
                $arr_db                 = (object) array();
                $arr_transation         = (object) array();
                $response               = (object) array();
                $arr_data               = (object) array();
                $arr_error              = (object) array();
                $arr_api                = (object) array();
                
                $arr_transation->status_token = $trasaction_err;
                $response ->trasactions = $arr_transation;
                $arr_db           = $this->M_Ws->SumTotalRequest();

                $arr_data = array('Packets' =>array('Status'   =>$arr_db->status_packets,
                                                    'Quantity' => array('Total'=>$arr_db->totalqty_packets,
                                                                        'Load'=>$arr_db->qty_packetsLoad,
                                                                        'Pending'=>$arr_db->pendingqtypack),
                                                    'Weight' => array('Total'=>$arr_db->totalweight,
                                                    'Load'=>$arr_db->weight_packetsLoad,
                                                    'Pending'=>$arr_db->pendingweigthload)                    
                                                                        
                                                    )
                                    );
                $arr_msg_db       = $this->M_Ws->getws_message_movil();

                if (count($arr_msg_db )>0){
                    $arr_error->client_message                  = $arr_msg_db->client_message;
                    $arr_error->client_message_type             = $arr_msg_db->client_message_type; 
                    $arr_error->client_status_message           = ($arr_msg_db->client_message_view==1) ? true : false;
                    $arr_error->client_last_read_barcode        = $arr_msg_db->last_read_bar_qr;
                }
                else{
                    $arr_error->client_message                  = '';
                    $arr_error->client_status_message           = '';
                    $arr_error->client_message_type             = '';
                    $arr_error->client_last_read_barcode        = '';
                }
            
                $msg_error = (count($arr_db )>0) ? 'DataFound' : 'DataNotFound';
                
                
                
                $arr_error->database_msg                    =(count($arr_db )>0) ? 'DataFound' : 'DataNotFound';


                
                $response->data                             =  $arr_data;
                
                                      
                 $response->Warning =  $arr_error;


              $this->set_response($response, REST_Controller::HTTP_OK);
                return;
            }
        }

        $this->set_response(array('res'=>"Unauthorised"), REST_Controller::HTTP_UNAUTHORIZED);
    }  



    
      
}