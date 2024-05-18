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
VALUES ('https://br.louisvuitton.com/images/is/image/lv/1/PP_VP_L/louis-vuitton-onthego-mm--M45321_PM2_Front%20view.jpg');
INSERT INTO Image (url)
VALUES ('https://cdn-images.farfetch-contents.com/20/16/32/39/20163239_50171749_600.jpg');
INSERT INTO Image (url)
VALUES ('https://i1.rgstatic.net/ii/profile.image/823368932679681-1573317859494_Q512/Andre-Restivo.jpg');

-- Create Users
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (1, 'JoshuaEBradley@rhyta.com', 'Joshua E. Bradley',
        '$2y$10$5qzG2ayXItO6hhltSvCLK.J41BWPnK8h9LKWT4BxD7716brYw2T4a', '1704112535',
        'https://randomuser.me/api/portraits/men/84.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (2, 'JeffreyFCervantes@teleworm.us', 'Jeffrey F. Cervantes',
        '$2y$10$wgMqjjZwkncCqt14pJAjpeThLPopeez2XY8CoXHLwWmcj/4nHNCFe', '1707146712',
        'https://randomuser.me/api/portraits/men/19.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (3, 'JohnAHill@armyspy.com', 'John A. Hill',
        '$2y$10$wqgEj1VXvv/sSANCNCpliuxZH3HrHW1XthJk2ATyHK2BQJYWiz0RK', '1709832885',
        'https://randomuser.me/api/portraits/men/32.jpg', 'seller');
INSERT INTO User (id, email, name, password, registerDatetime, profilePicture, type)
VALUES (4, 'DennisMChandler@dayrep.com', 'Dennis M. Chandler',
        '$2y$10$pTsBH1AIIMOso.Dl/knV6OzJVH73Kn.FihC9xBIzI9NXc2gd6SBxS', '1711963292',
        'https://randomuser.me/api/portraits/men/64.jpg', 'seller');
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

-- Create Products
INSERT INTO Product (title, price, description, publishDatetime, seller, size, category, condition)
VALUES ('T-shirt', 5.99, 'Brand new t-shirt from Gucci, I removed the tag but never used it', DATETIME('2024-04-23 14:00'), 5, 'M', 'T-shirts', 'New without tag'),
       ('Dress', 5.99, 'Almost new dress from Louis Vuitton', DATETIME('2024-04-23 14:01'), 6, 'S', 'Dresses', 'Like new'),
       ('Coat', 5.99, 'Coat in good condition from Chanel', DATETIME('2024-04-23 14:02'), 7, 'L', 'Coats', 'Excellent'),
       ('Bag', 67.99, 'Leather bag from Louis Vuitton', DATETIME('2024-05-01 09:12'), 5, 'M', 'Bags', 'New with tag'),
       ('Used Chanel Dress', 2334.00, 'Pre owned 1996 chanel dress', DATETIME('2024-05-02 10:43'), 6, 'S', 'Dresses', 'Excellent');

-- Create ProductBrands
INSERT INTO ProductBrand (product, brand)
VALUES (1, 'Gucci'),
       (2, 'Louis Vuitton'),
       (3, 'Chanel'),
       (4, 'Louis Vuitton'),
       (5, 'Chanel');

-- Create ProductImages
INSERT INTO ProductImage (product, image)
VALUES (1, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQs6eD780lPkOf86hwNJhBnREMUwWlvVpOCfTm8li5gmA&s'),
       (1,
        'https://media.gucci.com/style/DarkGray_Center_0_0_490x490/1692980128/440103_X3F05_1508_001_100_0000_Light.jpg'),
       (2, 'https://www.redcarpet-fashionawards.com/wp-content/uploads/2023/03/Ana-de-Armas.jpeg'),
       (3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSwl3bp6pxiz4KbGcqef7fPt7mE4eIWp0s24HBwxT3DyQ&s'),
       (4,
        'https://br.louisvuitton.com/images/is/image/lv/1/PP_VP_L/louis-vuitton-onthego-mm--M45321_PM2_Front%20view.jpg'),
       (5, 'https://cdn-images.farfetch-contents.com/20/16/32/39/20163239_50171749_600.jpg');

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