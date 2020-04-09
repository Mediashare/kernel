<?php
namespace Mediashare\Modules;
Class Curl
{
    public function get(string $url, ?array $headers = null) {
        $result = $this->request($url, $headers);
        return $result;
    }
    public function post(string $url, ?array $arguments = null, ?array $headers = null) {
        $result = $this->request($url, $arguments, $headers);
        return $result;
    }
    public function request(string $url, ?array $arguments = null, ?array $headers = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        if ($arguments): // Post Request
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $arguments);
        endif;

        if ($headers):
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        endif;

        $result = curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // Error(s)
        $error = curl_error($curl);
        $errno = curl_errno($curl);
        curl_close($curl);

        if (0 !== $errno) {
            throw new \RuntimeException($error, $errno);
        }

        return $result;
    }
}
