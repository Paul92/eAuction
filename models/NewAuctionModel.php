<?php

class NewAuctionModel extends Model {
  
    const NO_IMAGES      = 'Please add at least one file.';
    const NO_ITEM_NAME   = 'Please insert a name for your item.';
    const NO_START_PRICE = 'Please insert the start price of the auction.';
    const INAPPROPIATE_VALUE_START_PRICE = 'Please insert a positive integer
                                            as the value of the start price.';
    const NO_DESCRIPTION = 'Please insert a description for your item.';
    const NO_AUCTION_LENGTH = 'Please insert a duration for your auction.';
    const INAPPROPIATE_VALUE_AUCTION_LENGTH = 'Please insert a positive integer
                                               smaller than 30 as duration for
                                               your auction';
    const DESCRIPTION_TOO_LONG = 'The description should contain at most 1000
                                  characters.';
    const DUPLICATE_ITEM = 'You have added this item already.';

    const NO_MAIN_PICTURE = 'Please choose a main picture.';

    function __construct() {
        parent::__construct();
    }

    private function generateName($destDir, $fileName) {
        $slashIndex = strpos($fileName, '/');
        if ($slashIndex !== false)
            return $destDir . '/' . substr_replace($fileName, '/'.Session::get('itemId') . '_', $slashIndex, 1);
        else
            return $destDir . '/' . Session::get('itemId') . '_' . $fileName;
    }

    private function moveAllFilesToPermanentStorage($sourceDir,
                                                    $destDir,
                                                    $insertDb = false) {
        $files = scandir($sourceDir);
        foreach ($files as $file) {
            $filePath = "$sourceDir/$file";
            if (!is_dir($filePath)) {
                $newName = $this->generateName($destDir, $file);
                $newThumbnailName = $this->generateName($destDir . '/thumbnail',
                                                        $file);
                list($fileWidth, $fileHeight) = getimagesize('files/'.$file);
                list($thumbWidth, $thumbHeight) = getimagesize('files/thumbnail/' . $file);
                $fileSize = $fileWidth . 'x' . $fileHeight;
                $thumbSize = $thumbWidth . 'x' . $thumbHeight;
                if ($insertDb) {
                    $main = isset($_POST['main']) && $_POST['main'] == $file;
                    $this->createDbEntry($newName, $main, $newThumbnailName,
                                         $fileSize, $thumbSize);
                }
                rename($filePath, $newName);
                rename($sourceDir . '/thumbnail/' . $file, $newThumbnailName);
            }
        }
    }

    private function createDbEntry($filePath, $main, $thumbnailPath, $fileSize, $thumbSize) {
        $query = 'INSERT INTO image (filePath, itemId, main, size, thumbnailPath, thumbnailSize)
                  VALUES (:path, :id, :main, :size, :thumbnailPath, :thumbnailSize)';
        $this->db->executeQuery($query, array('path' => $filePath,
                                              'id' => Session::get('itemId'),
                                              'main' => $main,
                                              'size' => $fileSize,
                                              'thumbnailPath' => $thumbnailPath,
                                              'thumbnailSize' => $thumbSize));
    }

    public function getCategories() {
        $query = "SELECT * FROM category";
        $statement = $this->db->prepare($query);
        $statement->execute();
        $array = $statement->fetchAll();
        return $array;
    }

    public function uploadPictures() {
        $sourceDir = ROOT_DIR.'/files';
        $files = scandir($sourceDir);
        $num_files = count($files) - 3;
        if ($num_files != 0) {
            $this->moveAllFilesToPermanentStorage($sourceDir,
                                                 'permanentStorage', true);
        }
        if (Session::exists('itemId'))
            Session::remove('itemId');
    }

    public function submitForm() {
        $errors = array();
        $formArray = array();

        if (!isset($_POST['name']) || empty($_POST['name']))
            $errors['name'] = self::NO_ITEM_NAME;
        else
            $formArray['name'] = $_POST['name'];

        $formArray['category'] = $_POST['category'];
        $formArray['auctionType'] = $_POST['auctionType'];
        if (isset($_POST['featured']))
            $formArray['featured'] = true;
        else
            $formArray['featured'] = false;

        if (!isset($_POST['startPrice']) || empty($_POST['startPrice']))
            $errors['startPrice'] = self::NO_START_PRICE;
        else {
            $startPrice = intval($_POST['startPrice']);
            if ($startPrice <= 0)
                $errors['startPrice'] = self::INAPPROPIATE_VALUE_START_PRICE;
            else
                $formArray['startPrice'] = $_POST['startPrice'];
        }

        $_POST['description'] = trim($_POST['description']);
        if (!isset($_POST['description']) || empty($_POST['description']))
            $errors['description'] = self::NO_DESCRIPTION;
        else {
            $formArray['description'] = $_POST['description'];
            if (strlen($_POST['description']) > 1000)
                $errors['description'] = self::DESCRIPTION_TOO_LONG;
        }

        if (!isset($_POST['duration']) || empty($_POST['duration']))
            $errors['duration'] = self::NO_AUCTION_LENGTH;
        else {
            $duration = intval($_POST['duration']);
            if ($duration > 30 || $duration <= 0)
                $errors['duration'] = self::INAPPROPIATE_VALUE_AUCTION_LENGTH;
            else
                $formArray['duration'] = $duration;
        }

        $formArray['sellerId'] = Session::get('userId');

        if (empty($errors)) {
            if ($this->db->exists('item', array('name', 'sellerId'),
                                  array('name' => $formArray['name'],
                                        'sellerId' => $formArray['sellerId'])))
                $errors[] = self::DUPLICATE_ITEM;
            else {
                $query = 'INSERT INTO item (name, description, sellerId,
                                            categoryId, auctionType, endDate,
                                            startPrice, featured, startDate)
                          VALUES (:name, :description, :sellerId,
                                  :category, :auctionType,
                                  DATE_ADD(CURDATE(), INTERVAL :duration DAY),
                                  :startPrice, :featured, CURDATE())';

                $this->db->executeQuery($query, $formArray);

                $query = 'SELECT id FROM item WHERE name=:name and
                          sellerId=:id';
                $stmt  = $this->db->executeQuery($query,
                                        array('name' => $formArray['name'],
                                              'id' => $formArray['sellerId']));

                $itemId = $stmt->fetch(PDO::FETCH_ASSOC)['id'];
                Session::set('itemId', $itemId);
                Session::set('itemName', $formArray['name']);
            }
        }

        return array('errors' => $errors, 'formArray' => $formArray);
        //header('Location: index');
    }

    public function receiveFeaturedPayment() {
        require("config/config.php");
        require("libs/paypal.class.php");
        require("vendor/autoload.php");
        //Paypal redirects back to this page using ReturnURL, We should receive TOKEN and Payer ID
        if(isset($_GET["token"]) && isset($_GET["PayerID"]))
        {
            //we will be using these two variables to execute the "DoExpressCheckoutPayment"
            //Note: we haven't received any payment yet.
            
            $token = $_GET["token"];
            $payer_id = $_GET["PayerID"];
            
            //get session variables
            $ItemName           = $_SESSION['ItemName']; //Item Name
            $ItemPrice          = $_SESSION['ItemPrice'] ; //Item Price
            $ItemID             = $_SESSION['ItemNumber']; //Item ID
            $ItemDesc           = $_SESSION['ItemDesc']; //Item ID
            $ItemQty            = $_SESSION['ItemQty']; // Item Quantity
            $GrandTotal         = $_SESSION['GrandTotal'];
            $ItemTotalPrice     = $_SESSION['GrandTotal'];
        
            $padata =   '&TOKEN='.urlencode($token).
                        '&PAYERID='.urlencode($payer_id).
                        '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                        
                        //set item info here, otherwise we won't see product details later  
                        '&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
                        '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemID).
                        '&L_PAYMENTREQUEST_0_DESC0='.urlencode($ItemDesc).
                        '&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
                        '&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
        
        
                        '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                        '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                        '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode);
            
            //We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
            $paypal= new MyPayPal();
            $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
            
            //Check if everything went ok..
            if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
            {
                    $transactionID = urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
                    
                        /*
                        //Sometimes Payment are kept pending even when transaction is complete. 
                        //hence we need to notify user about it and ask him manually approve the transiction
                        */
                        
                        if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                        {
                            echo '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
                        }
                        elseif('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"])
                        {
                            echo '<div style="color:red">Transaction Complete, but payment is still pending! '.
                            'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
                        }
        
                        // we can retrieve transaction details using either GetTransactionDetails or GetExpressCheckoutDetails
                        // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
                        $padata =   '&TOKEN='.urlencode($token);
                        $paypal= new MyPayPal();
                        $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        
                        if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) 
                        {
        
                            /*
                            #### SAVE BUYER INFORMATION IN DATABASE ###
                            
                            
                            */
        
                            $query = 'INSERT INTO payment
                                             (transactionId, token, userId,
                                              itemName, paymentDescription,
                                              itemPrice, grandTotal, time)
                                      VALUES (:transactionId, :token, :userId,
                                              :itemName, :paymentDesc,
                                              :itemPrice, :grandTotal, NOW())';
                            $this->db->executeQuery($query,
                                array('transactionId' => $transactionID,
                                      'token' => $token,
                                      'userId' => Session::get('userId'),
                                      'itemName' => $ItemName,
                                      'itemPrice' => $ItemTotalPrice,
                                      'paymentDesc' => $ItemDesc,
                                      'grandTotal' => $GrandTotal));
                            echo '<pre>';
                            print_r($httpParsedResponseAr);
                            echo '</pre>';
                        } else  {
                            echo '<div style="color:red"><b>GetTransactionDetails failed:</b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
                            echo '<pre>';
                            print_r($httpParsedResponseAr);
                            echo '</pre>';
        
                        }
            
            }else{
                    echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';
            }
        }
    }

    public function makeFeaturedPayment() {
        require("config/config.php");
        require("libs/paypal.class.php");
        require("vendor/autoload.php");
        
        $paypalmode = ($PayPalMode=='sandbox') ? '.sandbox' : '';
        
            $ItemName       = "Featured payment";
            $ItemPrice      = 10;
        	  $ItemDesc       = "Featured payment for " . Session::get('itemName');
            $ItemID         = Session::get('itemId'); //Item ID
            $ItemQty        = 1; // Item Quantity
            
            $ItemTotalPrice = ($ItemPrice); 
            $PayPalReturnURL = ROOT_URL . '/newAuction/runFeaturedPayment';
        
            //Grand total including all tax, insurance, shipping cost and discount
            $GrandTotal = ($ItemTotalPrice);
            //Parameters for SetExpressCheckout, which will be sent to PayPal
            $padata =   '&METHOD=SetExpressCheckout'.
                        '&RETURNURL='.urlencode($PayPalReturnURL ).
                        '&CANCELURL='.urlencode($PayPalCancelURL).
                        '&PAYMENTREQUEST_0_PAYMENTACTION='.urlencode("SALE").
                        
                        '&L_PAYMENTREQUEST_0_NAME0='.urlencode($ItemName).
                        '&L_PAYMENTREQUEST_0_NUMBER0='.urlencode($ItemID).
                        '&L_PAYMENTREQUEST_0_DESC0='.urlencode($ItemDesc).
                        '&L_PAYMENTREQUEST_0_AMT0='.urlencode($ItemPrice).
                        '&L_PAYMENTREQUEST_0_QTY0='. urlencode($ItemQty).
                       
                        
                        '&NOSHIPPING=1'. //set 1 to hide buyer's shipping address, in-case products that do not require shipping
                        
                        '&PAYMENTREQUEST_0_ITEMAMT='.urlencode($ItemTotalPrice).
                        '&PAYMENTREQUEST_0_AMT='.urlencode($GrandTotal).
                        '&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
                        '&LOCALECODE=GB'. //PayPal pages to match the language on your website.
                        '&LOGOIMG=http://www.sanwebe.com/wp-content/themes/sanwebe/img/logo.png'. //site logo
                        '&CARTBORDERCOLOR=FFFFFF'. //border color of cart
                        '&ALLOWNOTE=1';
                        
                        ############# set session variable we need later for "DoExpressCheckoutPayment" #######
                        $_SESSION['ItemName']           =  $ItemName; //Item Name
                        $_SESSION['ItemPrice']          =  $ItemPrice; //Item Price
                        $_SESSION['ItemNumber']         =  $ItemID; //Item ID
                        $_SESSION['ItemDesc']           =  $ItemDesc; //Item description
                        $_SESSION['ItemQty']            =  $ItemQty; // Item Quantity
                        $_SESSION['ItemTotalPrice']     =  $ItemTotalPrice; //total amount of product; 
                        $_SESSION['GrandTotal']         =  $GrandTotal;
        
                        echo $padata;
                //We need to execute the "SetExpressCheckOut" method to obtain paypal token
                $paypal= new MyPayPal();
                
                $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
                //Respond according to message we receive from Paypal
                echo "redirecting...";
                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"]))
                {
                        
                        //Redirect user to PayPal store with Token received.
                        $paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
                        header('Location: '.$paypalurl);
                     
                }else{
                    //Show error message
                    echo '<div style="color:red"><b>Error : </b>'.urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]).'</div>';
                    echo '<pre>';
                    print_r($httpParsedResponseAr);
                    echo '</pre>';
                }
    }
}
?>
