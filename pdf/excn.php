<?php
require('mbfpdf.php');

$pdf=new MBFPDF();
$pdf->AddMBFont(BIG5,'BIG5');
$pdf->Open();
$pdf->AddPage();
$pdf->SetFont(BIG5,'',20);
$pdf->Write(10,'�{�ɮ�� 18 C ��� 83 %');
$pdf->Output();
?>
