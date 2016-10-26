<?php
/**
 * Provê os métodos necessários para todos os modelos
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Validator;

class AbstractModel extends Model
{
    private $errors;

    /**
     * validação dos atributos do modelo
     * @param $data
     * @return bool
     */
    public function validate($data) {
        $v = Validator::make($data, $this->rules, [], $this->attributesLabel);
        if($v->fails()) {
            $this->errors = $v->errors();
            return false;
        }
        return true;
    }

    /**
     * retorna os erros encontrados no preenchimento dos atributos do modelo
     * @return mixed
     */
    public function errors() {
        return $this->errors;
    }
}