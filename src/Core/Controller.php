<?php

namespace Hell\Mvc\Core;

class Controller
{
    public function success(array $data = [])
    {
        return $this->response('success', $data);
    }

    public function error(array $data = [])
    {
        return $this->response('error', $data);
    }

    private function response(string $status, array $data = [])
    {
        return json_encode([
            'status' => $status,
            'data' => $data
        ]);
    }
}