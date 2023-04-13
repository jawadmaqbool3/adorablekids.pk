<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomException;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PayProApiController extends Controller
{
    private $endPoint;
    private $marchantID;
    private $clientID;
    private $clientSecret;
    private $clientPassword;
    private $client;
    private $token;
    public function __construct()
    {
        $this->setEndPoint(env("PP_API"));
        $this->setMarchantID(env("PP_USER_NAME"));
        $this->setClientID(env("PP_ID"));
        $this->setClientSecret(env("PP_SECRET"));
        $this->setClientPassword(env("PP_PASSWORD"));
        $this->client = new \GuzzleHttp\Client(['verify' => false]);
        $this->setToken();
    }

    public function setEndPoint($endPoint)
    {
        if (!$endPoint) throw new CustomException("End point is not declared", "error");
        $this->endPoint = $endPoint;
    }
    public function setMarchantID($marchantID)
    {
        if (!$marchantID) throw new CustomException("User name is not declared", "error");
        $this->marchantID = $marchantID;
    }
    public function setClientID($clientID)
    {
        if (!$clientID) throw new CustomException("Client ID is not declared", "error");
        $this->clientID = $clientID;
    }
    public function setClientSecret($clientSecret)
    {
        if (!$clientSecret) throw new CustomException("Client Secret is not declared", "error");
        $this->clientSecret = $clientSecret;
    }
    public function setClientPassword($clientPassword)
    {
        if (!$clientPassword) throw new CustomException("Client Password is not declared", "error");
        $this->clientPassword = $clientPassword;
    }
    private function setToken()
    {
        $query  = '{
            "clientid": "' . $this->clientID . '",
            "clientsecret": "' . $this->clientSecret . '"
        }';
        $response = $this->client->request("POST", $this->endPoint . "ppro/auth", [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ],
            "body" => $query
        ]);
        if ($response->getStatusCode() == 200) $this->token = $response->getHeader("token")[0];
        else throw new CustomException("Failed to authenticate", "error");
    }
    public function placeOrder(Order $order)
    {

        $query = '[ 
            { 
                "MerchantId": "' . $this->marchantID . '" 
            } 
            ,
            { 
                "OrderNumber": "' . $order->order_no . '",
                "OrderAmount": "' . $order->amount . '",
                "OrderDueDate": "' . $order->due_date . '",
                "OrderType": "Product",
                "IssueDate": "' . $order->date . '",
                "OrderExpireAfterSeconds": "0",
                "CustomerName": "' . @$order->user->name . '",
                "CustomerMobile": "",
                "CustomerEmail": "' . @$order->user->email . '",
                "CustomerAddress": "' . @$order->user->details->address . '" 
             } 
             ]';
        $response = $this->client->request("POST", $this->endPoint . "ppro/co", [
            'headers' => [
                'content-type' => 'application/json',
                'Accept' => 'application/json',
                'token' => $this->token
            ],
            "body" => $query
        ]);
        if ($response->getStatusCode() == 200) {
            $response = json_decode($response->getBody()->getContents());
            $status = (int)$response[0]->Status;
            $response = $response[1];
            $this->handleResponseExceptions($status);
            return $response;
        } else throw new CustomException("Something went wrong", "error");
    }

    public function handleResponseExceptions($status)
    {
        switch ($status) {
            case 1:
                throw new CustomException("Order already exists", "error");
                break;
        }
    }
}
