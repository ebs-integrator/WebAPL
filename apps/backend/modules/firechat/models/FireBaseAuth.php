<?php

/**
 * JSON Web Token implementation, based on this spec:
 * http://tools.ietf.org/html/draft-ietf-oauth-json-web-token-06
 *
 * PHP version 5
 *
 * @category Authentication
 * @package  Authentication_JWT
 * @author   Neuman Vong <neuman@twilio.com>
 * @author   Anant Narayanan <anant@php.net>
 * @license  http://opensource.org/licenses/BSD-3-Clause 3-clause BSD
 * @link     https://github.com/firebase/php-jwt
 */
class JWT
{
    static $methods = array(
        'HS256' => array('hash_hmac', 'SHA256'),
        'HS512' => array('hash_hmac', 'SHA512'),
        'HS384' => array('hash_hmac', 'SHA384'),
        'RS256' => array('openssl', 'SHA256'),
    );

    /**
     * Decodes a JWT string into a PHP object.
     *
     * @param string      $jwt       The JWT
     * @param string|Array|null $key The secret key, or map of keys
     * @param bool        $verify    Don't skip verification process
     *
     * @return object      The JWT's payload as a PHP object
     * @throws UnexpectedValueException Provided JWT was invalid
     * @throws DomainException          Algorithm was not provided
     * 
     * @uses jsonDecode
     * @uses urlsafeB64Decode
     */
    public static function decode($jwt, $key = null, $verify = true)
    {
        $tks = explode('.', $jwt);
        if (count($tks) != 3) {
            throw new UnexpectedValueException('Wrong number of segments');
        }
        list($headb64, $bodyb64, $cryptob64) = $tks;
        if (null === ($header = JWT::jsonDecode(JWT::urlsafeB64Decode($headb64)))) {
            throw new UnexpectedValueException('Invalid segment encoding');
        }
        if (null === $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64))) {
            throw new UnexpectedValueException('Invalid segment encoding');
        }
        $sig = JWT::urlsafeB64Decode($cryptob64);
        if ($verify) {
            if (empty($header->alg)) {
                throw new DomainException('Empty algorithm');
            }
            if (is_array($key)) {
                if(isset($header->kid)) {
                    $key = $key[$header->kid];
                } else {
                    throw new DomainException('"kid" empty, unable to lookup correct key');
                }
            }
            if (!JWT::verify("$headb64.$bodyb64", $sig, $key, $header->alg)) {
                throw new UnexpectedValueException('Signature verification failed');
            }
            // Check token expiry time if defined.
            if (isset($payload->exp) && time() >= $payload->exp){
                throw new UnexpectedValueException('Expired Token');
            }
        }
        return $payload;
    }

    /**
     * Converts and signs a PHP object or array into a JWT string.
     *
     * @param object|array $payload PHP object or array
     * @param string       $key     The secret key
     * @param string       $algo    The signing algorithm. Supported
     *                              algorithms are 'HS256', 'HS384' and 'HS512'
     *
     * @return string      A signed JWT
     * @uses jsonEncode
     * @uses urlsafeB64Encode
     */
    public static function encode($payload, $key, $algo = 'HS256', $keyId = null)
    {
        $header = array('typ' => 'JWT', 'alg' => $algo);
        if($keyId !== null) {
            $header['kid'] = $keyId;
        }
        $segments = array();
        $segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($header));
        $segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($payload));
        $signing_input = implode('.', $segments);

        $signature = JWT::sign($signing_input, $key, $algo);
        $segments[] = JWT::urlsafeB64Encode($signature);

        return implode('.', $segments);
    }

    /**
     * Sign a string with a given key and algorithm.
     *
     * @param string $msg          The message to sign
     * @param string|resource $key The secret key
     * @param string $method       The signing algorithm. Supported algorithms
     *                               are 'HS256', 'HS384', 'HS512' and 'RS256'
     *
     * @return string          An encrypted message
     * @throws DomainException Unsupported algorithm was specified
     */
    public static function sign($msg, $key, $method = 'HS256')
    {
        if (empty(self::$methods[$method])) {
            throw new DomainException('Algorithm not supported');
        }
        list($function, $algo) = self::$methods[$method];
        switch($function) {
            case 'hash_hmac':
                return hash_hmac($algo, $msg, $key, true);
            case 'openssl':
                $signature = '';
                $success = openssl_sign($msg, $signature, $key, $algo);
                if(!$success) {
                    throw new DomainException("OpenSSL unable to sign data");
                } else {
                    return $signature;
                }
        }
    }

    /**
     * Verify a signature with the mesage, key and method. Not all methods
     * are symmetric, so we must have a separate verify and sign method.
     * @param string $msg the original message
     * @param string $signature
     * @param string|resource $key for HS*, a string key works. for RS*, must be a resource of an openssl public key
     * @param string $method
     * @return bool
     * @throws DomainException Invalid Algorithm or OpenSSL failure
     */
    public static function verify($msg, $signature, $key, $method = 'HS256') {
        if (empty(self::$methods[$method])) {
            throw new DomainException('Algorithm not supported');
        }
        list($function, $algo) = self::$methods[$method];
        switch($function) {
            case 'openssl':
                $success = openssl_verify($msg, $signature, $key, $algo);
                if(!$success) {
                    throw new DomainException("OpenSSL unable to verify data: " . openssl_error_string());
                } else {
                    return $signature;
                }
            case 'hash_hmac':
            default:
                $hash = hash_hmac($algo, $msg, $key, true);
                $len = min(strlen($signature), strlen($hash));

                $status = 0;
                for ($i = 0; $i < $len; $i++) {
                    $status |= (ord($signature[$i]) ^ ord($hash[$i]));
                }
                $status |= (strlen($signature) ^ strlen($hash));

                return ($status === 0);
        }
    }

    /**
     * Decode a JSON string into a PHP object.
     *
     * @param string $input JSON string
     *
     * @return object          Object representation of JSON string
     * @throws DomainException Provided string was invalid JSON
     */
    public static function jsonDecode($input)
    {
        if (version_compare(PHP_VERSION, '5.4.0', '>=') && !(defined('JSON_C_VERSION') && PHP_INT_SIZE > 4)) {
            /* In PHP >=5.4.0, json_decode() accepts an options parameter, that allows you to specify that large ints (like Steam
             * Transaction IDs) should be treated as strings, rather than the PHP default behaviour of converting them to floats.
             */
            $obj = json_decode($input, false, 512, JSON_BIGINT_AS_STRING);
        } else {
            /* Not all servers will support that, however, so for older versions we must manually detect large ints in the JSON
             * string and quote them (thus converting them to strings) before decoding, hence the preg_replace() call.
             */
            $max_int_length = strlen((string) PHP_INT_MAX) - 1;
            $json_without_bigints = preg_replace('/:\s*(-?\d{'.$max_int_length.',})/', ': "$1"', $input);
            $obj = json_decode($json_without_bigints);
        }

        if (function_exists('json_last_error') && $errno = json_last_error()) {
            JWT::_handleJsonError($errno);
        } else if ($obj === null && $input !== 'null') {
            throw new DomainException('Null result with non-null input');
        }
        return $obj;
    }

    /**
     * Encode a PHP object into a JSON string.
     *
     * @param object|array $input A PHP object or array
     *
     * @return string          JSON representation of the PHP object or array
     * @throws DomainException Provided object could not be encoded to valid JSON
     */
    public static function jsonEncode($input)
    {
        $json = json_encode($input);
        if (function_exists('json_last_error') && $errno = json_last_error()) {
            JWT::_handleJsonError($errno);
        } else if ($json === 'null' && $input !== null) {
            throw new DomainException('Null result with non-null input');
        }
        return $json;
    }

    /**
     * Decode a string with URL-safe Base64.
     *
     * @param string $input A Base64 encoded string
     *
     * @return string A decoded string
     */
    public static function urlsafeB64Decode($input)
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        return base64_decode(strtr($input, '-_', '+/'));
    }

    /**
     * Encode a string with URL-safe Base64.
     *
     * @param string $input The string you want encoded
     *
     * @return string The base64 encode of what you passed in
     */
    public static function urlsafeB64Encode($input)
    {
        return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
    }

    /**
     * Helper method to create a JSON error.
     *
     * @param int $errno An error number from json_last_error()
     *
     * @return void
     */
    private static function _handleJsonError($errno)
    {
        $messages = array(
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON'
        );
        throw new DomainException(
            isset($messages[$errno])
            ? $messages[$errno]
            : 'Unknown JSON error: ' . $errno
        );
    }

}


class FireBaseAuth
{
    private $version = 0;

    /**
     * Example usage:
     *     $tokenGen = new Services_FirebaseTokenGenerator("0014ae3b1ded44de9d9f6fc60dfd1c64");
     *     $tokenGen->createToken(array("id" => "foo", "bar" => "baz"));
     *
     * @access  public
     * @param   string       $secret   The API secret for the Firebase you
     *                                 want to generate an auth token for.
     */
    public function __construct($secret)
    {
        if (!is_string($secret)) {
            throw new UnexpectedValueException("Invalid secret provided");
        }
        $this->secret = $secret;
    }

    /**
     * @access  public
     * @param   array|object $data     An object or array of data you wish
     *                                 to associate with the token. It will
     *                                 be available as the variable "auth" in
     *                                 the Firebase rules engine.
     * @param   object       $options  Optional. An associative array with
     *                                 the developer supplied options for this
     *                                 token. The following keys are recognized:
     *
     *                                   'admin': Set to true if you want this
     *                                   token to bypass all security rules.
     *                                   Defaults to false.
     *
     *                                   'debug': Set to true if you want to
     *                                   enable debug output from your security
     *                                   rules.
     *
     *                                   'expires': Set to a number (seconds
     *                                   since epoch) or a DateTime object that
     *                                   specifies the time at which the token
     *                                   should expire.
     *
     *                                   'notBefore': Set to a number (seconds
     *                                   since epoch) or a DateTime object that
     *                                   specifies the time before which the
     *                                   should be rejected by the server.
     *
     *
     * @return  string       A Firebase auth token.
     */
    public function createToken($data, $options = null)
    {
        $funcName = 'Services_FirebaseTokenGenerator->createToken';

        // If $data is JSONifiable, let it pass.
        $json = json_encode($data);
        if (function_exists("json_last_error") && $errno = json_last_error()) {
            $this->handleJSONError($errno);
        } else if ($json === "null" && $data !== null) {
            throw new UnexpectedValueException("Data is not valid JSON");
        } else if (empty($data) && empty($options)) {
            throw new Exception($funcName + ": data is empty and no options are set.  This token will have no effect on Firebase.");
        }

        $claims = array();
        if (is_array($options)) {
            $claims = $this->_processOptions($options);
        }

        $this->_validateData($funcName, $data, ($claims["admin"] == true));

        $claims["d"] = $data;
        $claims["v"] = $this->version;
        $claims["iat"] = time();

        $token = JWT::encode($claims, $this->secret, "HS256");
        if (strlen($token) > 1024) {
            throw new Exception($funcName + ": generated token is too large.  Token cannot be larger than 1024 bytes.");
        }
        return $token;
    }

    /**
     * Parses provided options into a claims object.
     *
     * @param object $options Options as passed by the developer to createToken.
     *
     * @return array A claims array in which the options are stored.
     */
    private static function _processOptions($options) {
        $claims = array();
        foreach ($options as $key => $value) {
            switch ($key) {
                case "admin":
                    $claims["admin"] = $value;
                    break;
                case "debug":
                    $claims["debug"] = $value;
                    break;
                case "expires":
                case "notBefore":
                    $code = "exp";
                    if ($key == "notBefore") {
                        $code = "nbf";
                    }
                    switch (gettype($value)) {
                        case "integer":
                            $claims[$code] = $value;
                            break;
                        case "object":
                            if ($value instanceof DateTime) {
                                $claims[$code] = $value->getTimestamp();
                            } else {
                                throw new UnexpectedValueException(
                                    "Provided " + $key +
                                    " option is not a DateTime object");
                            }
                            break;
                        default:
                            throw new UnexpectedValueException(
                                "Provided " + $key +
                                " option is invalid " + $value);
                    }
                    break;
                default:
                    throw new UnexpectedValueException(
                        "Invalid key " + $key + " provided in options");
            }
        }
        return $claims;
    }

    /**
     * Validates provided data object, throwing Exceptions where necessary.
     *
     * @param string $funcName the function name string for error message reporting.
     * @param array $data the token data to be validated.
     * @param boolean $isAdminToken whether the admin flag has been set.
     */
     private static function _validateData($funcName, $data, $isAdminToken) {
        if (!is_null($data) && !is_array($data)) {
            throw new Exception($funcName + ": data must be null or an associative array of token data.");
        }
        $containsUID = (is_array($data) && array_key_exists("uid", $data));
        if ((!$containsUID && !$isAdminToken) || ($containsUID && !is_string($data["uid"]))) {
            throw new Exception($funcName + ": data must contain a \"uid\" key that must be a string.");
        } else if ($containsUID && (strlen($data["uid"]) > 256)) {
            throw new Exception($funcName + ": data must contain a \"uid\" key that must not be longer than 256 bytes.");
        }
    }

    /**
     * @access  private
     * @param   int          $errno    An error number from json_last_error()
     *
     * @return  void
     */
    private static function handleJSONError($errno)
    {
        $messages = array(
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON'
        );
        throw new UnexpectedValueException(isset($messages[$errno])
            ? $messages[$errno]
            : 'Unknown JSON error: ' . $errno
        );
    }
}

?>