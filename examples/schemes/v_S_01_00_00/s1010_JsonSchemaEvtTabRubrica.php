<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../../bootstrap.php';

use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;

//S-1010
//Campos {nrProc} – alterado tamanho. 20 -> 21
//sem alterações da 2.4.2 => 2.5.0
//versão S_1.00

$evento  = 'evtTabRubrica';
$version = 'S_01_00_00';

$jsonSchema = '{
    "title": "evtTabRubrica",
    "type": "object",
    "properties": {
        "sequencial": {
            "required": true,
            "type": "integer",
            "minimum": 1,
            "maximum": 99999
        },
        "codrubr": {
            "required": true,
            "type": "string",
            "maxLength": 30,
            "pattern": "^(?!eSocial)"
        },
        "idetabrubr": {
            "required": true,
            "type": "string",
            "maxLength": 8,
            "pattern": "^(?!eSocial)"
        },
        "inivalid": {
            "required": true,
            "type": "string",
            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])$"
        },
        "fimvalid": {
            "required": false,
            "type": ["string","null"],
            "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])$"
        },
        "modo": {
            "required": true,
            "type": "string",
            "pattern": "INC|ALT|EXC"
        },
        "dadosrubrica": {
            "required": false,
            "type": ["object","null"],
            "properties": {
                "dscrubr": {
                    "required": true,
                    "type": "string",
                    "maxLength": 100
                },
                "natrubr": {
                    "required": true,
                    "type": "integer"
                },
                "tprubr": {
                    "required": true,
                    "type": "integer",
                    "minimum": 1,
                    "maximum": 4
                },
                "codinccp": {
                    "required": true,
                    "type": "string",
                    "pattern": "^[0-9]{2}$"
                },
                "codincirrf": {
                    "required": true,
                    "type": "string",
                    "pattern": "^[0-9]{2}$"
                },
                "codincfgts": {
                    "required": true,
                    "type": "string",
                    "pattern": "^[0-9]{2}$"
                },
                "codinccprp": {
                    "required": false,
                    "type": ["string","null"],
                    "pattern": "^[0-9]{2}$"
                },
                "tetoremun": {
                    "required": false,
                    "type": ["string","null"],
                    "pattern": "^(S|N)$"
                },
                "observacao": {
                    "required": false,
                    "type": ["string","null"],
                    "maxLength": 255
                },
                "ideprocessocp": {
                    "required": false,
                    "type": ["array","null"],
                    "minItems": 0,
                    "maxItems": 99,
                    "items": {
                        "type": "object",
                        "properties": {
                            "tpproc": {
                                "required": true,
                                "type": "integer",
                                "minimum": 1,
                                "maximum": 2
                            },
                            "nrproc": {
                                "required": true,
                                "type": "string",
                                "maxLength": 21
                            },
                            "extdecisao": {
                                "required": true,
                                "type": "integer",
                                "minimum": 1,
                                "maximum": 2
                            },
                            "codsusp": {
                                "required": true,
                                "type": "string",
                                "pattern": "^[0-9]{1,14}"
                            }
                        }
                    }    
                },
                "ideprocessoirrf": {
                    "required": false,
                    "type": ["array","null"],
                    "minItems": 0,
                    "maxItems": 99,
                    "items": {
                        "type": "object",
                        "properties": {
                            "nrproc": {
                                "required": true,
                                "type": "string",
                                "maxLength": 20
                            },
                            "codsusp": {
                                "required": true,
                                "type": "string",
                                "pattern": "^[0-9]{1,14}"
                            }
                        }
                    }    
                },
                "ideprocessofgts": {
                    "required": false,
                    "type": ["array","null"],
                    "minItems": 0,
                    "maxItems": 99,
                    "items": {
                        "type": "object",
                        "properties": {
                            "nrproc": {
                                "required": true,
                                "type": "string",
                                "maxLength": 20
                            }
                        }
                    }    
                }
            }
        },
        "novavalidade": {
            "required": false,
            "type": ["object","null"],
            "properties": {
                "inivalid": {
                    "required": true,
                    "type": "string",
                    "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])$"
                },
                "fimvalid": {
                    "required": false,
                    "type": ["string","null"],
                    "pattern": "^(19[0-9][0-9]|2[0-9][0-9][0-9])[-/](0?[1-9]|1[0-2])$"
                }
            }    
        }
    }
}';

$std = new \stdClass();
$std->sequencial = 1;
$std->codrubr = 'alalalaallkj r9487dkjhdkjhd';
$std->idetabrubr = 'lslslsls';
$std->inivalid = '2017-01';
$std->fimvalid = '2017-12';
$std->modo = "INC";

//campo obirgatório
$std->dadosrubrica  = new \stdClass();
$std->dadosrubrica->dscrubr = 'dkdldkdlk';
$std->dadosrubrica->natrubr = 1234;
$std->dadosrubrica->tprubr = 1;
$std->dadosrubrica->codinccp = '11';
$std->dadosrubrica->codincirrf = '11';
$std->dadosrubrica->codincfgts = '11';
$std->dadosrubrica->codinccprp = '11';
$std->dadosrubrica->tetoremun = 'N';
$std->dadosrubrica->observacao = null;

//campo ARRAY opcional
$std->dadosrubrica->ideprocessocp[0] = new \stdClass();
$std->dadosrubrica->ideprocessocp[0]->tpproc = 1;
$std->dadosrubrica->ideprocessocp[0]->nrproc = 'alkdslkdldkdlk';
$std->dadosrubrica->ideprocessocp[0]->extdecisao = 1;
$std->dadosrubrica->ideprocessocp[0]->codsusp = '0929292882';

//campo ARRAY opcional
$std->dadosrubrica->ideprocessoirrf[0] = new \stdClass();
$std->dadosrubrica->ideprocessoirrf[0]->nrproc  = 'alkdslkdldkdlk';
$std->dadosrubrica->ideprocessoirrf[0]->codsusp = '0929292882';

//campo ARRAY opcional
$std->dadosrubrica->ideprocessofgts[0] = new \stdClass();
$std->dadosrubrica->ideprocessofgts[0]->nrproc  = 'alkdslkdldkdlk';


//campos opcionais usar apenas em alterações
$std->novavalidade = new \stdClass();
$std->novavalidade->inivalid = '2017-12';
$std->novavalidade->fimvalid = '2018-12';

// Schema must be decoded before it can be used for validation
$jsonSchemaObject = json_decode($jsonSchema);

// The SchemaStorage can resolve references, loading additional schemas from file as needed, etc.
$schemaStorage = new SchemaStorage();

// This does two things:
// 1) Mutates $jsonSchemaObject to normalize the references (to file://mySchema#/definitions/integerData, etc)
// 2) Tells $schemaStorage that references to file://mySchema... should be resolved by looking in $jsonSchemaObject
$definitions = realpath(__DIR__."/../../../jsonSchemes/definitions.schema");
$schemaStorage->addSchema("file:{$definitions}", $jsonSchemaObject);

// Provide $schemaStorage to the Validator so that references can be resolved during validation
$jsonValidator = new Validator(new Factory($schemaStorage));

// Do validation (use isValid() and getErrors() to check the result)
$jsonValidator->validate(
    $std,
    $jsonSchemaObject
);

if ($jsonValidator->isValid()) {
    echo "The supplied JSON validates against the schema.<br/>";
} else {
    echo "JSON does not validate. Violations:<br/>";
    foreach ($jsonValidator->getErrors() as $error) {
        echo sprintf("[%s] %s<br/>", $error['property'], $error['message']);
    }
    die;
}
//salva se sucesso
file_put_contents("../../../jsonSchemes/v_$version/$evento.schema", $jsonSchema);
