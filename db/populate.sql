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
VALUES ('https://randomuser.me/api/portraits/men/84.jpg'),
       ('https://randomuser.me/api/portraits/men/19.jpg'),
       ('https://randomuser.me/api/portraits/men/32.jpg'),
       ('https://randomuser.me/api/portraits/men/64.jpg');

-- Create Users
INSERT INTO User (username, email, name, password, registerDatetime, profilePicture, type)
VALUES ('Whichave', 'JoshuaEBradley@rhyta.com', 'Joshua E. Bradley',
        '$2y$10$XCd8oYMnh04062w15c08DuvsUbKHviBmGIE3nK4ZIwtlIgSbtOVa.', DATETIME('2024-01-01 12:35:35'),
        'https://randomuser.me/api/portraits/men/84.jpg', 'buyer'),
       ('Samses', 'JeffreyFCervantes@teleworm.us', 'Jeffrey F. Cervantes',
        '$2y$10$B5TYiAeEWLj3mV8vImn2ReTszGeU7aqMeVHLJGk.QcSFQt8kdikgG', DATETIME('2024-02-05 15:25:12'),
        'https://randomuser.me/api/portraits/men/19.jpg', 'buyer'),
       ('Hisguallon', 'JohnAHill@armyspy.com', 'John A. Hill',
        '$2y$10$jRYT23lX6YeCCMuXgawcUuWTQKXYLIUDtBmFhKsfE63TcndCR.hWy', DATETIME('2024-03-07 17:34:45'),
        'https://randomuser.me/api/portraits/men/32.jpg', 'buyer'),
       ('Lils1947', 'DennisMChandler@dayrep.com', 'Dennis M. Chandler',
        '$2y$10$DftDaXbYmdMbjX6CoHMIbeZaIjalhbzIpC2XZ46UKivtRUfJxMMQK', DATETIME('2024-04-01 09:21:32'),
        'https://randomuser.me/api/portraits/men/64.jpg', 'buyer');

-- Create Sizes
INSERT INTO Size (name)
VALUES ('XS'),
       ('S'),
       ('M'),
       ('L'),
       ('XL'),
       ('XXL');

-- Create Categories
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

-- Create Brands
-- Create ItemBrands
-- Create Posts
-- Create PostImages
-- Create Messages