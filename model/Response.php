<?php

    class Response{
        private $_success;
        private $_httpStatusCode;
        private $_message;
        private $_odata;
        private $_gdata;
        private $_toCache = false;
        private $_responseData = array();

        public function setSuccess($success){
            $this->_success = $success;
        }

        public function setHttpStatusCode($httpStatusCode){
            $this->_httpStatusCode = $httpStatusCode;
        }

        public function addMessage($message){
            $this->_message[] = $message;
        }

        public function setOSMData($data){
           
            $this->_odata = $data;
        }

        public function setGoogleData($data){
           
            $this->_gdata = $data;
        }

        public function toCache($toCache){
            $this->_toCache = $toCache;
        }

        public function send(){
            header('Content-type: application/json; charset=utf-8');
            if($this->_toCache== true){
                header('Cache-control: application/json; charset=utf-8');
            }
            else{
                header('Cache-control: no-cache no-store');
            }

            if(($this->_success !== false && $this->_success !== true) || !is_numeric($this->_httpStatusCode))
            {
                http_response_code(500);
                $this->_responseData['statusCode'] = 500; 
                $this->_responseData['success'] = false; 
                $this->addMessage['Response Creation Error']; 
                $this->_responseData['messages'] = $this->_message; 
            }
            else{
                http_response_code($this->_httpStatusCode);
                $this->_responseData['statusCode'] = $this->_httpStatusCode; 
                $this->_responseData['success'] = $this->_success; 
                $this->_responseData['messages'] = $this->_message;
                $this->_responseData['odata'] = empty($this->_odata) ?  null : $this->_odata;
                $this->_responseData['gdata'] = $this->_gdata;
            }
            echo json_encode($this->_responseData);
        }

    }