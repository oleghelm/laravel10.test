<?php

namespace App\Services;

use Illuminate\Http\Request;

class PaymentService {
    
    private $errors = [];
    
    public function processPayment(Request $req){
        /*
         * make payment actions and return result
         */
        return true;
    }
    
    public function getErrors(){
        return $this->errors;
    }
    
}