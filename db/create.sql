PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS PostImage;
DROP TABLE IF EXISTS Post;
DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS ItemBrand;
DROP TABLE IF EXISTS Brand;
DROP TABLE IF EXISTS Item;
DROP TABLE IF EXISTS Condition;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Size;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Image;

-- Tables

CREATE TABLE Image
(
    url VARCHAR(64)
        CONSTRAINT UrlNotNull NOT NULL,
    CONSTRAINT UrlPK PRIMARY KEY (url)
);

CREATE TABLE User
(
    id               INTEGER,
    email            VARCHAR(64)
        CONSTRAINT EmailNotNull NOT NULL
        CONSTRAINT EmailUnique UNIQUE,
    name             VARCHAR(32)
        CONSTRAINT NameNotNull NOT NULL,
    password         VARCHAR(32)
        CONSTRAINT PasswordNotNull NOT NULL,
    registerDatetime DATETIME
        CONSTRAINT RegisterDatetimeNotNull NOT NULL,
    profilePicture   VARCHAR(64),
    isBanned        BOOLEAN
        CONSTRAINT IsBannedNotNull NOT NULL
        CONSTRAINT IsBannedDefault DEFAULT FALSE,
    type             VARCHAR(6)
        CONSTRAINT TypeNotNull NOT NULL
        CONSTRAINT ValidType CHECK (type IN ('seller', 'buyer', 'admin')),
    CONSTRAINT idPK PRIMARY KEY (id),
    CONSTRAINT profilePictureFK FOREIGN KEY (profilePicture) REFERENCES Image (url)
);

CREATE TABLE Size
(
    name VARCHAR(16)
        CONSTRAINT NameNotNull NOT NULL,
    CONSTRAINT NamePK PRIMARY KEY (name)
);

CREATE TABLE Category
(
    name VARCHAR(16)
        CONSTRAINT NameNotNull NOT NULL,
    CONSTRAINT NamePK PRIMARY KEY (name)
);

CREATE TABLE Condition
(
    name VARCHAR(16)
        CONSTRAINT NameNotNull NOT NULL,
    CONSTRAINT NamePK PRIMARY KEY (name)
);

CREATE TABLE Item
(
    id        INTEGER,
    name      VARCHAR(64)
        CONSTRAINT NameNotNull NOT NULL,
    seller    INTEGER
        CONSTRAINT SellerNotNull NOT NULL,
    size      VARCHAR(16),
    category  VARCHAR(16),
    condition VARCHAR(16),
    CONSTRAINT IdPK PRIMARY KEY (id),
    CONSTRAINT SellerFK FOREIGN KEY (seller) REFERENCES User (id),
    CONSTRAINT SizeFK FOREIGN KEY (size) REFERENCES Size (name),
    CONSTRAINT CategoryFK FOREIGN KEY (category) REFERENCES Category (name),
    CONSTRAINT ConditionFK FOREIGN KEY (condition) REFERENCES Condition (name)
);

CREATE TRIGGER ItemOwnerIsSeller
    BEFORE INSERT
    ON Item
    FOR EACH ROW
    WHEN (SELECT type
          FROM User
          WHERE id = New.seller) = 'buyer'
BEGIN
    SELECT RAISE(FAIL, 'Item cannot belong to non-seller or non-admin user');
END;

CREATE TABLE Brand
(
    name VARCHAR(16)
        CONSTRAINT NameNotNull NOT NULL,
    CONSTRAINT NamePK PRIMARY KEY (name)
);

CREATE TABLE ItemBrand
(
    item  INT
        CONSTRAINT ItemNotNull NOT NULL,
    brand VARCHAR(16)
        CONSTRAINT BrandNotNull NOT NULL,
    CONSTRAINT ItemBrandPK PRIMARY KEY (item, brand),
    CONSTRAINT ItemFK FOREIGN KEY (item) REFERENCES Item (id),
    CONSTRAINT BrandFK FOREIGN KEY (brand) REFERENCES Brand (name)
);



CREATE TABLE Payment
(
    id       INTEGER,
    subtotal DECIMAL(5, 2)
        CONSTRAINT SubtotalNotNull NOT NULL
        CONSTRAINT SubtotalNotNegative CHECK (subtotal >= 0),
    shipping DECIMAL(5, 2)
        CONSTRAINT ShippingNotNull NOT NULL
        CONSTRAINT ShippingNotNegative CHECK (shipping >= 0),
    firstName VARCHAR(32)
        CONSTRAINT FirstNameNotNull NOT NULL,
    lastName  VARCHAR(32)
        CONSTRAINT LastNameNotNull NOT NULL,
    email     VARCHAR(64)
        CONSTRAINT EmailNotNull NOT NULL,
    phone     VARCHAR(9)
        CONSTRAINT PhoneNotNull NOT NULL,
    address   VARCHAR(64)
        CONSTRAINT AddressNotNull NOT NULL,
    zipCode   VARCHAR(8)
        CONSTRAINT ZipCodeNotNull NOT NULL,
    town      VARCHAR(32)
        CONSTRAINT CityNotNull NOT NULL,
    country     VARCHAR(32)
        CONSTRAINT CountryNotNull NOT NULL,
    paymentDatetime DATETIME
        CONSTRAINT PaymentDatetimeNotNull NOT NULL,
    CONSTRAINT IdPK PRIMARY KEY (id)
);

CREATE TABLE Post
(
    id              INTEGER,
    title           VARCHAR(64)
        CONSTRAINT TitleNotNull NOT NULL,
    price           DECIMAL(5, 2)
        CONSTRAINT PriceNotNull NOT NULL
        CONSTRAINT PriceNotNegative CHECK (price >= 0),
    description     TEXT,
    publishDatetime DATETIME
        CONSTRAINT PublishDatetimeNotNull NOT NULL,
    seller          INTEGER
        CONSTRAINT SellerNotNull NOT NULL,
    item            INT
        CONSTRAINT ItemNotNull NOT NULL,
    payment         INTEGER,
    CONSTRAINT IdPK PRIMARY KEY (id),
    CONSTRAINT SellerFK FOREIGN KEY (seller) REFERENCES User (id),
    CONSTRAINT ItemFK FOREIGN KEY (item) REFERENCES Item (id),
    CONSTRAINT PaymentFK FOREIGN KEY (Payment) REFERENCES Payment (id)
);

CREATE TRIGGER PostPublisherIsSeller
    BEFORE INSERT
    ON Post
    FOR EACH ROW
    WHEN (SELECT type
          FROM User
          WHERE id = New.seller) <> 'seller'
BEGIN
    SELECT RAISE(FAIL, 'The post''s publisher must be a seller');
END;

CREATE TRIGGER PostAndItemHaveSameOwner
    BEFORE INSERT
    ON Post
    FOR EACH ROW
    WHEN (SELECT seller
          FROM Item
          WHERE id = New.item) <> New.seller
BEGIN
    SELECT RAISE(FAIL, 'The post and the respective item must have the same seller');
END;

CREATE TRIGGER PostAfterUserRegister
    BEFORE INSERT
    ON Post
    FOR EACH ROW
    WHEN (SELECT registerDatetime
          FROM User
          WHERE id = New.seller) >= New.publishDatetime
BEGIN
    SELECT RAISE(FAIL, 'The post cannot be publish before the respective seller being registered');
END;

CREATE TABLE PostImage
(
    post  INT
        CONSTRAINT PostNotNull NOT NULL,
    image VARCHAR(64)
        CONSTRAINT ImageNotNull NOT NULL,
    CONSTRAINT PostPK PRIMARY KEY (image),
    CONSTRAINT PostFK FOREIGN KEY (post) REFERENCES Post (id),
    CONSTRAINT ImageFK FOREIGN KEY (image) REFERENCES Image (url)
);

CREATE TABLE Message
(
    id       INT
        CONSTRAINT IdNotNull NOT NULL,
    datetime DATETIME
        CONSTRAINT DatetimeNotNull NOT NULL,
    content  TEXT
        CONSTRAINT ContentNotNull NOT NULL,
    sender   INTEGER
        CONSTRAINT SenderNotNull NOT NULL,
    receiver INTEGER
        CONSTRAINT ReceiverNotNull NOT NULL,
    CONSTRAINT IdPK PRIMARY KEY (id),
    CONSTRAINT SenderFK FOREIGN KEY (sender) REFERENCES User (id),
    CONSTRAINT ReceiverFK FOREIGN KEY (receiver) REFERENCES User (id),
    CONSTRAINT SenderNotReceiver CHECK (sender <> receiver)
);

-- Indexes

CREATE INDEX ItemSellerIndex ON Item (seller);
CREATE INDEX ItemSizeIndex ON Item (size);
CREATE INDEX ItemCategoryIndex ON Item (category);
CREATE INDEX ItemConditionIndex ON Item (condition);

CREATE INDEX ItemBrandBrandIndex ON ItemBrand (brand);

CREATE INDEX PostTileIndex ON Post (title);
CREATE INDEX PostPriceIndex ON Post (price);

CREATE INDEX PostImagePostIndex ON PostImage (post);

CREATE INDEX MessageSenderIndex ON Message (sender);
CREATE INDEX MessageReceiverIndex ON Message (receiver);
