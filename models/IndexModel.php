<?php

class IndexModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getCategories() {
        $query = 'SELECT category.name AS category,
                         COUNT(item.name) AS noOfItems,
                         category.id
                  FROM category LEFT JOIN item ON category.id=item.categoryId
                                              AND item.endDate>CURDATE()
                  GROUP BY category.name';
        $stmt = $this->db->executeQuery($query);
        $array = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $array;
    }

    public function getFeaturedImages() {
        $query = 'SELECT filePath FROM image INNER JOIN item
                  ON image.itemId = item.id
                  AND item.featured = 1 AND image.main = 1
                  ORDER BY RAND() LIMIT 10';
        $stmt = $this->db->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewestItems($category = null, $wordList = null) {
        $query = 'SELECT item.id,
                         item.name,
                         IF (LENGTH(item.description) > 225,
                             CONCAT(LEFT(item.description, 225), "..."),
                             item.description) AS description,
                         auctionType.name AS auctionType,
                         (CURDATE() >= item.endDate) AS finished,
                         image.filePath AS mainPicture,
                         item.categoryId AS categoryId
                  FROM item
                  INNER JOIN image ON item.id = image.itemId
                                  AND image.main = 1
                  INNER JOIN auctionType ON
                             auctionType.id = item.auctionType';
        if ($category != null)
            $query .= ' WHERE item.categoryId = ' . $category;
        if ($wordList != null && !empty($wordList)) {
            $query .= ' WHERE';
            foreach ($wordList as $word)
                $query .= " item.name LIKE '%$word%' AND
                            item.description LIKE '%$word%' AND";
            $query = substr($query, 0, -4);
        }
        $query .= ' ORDER BY item.id DESC LIMIT 9';
        $stmt = $this->db->executeQuery($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
