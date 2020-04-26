<?php
namespace Mediashare\Modules;

use Mediashare\Modules\Curl;

Class CloudFile {
    public $api_url;

    public function upload(string $filePath, ?array $metadata = null, ?string $apiKey = null) {
        $url = "/upload";
        if ($metadata):$data = $metadata;endif;
        $data['file'] = curl_file_create($filePath);
        $response = $this->request($url, $data, $apiKey);
        return $response;
    }
    
    public function getStats(): array {
        $url = "/stats";
        $response = $this->request($url);
        return $response;
    }

    public function getFiles(?string $apiKey = null): array {
        $url = "/";
        $response = $this->request($url, null, $apiKey);
        return $response;
    }

    public function getFile(string $id, ?string $apiKey = null): array {
        $url = "/info/".$id;
        $response = $this->request($url, null, $apiKey);
        return $response;    
    }

    public function getFileContent(string $id, ?string $apiKey = null) {
        $url = "/show/".$id;
        $response = $this->request($url, null, $apiKey);
        return $response;    
    }

    public function removeFile(string $id, ?string $apiKey = null): array {
        $url = "/remove/".$id;
        $response = $this->request($url, null, $apiKey);
        return $response;    
    }

    public function createVolume(string $email, int $size, ?string $password = null) {
        $url = "/volume/new";
        $response = $this->request($url, [
            'email' => $email,
            'size' => $size,
            'volume_password' => $password
        ]);
        return $response;
    }
    public function retrieveVolumes(string $email, ?string $password = null) {
        $url = "/volumes/retrieve";
        $response = $this->request($url, [
            'email' => $email,
            'volume_password' => $password
        ]);
        return $response;
    }
    
    private function request(string $url, ?array $queries = [], ?string $apiKey = null) {
        $url = rtrim($this->api_url, '/').$url;
        if ($apiKey): $headers = ['apikey: '.$apiKey];
        else: $headers = null; endif;
        
        $request = new Curl();
        if (empty($queries)):
            $response = $request->get($url, $headers);
        else:
            $response = $request->post($url, $queries, $headers);
        endif;
        $result = \json_decode($response, true);
        
        if ($result):
            return $result;
        else:
            return [
                'status' => 'error',
                'response' => $response
            ];
        endif;
    }
}