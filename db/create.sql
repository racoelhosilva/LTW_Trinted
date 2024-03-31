PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS PostImage;
DROP TABLE IF EXISTS Post;
DROP TABLE IF EXISTS ItemBrand;
DROP TABLE IF EXISTS Brand;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS Condition;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Size;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Image;

CREATE TABLE Image(
    url     VARCHAR(64) CONSTRAINT UrlNotNull NOT NULL,
    CONSTRAINT UrlPK PRIMARY KEY (url)
);

CREATE TABLE User(
    username            VARCHAR(32) CONSTRAINT UsernameNotNull NOT NULL,
    email               VARCHAR(64) CONSTRAINT EmailNotNull NOT NULL CONSTRAINT EmailUnique UNIQUE,
    name                VARCHAR(32) CONSTRAINT NameNotNull NOT NULL,
    password            VARCHAR(32) CONSTRAINT PasswordNotNull NOT NULL,
    registerDatetime    DATETIME CONSTRAINT RegisterDatetimeNotNull NOT NULL,
    profilePicture      VARCHAR(64),
    type                VARCHAR(6) CONSTRAINT TypeNotNull NOT NULL CONSTRAINT ValidType CHECK (type IN ('seller', 'buyer', 'admin')),
    CONSTRAINT UsernamePK PRIMARY KEY (username),
    CONSTRAINT profilePictureFK FOREIGN KEY (profilePicture) REFERENCES Image(url)
);

CREATE TABLE Size(
    name    VARCHAR(16) CONSTRAINT NameNotNull NOT NULL,
    CONSTRAINT NamePK PRIMARY KEY (name)
);

CREATE TABLE Category(
    name    VARCHAR(16) CONSTRAINT NameNotNull NOT NULL,
    CONSTRAINT NamePK PRIMARY KEY (name)
);

CREATE TABLE Condition(
    name    VARCHAR(16) CONSTRAINT NameNotNull NOT NULL,
    CONSTRAINT NamePK PRIMARY KEY (name)
);

CREATE TABLE Item(
    id          INT CONSTRAINT IdNotNull NOT NULL,
    name        VARCHAR(64) CONSTRAINT NameNotNull NOT NULL,
    seller      VARCHAR(32) CONSTRAINT SellerNotNull NOT NULL,
    size        VARCHAR(16),
    category    VARCHAR(16),
    condition   VARCHAR(16),
    CONSTRAINT IdPK PRIMARY KEY (id),
    CONSTRAINT SellerFK FOREIGN KEY (seller) REFERENCES User(username),
    CONSTRAINT SizeFK FOREIGN KEY (size) REFERENCES Size(name),
    CONSTRAINT CategoryFK FOREIGN KEY (category) REFERENCES Category(name),
    CONSTRAINT ConditionFK FOREIGN KEY (condition) REFERENCES Condition(name)
);

CREATE TRIGGER ItemOwnerIsSeller
BEFORE INSERT ON Item
FOR EACH ROW
WHEN (SELECT type FROM User WHERE username = New.seller) <> 'seller'
BEGIN
    SELECT RAISE(FAIL, 'Item cannot belong to non-seller user');
END;

CREATE TABLE Brand(
    name    VARCHAR(16) CONSTRAINT NameNotNull NOT NULL,
    CONSTRAINT NamePK PRIMARY KEY (name)
);

CREATE TABLE ItemBrand(
    item    INT CONSTRAINT ItemNotNull NOT NULL,
    brand   VARCHAR(16) CONSTRAINT BrandNotNull NOT NULL,
    CONSTRAINT ItemBrandPK PRIMARY KEY (item, brand),
    CONSTRAINT ItemFK FOREIGN KEY (item) REFERENCES Item(id),
    CONSTRAINT BrandFK FOREIGN KEY (brand) REFERENCES Brand(name)
);

CREATE TABLE Post(
    id              INT CONSTRAINT IdNotNull NOT NULL,
    title           VARCHAR(64) CONSTRAINT TitleNotNull NOT NULL,
    price           DECIMAL(5, 2) CONSTRAINT PriceNotNull NOT NULL CONSTRAINT PriceNotNegative CHECK (price >= 0),
    description     TEXT,
    publishDatetime DATETIME CONSTRAINT PublishDatetimeNotNull NOT NULL,
    seller          VARCHAR(32) CONSTRAINT SellerNotNull NOT NULL,
    item            INT CONSTRAINT ItemNotNull NOT NULL,
    CONSTRAINT IdPK PRIMARY KEY (id),
    CONSTRAINT SellerFK FOREIGN KEY (seller) REFERENCES User(username),
    CONSTRAINT ItemFK FOREIGN KEY (item) REFERENCES Item(id)
);

CREATE TRIGGER PostPublisherIsSeller
BEFORE INSERT ON Post
FOR EACH ROW
WHEN (SELECT type FROM User WHERE username = New.seller) <> 'seller'
BEGIN
    SELECT RAISE(FAIL, 'The post'' publisher must be a seller');
END;

CREATE TRIGGER PostAndItemHaveSameOwner
BEFORE INSERT ON Post 
FOR EACH ROW 
WHEN (SELECT seller FROM Item WHERE id = New.item) <> New.seller
BEGIN
    SELECT RAISE(FAIL, 'The post and the respective item must have the same seller');
END;

CREATE TRIGGER PostAfterUserRegister
BEFORE INSERT ON Post 
FOR EACH ROW 
WHEN (SELECT registerDatetime FROM User WHERE username = New.seller) <= New.publishDatetime
BEGIN 
    SELECT RAISE(FAIL, 'The post cannot be publish before the respective seller being registered');
END;

CREATE TABLE PostImage(
    post    INT CONSTRAINT PostNotNull NOT NULL,
    image   VARCHAR(64) CONSTRAINT ImageNotNull NOT NULL,
    CONSTRAINT PostPK PRIMARY KEY (image),
    CONSTRAINT PostFK FOREIGN KEY (post) REFERENCES Post(id),
    CONSTRAINT ImageFK FOREIGN KEY (image) REFERENCES Image(url)
);

CREATE TABLE Message(
    id          INT CONSTRAINT IdNotNull NOT NULL,
    datetime    DATETIME CONSTRAINT DatetimeNotNull NOT NULL,
    content     TEXT CONSTRAINT ContentNotNull NOT NULL,
    sender      VARCHAR(32) CONSTRAINT SenderNotNull NOT NULL,
    receiver    VARCHAR(32) CONSTRAINT ReceiverNotNull NOT NULL,
    CONSTRAINT IdPK PRIMARY KEY (id),
    CONSTRAINT SenderFK FOREIGN KEY (sender) REFERENCES User(username),
    CONSTRAINT ReceiverFK FOREIGN KEY (receiver) REFERENCES User(username),
    CONSTRAINT SenderNotReceiver CHECK (sender <> receiver)
);
