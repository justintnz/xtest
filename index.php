<?php
const INVOICE_FILE = './test_files/invoice.txt';
// List of supplier names, can be stored in multiple files
const SUPPLIER_FILES = [
    './test_files/data1.txt',
    './test_files/data2.txt',
    './test_files/data3.txt',
    './test_files/data4.txt',
    './test_files/data5.txt',
    './test_files/suppliernames.txt',
];

function loadInvoice($invoiceFile): array
{
    $handle = file_exists($invoiceFile) ? fopen($invoiceFile, "r") : null;
    $data = [];
    $lines = [];
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $line = str_replace(['"', "'"], ['\"', '"'], $line);
            $row = json_decode($line, TRUE);
            $data[(int) $row['page_id']][(int) $row['line_id']][(int) $row['pos_id']] = strtolower($row['word']);
        }
        fclose($handle);
        ksort($data); // make sure pages in right order
        foreach ($data as $pageKey => $page) {
            if (is_array($page)) {
                ksort($page); // make sure lines on page in right order
                foreach ($page as $rowKey => $row) {
                    if (is_array($row)) {
                        ksort($row); // make sure words in line are in right order
                        $lines["P{$pageKey} L{$rowKey}"] = implode(' ', $row);
                    }
                }
            }
        }
    } else {
        die("Error! {$invoiceFile} not found \n");
    }
    return $lines;
}


function isExistSupplier($supplier, $invoice): int
{
    $supplier = strtolower(trim($supplier));
    foreach ($invoice as $line) {
        if (strpos($line, $supplier) !== false)
            return true;
    }
    return false;
}

function matchSupplierFiles($supplierFile, $invoice): string
{
    foreach ($supplierFile as $supplierFile) {
        $handle = file_exists($supplierFile) ? fopen($supplierFile, "r") : null;
        if ($handle) {
            echo ("Looking at '{$supplierFile}' \n");
            while (($line = fgets($handle)) !== false) {
                $row  = explode(',', $line);
                if (isExistSupplier($row[1], $invoice)) {
                    fclose($handle);
                    return $row[0];
                }
            }

            fclose($handle);
        } else {
            echo "Warning!!! '{$supplierFile}' not found \n";
        }
    }
    return '';
}

function main(): void
{
    $data = loadInvoice(INVOICE_FILE);
    $sup = matchSupplierFiles(SUPPLIER_FILES, $data);
    if ($sup) {
        echo "Matched supplier: {$sup}";
    } else {
        echo "Supplier nor found";
    }
}

main();
