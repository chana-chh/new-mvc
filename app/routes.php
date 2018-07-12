<?php

$routes = [
    ['GET', '/', 'StatickeStraniceController#pocetna', 'get.pocetna'],
    ['GET', '/statements/select', 'StatickeStraniceController#statementsSelect', 'get.statements.select'],
    ['GET', '/statements/insert', 'StatickeStraniceController#statementsInsert', 'get.statements.insert'],
    /* ==================================================================================================== */
    ['GET', '/sql/test', 'SqlController#sqlTest', 'get.sql.test'],
];
