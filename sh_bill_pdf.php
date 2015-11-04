<?php

@session_start();

if(mysql_real_escape_string($_GET['do'])=='by_voditel' or mysql_real_escape_string($_GET['do'])=='by_postanov') $do=mysql_real_escape_string($_GET['do']);
elseif (!isset($_GET['moneta'])) $do="by_voditel";
elseif (isset($_GET['moneta'])){

	if ($_GET['moneta']=="success") {

		if(isset($_GET['MNT_TRANSACTION_ID']) and is_numeric($_GET['MNT_TRANSACTION_ID'])){



			$TRANSACTION_ID=mysql_real_escape_string($_GET['MNT_TRANSACTION_ID']);

			$q_gos= "SELECT * FROM payment WHERE payment_id = \"".$TRANSACTION_ID."\" AND payment_confirm= \"1\" LIMIT 1";
			$res_gos=mysql_query($q_gos);

			if (mysql_num_rows($res_gos)>0){
				$row_gos = mysql_fetch_array($res_gos);
				require_once($up_way.'dir/modules/tcpdf/config/lang/rus.php');
				require_once($up_way.'dir/modules/tcpdf/tcpdf.php');
				// PDF_PAGE_FORMAT - A4
				// PDF_PAGE_ORIENTATION
				// PDF_UNIT - mm

				$pdf = new TCPDF('P', 'mm', array(108, 200), true, 'UTF-8', false);


				$pdf->SetTitle('Transaction ID Ref ' . $TRANSACTION_ID);
				// remove default header/footer
				$pdf->setPrintHeader(false);
				$pdf->setPrintFooter(false);
				$pdf->setJPEGQuality(100);
				$pdf->SetMargins(10, 10, true);
				// add a page
				$pdf->AddPage();
				$pdf->SetFont('arial', '', 8);

					
				$strContent = '<div style="border:1px dashed #aaa;"><br/><span style="text-align:center">НКО «МОНЕТА.РУ» (ООО)</span><br/>
				<span style="text-align:center">424000, Российская Федерация,</span><br/>
				<span style="text-align:center">Республика Марий Эл, г. Йошкар-Ола,</span><br/>
				<span style="text-align:center">ул. Гоголя, д. 2, строение "А"</span><br/>
				<span style="text-align:center">тел./факс: 8 (495) 743-49-85,</span><br/>
				<span style="text-align:center;">e-mail: helpdesk.support@moneta.ru</span><br/>
				<div style="text-align:center;border-top:1px solid #aaa;border-bottom:1px solid #aaa;height:100px"><br/>
				<b>Квитанция об оплате</b><br/>
				</div><br/>
				<span style="text-align:left;">&nbsp;&nbsp;Номер операции: '.$row_gos['MNT_OPERATION_ID'].'</span><br/>
				<span style="text-align:left;">&nbsp;&nbsp;Дата и время: '.$row_gos['payment_date'].'</span><br/><br/>
				<span style="text-align:left;">&nbsp;&nbsp;Сумма платежа: '.($row_gos['payment_amount']+$row_gos['payment_comission']).'.00 RUB</span><br/>
				<span style="text-align:left;">&nbsp;&nbsp;В том числе комиссия: '.$row_gos['payment_comission'].'.00 RUB</span><br/><br/>
				<span style="text-align:left;">&nbsp;&nbsp;Реквизиты плательщика:</span>
				<div style="text-align:center;border-bottom:1px solid #aaa;height:100px">
				<span style="text-align:left;">&nbsp;&nbsp;Номер карты: '.$row_gos['cardnumber'].'</span><br/><br/>
				<span style="text-align:left;">&nbsp;&nbsp;Оплачено на сайте: onlinegibdd.ru</span><br/>
				</div><br/>';
				
				$user_id=$row_gos['user_id'];
				$partner_id=$row_gos['partner_id'];

				$payment_fio=$row_gos['payment_fio'];
				$payment_phone=$row_gos['payment_phone'];

				$phone_out="8-".substr($payment_phone, 0 , 2).'*-***-'.substr($payment_phone, 6 , 2).'-'.substr($payment_phone, 8 , 2);


				$ext_bill_id=explode("|", $row_gos['bill_id']);
				$ext_bill_amount=explode("|", $row_gos['bill_amount']);
				$ext_bill_date=explode("|", $row_gos['bill_date']);
				$ext_bill_comission=explode("|", $row_gos['bill_comission']);
				$ext_bill_pay_system=explode("|", $row_gos['pay_system']);
				$ext_postanov=explode("|", $row_gos['postanov']);
				
				
				for ($i=0; $i<(count($ext_bill_id)-1); $i++){
					$bill_id=$ext_bill_id[$i];
					$bill_amount=$ext_bill_amount[$i];//сумма 
					$bill_date=$ext_bill_date[$i];//дата
					$bill_comission=$ext_bill_comission[$i];//комиссия

					if ($ext_bill_pay_system[$i]=="mari")

					$postanov=$bill_id;

					else {

					$postanov=$ext_postanov[$i];//постановление

					}
					//выборка данных для вывода подробностей платежа полностью
					$q_bill_all= "SELECT * FROM payment_bill WHERE pay_bill_id = \"".$bill_id."\" LIMIT 1"; //ищем данные по платежу
					$res_bill_all=mysql_query($q_bill_all);
					$row_bill_all = mysql_fetch_array($res_bill_all);

					if ($row_bill_all['pay_system']=="mari")

					$row_bill_all['addinfo']=set_mari_addon($row_bill_all['mari_id']);

					$strContent .= '

					<span style="text-align:left;">&nbsp;&nbsp;Вид платежа: Оплата штрафов ГИБДД</span><br/>
					<span style="text-align:left;">&nbsp;&nbsp;Наименование платежа: ШТРАФ ПО</span><br/><span style="text-align:left;">&nbsp;&nbsp;АДМИНИСТРАТИВНОМУ ПРАВОНАРУШЕНИЮ</span><br/><span style="text-align:left;">&nbsp;&nbsp;ПОСТАНОВЛЕНИЕ <b>№'.str_replace("Z", "", $postanov).' ОТ '.$bill_date.'</b></span><br/>
					<span style="text-align:left;">&nbsp;&nbsp;Сумма штрафа: <b>'.$bill_amount.' руб.</b></span><br/>
					<span style="text-align:left;">&nbsp;&nbsp;Комиссия: '.$bill_comission.'.00 руб.</span><br/>
					<span style="text-align:left;">&nbsp;&nbsp;Параметры платежа</span><br/>
					<span style="text-align:left;">&nbsp;&nbsp;Контактный телефон плательщика: '.$phone_out.'</span><br/>
					<span style="text-align:left;">&nbsp;&nbsp;Идентификатор платежа: '.$bill_id.'</span><br/>
					<span style="text-align:left;">&nbsp;&nbsp;ФИО плательщика: '.$payment_fio.'</span><br/>';

					if (!empty($add_info[0])){
						$strContent .= '<span style="text-align:left;">&nbsp;&nbsp;'.trim($add_info[1]).'</span><br/>
						<span style="text-align:left;">&nbsp;&nbsp;'.trim($add_info[2]).'</span><br/>
						<span style="text-align:left;">&nbsp;&nbsp;'.trim($add_info[3]).'; '.$add_info[4].'</span><br/>
						<span style="text-align:left;">&nbsp;&nbsp;'.trim($add_info[5]).'</span><br/>
						<span style="text-align:left;">&nbsp;&nbsp;'.trim($add_info[6]).'</span><br/>
						<span style="text-align:left;">&nbsp;&nbsp;'.trim($add_info[7]).'</span><br/>';
					}


					$strContent .= '<br/>';
				
				}
			

				$strContent .= '<span style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="/dir/modules/sh_bill/images/ispolneno.png" style="width:153px"></span><br/>
								<span style="text-align:center">По вопросам, связанным с исполнением платежа,</span><br/>
								<span style="text-align:center">необходимо направить заявление</span><br/>
								<span style="text-align:center">по адресу электронной почты,</span><br/>
								<span style="text-align:center">указанному в данной квитанции.</span><br/><br/>
								<span style="text-align:center">По прочим вопросам необходимо</span><br/>
								<span style="text-align:center">обращаться к получателю платежа.</span><br/></div>';
				
$strContent = iconv('windows-1251', 'UTF-8', $strContent);
					$pdf->writeHTML($strContent, true, 0, true, 0);
					//Close and output PDF document
					$file_name = 'Transaction_' . $TRANSACTION_ID . '.pdf';
					$pdf->Output($file_name, 'I');
					
//echo '<html><head></head><body marginwidth="0" marginheight="0" style="background-color:#262626;"><embed width="100%" height="100%" src="http://onlinegibdd.ru/uploads/pdf/'.$file_name.'" type="application/pdf"></body></html>';
			}
		}
	}
}
?>