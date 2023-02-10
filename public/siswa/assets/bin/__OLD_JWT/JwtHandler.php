<?php
include 'src/JWT.php';
include 'src/ExpiredException.php';
include 'src/SignatureInvalidException.php';
include 'src/BeforeValidException.php';

use \Firebase\JWT\JWT;

class JwtHandler {
    protected $jwt_secrect;
    protected $token;
    protected $issuedAt;
    protected $expire;
    protected $jwt;

    public function __construct()
    {
        // set your default time-zone
        date_default_timezone_set("Asia/Jakarta");
        $this->issuedAt = time();
        
        // Token Validity (3600 second = 1hr)
        $this->expire = $this->issuedAt + 360;

        // Set your secret or signature
        $this->jwt_secrect = "qqqqqqqqqqqqqqqqqqwwwwwwwwwelkfsjfl342398sjhfksfdgdfgfshfoiuawo4573987ruofhsfysvbalusnslaviuourywvlthvahfdasdf";  
    }

    // ENCODING THE TOKEN
    public function _jwt_encode_data($iss,$data){
        $this->token = array(
            //Adding the identifier to the token (who issue the token)
            "iss" => $iss,
            "aud" => $iss,
            // Adding the current timestamp to the token, for identifying that when the token was issued.
            "iat" => $this->issuedAt,
            // Token expiration
            "exp" => $this->expire,
            // Payload
            "data"=> $data
        );

        $this->jwt = JWT::encode($this->token, $this->jwt_secrect);
        return $this->jwt;
    }
    
    //DECODING THE TOKEN
    public function _jwt_decode_data($jwt_token){
        try{
            $decode = JWT::decode($jwt_token, $this->jwt_secrect, array('HS256'));
            return $decode->data;
        }
        catch(\Firebase\JWT\ExpiredException $e){
            return $e->getMessage();
        }
        catch(\Firebase\JWT\SignatureInvalidException $e){
            return $e->getMessage();
        }
        catch(\Firebase\JWT\BeforeValidException $e){
            return $e->getMessage();
        }
        catch(\DomainException $e){
            return $e->getMessage();
        }
        catch(\InvalidArgumentException $e){
            return $e->getMessage();
        }
        catch(\UnexpectedValueException $e){
            return $e->getMessage();
        }
    }
}
?>