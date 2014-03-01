<?php

class V1 extends REST_Controller
{

    public function index_get() {
        $this->response(array('status'=>true));
    }
}
