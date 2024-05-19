-- noinspection SqlWithoutWhereForFile

.headers on
.mode column
PRAGMA foreign_keys = ON;

DELETE
FROM Message;
DELETE
FROM Wishes;
DELETE
FROM ProductImage;
DELETE
FROM ProductBrand;
DELETE
FROM Product;
DELETE
FROM Payment;
DELETE
FROM Brand;
DELETE
FROM Condition;
DELETE
FROM Category;
DELETE
FROM Size;
DELETE
FROM User;
DELETE
FROM Image;

-- Create Images
INSERT INTO Image (url)
VALUES ('https://wallpapers.com/images/high/basic-default-pfp-pxi77qv5o0zuz8j3.webp');
INSERT INTO Image (url)
VALUES ('https://randomuser.me/api/portraits/men/84.jpg');
INSERT INTO Image (url)
VALUES ('https://randomuser.me/api/portraits/men/19.jpg');
INSERT INTO Image (url)
VALUES ('https://randomuser.me/api/portraits/men/32.jpg');
INSERT INTO Image (url)
VALUES ('https://randomuser.me/api/portraits/men/64.jpg');
INSERT INTO Image (url)
VALUES ('https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/%D0%92%D0%BB%D0%B0%D0%B4%D0%B8%D0%BC%D0%B8%D1%80_%D0%9F%D1%83%D1%82%D0%B8%D0%BD_%2818-06-2023%29_%28cropped%29.jpg/640px-%D0%92%D0%BB%D0%B0%D0%B4%D0%B8%D0%BC%D0%B8%D1%80_%D0%9F%D1%83%D1%82%D0%B8%D0%BD_%2818-06-2023%29_%28cropped%29.jpg');
INSERT INTO Image (url)
VALUES ('https://i.ibb.co/tqjY71F/2abbdcf4c2ffd98961dccef0acc31218.png');
INSERT INTO Image (url)
VALUES ('https://i.ibb.co/7SDQjf8/ae83d24e3101503ae176fa79b8416272.png');
INSERT INTO Image (url)
VALUES ('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQs6eD780lPkOf86hwNJhBnREMUwWlvVpOCfTm8li5gmA&s');
INSERT INTO Image (url)
VALUES ('https://www.redcarpet-fashionawards.com/wp-content/uploads/2023/03/Ana-de-Armas.jpeg');
INSERT INTO Image (url)
VALUES ('https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwl3bp6pxiz4KbGcqef7fPt7mE4eIWp0s24HBwxT3DyQ&s');
INSERT INTO Image (url)
VALUES ('https://media.gucci.com/style/DarkGray_Center_0_0_490x490/1692980128/440103_X3F05_1508_001_100_0000_Light.jpg');
INSERT INTO Image (url)
VALUES ('https://cdn-images.farfetch-contents.com/20/16/32/39/20163239_50171749_600.jpg');
INSERT INTO Image (url)
VALUES ('https://i1.rgstatic.net/ii/profile.image/823368932679681-1573317859494_Q512/Andre-Restivo.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a75633874a.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a75633c5de.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a756340197.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a75c6f3180.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a767ee867f.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a767eec822.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a76ed37cf6.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a76ed3c31e.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a777c09ed7.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a777c0e906.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a780e20a33.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/664a780e241db.jpg');

-- Create Users
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (1, 'JoshuaEBradley@rhyta.com', 'Joshua E. Bradley',
        '$2y$10$5qzG2ayXItO6hhltSvCLK.J41BWPnK8h9LKWT4BxD7716brYw2T4a', '1704112535',
        'https://randomuser.me/api/portraits/men/84.jpg', 'buyer');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (2, 'JeffreyFCervantes@teleworm.us', 'Jeffrey F. Cervantes',
        '$2y$10$wgMqjjZwkncCqt14pJAjpeThLPopeez2XY8CoXHLwWmcj/4nHNCFe', '1707146712',
        'https://randomuser.me/api/portraits/men/19.jpg', 'buyer');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (3, 'JohnAHill@armyspy.com', 'John A. Hill',
        '$2y$10$wqgEj1VXvv/sSANCNCpliuxZH3HrHW1XthJk2ATyHK2BQJYWiz0RK', '1709832885',
        'https://randomuser.me/api/portraits/men/32.jpg', 'buyer');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (4, 'DennisMChandler@dayrep.com', 'Dennis M. Chandler',
        '$2y$10$pTsBH1AIIMOso.Dl/knV6OzJVH73Kn.FihC9xBIzI9NXc2gd6SBxS', '1711963292',
        'https://randomuser.me/api/portraits/men/64.jpg', 'buyer');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (5, 'up202204988@up.pt', 'Henrique Fernandes',
        '$2y$10$h5ldOURPVpPjsl44MzI1..7wPzCXV4x87f2ABP5ufxk1pcDK8EE7W', '1656513143',
        'https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/%D0%92%D0%BB%D0%B0%D0%B4%D0%B8%D0%BC%D0%B8%D1%80_%D0%9F%D1%83%D1%82%D0%B8%D0%BD_%2818-06-2023%29_%28cropped%29.jpg/640px-%D0%92%D0%BB%D0%B0%D0%B4%D0%B8%D0%BC%D0%B8%D1%80_%D0%9F%D1%83%D1%82%D0%B8%D0%BD_%2818-06-2023%29_%28cropped%29.jpg',
        'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (6, 'up202205188@up.pt', 'Rodrigo Albergaria',
        '$2y$10$cSeD.JpzN3KZNTCTfHIzhOYleR93GVmKDuTrHIhOv2Pqs7TmN/di6', '1656513143',
        'https://i.ibb.co/tqjY71F/2abbdcf4c2ffd98961dccef0acc31218.png', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (7, 'up202208700@up.pt', 'Bruno Oliveira',
        '$2y$10$Vo/ZYT5.CrKgk876Ha9DmOywwqlyMTtRi.C5ywYgPIgDTWrvVte.K', '1656513143',
        'https://i.ibb.co/7SDQjf8/ae83d24e3101503ae176fa79b8416272.png', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (8, 'arestivo@gmail.com', 'André Restivo',
        '$2y$10$Vo/ZYT5.CrKgk876Ha9DmOywwqlyMTtRi.C5ywYgPIgDTWrvVte.K', '1656513144',
        'https://i1.rgstatic.net/ii/profile.image/823368932679681-1573317859494_Q512/Andre-Restivo.jpg', 'admin');


-- Create Sizes
INSERT INTO Size (name)
VALUES ('XS'),
       ('S'),
       ('M'),
       ('L'),
       ('XL'),
       ('XXL');

-- Create Categories
INSERT INTO Category (name)
VALUES ('Armwear');
INSERT INTO Category (name)
VALUES ('Badges');
INSERT INTO Category (name)
VALUES ('Belts');
INSERT INTO Category (name)
VALUES ('Bags');
INSERT INTO Category (name)
VALUES ('Children&#039;s clothing');
INSERT INTO Category (name)
VALUES ('Coats');
INSERT INTO Category (name)
VALUES ('Dresses');
INSERT INTO Category (name)
VALUES ('Footwear');
INSERT INTO Category (name)
VALUES ('Gowns');
INSERT INTO Category (name)
VALUES ('Handwear');
INSERT INTO Category (name)
VALUES ('Headgear');
INSERT INTO Category (name)
VALUES ('Hosiery');
INSERT INTO Category (name)
VALUES ('Jackets');
INSERT INTO Category (name)
VALUES ('Knee clothing');
INSERT INTO Category (name)
VALUES ('Masks');
INSERT INTO Category (name)
VALUES ('Neckwear');
INSERT INTO Category (name)
VALUES ('One-piece suits');
INSERT INTO Category (name)
VALUES ('Outerwear');
INSERT INTO Category (name)
VALUES ('Ponchos');
INSERT INTO Category (name)
VALUES ('Robes and cloaks');
INSERT INTO Category (name)
VALUES ('Royal attire');
INSERT INTO Category (name)
VALUES ('Saris');
INSERT INTO Category (name)
VALUES ('Sashes');
INSERT INTO Category (name)
VALUES ('Shawls and wraps');
INSERT INTO Category (name)
VALUES ('Skirts');
INSERT INTO Category (name)
VALUES ('Sportswear');
INSERT INTO Category (name)
VALUES ('Suits');
INSERT INTO Category (name)
VALUES ('Tops');
INSERT INTO Category (name)
VALUES ('Trousers and shorts');
INSERT INTO Category (name)
VALUES ('T-shirts');
INSERT INTO Category (name)
VALUES ('Undergarments');
INSERT INTO Category (name)
VALUES ('Wedding clothing');
INSERT INTO Category (name)
VALUES ('Sweatshirt');
INSERT INTO Category (name)
VALUES ('Jeans');
INSERT INTO Category (name)
VALUES ('Watches');
INSERT INTO Category (name)
VALUES ('Socks');


-- Create Conditions
INSERT INTO Condition (name)
VALUES ('New with tag'),
       ('New without tag'),
       ('Deadstock'),
       ('Like new'),
       ('Excellent'),
       ('Very good'),
       ('Distressed');

-- Create Brands
INSERT INTO Brand (name)
VALUES ('ACM');
INSERT INTO Brand (name)
VALUES ('Adidas');
INSERT INTO Brand (name)
VALUES ('Cartier');
INSERT INTO Brand (name)
VALUES ('Casio');
INSERT INTO Brand (name)
VALUES ('Chanel');
INSERT INTO Brand (name)
VALUES ('Dior');
INSERT INTO Brand (name)
VALUES ('Gucci');
INSERT INTO Brand (name)
VALUES ('Hermès');
INSERT INTO Brand (name)
VALUES ('Kiabi');
INSERT INTO Brand (name)
VALUES ('Levis');
INSERT INTO Brand (name)
VALUES ('Louis Vuitton');
INSERT INTO Brand (name)
VALUES ('Nike');
INSERT INTO Brand (name)
VALUES ('Rolex');
INSERT INTO Brand (name)
VALUES ('Trendsplant');
INSERT INTO Brand (name)
VALUES ('Zara');


-- Create Products
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (1, 'T-shirt', 5.99, 'Brand new t-shirt from Gucci, I removed the tag but never used it', '2024-04-23 14:00:00',
        5, 'M', 'T-shirts', 'New without tag', null);
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (2, 'Dress', 5.99, 'Almost new dress from Louis Vuitton', '2024-04-23 14:01:00', 6, 'S', 'Dresses', 'Like new',
        null);
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (3, 'Coat', 5.99, 'Coat in good condition from Chanel', '2024-04-23 14:02:00', 7, 'L', 'Coats', 'Excellent',
        null);
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (5, 'Used Chanel Dress', 2334, 'Pre owned 1996 chanel dress', '2024-05-02 10:43:00', 6, 'S', 'Dresses',
        'Excellent', null);
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (6, 'Levis Jeans', 5.95, 'Levis Jeans', '05/19/2024 21:55:47', 5, 'S', 'Jeans', 'New without tag', null);
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (7, 'Casio watch', 12, 'Rare watch from casio', '05/19/2024 22:00:30', 5, 'M', 'Watches', 'New without tag',
        null);
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (8, 'Nike Air Force 1', 15, 'Original but used, just a slight defect in the interior', '05/19/2024 22:02:21', 5,
        'M', 'Footwear', 'Very good', null);
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (9, 'Kiabi pullover', 7.5, '100% cotton pullover', '05/19/2024 22:04:44', 6, 'M', 'Sweatshirt', 'Very good',
        null);
INSERT INTO Product (id, title, price, description, publishDatetime, seller, size, category, condition, payment)
VALUES (10, 'Socks from trendsplant', 9.99, 'Socks from trendsplant', '05/19/2024 22:07:10', 6, 'M', 'Socks',
        'Like new', null);


-- Create ProductBrands
INSERT INTO ProductBrand (product, brand)
VALUES (1, 'Gucci');
INSERT INTO ProductBrand (product, brand)
VALUES (2, 'Louis Vuitton');
INSERT INTO ProductBrand (product, brand)
VALUES (3, 'Chanel');
INSERT INTO ProductBrand (product, brand)
VALUES (5, 'Chanel');
INSERT INTO ProductBrand (product, brand)
VALUES (6, 'Levis');
INSERT INTO ProductBrand (product, brand)
VALUES (7, 'Casio');
INSERT INTO ProductBrand (product, brand)
VALUES (8, 'Nike');
INSERT INTO ProductBrand (product, brand)
VALUES (9, 'Kiabi');
INSERT INTO ProductBrand (product, brand)
VALUES (10, 'Trendsplant');

-- Create ProductImages
INSERT INTO ProductImage (product, image)
VALUES (1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQs6eD780lPkOf86hwNJhBnREMUwWlvVpOCfTm8li5gmA&s');
INSERT INTO ProductImage (product, image)
VALUES (1,
        'https://media.gucci.com/style/DarkGray_Center_0_0_490x490/1692980128/440103_X3F05_1508_001_100_0000_Light.jpg');
INSERT INTO ProductImage (product, image)
VALUES (2, 'https://www.redcarpet-fashionawards.com/wp-content/uploads/2023/03/Ana-de-Armas.jpeg');
INSERT INTO ProductImage (product, image)
VALUES (3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwl3bp6pxiz4KbGcqef7fPt7mE4eIWp0s24HBwxT3DyQ&s');
INSERT INTO ProductImage (product, image)
VALUES (5, 'https://cdn-images.farfetch-contents.com/20/16/32/39/20163239_50171749_600.jpg');
INSERT INTO ProductImage (product, image)
VALUES (6, 'images/posts/664a75633874a.jpg');
INSERT INTO ProductImage (product, image)
VALUES (6, 'images/posts/664a75633c5de.jpg');
INSERT INTO ProductImage (product, image)
VALUES (6, 'images/posts/664a756340197.jpg');
INSERT INTO ProductImage (product, image)
VALUES (7, 'images/posts/664a767ee867f.jpg');
INSERT INTO ProductImage (product, image)
VALUES (7, 'images/posts/664a767eec822.jpg');
INSERT INTO ProductImage (product, image)
VALUES (8, 'images/posts/664a76ed37cf6.jpg');
INSERT INTO ProductImage (product, image)
VALUES (8, 'images/posts/664a76ed3c31e.jpg');
INSERT INTO ProductImage (product, image)
VALUES (9, 'images/posts/664a777c09ed7.jpg');
INSERT INTO ProductImage (product, image)
VALUES (9, 'images/posts/664a777c0e906.jpg');
INSERT INTO ProductImage (product, image)
VALUES (10, 'images/posts/664a780e20a33.jpg');
INSERT INTO ProductImage (product, image)
VALUES (10, 'images/posts/664a780e241db.jpg');
