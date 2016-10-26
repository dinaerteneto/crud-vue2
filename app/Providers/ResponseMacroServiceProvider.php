<?php

namespace App\Providers;

use Response;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;

class ResponseMacroServiceProvider extends ServiceProvider
{

    public function register() {}
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('api', function ($data = [], $pagination = [], $errorStatus = 0, $errorMsg = []) {
            /**
             *  error status
             *  200 = OK            GET
             *  201 = Created       POST
             *  202 = Accepted      PUT
             *  204 = No Content    DELETE
             *  400 = Bad Request
             *  401 = Unauthorized
             *  403 = Forbidden
             *  404 = Not Found
             *  405 = Method Not Allowed
             *  1000 = Form error
             *  1001 = Error for user
             */
            $errorDev = null;
            if(isset($errorMsg['dev'])) {
                $errorDev = json_decode($errorMsg['dev']);
                if(json_last_error()) {
                    $errorDev = $errorMsg;
                }
            }

            $json = [
                'pagination' => $pagination,
                'request' => Request::all(),
                'response' => $data,
                'error' => [
                    'status' => $errorStatus,
                    'user' => isset($errorMsg['user']) ? $errorMsg['user'] : null,
                    'dev' => $errorDev
                ]
            ];
            return response()->json($json, 200);
        });
    }
}