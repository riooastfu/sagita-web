<?php
            $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
            $pdf->SetTitle('Sales Report');
            $pdf->SetHeaderMargin(30);
            $pdf->SetTopMargin(20);
            $pdf->setFooterMargin(20);
            $pdf->SetAutoPageBreak(true);
            $pdf->SetAuthor('Author');
            $pdf->SetDisplayMode('real', 'default');
            $pdf->AddPage();
            $i=0;
            $html='<h3>Sales Report</h3>
                    <table cellspacing="1" bgcolor="#666666" cellpadding="2">
                        <tr bgcolor="#ffffff">
                            <th width="32%" align="center">Title</th>
                            <th width="32%" align="center">Quantity</th>
                            <th width="32%" align="center">Unit-Price</th>
                            
                            
                        </tr>';
                                
            foreach ($report as $r) 
           
                {
                    $html.='<tr bgcolor="#ffffff">
                            
                        
                            <td>'.$r['nama_buku'].'</td>
                            <td>'.$r['jumlah'].'</td>
                            <td align="right">'.number_format($r['harga'],0,",",",").'</td>
                 
                        </tr>';      
                        
                }
            $html.='</table>';
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output('salesreport.pdf', 'I');
?>