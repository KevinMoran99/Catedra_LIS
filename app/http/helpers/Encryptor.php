<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15/3/2018
 * Time: 1:02 PM
 */

namespace Http\Helpers;

use RandomLib\Factory;

class Encryptor
{

    //Encriptación de una sola direccion
    public static function encrypt($message)
    {
        return password_hash($message, PASSWORD_BCRYPT);
    }

    //Genera una contraseña aleatoria
    public static function generatePassword() {
        //Objetos que hacen la generación aleatoria
        $factory = new Factory();
        $generator = $factory->getMediumStrengthGenerator();

        //Objeto de validación
        $validator = new Validator();
        do {
            //Generando contraseña
            $randomString = $generator->generateString(8, '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_!#$%&\/()=?+*');
        
        }while(!$validator->validatePassword($randomString)); //Si la contraseña generada no tiene al menos un caracter alfanumerico y especial, es generada de nuevo

        return $randomString;
    }

    //Genera un hash aleatorio que es enviado al correo electronico de un usuario que quiere hacer login
    public static function generateConfirmHash() {
        //Objetos que hacen la generación aleatoria
        $factory = new Factory();
        $generator = $factory->getMediumStrengthGenerator();

        //Objeto de validación
        $validator = new Validator();
        $randomString = $generator->generateString(10);
        
        return $randomString;
    }


    //const METHOD = 'aes-256-ctr';
    /**
     * Encrypts (but does not authenticate) a message
     *
     * @param string $message - plaintext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encode - set to TRUE to return a base64-encoded
     * @return string (raw binary)
     */
    /*public static function encrypt($message, $key, $encode = false)
    {
        return password_hash($message, PASSWORD_BCRYPT);
        $key = hex2bin('010102030405060708090e0b0c0d0e0f101112141415661718191a1b1c1d1e1f');
        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = openssl_random_pseudo_bytes($nonceSize);

        $ciphertext = openssl_encrypt(
            $message,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        // Now let's pack the IV and the ciphertext together
        // Naively, we can just concatenate
        if ($encode) {
            return base64_encode($nonce.$ciphertext);
        }
        return $nonce.$ciphertext;
    }*/

    /**
     * Decrypts (but does not verify) a message
     *
     * @param string $message - ciphertext message
     * @param string $key - encryption key (raw binary expected)
     * @param boolean $encoded - are we expecting an encoded string?
     * @return string
     */
    /*public static function decrypt($message, $key=false, $encoded = false)
    {
        $key = hex2bin('010102030405060708090e0b0c0d0e0f101112141415661718191a1b1c1d1e1f');

        if ($encoded) {
            $message = base64_decode($message, true);
            if ($message === false) {
                throw new Exception('Encryption failure');
            }
        }

        $nonceSize = openssl_cipher_iv_length(self::METHOD);
        $nonce = mb_substr($message, 0, $nonceSize, '8bit');
        $ciphertext = mb_substr($message, $nonceSize, null, '8bit');

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::METHOD,
            $key,
            OPENSSL_RAW_DATA,
            $nonce
        );

        return $plaintext;
    }*/
}