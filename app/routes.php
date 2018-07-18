<?php

$routes = [
    ['GET', '/prijava', 'PrijavaController#login', 'get.login'],
    /* ==================================================================================================== */
    ['GET', '/', 'StatickeStraniceController#pocetna', 'get.pocetna'],
    ['GET', '/statements/select', 'StatickeStraniceController#statementsSelect', 'get.statements.select'],
    ['GET', '/statements/insert', 'StatickeStraniceController#statementsInsert', 'get.statements.insert'],
    /* ==================================================================================================== */
    ['GET', '/sql/test', 'SqlController#sqlTest', 'get.sql.test'],
    ['POST', '/sql/test', 'SqlController#sqlTestPOst', 'post.sql.test'],
];
