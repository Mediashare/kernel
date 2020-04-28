<?php
namespace Mediashare\Modules;

use Mediashare\Modules\Curl;

Class CloudFile {
    public $api_url;

    /**
     * Files
     */

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

    public function getFileRender(string $id, ?string $apiKey = null) {
        $url = "/render/".$id;
        $response = $this->request($url, null, $apiKey);
        return $response;    
    }

    public function removeFile(string $id, ?string $apiKey = null): array {
        $url = "/remove/".$id;
        $response = $this->request($url, null, $apiKey);
        return $response;    
    }

    /**
     * Volumes
     */

    public function createVolume(string $email, int $size, ?string $cloudfile_password = null) {
        $url = "/volume/new";
        $response = $this->request($url, [
            'email' => $email,
            'size' => $size,
            'cloudfile_password' => $cloudfile_password
        ]);
        return $response;
    }
    public function getVolume(string $apiKey) {
        $url = "/volume";
        $response = $this->request($url, [], $apiKey);
        return $response;
    }
    public function clearVolume(string $apiKey) {
        $url = "/volume/clear";
        $response = $this->request($url, [], $apiKey);
        return $response;
    }
    public function resetApiKey(string $apiKey) {
        $url = "/volume/reset/apikey";
        $response = $this->request($url, [], $apiKey);
        return $response;
    }
    public function deleteVolume(string $apiKey) {
        $url = "/volume/delete";
        $response = $this->request($url, [], $apiKey);
        return $response;
    }
    public function retrieveVolumes(string $email, ?string $cloudfile_password = null) {
        $url = "/volume/retrieve";
        $response = $this->request($url, [
            'email' => $email,
            'cloudfile_password' => $cloudfile_password
        ]);
        return $response;
    }
    

    /**
     * Send request
     */
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