<?php
/**
 * Created by PhpStorm.
 * User: bram.vaneijk
 * Date: 26-10-2016
 * Time: 10:49
 */

namespace CleverIt\UBL\Invoice;

use Sabre\Xml\Service;

class Generator {
    public static $currencyID;

    public static function invoice(Invoice $invoice, $currencyId = 'EUR') {
        self::$currencyID = $currencyId;

        $xmlService = new Service();

        $xmlService->namespaceMap = [
            'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2' => '',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2' => 'cbc',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2' => 'cac'
        ];

        $nameSpaces = [
            'xmlns:qdt="urn:oasis:names:specification:ubl:schema:xsd:QualifiedDatatypes-2"',
            'xmlns:ccts="urn:oasis:names:specification:ubl:schema:xsd:CoreComponentParameters-2"',
            'xmlns:stat="urn:oasis:names:specification:ubl:schema:xsd:DocumentStatusCode-1.0"',
            'xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2"',
            'xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2"',
            'xmlns:udt="urn:un:unece:uncefact:data:draft:UnqualifiedDataTypesSchemaModule:2"',
            'xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2"',
            'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"',
            'xsi:schemaLocation="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2 file:UBL-Invoice-2.0.xsd"',
        ];

        $output = $xmlService->write('Invoice', [
            $invoice
        ]);

        $search = '<Invoice xmlns="urn:oasis:names:specification:ubl:schema:xsd:Invoice-2" xmlns:cbc="urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2" xmlns:cac="urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2">';
        $elementWithNamespaces = '<Invoice ' . implode(' ', $nameSpaces) . '>';
        $output = str_replace($search, $elementWithNamespaces, $output);

        return $output;
    }
}