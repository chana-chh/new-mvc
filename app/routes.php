<?php

$routes = [
    ['GET', '/', 'StatickeStraniceController#pocetna', 'get.pocetna'],
    ['GET', '/o-nama', 'StatickeStraniceController#oNama', 'get.o-nama'],
    ['GET', '/kontakt', 'StatickeStraniceController#kontakt', 'get.kontakt'],
    ['GET', '/test/gen/:id/:name', 'StatickeStraniceController#test', 'get.test'],
    ['GET', '/sql/:page', 'SqlController#sqlTest', 'get.sql'],
];
