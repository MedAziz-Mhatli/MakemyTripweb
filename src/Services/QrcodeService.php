<?php

namespace App\Services;

use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;

class QrcodeService{

    protected $builder;

    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
    }

    public function qrCode($query){

        $result = $this->builder
            ->data($query)
            ->size(400)
            ->errorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->encoding(new Encoding('UTF-8'))
            ->backgroundColor()
            ->build()

        ;

        $namePng = uniqid(''.'').'.png';

        $result->saveToFile((\dirname(__DIR__,2).'/public/qrcode/'.$namePng));
        return $result->getDataUri();
    }

}
