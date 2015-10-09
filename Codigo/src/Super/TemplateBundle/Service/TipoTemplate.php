<?php
namespace Super\TemplateBundle\Service;

use Base\CrudBundle\Service\CrudService;
use Symfony\Component\Validator\Validator;

class TipoTemplate extends CrudService
{

    CONST CadastroUsuario = 1;
    CONST CadastroOperadorFranquia = 2;
    CONST CadastroFranquia = 3;
    CONST CadastroOperadorFranqueador = 4;
    CONST CadastroFranqueador = 5;
    CONST CancelmentoCadastroUsuario = 6;
    CONST EsqueciSenha = 7;
    CONST Feedback = 8;

    protected $entityName = 'Base\BaseBundle\Entity\TbTipoTemplate';
}