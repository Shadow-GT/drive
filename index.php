<?php

require __DIR__.'/vendor/autoload.php';


    $conection = new \Zenteno\Http\UploadFile(
        '46196560743-97h68eib210ib3kjnoqont5ec560qhgr.apps.googleusercontent.com',
        '7KgfHTBAwxwLRt0yHjxDmhRW',
        'http://drive.io');


    //$url = $conection->createFolder('ahouahia ho ho ');
    //$client = $conection->uploadFile('pdf', 'https://dialnet.unirioja.es/descarga/articulo/3813287.pdf');
    $conection->findFileInsideAFolder('1BCNw_lFUnIxAu-7esi7mEr-QVlizQiLH', 'pdf');


