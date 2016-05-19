<?php ob_start(); ?>
<?php
/*include_once 'db.php';
$db = new PDO(DB_INFO, DB_USER, DB_PASS);
$id = $_GET['quote_id'];
$sql = "SELECT *
FROM quotes_cart 
WHERE quote_id=? AND quote_status=?
LIMIT 1";

$stmt = $db->prepare($sql);
$stmt->execute(array($id, 'Approved'));*/

// Save the returned entry array
//$e = $stmt->fetch();

$cartamount= 100;
$item='testproduct';

$websiteurl='http://www.appleflyers.com/';
$shipmentamont='0.00';
$addshipment=0;

////all hidden variables
//$g1 = $_REQUEST['group1'];
//$g2 = $_REQUEST['group2'];
//
////since we need to set Item_name in paypal
//if($g1=="1")
//	{
//		$group1="Prochaine formation Paris 1, 2, 3 & 4 mars 2013
//";//"du 20 au 23 octobre 2011, Paris";
//	}
//elseif($g1=="2")
//	{	
//		$group1="Prochaine formation Paris 1, 2, 3 & 4 mars 2013
//";//"du 11, 12, 13 & 14 octobre 2012, Paris";	
//	}
//else //3
//	{	
//		$group1="Prochaine formation Paris 1, 2, 3 & 4 mars 2013
//";//"du 11, 12, 13 & 14 octobre 2012, Paris";	
//	}
				
?>

<?php

/*  PHP Paypal IPN Integration Class Demonstration File
 *  4.16.2005 - Micah Carrick, email@micahcarrick.com
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed  
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4 
 *  virtual pages depending on the "action" varialble passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
 *
 *  I tried to comment this file, aswell as the acutall class file, as well as
 *  I possibly could.  Please email me with questions, comments, and suggestions.
 *  See the header of paypal.class.php for additional resources and information.
*/

// Setup class
require_once('paypal.class.php');  // include the class file
$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
            
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action'])) $_GET['action'] = 'process';  

switch ($_GET['action']) {
    
   case 'process':      // Process and order...

      // There should be no output at this point.  To process the POST data,
      // the submit_paypal_post() function will output all the HTML tags which
      // contains a FORM which is submited instantaneously using the BODY onload
      // attribute.  In other words, don't echo or printf anything when you're
      // going to be calling the submit_paypal_post() function.
 
      // This is where you would have your form validation  and all that jazz.
      // You would take your POST vars and load them into the class like below,
      // only using the POST values instead of constant string expressions.
 
      // For example, after ensureing all the POST variables from your custom
      // order form are valid, you might have:
      //
      // $p->add_field('first_name', $_POST['first_name']);
      // $p->add_field('last_name', $_POST['last_name']);

	  
      $p->add_field('business', 'kiani_1359496277_biz@gmail.com');
      $p->add_field('return', $this_script.'?action=success');
      $p->add_field('cancel_return', $this_script.'?action=cancel');
      $p->add_field('notify_url', $this_script.'?action=ipn');	
	  $p->add_field('item_name', $item);
	  $p->add_field('amount', $cartamount);
	  if($addshipment==1) $p->add_field('shipping', $shipmentamont);
	  $p->add_field('currency_code', "USD");
	  //$p->add_field('upload', "1");
	  $customfileds='id='.$id.'&price='.$cartamount.'&product='.$item;
      $p->add_field('custom', $customfileds);
      $p->submit_paypal_post(); // submit the fields to paypal
      //$p->dump_fields();      // for debugging, output a table of all the fields	  
      break;
      
   case 'success':      // Order was successful...
   
      // This is where you would probably want to thank the user for their order
      // or what have you.  The order information at this point is in POST 
      // variables.  However, you don't want to "process" the order until you
      // get validation from the IPN.  That's where you would have the code to
      // email an admin, update the database with payment status, activate a
      // membership, etc.  

      echo "<html><head><title>Success</title></head><body><h3>Merci pour votre commande.</h3>";
      foreach ($_POST as $key => $value) { echo "$key: $value<br>"; }
      echo "</body></html>";
	  header("Location: thankyou.php"); 
      // You could also simply re-direct them to another page, or your own 
      // order status page which presents the user with the status of their
      // order based on a database (which can be modified with the IPN code 
      // below).
      
      break;
      
   case 'cancel':       // Order was canceled...

      // The order was canceled before being completed.
 
      echo "<html><head><title>Canceled</title></head><body><h3>La commande a été annulée.</h3>";
      echo "</body></html>";
      header("Location: atp_quotehistory.php"); 
      break;
      
   case 'ipn':          // Paypal is calling page for IPN validation...
    	
		//$custom = $_REQUEST['custom'];
		//mail("usman.mangak@gmail.com", 'Paypal test '.count($custom).' >IPN', 'test from paypal sandbox4');  


      // It's important to remember that paypal calling this script.  There
      // is no output here.  This is where you validate the IPN data and if it's
      // valid, update your database to signify that the user has payed.  If
      // you try and use an echo or printf function here it's not going to do you
      // a bit of good.  This is on the "backend".  That is why, by default, the
      // class logs all IPN data to a text file.

      if (1) {
       
         // Payment has been recieved and IPN is verified.  This is where you
         // update your database to activate or process the order, or setup
         // the database with the user's order details, email an administrator,
         // etc.  You can access a slew of information via the ipn_data() array.
  
         // Check the paypal documentation for specifics on what information
         // is available in the IPN POST variables.  Basically, all the POST vars
         // which paypal sends, which we send back for validation, are now stored
         // in the ipn_data() array.
		 
		 //Get your custom feild variables
			$custom = $_REQUEST['custom'];
			$delimiter = "&";
			$customvariables = array();
			
			$namevaluecombos = explode($delimiter, $custom);
			
			foreach ($namevaluecombos as $keyval_unparsed)
			{
				$equalsignposition = strpos($keyval_unparsed, '=');
				if ($equalsignposition === false)
				{
					$customvariables[$keyval_unparsed] = '';
					continue;
				}
				$key = substr($keyval_unparsed, 0, $equalsignposition);
				$value = substr($keyval_unparsed, $equalsignposition + 1);
				$customvariables[$key] = $value;
			}				

		$id = $customvariables['id'];
		$price = $customvariables['price'];
		$product = $customvariables['product'];
				
		include_once 'db.php';
		$db = new PDO(DB_INFO, DB_USER, DB_PASS);
		
		$sql = "UPDATE quotes_cart
		SET quote_status=?, quote_price=?, order_status=?
		WHERE quote_id=?
		LIMIT 1";

		$stmt = $db->prepare($sql);
		
		$stmt->execute(
		array(
		'pass_out',
		$price,
		'pending',
		$id
		));
		
		$stmt->closeCursor();		
				  
//		$g1 = $customvariables['g1']; 
//		$g2 = $customvariables['g2'];
//
//		if($count=="1")
//			{
//				$group1="Prochaine formation Paris 1, 2, 3 & 4 mars 2013";
//			}
//		elseif($g1=="2")
//			{	
//				$group1="Prochaine formation Paris 1, 2, 3 & 4 mars 2013";	
//			}
//		else //3
//			{	
//				$group1="Prochaine formation Paris 1, 2, 3 & 4 mars 2013";	
//			}
//		
//			
//		if($g2=="1")
//			{
//				$group2="Je règle d&egrave;s maintenant 75 € de frais de dossier. A l’issue de la formation, et uniquement si je suis satisfait de la qualité de l'enseignement reçu pendant ces 4 jours, je m’engage à effectuer le paiement de 2100 €.";
//			}
//		else //2
//			{
//				$group2="Je souhaite bénéficier d’un plan de paiement.Je règle maintenant 75 € de frais de dossier. A l’issue de la formation, et uniquement si je suis satisfait de la qualité de l'enseignement reçu, je m’engage à régler le reste en 6 chèques de 350 €. Le premier chèque sera encaissé au bout de 30 jours, et les autres suivront au même rythme.";
//			}		
//		 		 
		$headers = "From: www.appleflyers.com\r\n";
		$headers .= "Reply-To: www.appleflyers.com\r\n";
		//$headers .= "Cc: tonypodosky@bigpond.com";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		$subject = "www.appleflyers.com - Order Confirmation";
		
		$message = '<html><body style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;">';
		$message .= "Cher utilisateur ".",<br><br>";
		$message .= "Thank you for booking. Your order has been registered. Here are the details:<br><br>";
		$message .= '<table rules="all" style="border-color: #666;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:12px;" cellpadding="10">';		
		$message .= "<tr style='background: #eee;'><td><strong>ID de commande:</strong> </td><td>" . $_REQUEST['txn_id']. "B</td></tr>";
		$message .= '<tr><td><strong>1</strong> </td><td>'.$product.'</td></tr>';		
		$message .= '<tr><td><strong>Order placed on:</strong> </td><td>'.$_REQUEST['payment_date'].'</td></tr>'; //Order Placed On
		$message .= '<tr><td><strong>Gross Payment:</strong> </td><td>€ '.$_REQUEST['mc_gross'].'</td></tr>';//gross payment		
//		$message .= '<tr><td colspan="2">&nbsp;</td></tr>';
		$message .= "<tr style='background: #eee;'><td colspan='2'><strong>Infos payeur:</strong></td></tr>";//Payer Info
                $message .= '<tr><td><strong>Email:</strong> </td><td>'.$_REQUEST['payer_email'].'</td></tr>';
		$message .= '<tr><td><strong>Adress</strong> </td><td>'.$_REQUEST['address_street'].'</td></tr>';
		$message .= '<tr><td><strong>City:</strong> </td><td>'.$_REQUEST['address_city'].'</td></tr>';
		$message .= '<tr><td><strong>State:</strong> </td><td>'.$_REQUEST['address_state'].'</td></tr>';
		$message .= '<tr><td><strong>Zip:</strong> </td><td>'.$_REQUEST['address_zip'].'</td></tr>';
		$message .= '<tr><td><strong>Country:</strong> </td><td>'.$_REQUEST['address_country'].'</td></tr>';
		$message .= "</table>";
		$message .= "<br><br>Thank you.";
		$message .= "</body></html>"; 		
		
		//to admin
		//mail("yasir.bhatti99@gmail.com", $subject, $message,$headers);	

		//send email to buyer
        //mail($_REQUEST['receiver_email'], $subject, $message,$headers);
		
      }
      break;
 }     

?>