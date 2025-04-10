<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
include_once APPPATH . '/third_party/fpdf/fpdf.php';

class CustomFPDF extends FPDF
{
    protected $col = 0; // Current column
    protected $y0;      // Ordinate of column start

    function Header()
    {
        global $title;
        $this->SetFont('Arial', 'B', 10);
        $this->SetDrawColor(0, 80, 180);
        $this->SetFillColor(20, 876, 0);
        $this->SetLineWidth(0);
        $this->Cell(0, 1, $title, 0, 1, 'C');
        $this->Ln(4);
        // Save ordinate
        $this->y0 = $this->GetY(); // To be implemented in your own inherited class
    }
    function Footer()
    {
        // Page footer
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 10);
        $this->SetTextColor(128);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
        //To be implemented in your own inherited class
    }
    function SetCol($col)
    {
        // Set position at a given column
        $this->col = $col;
        $x = 10 + $col * 100;
        $this->SetLeftMargin($x);
        $this->SetX($x);
    }

    function AcceptPageBreak()
    {
        // Method accepting or not automatic page break
        if ($this->col < 1) {
            // Go to next column
            $this->SetCol($this->col + 1);
            // Set ordinate to top
            $this->SetY($this->y0);
            // Keep on page
            return false;
        } else {
            // Go back to first column
            $this->SetCol(0);
            // Page break
            return true;
        }
    }

    public function getInstance()
    {
        return new CustomFPDF();
    }
}
