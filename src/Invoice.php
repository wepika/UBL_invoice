<?php
/**
 * Created by PhpStorm.
 * User: bram.vaneijk
 * Date: 13-10-2016
 * Time: 16:29
 */

namespace CleverIt\UBL\Invoice;


use Sabre\Xml\Writer;
use Sabre\Xml\XmlSerializable;

class Invoice implements XmlSerializable{
    private $UBLVersionID = '2.0';

    /**
     * @var int
     */
    private $id;
    /**
     * @var bool
     */
    private $copyIndicator = false;

    /**
     * @var \DateTime
     */
    private $issueDate;
    /**
     * @var string
     */

    private $invoiceTypeCode;

    /**
     * @var AdditionalDocumentReference
     */
    private $additionalDocumentReference;

    /**
     * @var Party
     */
    private $accountingSupplierParty;
    /**
     * @var Party
     */
    private $accountingCustomerParty;
    /**
     * @var TaxTotal
     */
    private $taxTotal;
    /**
     * @var LegalMonetaryTotal
     */
    private $legalMonetaryTotal;
    /**
     * @var InvoiceLine[]
     */
    private $invoiceLines;
    /**
     * @var AllowanceCharge[]
     */
    private $allowanceCharges;
    /**
     * @var \CleverIt\UBL\Invoice\PaymentMeans
     */
    private $paymentMeans;
    /**
     * @var string
     */
    private $note;

    function validate()
    {
        if ($this->id === null) {
            throw new \InvalidArgumentException('Missing invoice id');
        }

        if ($this->id === null) {
            throw new \InvalidArgumentException('Missing invoice id');
        }

        if (!$this->issueDate instanceof \DateTime) {
            throw new \InvalidArgumentException('Invalid invoice issueDate');
        }

        if ($this->invoiceTypeCode === null) {
            throw new \InvalidArgumentException('Missing invoice invoiceTypeCode');
        }

        if ($this->accountingSupplierParty === null) {
            throw new \InvalidArgumentException('Missing invoice accountingSupplierParty');
        }

        if ($this->accountingCustomerParty === null) {
            throw new \InvalidArgumentException('Missing invoice accountingCustomerParty');
        }

        if ($this->invoiceLines === null) {
            throw new \InvalidArgumentException('Missing invoice lines');
        }

        if ($this->legalMonetaryTotal === null) {
            throw new \InvalidArgumentException('Missing invoice LegalMonetaryTotal');
        }
    }

    function xmlSerialize(Writer $writer)
    {
        $this->validate();

        $writer->write([
            Schema::CBC . 'UBLVersionID' => $this->UBLVersionID,
            Schema::CBC . 'CustomizationID' => '1.0',
            Schema::CBC . 'ProfileID' => 'FFF.BE',
            Schema::CBC . 'ID' => $this->id,
            Schema::CBC . 'CopyIndicator' => $this->copyIndicator ? 'true' : 'false',
            Schema::CBC . 'IssueDate' => $this->issueDate->format('Y-m-d'),
            [
                'name' => Schema::CBC . 'InvoiceTypeCode',
                'value' => $this->invoiceTypeCode,
                'attributes' => [
                    'listURI' => 'http://www.FFF.be/ubl/2.0/cl/gc/BE-InvoiceCode-1.0.gc'
                ]
            ],
            Schema::CBC . 'DocumentCurrencyCode' => 'EUR',
            Schema::CBC . 'LineCountNumeric' => count($this->invoiceLines),
            Schema::CBC . 'Note' => $this->note,
        ]);

        if ($this->additionalDocumentReference != null) {
            $writer->write(
                [
                    Schema::CAC . 'AdditionalDocumentReference' => $this->additionalDocumentReference,
                ]
            );
        }

        $writer->write(
            [
                Schema::CAC . 'AccountingSupplierParty' => [Schema::CAC . "Party" => $this->accountingSupplierParty],
                Schema::CAC . 'AccountingCustomerParty' => [Schema::CAC . "Party" => $this->accountingCustomerParty],
            ]
        );

        if ($this->paymentMeans != null) {
            $writer->write(
                [
                    Schema::CAC . 'PaymentMeans' => $this->paymentMeans
                ]
            );
        }

        if ($this->allowanceCharges != null) {
            foreach ($this->allowanceCharges as $invoiceLine) {
                $writer->write([
                    Schema::CAC . 'AllowanceCharge' => $invoiceLine
                ]);
            }
        }

        if ($this->taxTotal != null) {
            $writer->write([
                Schema::CAC . 'TaxTotal' => $this->taxTotal
            ]);
        }

        $writer->write([
            Schema::CAC . 'LegalMonetaryTotal' => $this->legalMonetaryTotal
        ]);

        foreach ($this->invoiceLines as $invoiceLine) {
            $writer->write([
                Schema::CAC . 'InvoiceLine' => $invoiceLine
            ]);
        }

    }

    /**
     * @return int
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Invoice
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isCopyIndicator() {
        return $this->copyIndicator;
    }

    /**
     * @param boolean $copyIndicator
     * @return Invoice
     */
    public function setCopyIndicator($copyIndicator) {
        $this->copyIndicator = $copyIndicator;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getIssueDate() {
        return $this->issueDate;
    }

    /**
     * @param \DateTime $issueDate
     * @return Invoice
     */
    public function setIssueDate($issueDate) {
        $this->issueDate = $issueDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getInvoiceTypeCode() {
        return $this->invoiceTypeCode;
    }

    /**
     * @param string $invoiceTypeCode
     * @return Invoice
     */
    public function setInvoiceTypeCode($invoiceTypeCode) {
        $this->invoiceTypeCode = $invoiceTypeCode;
        return $this;
    }

    /**
     * @return AdditionalDocumentReference
     */
    public function getAdditionalDocumentReference() {
        return $this->additionalDocumentReference;
    }

    /**
     * @param AdditionalDocumentReference $additionalDocumentReference
     * @return Invoice
     */
    public function setAdditionalDocumentReference($additionalDocumentReference) {
        $this->additionalDocumentReference = $additionalDocumentReference;
        return $this;
    }

    /**
     * @return Party
     */
    public function getAccountingSupplierParty() {
        return $this->accountingSupplierParty;
    }

    /**
     * @param Party $accountingSupplierParty
     * @return Invoice
     */
    public function setAccountingSupplierParty($accountingSupplierParty) {
        $this->accountingSupplierParty = $accountingSupplierParty;
        return $this;
    }

    /**
     * @return Party
     */
    public function getAccountingCustomerParty() {
        return $this->accountingCustomerParty;
    }

    /**
     * @param Party $accountingCustomerParty
     * @return Invoice
     */
    public function setAccountingCustomerParty($accountingCustomerParty) {
        $this->accountingCustomerParty = $accountingCustomerParty;
        return $this;
    }

    /**
     * @return TaxTotal
     */
    public function getTaxTotal() {
        return $this->taxTotal;
    }

    /**
     * @param TaxTotal $taxTotal
     * @return Invoice
     */
    public function setTaxTotal($taxTotal) {
        $this->taxTotal = $taxTotal;
        return $this;
    }

    /**
     * @return LegalMonetaryTotal
     */
    public function getLegalMonetaryTotal() {
        return $this->legalMonetaryTotal;
    }

    /**
     * @param LegalMonetaryTotal $legalMonetaryTotal
     * @return Invoice
     */
    public function setLegalMonetaryTotal($legalMonetaryTotal) {
        $this->legalMonetaryTotal = $legalMonetaryTotal;
        return $this;
    }

    /**
     * @return InvoiceLine[]
     */
    public function getInvoiceLines() {
        return $this->invoiceLines;
    }

    /**
     * @param InvoiceLine[] $invoiceLines
     * @return Invoice
     */
    public function setInvoiceLines($invoiceLines) {
        $this->invoiceLines = $invoiceLines;
        return $this;
    }

    /**
     * @return AllowanceCharge[]
     */
    public function getAllowanceCharges() {
        return $this->allowanceCharges;
    }

    /**
     * @param AllowanceCharge[] $allowanceCharges
     * @return Invoice
     */
    public function setAllowanceCharges($allowanceCharges) {
        $this->allowanceCharges = $allowanceCharges;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentMeans()
    {
        return $this->paymentMeans;
    }

    /**
     * @param mixed $paymentMeans
     */
    public function setPaymentMeans($paymentMeans)
    {
        $this->paymentMeans = $paymentMeans;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }
}
