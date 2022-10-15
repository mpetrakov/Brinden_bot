<?php

namespace Hell\Mvc\Core;

class Controller
{
    public function success(array $data = [])
    {
        $this->response('success', $data);
    }

    public function error(array $data = [])
    {
        $this->response('error', $data);
    }

    private function response(string $status, array $data = [])
    {
        echo json_encode([
            'status' => $status,
            'data' => $data
        ]);

        die();
    }
}