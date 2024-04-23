-- noinspection SqlWithoutWhereForFile

.headers on
.mode column
PRAGMA foreign_keys = ON;

DELETE
FROM Message;
DELETE
FROM PostImage;
DELETE
FROM Post;
DELETE
FROM ItemBrand;
DELETE
FROM Brand;
DELETE
FROM Item;
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
VALUES ('https://randomuser.me/api/portraits/men/84.jpg');
INSERT INTO Image (url)
VALUES ('https://randomuser.me/api/portraits/men/19.jpg');
INSERT INTO Image (url)
VALUES ('https://randomuser.me/api/portraits/men/32.jpg');
INSERT INTO Image (url)
VALUES ('https://randomuser.me/api/portraits/men/64.jpg');
INSERT INTO Image (url)
VALUES ('https://ibb.co/w4L5GzT');
INSERT INTO Image (url)
VALUES ('https://ibb.co/v3yL7MR');
INSERT INTO Image (url)
VALUES ('https://ibb.co/YNSXPCY');
INSERT INTO Image (url)
VALUES ('https://picsum.photos/200/300');INSERT INTO Image (url)
VALUES ('https://picsum.photos/200/301');
INSERT INTO Image (url)
VALUES ('https://picsum.photos/200/302');


-- Create Users
INSERT INTO User (username, email, name, password, registerDatetime, profilePicture, type)
VALUES ('Whichave', 'JoshuaEBradley@rhyta.com', 'Joshua E. Bradley',
        '$2y$10$5qzG2ayXItO6hhltSvCLK.J41BWPnK8h9LKWT4BxD7716brYw2T4a', '1704112535',
        'https://randomuser.me/api/portraits/men/84.jpg', 'seller');
INSERT INTO User (username, email, name, password, registerDatetime, profilePicture, type)
VALUES ('Samses', 'JeffreyFCervantes@teleworm.us', 'Jeffrey F. Cervantes',
        '$2y$10$wgMqjjZwkncCqt14pJAjpeThLPopeez2XY8CoXHLwWmcj/4nHNCFe', '1707146712',
        'https://randomuser.me/api/portraits/men/19.jpg', 'seller');
INSERT INTO User (username, email, name, password, registerDatetime, profilePicture, type)
VALUES ('Hisguallon', 'JohnAHill@armyspy.com', 'John A. Hill',
        '$2y$10$wqgEj1VXvv/sSANCNCpliuxZH3HrHW1XthJk2ATyHK2BQJYWiz0RK', '1709832885',
        'https://randomuser.me/api/portraits/men/32.jpg', 'seller');
INSERT INTO User (username, email, name, password, registerDatetime, profilePicture, type)
VALUES ('Lils1947', 'DennisMChandler@dayrep.com', 'Dennis M. Chandler',
        '$2y$10$pTsBH1AIIMOso.Dl/knV6OzJVH73Kn.FihC9xBIzI9NXc2gd6SBxS', '1711963292',
        'https://randomuser.me/api/portraits/men/64.jpg', 'seller');
INSERT INTO User (username, email, name, password, registerDatetime, profilePicture, type)
VALUES ('Ricky', 'up202204988@up.pt', 'Henrique Fernandes',
        '$2y$10$h5ldOURPVpPjsl44MzI1..7wPzCXV4x87f2ABP5ufxk1pcDK8EE7W', '0', 'https://ibb.co/w4L5GzT', 'seller');
INSERT INTO User (username, email, name, password, registerDatetime, profilePicture, type)
VALUES ('Shayde', '202205188@up.pt', 'Rodrigo Albergaria',
        '$2y$10$cSeD.JpzN3KZNTCTfHIzhOYleR93GVmKDuTrHIhOv2Pqs7TmN/di6', '0', 'https://ibb.co/v3yL7MR', 'seller');
INSERT INTO User (username, email, name, password, registerDatetime, profilePicture, type)
VALUES ('AnalyticalT', '202208700@up.pt', 'Bruno Oliveira',
        '$2y$10$Vo/ZYT5.CrKgk876Ha9DmOywwqlyMTtRi.C5ywYgPIgDTWrvVte.K', '0', 'https://ibb.co/YNSXPCY', 'seller');


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
VALUES ('Armwear'),
       ('Badges'),
       ('Belts'),
       ('Children''s clothing'),
       ('Coats'),
       ('Dresses'),
       ('Footwear'),
       ('Gowns'),
       ('Handwear'),
       ('Headgear'),
       ('Hosiery'),
       ('Jackets'),
       ('Knee clothing'),
       ('Masks'),
       ('Neckwear'),
       ('One-piece suits'),
       ('Outerwear'),
       ('Ponchos'),
       ('Robes and cloaks'),
       ('Royal attire'),
       ('Saris'),
       ('Sashes'),
       ('Shawls and wraps'),
       ('Skirts'),
       ('Sportswear'),
       ('Suits'),
       ('Tops'),
       ('Trousers and shorts'),
       ('T-shirts'),
       ('Undergarments'),
       ('Wedding clothing');

-- Create Conditions
INSERT INTO Condition (name)
VALUES ('New with tag'),
       ('New without tag'),
       ('Deadstock'),
       ('Like new'),
       ('Excellent'),
       ('Very good'),
       ('Distressed');

-- Create Items
INSERT INTO Item (name, seller, size, category, condition)
VALUES ('T-shirt ', 'Ricky', 'M', 'T-shirts', 'New without tag');
INSERT INTO Item (name, seller, size, category, condition)
VALUES ('Dress', 'Shayde', 'S', 'Dresses', 'Like new');
INSERT INTO Item (name, seller, size, category, condition)
VALUES ('Coat', 'AnalyticalT', 'L', 'Coats', 'Excellent');

-- Create Brands
INSERT INTO Brand (name)
VALUES ('Nike'),
       ('Adidas'),
       ('Louis Vuitton'),
       ('Chanel'),
       ('Gucci'),
       ('Hermès'),
       ('Dior'),
       ('Cartier'),
       ('Zara'),
       ('Rolex');

-- Create ItemBrands
INSERT INTO ItemBrand (item, brand)
VALUES (1, 'Gucci'),
       (2, 'Louis Vuitton'),
       (3, 'Chanel');

-- Create Posts
INSERT INTO Post (title, price, description, publishDatetime, seller, item)
VALUES ('T-Dress', 5.99, 'Brand new t-shirt from Gucci, I removed the tag but never used it',
        DATETIME('2024-04-23 14:00'), 'Ricky', 1),
       ('Dress', 5.99, 'Almost new dress from Louis Vuitton',
        DATETIME('2024-04-23 14:01'), 'Shayde', 2),
       ('Coat', 5.99, 'Coat in good condition from Chanel',
        DATETIME('2024-04-23 14:02'), 'AnalyticalT', 3);

-- Create PostImages
INSERT INTO PostImage (post, image)
VALUES (1, 'https://picsum.photos/200/300'), (2, 'https://picsum.photos/200/301'), (3, 'https://picsum.photos/200/302');

-- Create Messages