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
VALUES ('image/profiles/6648d6da4af61.jpg');
INSERT INTO Image (url)
VALUES ('images/profiles/6648d78653663.jpg');
INSERT INTO Image (url)
VALUES ('images/profiles/6648d7a430fac.jpg');
INSERT INTO Image (url)
VALUES ('images/profiles/6648d7ce738ea.jpg');
INSERT INTO Image (url)
VALUES ('images/profiles/6648d67d2738b.jpg');
INSERT INTO Image (url)
VALUES ('images/profiles/6648d7f53097c.jpg');
INSERT INTO Image (url)
VALUES ('images/profiles/6648d816aca67.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/6648d86f8f6da.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/6648d8fb06a87.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/6648d9350513a.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/6648d8c06bc30.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/6648d99f8c78b.jpg');
INSERT INTO Image (url)
VALUES ('images/posts/6648d9d7ced9e.jpg');
INSERT INTO Image (url)
VALUES ('images/profiles/6648d83b5e013.jpg');

-- Create Users
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (0, 'JoshuaEBradley@rhyta.com', 'Joshua E. Bradley',
        '$2y$10$5qzG2ayXItO6hhltSvCLK.J41BWPnK8h9LKWT4BxD7716brYw2T4a', '1704112535',
        'image/profiles/6648d6da4af61.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (1, 'JeffreyFCervantes@teleworm.us', 'Jeffrey F. Cervantes',
        '$2y$10$wgMqjjZwkncCqt14pJAjpeThLPopeez2XY8CoXHLwWmcj/4nHNCFe', '1707146712',
        'images/profiles/6648d78653663.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (2, 'JohnAHill@armyspy.com', 'John A. Hill',
        '$2y$10$wqgEj1VXvv/sSANCNCpliuxZH3HrHW1XthJk2ATyHK2BQJYWiz0RK', '1709832885',
        'images/profiles/6648d7a430fac.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (3, 'DennisMChandler@dayrep.com', 'Dennis M. Chandler',
        '$2y$10$pTsBH1AIIMOso.Dl/knV6OzJVH73Kn.FihC9xBIzI9NXc2gd6SBxS', '1711963292',
        'images/profiles/6648d7ce738ea.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (4, 'up202204988@up.pt', 'Henrique Fernandes',
        '$2y$10$h5ldOURPVpPjsl44MzI1..7wPzCXV4x87f2ABP5ufxk1pcDK8EE7W', '1656513143',
        'images/profiles/6648d67d2738b.jpg',
        'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (5, 'up202205188@up.pt', 'Rodrigo Albergaria',
        '$2y$10$cSeD.JpzN3KZNTCTfHIzhOYleR93GVmKDuTrHIhOv2Pqs7TmN/di6', '1656513143',
        'images/profiles/6648d7f53097c.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (6, 'up202208700@up.pt', 'Bruno Oliveira',
        '$2y$10$Vo/ZYT5.CrKgk876Ha9DmOywwqlyMTtRi.C5ywYgPIgDTWrvVte.K', '1656513143',
        'images/profiles/6648d816aca67.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (7, 'arestivo@gmail.com', 'André Restivo',
        '$2y$10$Vo/ZYT5.CrKgk876Ha9DmOywwqlyMTtRi.C5ywYgPIgDTWrvVte.K', '1656513144',
        'images/profiles/6648d83b5e013.jpg', 'admin');


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
       ('Bags'),
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
VALUES ('T-shirt ', 4, 'M', 'T-shirts', 'New without tag');
INSERT INTO Item (name, seller, size, category, condition)
VALUES ('Dress', 5, 'S', 'Dresses', 'Like new');
INSERT INTO Item (name, seller, size, category, condition)
VALUES ('Coat', 6, 'L', 'Coats', 'Excellent');
INSERT INTO Item (name, seller, size, category, condition)
VALUES ('Bag', 4, 'M', 'Bags', 'New with tag');
INSERT INTO Item (name, seller, size, category, condition)
VALUES ('Used dress', 5, 'S', 'Dresses', 'Excellent');

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
       (3, 'Chanel'),
       (4, 'Louis Vuitton'),
       (5, 'Chanel');

-- Create Posts
INSERT INTO Post (title, price, description, publishDatetime, seller, item)
VALUES ('T-shirt', 5.99, 'Brand new t-shirt from Gucci, I removed the tag but never used it',
        DATETIME('2024-04-23 14:00'), 4, 1),
       ('Dress', 5.99, 'Almost new dress from Louis Vuitton',
        DATETIME('2024-04-23 14:01'), 5, 2),
       ('Coat', 5.99, 'Coat in good condition from Chanel',
        DATETIME('2024-04-23 14:02'), 6, 3),
       ('Bag', 67.99, 'Leather bag from Louis Vuitton', DATETIME('2024-05-01 09:12'), 4, 4),
       ('Used Chanel Dress', 2334.00, 'Pre owned 1996 chanel dress', DATETIME('2024-05-02 10:43'), 5, 5);


-- Create PostImages
INSERT INTO PostImage (post, image)
VALUES (1, 'images/posts/6648d86f8f6da.jpg'),
       (1,
        'images/posts/6648d8c06bc30.jpg'),
       (2, 'images/posts/6648d8fb06a87.jpg'),
       (3, 'images/posts/6648d9350513a.jpg'),
       (4,
        'images/posts/6648d99f8c78b.jpg'),
       (5, 'images/posts/6648d9d7ced9e.jpg');

-- Create Messages
INSERT INTO Message (id, datetime, content, sender, receiver)
VALUES  (0, '1715351715', 'Hello, Rodrigo from Henrique!', 4, 5),
        (1, '1715351778', 'Hi, Henrique from Rodrigo!', 5, 4),
        (2, '1715351716', 'Hello, Bruno from Rodrigo!', 5, 6),
        (3, '1715351779', 'Hi, Rodrigo from Bruno!', 6, 5),
        (4, '1715351717', 'Hello, Henrique from Bruno!', 6, 4),
        (5, '1715351780', 'Hi, Bruno from Henrique!', 4, 6),
        (6, '1715351718', 'Hello, professor from Rodrigo!', 5, 7),
        (7, '1715351818', 'Hello, professor from Rodrigo!', 7, 5);