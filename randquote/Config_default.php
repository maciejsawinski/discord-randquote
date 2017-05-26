<?php 

class Config {
    
    private $token = 'your_bot_token';
    
    public function setToken($token) { 
        
        $this->token = $token; 
    }
    
    public function getToken() { 
        
        return $this->token; 
    }
}