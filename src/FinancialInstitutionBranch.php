<?php

namespace CleverIt\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class FinancialInstitutionBranch implements XmlSerializable
{
    private $financialInstitions;

    /**
     * @return mixed
     */
    public function getFinancialInstitions()
    {
        return $this->financialInstitions;
    }

    function xmlSerialize(Writer $writer)
    {
        /**
         *  <cac:FinancialInstitutionBranch>
         *      <cac:FinancialInstitution>
         *          <cbc:ID schemeID="BIC">KREDBEBB</cbc:ID>
         *      </cac:FinancialInstitution>
         *  </cac:FinancialInstitutionBranch>
         */

        foreach ($this->financialInstitions as $financialInstition) {
            $writer->write(
                [
                    Schema::CAC . 'FinancialInstitution' => [
                        [
                            'name' => Schema::CBC . 'ID',
                            'value' => $financialInstition->getId(),
                            'attributes' => [
                                'schemeID' => 'BIC'
                            ]
                        ]
                    ]
                ]
            );
        }
    }

    public function addFinancialInstitution($financialInstitution)
    {
        $this->financialInstitions[] = $financialInstitution;
    }
}
