<?php
namespace Mediashare\Modules;

use CloudflareBypass\CFCurlImpl;
use CloudflareBypass\Model\UAMOptions;

Class Curl
{
    private $retry = 0;
    public function get(string $url, ?array $headers = null) {
        $result = $this->request($url, null, $headers);
        return $result;
    }
    public function post(string $url, $arguments = null, ?array $headers = null) {
        $result = $this->request($url, $arguments, $headers);
        return $result;
    }
    public function download(string $url, string $destination, $arguments = null, ?array $headers = null) {
        $result = $this->request($url, $arguments, $headers, true);
        $fp = \fopen($destination, 'w'); \fwrite($fp, $result); \fclose($fp);
        return $destination;
        
    }
    public function request(string $url, $arguments = null, ?array $headers = null, ?bool $download = false) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        if ($download):
            curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
        endif;
        curl_setopt($curl, CURLOPT_URL, $url);

        if ($arguments): // Post Request
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $arguments);
        endif;
        
        // Header
        $header = ["User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.100 Safari/537.36"];
        if ($headers):
            $header = array_merge($headers, $header);
        endif;
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        // $result = curl_exec($curl);
        // $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        // // Error(s)
        // $error = curl_error($curl);
        // $errno = curl_errno($curl);
        // curl_close($curl);
        // if (0 !== $errno) {
        //     $this->retry++;
        //     if ($this->retry > 5): echo new \RuntimeException($error, $errno);
        //     else: $result = $this->request($url, $arguments, $headers); endif;
        // }

        $cfCurl = new CFCurlImpl();
        $cfOptions = new UAMOptions();
        $cfOptions->setVerbose(false);
        // $cfOptions->setDelay(5);

        try {
            $result = $cfCurl->exec($curl, $cfOptions);
            // Want to get clearance cookies ?
            //$cookies = curl_getinfo($ch, CURLINFO_COOKIELIST);
        } catch (ErrorException $ex) {
            $this->retry++;
            if ($this->retry > 5):
                echo "Unknown error -> " . $ex->getMessage();
            else:
                $result = $this->request($url, $arguments, $headers);
            endif;
        }

        return $result;
    }
}

