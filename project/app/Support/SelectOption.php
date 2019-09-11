<?php

namespace App\Helpers;

use JsonSerializable;

class SelectOption implements JsonSerializable
{
    protected $text = null;
    protected $value = null;
    protected $textKey = 'text';
    protected $valueKey = 'value';

    /**
     * Classe utilizada para representar cada ítem de um Select de opções.
     * @param string $value Valor da opção
     * @param string $text  Texto a ser exibido
     */
    public function __construct(string $value, string $text)
    {
        $this->text = $text;
        $this->value = $value;
    }

    /**
     * Define as chaves para o valor e texto da opção para quando é serializada.
     * @param string $valueKey
     * @param string $textKey
     * @return self
     */
    public function setKeys(string $valueKey = 'value', string $textKey = 'text'): SelectOption
    {
        $this->textKey = $textKey;
        $this->valueKey = $valueKey;
        return $this;
    }

    /**
     * Obter o valor atribuído à opção
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Obtém o texto a ser exibido atribuído à opção
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * Configuração da serialização para JSON
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            $this->valueKey => $this->getValue(),
            $this->textKey => $this->getText(),
        ];
    }
}
