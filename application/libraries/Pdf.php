<?php
include_once APPPATH . '/third_party/fpdf/fpdf.php';

class PDF extends FPDF
{

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-25);

        //$this->Image('assets/bsre.png', 157, $this->GetY()+1, 32, 13);

        $this->SetFont('Arial', 'I', 7);


        $this->Rect(16, $this->GetY()-3, 178, 15, 'D'); //For A4

        $this->Cell(5, 3, '1.', 0, 0, 'L');
        $this->MultiCell(170, 3, 'Dokumen ini diterbitkan sistem OSS berdasarkan data dari Pelaku Usaha, tersimpan dalam sistem OSS, yang menjadi tanggung jawab Pelaku Usaha.', 0, 3);

        $this->Cell(5, 3, '2.', 0, 0, 'L');
        $this->MultiCell(130, 3, 'Dalam hal terjadi kekeliruan isi dokumen ini akan dilakukan perbaikan sebagaimana mestinya.', 0, 1);

        // $this->Cell(5, 3, '3.', 0, 0, 'L');
        // $this->MultiCell(130, 3, 'Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan oleh BSrE-BSSN.', 0, 1);

        $this->Cell(5, 3, '3.', 0, 0, 'L');
        $this->MultiCell(130, 3, 'Data lengkap Perizinan Berusaha dapat diperoleh melalui sistem OSS menggunakan hak akses.', 0, 1);

    }
}

?>