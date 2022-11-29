<?php

namespace CleverIt\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class FinancialInstitution implements XmlSerializable
{
    private $id;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    function xmlSerialize(Writer $writer)
    {
        /**
         *  <cac:FinancialInstitution>
         *      <cbc:ID schemeID="BIC">KREDBEBB</cbc:ID>
         *  </cac:FinancialInstitution>
         */

        $writer->write(
            [
                [
                    'name' => Schema::CBC . 'ID',
                    'value' => $this->id,
                    'attributes' => [
                        'schemeID' => 'BIC'
                    ]
                ]
            ]
        );
    }
}