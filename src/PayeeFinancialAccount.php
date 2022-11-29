<?php

namespace CleverIt\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PayeeFinancialAccount implements XmlSerializable
{
    private $id;
    private $financialInstitutionBranch;

    function xmlSerialize(Writer $writer)
    {
        /**
         *  <cac:PayeeFinancialAccount>
         *      <cbc:ID schemeID="IBAN">BE0870808293</cbc:ID>
         *      <cac:FinancialInstitutionBranch>
         *          <cac:FinancialInstitution>
         *              <cbc:ID schemeID="BIC">KREDBEBB</cbc:ID>
         *          </cac:FinancialInstitution>
         *      </cac:FinancialInstitutionBranch>
         *  </cac:PayeeFinancialAccount>
         */

        $writer->write(
            [
                [
                    'name' => Schema::CBC . 'ID',
                    'value' => $this->id,
                    'attributes' => [
                        'schemeID' => 'IBAN'
                    ]
                ],
                Schema::CAC . 'FinancialInstitutionBranch' => $this->financialInstitutionBranch,
            ]
        );
    }

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

    /**
     * @return mixed
     */
    public function getFinancialInstitutionBranch()
    {
        return $this->financialInstitutionBranch;
    }

    /**
     * @param mixed $financialInstitutionBranch
     */
    public function setFinancialInstitutionBranch($financialInstitutionBranch)
    {
        $this->financialInstitutionBranch = $financialInstitutionBranch;
    }
}