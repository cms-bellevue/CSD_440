<?php
/**
 * Clint Scott
 * CSD440 Server-Side Scripting
 * Module 11 Programming Assignment
 * Database PDF Export Script
 * 03/13/2026
 *
 * This program:
 * - Integrates the FPDF library to generate a document
 * - Retrieves retro gaming data from the MySQL database
 * - Formats data into a structured table with a specific header and footer row
 * - Includes a general overview of the collection topic
 */

require_once __DIR__ . '/fpdf186/fpdf.php';
require_once __DIR__ . '/ClintDbConfig.php';

class ClintPDF extends FPDF {
    // Page header (Top of paper)
    function Header() {
        $this->SetFont('Helvetica', 'B', 15);
        $this->Cell(0, 10, 'RETRO GAMING INVENTORY REPORT', 0, 1, 'C');
        $this->Ln(5);
    }

    // Table Header Row
    function CreateTableHeader() {
        $this->SetFillColor(51, 255, 51); // Retro Green
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Helvetica', 'B', 10);
        $this->Cell(70, 10, 'Title', 1, 0, 'C', true);
        $this->Cell(40, 10, 'Platform', 1, 0, 'C', true);
        $this->Cell(25, 10, 'Year', 1, 0, 'C', true);
        $this->Cell(35, 10, 'Genre', 1, 0, 'C', true);
        $this->Cell(20, 10, 'Done', 1, 1, 'C', true);
    }

    // Table Footer Row
    function CreateTableFooter($count) {
        $this->SetFillColor(230, 230, 230); // Light grey footer row
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Helvetica', 'B', 10);
        // Spans the first 4 columns
        $this->Cell(170, 10, 'Total Records in Collection:', 1, 0, 'R', true);
        // Displays the total count in the last column
        $this->Cell(20, 10, $count, 1, 1, 'C', true);
    }

    // Page footer (Bottom of paper)
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Helvetica', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'End of Inventory Report - Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

try {
    $conn = get_db_connection();
    $sql = "SELECT title, platform, release_year, genre, is_completed FROM game_collection ORDER BY release_year ASC";
    $result = $conn->query($sql);
    $rowCount = $result->num_rows;

    // Initialize PDF
    $pdf = new ClintPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    
    // General Topic Information
    $pdf->SetFont('Helvetica', '', 11);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->MultiCell(0, 8, "This report contains a curated list of classic software titles spanning the MS-DOS, Atari, and NES eras. The data focuses on historical preservation and completion status for personal library auditing.", 0, 'L');
    $pdf->Ln(5);

    // 1. Data Table Header
    $pdf->CreateTableHeader();

    // 2. Data Table Body
    $pdf->SetFont('Courier', '', 9);
    if ($rowCount > 0) {
        while($row = $result->fetch_assoc()) {
            $status = $row['is_completed'] ? 'Yes' : 'No';
            $pdf->Cell(70, 8, substr($row['title'], 0, 35), 1);
            $pdf->Cell(40, 8, $row['platform'], 1);
            $pdf->Cell(25, 8, $row['release_year'], 1, 0, 'C');
            $pdf->Cell(35, 8, $row['genre'], 1);
            $pdf->Cell(20, 8, $status, 1, 1, 'C');
        }
    } else {
        $pdf->Cell(190, 10, 'No records found in the database.', 1, 1, 'C');
    }

    // 3. Data Table Footer
    $pdf->CreateTableFooter($rowCount);

    $pdf->Output('I', 'ClintGameCollection.pdf');

} catch (Exception $e) {
    die("Error generating PDF: " . $e->getMessage());
}