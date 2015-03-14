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

    const AUCTION_TYPES = array('englishAuction', 'dutchAuction',
                                'englishAuctionHidden', 'vickeryAuction',
                                'buyItNow');
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
            }
        }

        return array('errors' => $errors, 'formArray' => $formArray);
        //header('Location: index');
    }
}

