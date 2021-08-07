<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'total', 'total_fee', 'status'];
    public function getOrderPackage(){
        return $this->hasMany(OrderPackage::class);
    }
    public function createOrder($order){
        $validation = $this->validateOrder($order);
        if($validation['success']){
            return $this->insertOrder($order);
        } else {
            return array("success" => FALSE, "message" => $validation['message']);
        }
    }
    public function validateOrder($order){
        $success = TRUE;
        $message = array();
        $required_string = array("first_name", "last_name", "email", "phone");
        $required_integer = array("package_id", "tickets_purchased");
        foreach($required_string as $field_name){
            if(!(isset($order[$field_name]) && strlen($order[$field_name]) > 0)){
                $success = FALSE;
                $message[] = $field_name. " is required";
            }
        }
        foreach($required_integer as $field_name){
            if(!( isset($order[$field_name])
                && filter_var($order[$field_name], FILTER_VALIDATE_INT)
                && (int) $order[$field_name] > 0) ){
                $success = FALSE;
                $message[] = $field_name. " is required and must be an integer greater than zero";
            }
        }
        if(isset($order['package_id'])
            && is_int($order['package_id'])
            && $order['package_id'] > 0
            && !Package::where('id', '=', $order['package_id'])->exists()){
            $success = FALSE;
            $message[] = "package_id ".$order['package_id']." does not exist";
        }
        return array("success" => $success, "message" => $message);
    }
    public function insertOrder($order) {
        try {
            $package = Package::select('price','fee')->where('id', '=', $order['package_id'])->get()->first();
            $orderInserted = Order::create( [
                "first_name" => $order['first_name'],
                "last_name" => $order['last_name'],
                "email" => $order['email'],
                "phone" => $order['phone'],
                "total" => $package['price'] * $order['tickets_purchased'] ,
                "total_fee" => $package['fee'] * $order['tickets_purchased'],
                "status" => 'approved'
            ]);
            OrderPackage::create( [
                "order_id" => $orderInserted->id,
                "package_id" => $order['package_id'],
                "tickets_purchased" => $order['tickets_purchased']
            ]);
            return array('success' => TRUE, "message" => "Order created successfully", "order_id" => $orderInserted->id);
        } catch (Exception $e) {
            return array('success' => FALSE, "message" => $e->getMessage());
        }
    }
}
