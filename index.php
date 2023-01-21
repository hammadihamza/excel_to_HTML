<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excel to HTML table</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="./style.css">


    </head>
<body>
    <?php
   //echo uniqid('', true); 
    require("vendor/autoload.php");
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
    $spreadsheet = $reader->load("./DATA.xlsx");
    $worksheet = $spreadsheet->getActiveSheet();

    // Get the highest column and row values
    $highestColumn = $worksheet->getHighestColumn();
    $highestRow = $worksheet->getHighestRow();
    
    // Start the table
    echo '<table style="text-align:center;">';
    
    // header row flag
    $headerRow = true;
    
    // number of columns in header row
    $columnCount = 0;
    
    // Iterate through rows
    for ($row = 1; $row <= $highestRow; $row++) {
        echo '<tr>';
        // Iterate through columns
        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $cell = $worksheet->getCell($col.$row);
            // check if cell is empty
            if (empty($cell->getValue())) {
                // Echo "null"
                if ($headerRow) {
                    echo '<th>null</th>';
                    $columnCount++;
                } else {
                    echo '<td>null</td>';
                }
            } else {
                // Echo the value using <th> tags for the header and <td> tags for the rest of the data
                if ($headerRow) {
                    echo '<th>'.$cell->getValue().'</th>';
                    $columnCount++;
                } else {
                    echo '<td>'.$cell->getValue().'</td>';
                }
            }
        }
        echo '</tr>';
        // set headerRow flag to false after first row
        $headerRow = false;
    }
    
    // End the table
    echo '</table>';
    
    //Initialize DataTables
    echo "<script>
    $(document).ready( function () {
        $('table').DataTable({
            deferRender: true,
            'bSort': false,
            'columns': [
                { 'searchable': true },
                { 'searchable': true },
                { 'searchable': true },
                { 'searchable': true }
               ],
            'searching': {
                'caseInsensitive': true
                },
            columnDefs: [{ targets: [$columnCount-1], visible: false }]
        });
    } );
</script>";
    ?>

</body>
</html>