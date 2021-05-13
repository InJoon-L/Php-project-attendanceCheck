<?php
class Res {
    public $success, $resData;

    public function __construct($argSuccess, $argResData) {
        
        $this->success = $argSuccess; // 성공의 유무
        $this->resData = $argResData; // 쿼리 데이터
    }
}
?>