<?php

require __DIR__.'/vendor/autoload.php';


    $conection = new \Zenteno\Http\UploadFile('46196560743-q5fp7g28gtf856j3bfs7667iaak9nqto.apps.googleusercontent.com','Sh4l0iHtXEocAOG0w48rY-aM','http://drive.io');
    $url = $conection->createFolder('ahouahia ho ho ');
    $client = $conection->uploadFile('pdf', 'https://dialnet.unirioja.es/descarga/articulo/3813287.pdf', $url);


