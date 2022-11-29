<?php

namespace CleverIt\UBL\Invoice;

use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class PaymentMeans implements XmlSerializable
{
    private $paymentMeansCode;
    private $paymentID;
    private $payeeFinancialAccount;

    /**
     * @return mixed
     */
    public function getPaymentMeansCode()
    {
        return $this->paymentMeansCode;
    }

    /**
     * @param mixed $paymentMeansCode
     */
    public function setPaymentMeansCode($paymentMeansCode)
    {
        $this->paymentMeansCode = $paymentMeansCode;
    }

    /**
     * @return mixed
     */
    public function getPaymentID()
    {
        return $this->paymentID;
    }

    /**
     * @param mixed $paymentID
     */
    public function setPaymentID($paymentID)
    {
        $this->paymentID = $paymentID;
    }

    /**
     * @return mixed
     */
    public function getPayeeFinancialAccount()
    {
        return $this->payeeFinancialAccount;
    }

    /**
     * @param mixed $payeeFinancialAccount
     */
    public function setPayeeFinancialAccount($payeeFinancialAccount)
    {
        $this->payeeFinancialAccount = $payeeFinancialAccount;
    }

    function xmlSerialize(Writer $writer)
    {
        /**
         *  <cac:PaymentMeans>
         *      <cbc:PaymentMeansCode listID="UNCL4461">42</cbc:PaymentMeansCode>
         *      <cbc:PaymentID>K-20-04-15597</cbc:PaymentID>
         *      <cac:PayeeFinancialAccount>
         *          <cbc:ID schemeID="IBAN">BE0870808293</cbc:ID>
         *          <cac:FinancialInstitutionBranch>
         *              <cac:FinancialInstitution>
         *                  <cbc:ID schemeID="BIC">KREDBEBB</cbc:ID>
         *              </cac:FinancialInstitution>
         *          </cac:FinancialInstitutionBranch>
         *      </cac:PayeeFinancialAccount>
         *  </cac:PaymentMeans>
         */

        $writer->write(
            [
                [
                    'name' => Schema::CBC . 'PaymentMeansCode',
                    'value' => $this->paymentMeansCode,
                    'attributes' => [
                        'listID' => 'UNCL4461'
                    ]
                ],
                Schema::CBC . 'PaymentID' => $this->paymentID,
                Schema::CAC . 'PayeeFinancialAccount' => $this->payeeFinancialAccount,
            ]
        );
    }
}